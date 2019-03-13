loginFormComponent.
    onSubmit(
        function (fields) {
            let { username, password } = fields
            sessions.login(username, password, function (response, fields) {
                if (response.status === 200) {
                    let bearerToken = response.headers.authorization.replace('Bearer ', '')
                    sessions.saveBearerToken(bearerToken)
                }
            })
        })