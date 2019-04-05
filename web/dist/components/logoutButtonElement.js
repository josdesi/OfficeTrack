const logoutButtonElement = new Vue({
    el:'#logoutButtonElement',
    data:{
      onLogoutEventListener: undefined,
      modal: null
    },
    store,
    methods:{
      showModal: function (modalName) {
        this.modal = modalName
      },
      hideModal: function (modalName) {
        if (this.modal === modalName) {
          this.modal = null
        }
      },
      logoutEvaluate: function(){
        this.onLogoutEventListener();
      },
      onClickLogout: function ( callback ) {
        this.onLogoutEventListener = callback ;
      }
    }
})