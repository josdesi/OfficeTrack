new Vue({
    el: "#component_login",
    data: {
        username: "",
        password: "",
    },
    methods: {
        login: function(){
            axios({
                method: 'post',
                url: 'http://localhost/api/controllers/login.php',
                data: {
                  username: this.username,
                  password: this.password,
                }
              })
              .then(function (response) {
                
              })
              .catch(error => console.log(error))
        }
    }
})