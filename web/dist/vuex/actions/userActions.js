var actions = (function (a, b) {
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a;

})({
    //actions
}, actions);

var mutations = (function (a, b) {
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a;

})({
    //mutations
}, mutations);