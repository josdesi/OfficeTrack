var URL_NEWLETTER = env.newsletterURL;


var newsletter = new Vue({
    el: "",
    data: {
        
    },
    methods: {
        register: function (fields, callback, callbackOnFail) {
            axios({
                method: 'post',
                url: URL_NEWLETTER,
                data: fields,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(function (response) {
                    callback(response, fields)
                })
                .catch(() => callbackOnFail())
        },
    }
})