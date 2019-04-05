$.validator.addMethod("usuario", function (value, element) {
    return this.optional(element) || /^[ña-zA-Z0-9]{1,}$/.test(value);
})

$.validator.addMethod("correo", function (value, element) {
    return this.optional(element) || /^[ña-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])$/.test(value);
})

$.validator.addMethod("contraseña", function (value, element) {
    return this.optional(element) || /^[ña-zA-Z0-9]{1,}$/.test(value);
})
