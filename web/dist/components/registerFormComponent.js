var registerFormComponent = new Vue({
  el: "#registerFormComponent",
  data: {
    username: '',
    email: '',
    password:'',
    termsAndConditions: false,
    OnSubmitEventListener: undefined,
  },
  store,
  computed: {
  },
  methods: {
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        username: this.username,
        email: this.email,
        password: this.password,
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