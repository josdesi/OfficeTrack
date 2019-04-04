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
                                registerForm.showModal('m-01')
                                registerForm.successfulResponse = true
                                break;

                            case 'RSP_01':
                                registerForm.showModal('m-01')
                                break;

                            case 'RSP_02':
                                registerForm.showModal('m-01')
                                break;

                            case 'RSP_03':
                                registerForm.showModal('m-00')
                                break;

                            case 'RSP_04':
                                registerForm.showModal('m-00')
                                break;

                            case 'RSP_05':
                                alert('El correo se ya encuentra registrado')
                                registerForm.showModal('m-00')
                                break;
                            case 'RSP_06':
                                alert('El usuario ya se encuentra registrado')
                                registerForm.showModal('m-00')
                                break;
                            case 'RSP_07':
                                registerForm.showModal('m-00')
                                break;
                            case 'RSP_08':
                                alert('Fallo en el envio de Email')
                                registerForm.showModal('m-01')
                            break;

                            default:
                                registerForm.showModal('m-00')
                                break;
                        }

                        $('#submit-register').prop('disabled', false);
                        $('#submit-register').html('Crear cuenta');
                    },
                    function () {
                        registerForm.showModal('m-00')
                        $('#submit-register').prop('disabled', false);
                        $('#submit-register').html('Crear cuenta');
                    }
                )
        }
    )