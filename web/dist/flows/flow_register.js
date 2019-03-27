registerFormComponent.onSubmit
    (
        function (fields) {
            $('#submit-register').prop('disabled', true);
            $('#submit-register').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            users.createUser
                (
                    fields,
                    function (response, fields) {
                        if (response.status === 200) {
                            $("#m-01").modal("show")
                        } else {
                            $("#m-xx").modal("show")
                        }
                        $('#submit-register').prop('disabled', false);
                        $('#submit-register').html('Crear cuenta');
                    },
                    function () {
                        $("#m-xx").modal("show")
                        $('#submit-register').prop('disabled', false);
                        $('#submit-register').html('Crear cuenta');
                    }
                )
        }
    )