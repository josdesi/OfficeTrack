var registerFormComponent = new Vue({
  el: "#registerFormComponent",
  data: {
    username: '',
    email: '',
    password: '',
    OnSubmitEventListener: undefined,
  },
  store,
  methods: {    
    onSubmitEventListener: function (ev) {
      let fields = {
        username: this.username,
        email: this.email,
        password: this.password,
      }
      if (ev) ev.preventDefault();
      console.log("parametro fields de registerForm.OnSubmitEventListener()",fields)
      this.OnSubmitEventListener(fields);
    },
    onSubmit: function ( callback ) {
      console.log("Se agrega ", callback, " a registerForm")
      this.OnSubmitEventListener = callback ;
    },
  }
})