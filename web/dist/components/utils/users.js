var URL_USERS = env.usersURL;
var URL_LOGIN = env.loginURL;


var users = new Vue({
    el: "#component_register",
    data: {

    },
    methods: {
        createUser: function (username, email, password, callback) {
            let fields = {
                username,
                email,
                password
            }
            axios({
                method: 'post',
                url: URL_USERS,
                data: fields,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    console.log("Respuesta del mentodo users.createUser()", response)
                    callback(response, fields)
                })
                .catch(error => console.error(error))
        },
    }
})