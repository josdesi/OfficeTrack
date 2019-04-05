$(document).ready(function () {
    $("#registerForm").validate({
        debug: true,
        rules: {
            username: {
                remote: {
                    url: 'http://localhost/api/controllers/checkUsername.php',
                    method: "GET",
                    contentType:  "application/json; charset=utf8",
                    dataType: "json",
                    data: {
                        "username": function () {
                            return $("#username").val();
                        }
                    },
                    dataFilter: function (data) {
                        data = JSON.parse(data)
                        console.log(data)   
                        return !data.response
                    }
                },
                usuario: true,
                required: true,
                minlength: 2,                
            },
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
            email: {
                remote: {
                    url: 'http://localhost/api/controllers/checkEmail.php',
                    method: "GET",
                    contentType: "application/json; charset=utf8",
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
                correo: true,
                required: true,
                email: false,                
            },
            terms: {
                required: true
            }
        },
        messages: {
            username: {
                minlength: "El nombre de usuario debe tener al menos 3 caracteres",
                required: "Este campo es requerido",
                usuario: "Introduce un nombre de usuario valido",
                remote : "Nombre de usuario ya se está en uso"
            },
            password: {
                required: "Este campo es requerido",
                contraseña: "Introduce una contraseña valida",
                minlength: "La contraseña debe tener al menos 6 caracteres"
            },
            password_confiramtion: {
                required: "Este campo es requerido",
                equalTo: "Las contraseñas no coinciden"
            },
            email: {
                required: "Este campo es requerido",
                correo: "Introduce un correo valido",
                remote: "Correo electrónico ya esta en uso"
            },
            terms: "Debes aceptar los terminos y condiciones"
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