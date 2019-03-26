var recoverPasswordFormComponent = new Vue({
  el: "#recoverPasswordFormComponent",
  data: {
    email: '',
    OnSubmitEventListener: undefined,
  },
  store,
  methods: {    
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        email: this.email,
      }
      if (
        $("#recoverPasswordFormComponent").valid()
      ) {
        this.OnSubmitEventListener(fields);
      }
    },
    onSubmit: function ( callback ) {
      this.OnSubmitEventListener = callback ;
    },
  }
})