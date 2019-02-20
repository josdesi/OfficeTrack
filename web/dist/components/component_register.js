new Vue({
    el: "#component_register",
    data: {
        username: "",
        email: "",
        password: "",
    },
    methods: {
        registerUser: function(){
            axios({
                method: 'post',
                url: 'http://localhost/api/controllers/users.php',
                data: {
                  username: this.username,
                  email: this.email,
                  password: this.password,
                }
              })
              .then(function (response) {
                
              })
              .catch(error => console.log(error))
        }
    }
})