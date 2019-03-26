var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;


var users = new Vue({
    el: "#component_register",
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
                .catch(callbackOnFail)
        },
    }
})