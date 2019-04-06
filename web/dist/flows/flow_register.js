registerForm.setSubmitFunction
    (
        function (fields) {
            $('#submit-register').prop('disabled', true);
            $('#submit-register').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            users.createUser
                (
                    fields,
                    function (response, fields) {
                        switch (response.data.code) {
                            case 'RSP_00':
                                $('#m-01').modal('show')
                                registerForm.successfulResponse = true
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
                                alert('El correo se ya encuentra registrado')
                                $('#m-00').modal('show')
                                break;
                            case 'RSP_06':
                                alert('El usuario ya se encuentra registrado')
                                $('#m-00').modal('show')
                                break;
                            case 'RSP_07':
                                $('#m-00').modal('show')
                                break;
                            case 'RSP_08':
                                alert('Fallo en el envio de Email')
                                $('#m-01').modal('show')
                            break;

                            default:
                                $('#m-00').modal('show')
                                break;
                        }

                        $('#submit-register').prop('disabled', false);
                        $('#submit-register').html('Crear cuenta');
                    },
                    function (error) {
                        console.error(error)
                        $('#m-00').modal('show')
                        $('#submit-register').prop('disabled', false);
                        $('#submit-register').html('Crear cuenta');
                    }
                )
        }
    )