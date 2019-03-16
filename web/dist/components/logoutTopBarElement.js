const logoutTopBarElement = new Vue({
    el:'#logoutTopBarElement',
    data:{
      onLogoutEventListener: undefined
    },
    store,
    methods:{
      logoutEvaluate: function(){
          console.info("Ejecutando método click de logout");
          this.onLogoutEventListener();
      },
      onClickLogout: function ( callback ) {
        console.log("Se agrega ", callback, " a loginFormComponent");
        this.onLogoutEventListener = callback ;
      }
    }
})