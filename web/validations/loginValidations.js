$(document).ready(function () {
    $("#loginFormComponent").validate({
        debug: true,
        rules: {
            username: {
                usuario: true,
                required: true,
            },
            password: {
                contraseña: true,
                required: true,
            },
        },
        messages: {
            username: {
                required: "Este campo es requerido",
            },
            password: {
                required: "Este campo es requerido",
            },
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element
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