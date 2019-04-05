var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;
var URL_RECOVER_PASSWORD = env.recoverPasswordURL;
var URL_CHANGE_PASSWORD = env.changePasswordURL;


var newsletter = new Vue({
    el: "",
    data: {
        
    },
    methods: {
        register: function (fields, callback, callbackOnFail) {
            axios({
                method: 'post',
                url: URL_USERS,
                data: fields,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    callback(response, fields)
                })
                .catch(() => callbackOnFail())
        },
    }
})