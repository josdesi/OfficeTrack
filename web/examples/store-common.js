var state = {
  profile: {
    name: '',
    surnameFather: '',
    surnameMother: '',
    email: '',
    userId: '',
    validEmail:''
  },
  deliverAddress: {
    streetName: '',
    streetNumber: '',
    innerNumer: '',
    blockName: '',
    zipCode: '',
    cityName: '',
    idStateColony: '',
    deliveryRef: '',
    receiveName: ''
  },
  invoiceAddress: {
    streetName: '',
    streetNumber: '',
    innerNumer: '',
    blockName: '',
    zipCode: '',
    cityName: '',
    rfc: '',
    stateName: ''
  },
  product: {
    price: '',
    velocity: '',
    description: '',
    type:''
  },
  user: {
    profile: {
      name: '',
      surnameFather: '',
      surnameMother: '',
      email: '',
      userId: '',
      phone: '',
      validEmail:'',
    },
    leadAddress: {
      street: '',
      streetNumber: '',
      colony: '',
      city: '',
      state: '',
      zipCode: '',
      latitude: '',
      longitude: '',
      formattedAddress: '',
    },
    flagsOtherAddress: true,
    keySpeeds: '',
    bearerToken: '',
    estimatedDeliveryDate: '',
    orderID : '',
    account: '',
    cardType: "",
    terminacion: "",
    nombreRecibe:"",
    direccionEnvio:"",
    rfc:"",
  }
};


var getters = {
  getLeadAddress: state => state.user.leadAddress,
  getProfile: state => state.user.profile,
  getDeliverAddress: state => state.deliverAddress,
  getInvoiceAddress: state => state.invoiceAddress,
  getFlagsOtherAddress: state => state.user.flagsOtherAddress,
  getProduct: state => state.product,
  getKeySpeeds: state => state.user.keySpeeds,
  getUserProfile: state => state.user.profile,
  getBearerToken: state => state.user.bearerToken,
  getLeadAddress: state => state.user.leadAddress,
  getEstimatedDeliveryDate: state => state.user.estimatedDeliveryDate,
  getOrderID: state => state.user.orderID,
  getAccount: state => state.user.account,
  getCardType: state => state.user.cardType,
  getTerminacion: state => state.user.terminacion,
  getNombreRecibe: state => state.user.nombreRecibe,
  getDireccionEnvio: state => state.user.direccionEnvio,
  getRfc: state => state.user.rfc,
  // getTodos: state => state.todos
};


var mutations = (function (a, b) {
  var ref = {};
  for (var attrname in a) {
    ref[attrname] = a[attrname];
  }
  for (var attrname in b) {
    ref[attrname] = b[attrname];
  }
  return a != undefined ? ref : a;

})({
    RESET_STORE: (state, payload) => {

        state.user.leadAddress = '';
        state.user.profile = '';
        state.deliverAddress = '';
        state.invoiceAddress = '';
        state.user.flagsOtherAddress = '';
        state.product = '';
        state.user.keySpeeds = '';
        state.user.profile = '';
        state.user.bearerToken = '';
        state.user.estimatedDeliveryDate = '';
        state.user.leadAddress = '';
        state.user.orderID = '';
        state.user.account = '';
        state.user.cardType = '';
        state.user.terminacion = '';
        state.user.nombreRecibe = '';
        state.user.direccionEnvio = '';
        state.user.rfc = '';
    },    
    RESET_PRODUCT: (state, payload) => {

        state.user.leadAddress = '';
        state.user.flagsOtherAddress = '';
        state.product = '';
        state.user.keySpeeds = '';
        state.user.leadAddress = '';
    },
    initialiseStore(state) {
    // Check if the ID exists
        if (localStorage.getItem('store')) {
          // Replace the state object with the stored item
          this.replaceState(
              Object.assign(state, JSON.parse(localStorage.getItem('store')))
              );
        }
  }
}, mutations);


var actions = ( function( a, b ){
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a ;

})( {
    resetStore: (context, payload) => {
        context.commit( "RESET_STORE", payload );
    },    
    resetProduct: (context, payload) => {
        context.commit( "RESET_PRODUCT", payload );
    },
}, actions );


var store = new Vuex.Store({
  state: state,
  getters: getters,
  mutations: mutations,
  actions: actions
});


// Subscribe to store updates
store.subscribe((mutation, state) => {
  // Store the state object as a JSON string
  localStorage.setItem('store', JSON.stringify(state));
});