var changePasswordFormComponent = new Vue({
  el: "#changePasswordFormComponent",
  data: {
    password: '',
    OnSubmitEventListener: undefined,
  },
  store,
  methods: {    
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        password: this.password,
      }
      if (
        $("#changePasswordFormComponent").valid()
      ) {
        this.OnSubmitEventListener(fields);
      }
    },
    onSubmit: function ( callback ) {
      this.OnSubmitEventListener = callback ;
    },
  }
})