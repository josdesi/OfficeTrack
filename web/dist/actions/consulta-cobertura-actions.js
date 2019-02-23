var actions = ( function( a, b ){
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a ;

})( {
    addLeadAddress: (context, payload) => {
        context.commit( "ADD_LEAD_ADDRESS", payload )
    },
    addProfile: (context, payload) => {
        context.commit( "ADD_PROFILE", payload )
    },
    addTodo: (context, payload) => {
        context.commit("ADD_TODO", payload)
    },
    toggleTodo: (context, payload) => {
        context.commit("TOGGLE_TODO", payload)
    },
    deleteTodo: (context, payload) => {
        context.commit("DELETE_TODO", payload)
    }
}, actions );


var mutations = ( function( a, b ){
    var ref = {};
    for (var attrname in a) { ref[attrname] = a[attrname]; }
    for (var attrname in b) { ref[attrname] = b[attrname]; }
    return a != undefined ? ref : a ;

})( {
    ADD_LEAD_ADDRESS: (state, payload) => {

        var newTask = {
            street: payload.street,
            streetNumber: payload.streetNumber,
            colony: payload.colony,
            city: payload.city,
            state: payload.state,
            zipCode: payload.zipCode,
            latitude: payload.latitude,
            longitude: payload.longitude,
            formattedAddress: payload.formattedAddress,
        }
        state.user.leadAddress = newTask;
    },
    ADD_PROFILE: (state, payload) => {

        var newTask = {
            name: payload.name,
            surnameFather: payload.surnameFather,
            surnameMother: payload.surnameMother,
            email: payload.email,
            userId: payload.userId,
        }
        state.profile = newTask;
    },

    ADD_TODO: (state, payload) => {

        var newTask = {
            id: payload.newId,
            task: payload.task,
            completed: false
        }

        state.todos.unshift( newTask );
    },
    TOGGLE_TODO: (state, payload) => {
        var item = state.todos.find(todo => todo.id === payload);
        item.completed = !item.completed;
    },
    DELETE_TODO: (state, payload) => {
        var index = state.todos.findIndex(todo => todo.id === payload);
        state.todos.splice(index, 1);
    }
}, mutations );