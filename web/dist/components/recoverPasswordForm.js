var recoverPasswordForm = new Vue({
  el: "#recoverPasswordFormComponent",
  data: {
    // FIELDS
    email: '',

    //CURRENT MODAL
    modal: null,

    //RESPONSE STATE
    successfulResponse: false,

    //SUBMIT FUNCTION
    OnSubmitEventListener: undefined,
  },
  methods: {
    showModal: function (modalName) {
      this.modal = modalName
    },
    hideModal: function (modalName) {
      if (this.modal === modalName) {
        this.modal = null
      }
    },
    onSubmitEventListener: function (ev) {
      ev.preventDefault();
      ev.stopPropagation();
      let fields = {
        email: this.email,
      }
      if (
        $("#recoverPasswordForm").valid()
      ) {
        this.OnSubmitEventListener(fields);
      }
    },
    onSubmit: function (callback) {
      this.OnSubmitEventListener = callback;
    },
  }
})