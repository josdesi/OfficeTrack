var state = {
  userInfo: {
    userId: '',
    username: '',
    name: '',
    fatherSurname: '',
    motherSurname: '',
  },
  session: {
    bearerToken: '',
  }
}

var getters = {
  getBearerToken: state => state.session.bearerToken,
  getUserInfo: state => state.userInfo,
}

var mutations = (function (a, b) {
  var ref = {};
  for (var attrname in a) { ref[attrname] = a[attrname] }
  for (var attrname in b) { ref[attrname] = b[attrname] }
  return a != undefined ? ref : a;

})({
  RESET_STORE: (state, payload) => {
    state.userInfo.userId = '';
    state.userInfo.userName = '';
    state.userInfo.name = '';
    state.userInfo.fatherSurname = '';
    state.userInfo.motherSurname = '';
    state.session.bearerToken = '';
  },
  initialise_Store(state) {
    // Check if the ID exists
    if (localStorage.getItem('store')) {
      // Replace the state object with the stored item
      this.replaceState(
        Object.assign(state, JSON.parse(localStorage.getItem('store')))
      );
    }
  }
}, mutations);

var actions = (function (a, b) {
  var ref = {};
  for (var attrname in a) { ref[attrname] = a[attrname]; }
  for (var attrname in b) { ref[attrname] = b[attrname]; }
  return a != undefined ? ref : a;

})({
  resetStore: (context, payload) => {
    context.commit("RESET_STORE", payload);
  },
  InitialiseStore(context){
    context.commit("initialise_Store");
  }
}, actions);

var store = new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
})

// Subscribe to store updates
store.subscribe((mutation, state) => {
  // Store the state object as a JSON string
  localStorage.setItem('store', JSON.stringify(state));
});

store.dispatch('InitialiseStore')
