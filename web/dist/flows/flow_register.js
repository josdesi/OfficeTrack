registerFormComponent.
    onSubmit(
        function (fields) {            
            let {username, email, password} = fields;
            registerFormComponent.waitingForResponse = true;
            users.createUser(username, email, password, function (response, fields) {
                registerFormComponent.waitingForResponse = false;
                $("#modal").modal('show')
                console.log("respuesta del peticion createUser", response)
                if(response.status === 200){
                    $("#m-01").modal("show")
                } else {
                    $("#m-01").modal("show")
                }
            })
        })