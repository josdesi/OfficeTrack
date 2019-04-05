recoverPasswordForm.
    onSubmit(
        function (fields) {
            $('#submit-recover').prop('disabled', true);
            $('#submit-recover').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            users.recoverPassword(
                fields,
                function (response, fields) {
                    switch (response.data.code) {
                        case 'RSP_00':
                            recoverPasswordForm.showModal('m-05')
                            break;

                        case 'RSP_01':
                            recoverPasswordForm.showModal('m-00-2')
                            break;

                        case 'RSP_03':
                            recoverPasswordForm.showModal('m-00-2')
                            break;

                        case 'RSP_05':
                            recoverPasswordForm.showModal('m-00-2')
                            break;

                        case 'RSP_07':
                            recoverPasswordForm.showModal('m-00-2')
                            break;
                        case 'RSP_08':
                            alert('Fallo en el envio de Email')
                            recoverPasswordForm.showModal('m-00-2')
                            break;

                        default:
                            recoverPasswordForm.showModal('m-00-2')
                            break;
                    }
                    $('#submit-recover').prop('disabled', false);
                    $('#submit-recover').html('Recuperar');
                },
                function (response, fields) {
                    recoverPasswordForm.showModal('m-00-2')
                    $('#submit-recover').prop('disabled', false);
                    $('#submit-recover').html('Recuperar');
                })
        })