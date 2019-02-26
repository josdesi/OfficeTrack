var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;


var sessions = new Vue({
    el: "#component_register",
    data: {

    },
    store,
    methods: {
        login(username, password, callback) {
            let context = {
                username,
                password
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
        }
    }
})