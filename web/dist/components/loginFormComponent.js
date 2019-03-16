var loginFormComponent = new Vue({
  el: "#loginFormComponent",
  data: {
    username: '',
    password: '',
    OnSubmitEventListener: undefined,
  },
  store,
  methods: {    
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        username: this.username,
        password: this.password,
      }
      if (
        $("#loginFormComponent").valid()
      ) {
        this.OnSubmitEventListener(fields);
      }
    },
    onSubmit: function ( callback ) {
      console.log("Se agrega ", callback, " a loginFormComponent")
      this.OnSubmitEventListener = callback ;
    },
  }
})