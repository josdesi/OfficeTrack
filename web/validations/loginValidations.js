$(document).ready(function () {
    let url = new URL(window.location.href);
    let correctUser = url.searchParams.get("correct_user") || null;
    let correctPassword = url.searchParams.get("correct_password") || null;


    let loginValidator = $("#loginForm").validate({
        debug: true,
        rules: {
            username: {
                required: true,
            },
            password: {
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
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        }
    });


    if (correctUser === 'false') {
        loginValidator.showErrors({
            "username": "No tenemos ninguna cuenta de usuario asociada a estos datos de accesos. ¿Quieres registrate con nosotros? Dirigete a Crear cuenta de usuario",
        });
    }

    if (correctPassword === 'false') {
        loginValidator.showErrors({
            "password": "La contraseña es incorrecta. ¿No la recuerdas? dirigete a ¿Olvidaste tu contraseña?",
        });
    }



});