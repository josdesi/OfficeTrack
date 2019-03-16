registerFormComponent.onSubmit
    (
        function (fields) {
            users.createUser
                (
                    fields,
                    function (response, fields) {
                        if (response.status === 200) {
                            $("#m-01").modal("show")
                        } else {
                            $("#m-01").modal("show")
                        }
                    },
                    function () {
                        $("#m-01").modal("show")
                    }
                )
        }
    )