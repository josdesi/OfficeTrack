recoverPasswordFormComponent.
    onSubmit(
        function (fields) {
            users.recoverPassword(
                fields,
                function (response, fields) {
                    $("#m-03").modal("show");
                },
                function (response, fields) {
                    $("#m-03").modal("show");
                })
        })