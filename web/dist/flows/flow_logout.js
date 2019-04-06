logoutButton.onClick(function () {
    sessions.logout(function (response) {
        $('#transicion').modal('show')
        switch (response.data.code) {
            case 'RSP_00':
                store.dispatch('resetStore')
                location.href = 'login.html'
                break;
            case 'RSP_01':
                $('#transicion').modal('hide')
                $('#m-00').modal('show')
                break;

            case 'RSP_03':
                $('#transicion').modal('hide')
                $('#m-00').modal('show')
                break;

            case 'RSP_04':
                $('#transicion').modal('hide')
                $('#m-00').modal('show')
                break;

            default:
                $('#m-00').modal('show')
                break;
        }
    },
        function () {
            console.error(error)
            $('#m-00').modal('show')
        })
})