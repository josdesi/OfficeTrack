var loginForm = new Vue({
  el: "#loginFormComponent",
  data: {
    // FIELDS
    username: '',
    password: '',

    emailToken: undefined,

    //CURRENT MODAL
    modal: null,

    //RESPONSE STATE
    successfulResponse: false,

    //SUBMIT FUNCTION
    OnSubmitEventListener: undefined,
  },
  mounted: function () {
    let url = new URL(window.location.href);
    let confirmed = url.searchParams.get("confirmed") || null;
    let emailToken = url.searchParams.get("emailToken") || null;

    if (confirmed === 'true') {
      this.showModal('m-02')
    } else if (confirmed === 'false') {
      this.showModal('m-04')
    }
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
        username: this.username,
        password: this.password,
      }
      if (
        $("#loginForm").valid()
      ) {
        this.OnSubmitEventListener(fields);
      }
    },
    onSubmit: function (callback) {
      console.log("Se agrega ", callback, " a loginFormComponent")
      this.OnSubmitEventListener = callback;
    },
  }
})