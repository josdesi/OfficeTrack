var registerFormComponent = new Vue({
  el: "#registerFormComponent",
  data: {
    username: '',
    email: '',
    password:'',
    passwordConfirmation: '',
    termsAndConditions: false,
    OnSubmitEventListener: undefined,
    waitingForResponse: false,
    modal:{
      message: '',
    }
  },
  store,
  computed: {
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
        $("#registerFormComponent").valid()
      ) {
        this.OnSubmitEventListener(fields);
      }
    },
    onSubmit: function (callback) {
      this.OnSubmitEventListener = callback;
    },
  }
})