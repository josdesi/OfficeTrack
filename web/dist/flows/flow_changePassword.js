changePasswordFormComponent.
    onSubmit(
        function (fields) {
            users.changePassword(
                fields,
                function (response, fields) {
                    $("#m-04").modal("show");
                },
                function (response, fields) {
                    $("#m-04").modal("show");
                })
        })