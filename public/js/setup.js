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
        500: function(xhr) {
            if(window.console) console.log(xhr.responseText);
            window.location.href = webBaseUrl+'/login'
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
                functionsjs.setAttribute('src', webBaseUrl+'/js/functions.js');
                document.body.appendChild(functionsjs);
                
                setUser()
            },
            error: (err, text, statusMessage) => {
                // console.log(text, err, statusMessage)
                if(err.responseJSON.status == 400 && err.responseJSON.token != null) {
                    // console.log("reload")
                    localStorage.setItem('_token', err.responseJSON.token)
                    window.location.reload()
                }else if (err.responseJSON.status != 400) {
                    // console.log("pindah")
                    window.location.href = webBaseUrl+'/login'
                }
            }
        })
    }else {
        window.location.href = webBaseUrl+'/login'
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