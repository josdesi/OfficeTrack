const logoutButton = new Vue({
    el:'#logoutButtonComponent',
    data:{
      onLogoutEventListener: undefined,      
      modal: null
    },
    methods:{
      logoutEvaluate: function(){
        this.onLogoutEventListener();
      },
      onClick: function ( callback ) {
        this.onLogoutEventListener = callback ;
      }
    }
})