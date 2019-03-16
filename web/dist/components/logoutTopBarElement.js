const logoutTopBarElement = new Vue({
    el:'#logoutTopBarElement',
    data:{
      onLogoutEventListener: undefined
    },
    store,
    methods:{
      logoutEvaluate: function(){
          this.onLogoutEventListener();
      },
      onClickLogout: function ( callback ) {
        this.onLogoutEventListener = callback ;
      }
    }
})