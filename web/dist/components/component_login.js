let state = {
  token: "",
}

let getters = {
  getToken: state => state.token,
}

let mutations = {
  CHANGE_TOKEN: (state, payload) => {
    state.token = payload;
  }
}

let actions = {
  changeToken: (context, payload) => {
    context.commit('CHANGE_TOKEN', payload);
  }
}

let store = new Vuex.Store({
  state,
  getters,
  mutations,
  actions
})


let component_login = new Vue({
  el: "#component_login",
  data: {
    username: "",
    password: "",
  },
  store: store,
  computed: {
    token() {
      return this.$store.getters.getToken;
    }
  },
  methods: {
    login: function () {
      let store = this.$store;
      axios({
        method: 'post',
        url: 'http://localhost/api/controllers/login.php',
        data: {
          username: this.username,
          password: this.password,
        }
      })
        .then(function (response) {
          store.dispatch('changeToken', response.data.response);
        })
        .catch(error => console.log(error))
    }
  }
})