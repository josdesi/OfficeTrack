newsletterForm.
onSubmit(
    function (fields) {
        $('#submit-newsletter').prop('disabled', true);
        $('#btn-text').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

        fields = { ...fields, sessionType: 'web' }
        newsletter.register(
            fields,
            function (response, fields) {
                switch (response.data.code) {
                    case 'RSP_00':
                        newsletterForm.showModal('m-09')
                        break;

                    case 'RSP_01':
                        newsletterForm.showModal('m-00')
                        break;

                    case 'RSP_03':
                        newsletterForm.showModal('m-00')
                        break;

                    case 'RSP_08':
                        alert('Fallo en el envio de Email')
                        newsletterForm.showModal('m-00')
                        break;

                    default:
                        newsletterForm.showModal('m-00')
                        break;
                }
                $('#submit-newsletter').prop('disabled', false);
                $('#btn-text').html('Suscribirse');
            },
            function (error) {
                console.error(error)
                newsletterForm.showModal('m-00')
                $('#submit-newsletter').prop('disabled', false);
                $('#btn-text').html('Suscribirse');
            })
    })