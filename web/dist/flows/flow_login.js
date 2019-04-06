loginForm.
    onSubmit(
        function (fields) {
            $('#submit-login').prop('disabled', true);
            $('#submit-login').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            fields = { ...fields, sessionType: 'web' }
            sessions.login(
                fields,
                function (response, fields) {

                    switch (response.data.code) {
                        case 'RSP_00':
                            let bearerToken = response.headers.authorization.replace('Bearer ', '')
                            store.dispatch('saveBearerToken', bearerToken)
                            window.location.href = "main.html"
                            break;

                        case 'RSP_01':
                            $('#m-00').modal('show')
                            break;

                        case 'RSP_02':
                            $('#m-01').modal('show')
                            break;

                        case 'RSP_03':
                            $('#m-00').modal('show')
                            break;

                        case 'RSP_04':
                            $('#m-00').modal('show')
                            break;

                        case 'RSP_05':
                            window.location.href = "login.html?correct_user=false"
                            break;
                        case 'RSP_06':
                            window.location.href = "login.html?correct_password=false"
                            break;
                        case 'RSP_07':
                            $('#m-00').modal('show')
                            break;
                        case 'RSP_08':
                            alert('Fallo en el envio de Email')
                                $('#m-00').modal('show')
                            break;

                        default:
                        $('#m-00').modal('show')
                            break;
                    }
                    $('#submit-login').prop('disabled', false);
                    $('#submit-login').html('Iniciar sesión')
                },
                function (error) {
                    console.error(error)
                    $('#m-00').modal('show')
                    $('#submit-login').prop('disabled', false);
                    $('#submit-login').html('Iniciar sesión');
                })
        })