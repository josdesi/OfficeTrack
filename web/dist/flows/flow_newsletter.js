newsletterForm.
onSubmit(
    function (fields) {
        $('#submit-newsletter').prop('disabled', true);
        $('#btn-text').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        
        newsletter.register(
            fields,
            function (response, fields) {
                console.log(response)
                switch (response.data.code) {
                    case 'RSP_00':
                        $('#m-09').modal('show')
                        break;

                    case 'RSP_01':
                        $('#m-00').modal('show')
                        break;

                    case 'RSP_03':
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
                $('#submit-newsletter').prop('disabled', false);
                $('#btn-text').html('Suscribirse');
            },
            function (error) {
                console.error(error)
                $('#m-00').modal('show')
                $('#submit-newsletter').prop('disabled', false);
                $('#btn-text').html('Suscribirse');
            })
    })