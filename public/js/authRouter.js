const webBaseUrl = window.location.origin
const apiBaseUrl = webBaseUrl + '/api/v1'

function loginPage() {
    $.ajax({
        url: webBaseUrl+'/login-page',
        type: 'GET',
        beforeSend: function () {  
            $('.form-spinner').removeClass('visually-hidden')
            $('.auth-content').html(' ')
        },
        success: function (res) {  
            $('.auth-content').html(res)
        },
        error: function (err) {  
            console.log(err)
        },
        complete: function () {  
            $('.form-spinner').addClass('visually-hidden')
        }
    })
}

function registerPage() {
    $.ajax({
        url: webBaseUrl+'/register-page',
        type: 'GET',
        beforeSend: function () {  
            $('.form-spinner').removeClass('visually-hidden')
            $('.auth-content').html(' ')
        },
        success: function (res) {  
            $('.auth-content').html(res)
        },
        error: function (err) {  
            console.log(err)
        },
        complete: function () {  
            $('.form-spinner').addClass('visually-hidden')
        }
    })
}