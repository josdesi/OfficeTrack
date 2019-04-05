$(document).ready(function () {
    $("#newsletterForm").validate({
        debug: true,
        rules: {
            email: {
                remote: {
                    url: 'http://localhost/api/controllers/newsletter.php',
                    method: "GET",
                    contentType:  "application/json; charset=utf8",
                    dataType: "json",
                    data: {
                        "email": function () {
                            return $("#email").val();
                        }
                    },
                    dataFilter: function (data) {
                        data = JSON.parse(data)
                        console.log(data)
                        return !data.response
                    }
                },
                required: true,
            },
        },
        messages: {
            email: {
                email: "Introduce un correo valido",
                required: "Este campo es requerido",
                remote : "Correo electrónico ya está suscrito"
            },
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });
});