newsletterFormComponent.
    onSubmit(
        function (fields) {
            axios({
                method: 'post',
                url: 'http://localhost/api/controllers/newsletter.php',
                data: fields,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    console.log("Respuesta del mentodo users.createUser()", response)
                })
                .catch(error => console.error(error))
        })