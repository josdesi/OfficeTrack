var loginForm = new Vue({
  el: "#loginFormComponent",
  data: {
    // FIELDS
    username: '',
    password: '',
    
    //SUBMIT FUNCTION
    OnSubmitEventListener: undefined,
  },
  mounted: function () {
    let url = new URL(window.location.href);
    let confirmed = url.searchParams.get("confirmed") || null;
    let emailToken = url.searchParams.get("emailToken") || null;

    if (confirmed === 'true') {
      $('#m-02').modal('show')
    } else if (confirmed === 'false') {
      $('#m-04').modal('show')
    }
  },
  methods: {
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
      this.OnSubmitEventListener = callback;
    },
  }
})