recoverPasswordFormComponent.
    onSubmit(
        function (fields) {
            $('#submit-recover').prop('disabled', true);
            $('#submit-recover').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            users.recoverPassword(
                fields,
                function (response, fields) {
                    $("#m-03").modal("show");
                    $('#submit-recover').prop('disabled', false);
                    $('#submit-recover').html('Recuperar');
                },
                function (response, fields) {
                    $("#m-03").modal("show");
                    $('#submit-recover').prop('disabled', false);
                    $('#submit-recover').html('Recuperar');
                })
        })