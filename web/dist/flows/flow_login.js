loginFormComponent.
    onSubmit(
        function (fields) {
            $('#submit-login').prop('disabled', true);
            $('#submit-login').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            fields = { ...fields, sessionType: 'web' }
            sessions.login(
                fields,
                function (response, fields) {
                    if (response.status === 200) {
                        let bearerToken = response.headers.authorization.replace('Bearer ', '')
                        store.dispatch('saveBearerToken', bearerToken)
                        location.href = "main.html"
                        $('#submit-login').prop('disabled', false);
                        $('#submit-login').html('Iniciar sesión');
                    } else {
                        $("#m-xx").modal("show")
                        $('#submit-login').prop('disabled', false);
                        $('#submit-login').html('Iniciar sesión');
                    }
                },
                function () {
                    $("#m-xx").modal("show")
                    $('#submit-login').prop('disabled', false);
                    $('#submit-login').html('Iniciar sesión');
                })
        })