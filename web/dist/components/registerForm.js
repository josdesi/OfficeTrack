var registerForm = new Vue({
  el: "#registerFormComponent",
  data: {
    // FIELDS
    username: '',
    email: '',
    password: '',
    termsAndConditions: false,

    //CURRENT MODAL
    modal: null,

    //RESPONSE STATE
    successfulResponse: false,

    //SUBMIT FUNCTION
    submit: undefined,
  },
  methods: {
    showModal: function (modalName) {
      this.modal = modalName
    },
    hideModal: function () {
      this.modal = null
    },
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        username: this.username,
        email: this.email,
        password: this.password,
      }
      if (
        $("#registerForm").valid()
      ) {
        this.submit(fields);
      }

    },
    setSubmitFunction: function (callback) {
      this.submit = callback;
    },
  }
})

