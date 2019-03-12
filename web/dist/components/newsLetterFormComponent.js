var newsletterFormComponent = new Vue({
    el: "#newsletterFormComponent",
    data: {
      email: {
        value: '',
        validationMessage: false,
      },
      OnSubmitEventListener: undefined,
    },
    computed: {
      invalidEmailError: function () {
        let REGEX = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])$/;
        if(this.email.value === ''){
          return "Este campo es requerido"
        } else if (!REGEX.test(this.email.value)) {
          return "ingresa un correo valido"
  
        }
        return false
      },
    },
    methods: {
      onSubmitEventListener: function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        let fields = {
          email: this.email.value,
        }
        
        if (
          !newsletterFormComponent.invalidEmailError
        ) {
          this.OnSubmitEventListener(fields);
        } else {
          this.email.validationMessage = true;
        }
      },
      onSubmit: function (callback) {
        this.OnSubmitEventListener = callback;
      },
    }
  })