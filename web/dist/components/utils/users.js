var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;
var URL_RECOVER_PASSWORD = env.recoverPasswordURL;
var URL_CHANGE_PASSWORD = env.changePasswordURL;


var users = new Vue({
    el: "",
    data: {

    },
    methods: {
        createUser: function (fields, callback, callbackOnFail) {
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
                .catch((error) => callbackOnFail(error))
        },
        recoverPassword: function (fields, callback, callbackOnFail) {
            axios({
                method: 'post',
                url: URL_RECOVER_PASSWORD,
                data: fields,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    callback(response, fields)
                })
                .catch((error) => callbackOnFail(error))
        },
        changePassword: function (fields, callback, callbackOnFail) {
            let url = new URL(window.location.href);
            let token = url.searchParams.get("token");
            axios({
                method: 'post',
                url: URL_CHANGE_PASSWORD,
                data: fields,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                }
            })
                .then(
                    function (response) {
                        callback(response, fields)
                    }
                )
                .catch((error) => callbackOnFail(error))
        },
    }
})