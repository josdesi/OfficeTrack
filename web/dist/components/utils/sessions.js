var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;
var URL_LOGOUT = env.logoutURL;


var sessions = new Vue({
    el: "#component_register",
    data: {

    },
    store,
    methods: {
        login(username, password, callback) {
            let context = {
                username,
                password,
                sessionType:'web'
            }
            axios({
                method: 'post',
                url: URL_LOGIN,
                data: context,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    console.log("Respuesta del mentodo session.login()", response)
                    callback(response, context)
                })
                .catch(error => console.error(error))
        },
        saveBearerToken(token){
            this.$store.dispatch('saveBearerToken', token)
        },
        logout(callback){
            this.$store.dispatch('InitialiseStore')
            let tokenActive = this.$store.getters.getBearerToken;
            axios({
                method: 'post',
                url: URL_LOGOUT,
                data: '',
                headers: {
                    'Authorization': 'Bearer ' + tokenActive,
                }
            })
            .then(function (response){
                console.log("Respuesta del método session.logout()", response)
                callback(response, tokenActive)
            })
            .catch(error => console.error(error))
        },
        resetStateStore(token){
            this.$store.dispatch('resetStore', token);
        }
    }
})