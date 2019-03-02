var registerFormComponent = new Vue({
  el: "#registerFormComponent",
  data: {
    username: {
      value: '',
      validationMessage: false,
    },
    email: {
      value: '',
      validationMessage: false,
    },
    password: {
      value: '',
      validationMessage: false,
    },
    passwordConfirmation: {
      value: '',
      validationMessage: false,
    },
    termsAndConditions: {
      value: false,
      validationMessage: false,
    },
    OnSubmitEventListener: undefined,
    waitingForResponse: false,
    modal:{
      message: '',
      show: false,
    }
  },
  store,
  computed: {
    invalidUsernameError: function () {
      let REGEX = /^[a-zA-Z0-9]{1,}$/
      if(this.username.value === ''){
        return "Este campo es requerido"
      } else if (!REGEX.test(this.username.value)) {
        return "ingresa un usuario valido"
      }
      return false
    },
    invalidEmailError: function () {
      let REGEX = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])$/;
      if(this.email.value === ''){
        return "Este campo es requerido"
      } else if (!REGEX.test(this.email.value)) {
        return "ingresa un correo valido"

      }
      return false
    },
    invalidPasswordError: function () {
      let REGEX = /^[a-zA-Z0-9"#$%&/()=¿?¡!<>|°\.\[\]:,;-]{6,}$/;
      if(this.password.value === ''){
        return "Este campo es requerido"
      } else if (!REGEX.test(this.password.value)) {
        return "ingresa una contraseña valida"
      }
      return false
    },
    invalidPasswordConfirmationError: function () {
      if(this.passwordConfirmation.value === ""){
        return "Este campo es requerido"
      } else if (this.password.value !== this.passwordConfirmation.value){
        return "Las contraseñas no coinciden"
      }
      return false
    },
    invalidTermsAndConditionsError: function () {
      return this.termsAndConditions? false : "Debes aceptar los terminos y condiciones";
    }
  },
  methods: {
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        username: this.username.value,
        email: this.email.value,
        password: this.password.value,
      }
      
      if (
        !registerFormComponent.invalidUsernameError &&
        !registerFormComponent.invalidEmailError &&
        !registerFormComponent.invalidPasswordError &&
        !registerFormComponent.invalidPasswordConfirmationError &&
        !registerFormComponent.invalidTermsAndConditionsError
      ) {
        this.OnSubmitEventListener(fields);
      } else {
        this.username.validationMessage = true;
        this.email.validationMessage = true;
        this.password.validationMessage = true;
        this.passwordConfirmation.validationMessage = true;
        this.termsAndConditions.validationMessage = true;
      }
    },
    onSubmit: function (callback) {
      this.OnSubmitEventListener = callback;
    },
  }
})