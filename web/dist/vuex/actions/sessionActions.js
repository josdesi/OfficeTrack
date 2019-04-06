var mutations = (function (a, b) {
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a;

})({
    SAVE_BEARER_TOKEN: (state, payload) => {
        state.session.bearerToken = payload;
    }
}, mutations);

var actions = (function (a, b) {
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a;

})({
    saveBearerToken: (context, payload) => {
        context.commit('SAVE_BEARER_TOKEN', payload);
    }
}, actions);
