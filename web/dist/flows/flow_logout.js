logoutTopBarElement.onClickLogout(function () {
    sessions.logout(function (response) {
        if (response.status === 200){
            store.dispatch('resetStore')
            location.href='login.html'
        }
    })
})