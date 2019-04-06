var newsletterForm = new Vue({
    el: "#newsletterFormComponent",
    data: {
      email:"",
      modal: null,
      OnSubmitEventListener: undefined,
    },
    methods: {
      onSubmitEventListener: function (ev) {
        let fields = {
          email: this.email,
        }
        if (
          $("#newsletterForm").valid()
        ) {
          this.OnSubmitEventListener(fields);
        }
      },
      onSubmit: function (callback) {
        this.OnSubmitEventListener = callback;
      },
    }
  })