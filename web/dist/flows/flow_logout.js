logoutTopBarElement.onClickLogout(function () {
    sessions.logout(function (response,token) {
        if (response.status === 200){
            sessions.resetStateStore(token)
            location.href='login.html'
        }
    })
})