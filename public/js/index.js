const webBaseUrl = window.location.origin
const apiBaseUrl = webBaseUrl + '/api/v1'

function authCheck() {  
    console.log(localStorage.getItem('_token'))
    if (localStorage.getItem('_token') != null) {
        $.ajax({
            url: webBaseUrl + '/indexPage',
            type: "GET",
            headers: {
                Authorization: 'bearer' + localStorage.getItem('_token')
            },
            success: (res) => {
                $('#app').html(res)        
                let script = document.createElement('script');
                script.setAttribute('type', 'text/javascript');
                script.setAttribute('src', webBaseUrl+'/js/main.js');
                document.head.appendChild(script);
            },
            error: (err) => {
                if (err.status != 400) {
                    window.location.href = webBaseUrl+'/login'
                }
            }
        })
    }else {
        window.location.href = webBaseUrl+'/login'
    }
}
authCheck()