$(document).ready(function () {
    $("#changePasswordFormComponent").validate({
        debug: true,
        rules: {
            password: {
                contraseña: true,
                required: true,
                minlength: 6
            },
            password_confiramtion: {
                contraseña: true,
                required: true,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Este campo es requerido",
                contraseña: "Introduce una contraseña valida",
                minlength: "La contraseña debe tener al menos 6 caracteres"
            },
            password_confiramtion: {
                required: "Este campo es requerido",
                equalTo: "Las contraseñas no coinciden"
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