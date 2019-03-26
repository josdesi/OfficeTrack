loginFormComponent.
    onSubmit(
        function (fields) {
            fields = { ...fields, sessionType: 'web' }
            sessions.login(
                fields,
                function (response, fields) {
                    if (response.status === 200) {
                        let bearerToken = response.headers.authorization.replace('Bearer ', '')
                        store.dispatch('saveBearerToken', bearerToken)
                        location.href = "main.html"
                    }else{
                        $("#m-03").modal("show")
                    }
                },
                function () {
                    $("#m-03").modal("show")
                })
        })