$.validator.addMethod("usuario", function (value, element) {
    return this.optional(element) || /^[ña-zA-Z0-9]{1,}$/.test(value);
})

$.validator.addMethod("correo", function (value, element) {
    return this.optional(element) || /^[ña-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])$/.test(value);
})

$.validator.addMethod("contraseña", function (value, element) {
    return this.optional(element) || /^[ña-zA-Z0-9]{1,}$/.test(value);
})

$.validator.addMethod("checkUser", function (value, element) {
    var validacion = false;
    $.ajax({
        url: 'http://localhost/api/controllers/checkUsername.php',
        method: "GET",
        contentType: "application/json; charset=utf8",
        dataType: "json",
        data: {
            "username": value
        },
        success: function( resp ) {
            console.log('Ejecutando callback Success. ' + value);
           if(resp.response == "true" || resp.response == true || resp.response == "1")
           this.validacion = false;
           else this.validacion = true;
           console.log("Variable en promesa = " + this.validacion);
        },
        error: function(errorResp) {
            console.log(errorResp);
        }
    });
    console.log("Variable en el flujo de la funcion = " + validacion);
    return validacion;
})

$.validator.addMethod("checkEmail", function (value, element) {
    var validacion = true;
    $.ajax({
        url: 'http://localhost/api/controllers/checkEmail.php',
        method: "GET",
        contentType: "application/json; charset=utf8",
        dataType: "json",
        data:{
            "email": value
        },
        success: function( resp ) {
            console.log('Ejecutando callback Success. ' + value);
            console.log(resp.response);
            validacion = resp.response;
        },
        error: function(errorResp) {
            console.log(errorResp);
        }
    });
    return validacion;
})