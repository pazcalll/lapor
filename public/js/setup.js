let headers = {
    Authorization: 'bearer ' + localStorage.getItem('_token')
}


$.ajaxSetup({
    headers: headers,
    error: (err) => {
        console.log(err.responseJSON)
        window.location.reload()
    },
    statusCode: {
        // 500: function(xhr) {
        //     if(window.console) console.log(xhr.responseText);
        //     localStorage.removeItem('_token')
        //     window.location.href = webBaseUrl+'/login'
        // },
        401: function (xhr) {
            window.location.href = webBaseUrl
            // authCheck()
        }
    }
})


var webBaseUrl = window.location.origin
var apiBaseUrl = webBaseUrl + '/api/v1'

function authCheck() {
    // console.log(localStorage.getItem('_token'))
    if (localStorage.getItem('_token') != null) {
        $.ajax({
            url: webBaseUrl + '/authenticator',
            type: "GET",
            success: (res) => {
                // console.log(res)
                $('#app').html(res)
                let functionsjs = document.createElement('script');
                functionsjs.setAttribute('type', 'text/javascript');
                functionsjs.setAttribute('src', webBaseUrl + '/js/functions.js');
                document.body.appendChild(functionsjs);

                setUser()
            },
            error: (err, text, statusMessage) => {
                // console.log(text, err, statusMessage)
                if (err.responseJSON.status == 401 && err.responseJSON.token != null) {
                    // console.log("reload")
                    localStorage.setItem('_token', err.responseJSON.token)
                    window.location.reload()
                } else if (err.responseJSON.status != 401) {
                    // console.log("pindah")
                    window.location.href = webBaseUrl
                }
            }
        })
    } else {
        window.location.href = webBaseUrl
    }
}
authCheck()


function setUser() {
    $.ajax({
        url: apiBaseUrl + "/user/get-profile",
        type: "GET",
        success: (res) => {
            // console.log(res)
            $('.user-fullname').html(res.name)
        }
    })
}

function profilePage() {
    $.ajax({
        url: webBaseUrl + "/profile-page",
        type: "GET",
        success: (res) => {
            console.log(res)
        }
    })
}

function logout() {
    $.ajax({
        url: apiBaseUrl + "/user/logout",
        type: "POST",
        headers: {
            Authorization: "bearer " + localStorage.getItem('_token')
        },
        success: (res) => {
            window.location.href = webBaseUrl
        },
        error: (err) => {
            if (err.responseJSON.status == 400) {
                localStorage.setItem('_token', err.responseJSON._token)
                logout()
            } else {
                window.location.href = webBaseUrl
            }
        }
    })
}