var loginFormComponent = new Vue({
  el: "#loginFormComponent",
  data: {
    username: '',
    password: '',
    OnSubmitEventListener: undefined,
  },
  store,
  computed: {
    validUsername: function () {
      return validateUsername(this.username);
    },
    validPasswor: function () {
      return validatePassword(this.password);
    },
    validEmail: function () {
      validateEmail(this.email)
    }
  },
  methods: {    
    onSubmitEventListener: function (ev) {
      let fields = {
        username: this.username,
        password: this.password,
      }
      if (ev) ev.preventDefault();
      console.log("parametro fields de registerForm.OnSubmitEventListener()",fields)
      this.OnSubmitEventListener(fields);
    },
    onSubmit: function ( callback ) {
      console.log("Se agrega ", callback, " a loginFormComponent")
      this.OnSubmitEventListener = callback ;
    },
  }
})