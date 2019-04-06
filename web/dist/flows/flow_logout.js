logoutButtonElement.onClickLogout(function () {
        sessions.logout(function (response) {
            switch (response.data.code) {
                case 'RSP_00':
                    store.dispatch('resetStore')
                    location.href='login.html'
                    break;
                case 'RSP_01':
                    logoutButtonElement.showModal('m-00')
                    break;
                case 'RSP_03':
                    logoutButtonElement.showModal('m-00')
                    break;
                case 'RSP_07':
                    logoutButtonElement.showModal('m-00')
                    break;
                default:
                    logoutButtonElement.showModal('m-00')
                    break;
            }
        },
        function () {
            console.error(error)
            logoutButtonElement.showModal('m-00')
        })
})