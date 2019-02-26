registerFormComponent.
    onSubmit(
        function (fields) {            
            let {username, email, password} = fields 
            users.createUser(username, email, password, function (response, fields) {
                if(response.status === 200){
                    location.href = "login.html"
                }
            })
        })