$(document).ready(function () {
    $("#newsLetterFormComponent").validate({
        debug: true,
        rules: {
            email: {
                required: true,
            },
        },
        messages: {
            email: {
                email: "Introduce un correo valido",
                required: "Este campo es requerido",
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