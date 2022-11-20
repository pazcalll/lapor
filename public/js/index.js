const webBaseUrl = window.location.origin
const apiBaseUrl = webBaseUrl + '/api/v1'

function authCheck() {  
    console.log(localStorage.getItem('_token'))
    if (localStorage.getItem('_token') != null) {
        $.ajax({
            url: apiBaseUrl,
            type: "GET",
            headers: {
                Authorization: localStorage.getItem('_token')
            },
            success: (res) => {
                $('#app').html(res)
            },
            error: (err) => {
                console.log(err)
            }
        })
    }else {
        window.location.href = webBaseUrl+'/login'
    }
}
authCheck()