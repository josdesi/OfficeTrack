changePasswordFormComponent.
    onSubmit(
        function (fields) {
            users.changePassword(
                fields,
                function (response, fields) {
                    $("#m-04").modal("show");
                },
                function (error) {
                    console.error(error)
                    $("#m-04").modal("show");
                })
        })