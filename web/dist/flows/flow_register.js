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
                    registerFormComponent.modal.title = "Su registro se ha completado con exito"
                    registerFormComponent.modal.message = response.data.response
                } else {
                    registerFormComponent.modal.title = "No se pudo completar el registro"
                    registerFormComponent.modal.message = response.data.response
                }
            })
        })