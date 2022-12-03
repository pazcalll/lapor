var dt = null

function homePage() {
    $.ajax({
        url: webBaseUrl + '/officer/home-page',
        type: "GET",
        headers: {
            Authorization: 'bearer ' + localStorage.getItem('_token')
        },
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#home").addClass('active')
        },
        success: (res) => {
            // let mainjs = document.createElement('script');
            // mainjs.setAttribute('type', 'text/javascript');
            // mainjs.setAttribute('src', webBaseUrl+'/js/main.js');
            // document.head.appendChild(mainjs);
            $('#content').html(res)
        },
        error: (err) => {
            console.log(err)
            window.location.reload()
        }
    })
}
homePage()

function logout() {
    $.ajax({
        url: apiBaseUrl + "/user/logout",
        type: "POST",
        headers: {
            Authorization: "bearer " + localStorage.getItem('_token')
        },
        success: (res) => {
            window.location.href = webBaseUrl + "/login"
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                logout()
            }else {
                window.location.reload()
            }
        }
    })
}