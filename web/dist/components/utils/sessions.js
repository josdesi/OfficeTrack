var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;
var URL_LOGOUT = env.logoutURL;


var sessions = new Vue({
    el: "#component_register",
    store,
    methods: {
        login(fields, callback, callbackOnFails) {
            axios({
                method: 'post',
                url: URL_LOGIN,
                data: fields,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    callback(response, fields)
                })
                .catch(()=>callbackOnFails())
        },
        logout(callback, callbackOnFails) {
            let tokenActive = this.$store.getters.getBearerToken;
            axios({
                method: 'post',
                url: URL_LOGOUT,
                data: '',
                headers: {
                    'Authorization': 'Bearer ' + tokenActive,
                }
            })
                .then(function (response) {
                    callback(response, tokenActive)
                })
                .catch(()=>callbackOnFails())
        },
    }
})