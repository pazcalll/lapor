let headers = {
    Authorization: 'bearer ' + localStorage.getItem('_token') 
}


$.ajaxSetup({
    headers: headers,
    error: (err) => {
        console.log(err)
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
                let indexjs = document.createElement('script');
                indexjs.setAttribute('type', 'text/javascript');
                indexjs.setAttribute('src', webBaseUrl+'/js/main.js');
                document.body.appendChild(indexjs);
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