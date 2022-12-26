function profilePage() {
    $.ajax({
        url: webBaseUrl + "/profile-page",
        type: "GET",
        beforeSend:() => {
            $('#content').html(`
            <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </span>
            `)
        },
        success: (res1) => {
            $('.menu-backdrop').click()

            $.ajax({
                url: apiBaseUrl + "/user/get-profile",
                type: "GET",
                success: (res2) => {

                    $.ajax({
                        url: apiBaseUrl + "/user/get-gender-enum",
                        type: "GET",
                        beforeSend: () => {
                            $("#content").html(res1)
                        },
                        success: (res3) => {
                            res3.forEach(gender => {
                                $('#gender').append(`
                                    <option value="${gender}">${gender}</option>
                                `)
                            });
                        },
                        error: (err) => {
                            console.log(err)
                        },
                        complete: () => {
                            $('#name').val(res2.name)
                            $('#username').val(res2.username)
                            $('#password').val(res2.password)
                            $('#phone').val(res2.phone)
                            $('#street').val(res2.user_address_detail.street)
                            $('#rt').val(res2.user_address_detail.rt)
                            $('#rw').val(res2.user_address_detail.rw)
                            $('#village').val(res2.user_address_detail.village)
                            $('#sub_district').val(res2.user_address_detail.sub_district)
                            $('#appointment_letter_link').data('url', webBaseUrl+"/storage/appointment_letter/"+res2.appointment_letter)

                            $('#appointment_letter_link').on('click', function () {  
                                window.open($(this).data('url'), '_blank')
                            })
                            $('#gender').val(res2.gender)
                        }
                    })
                }
            })
        }
    })
}

function updateProfile(e) {
    e.preventDefault()

    if ($('#password').val() == $('#password_confirm').val()) {
        $.ajax({
            url: apiBaseUrl + '/user/update-profile',
            type: "PATCH",
            data: {
                name: $('#name').val(),
                username: $('#username').val(),
                password: $('#password').val(),
                street: $('#street').val(),
                rt: $('#rt').val(),
                rw: $('#rw').val(),
                village: $('#village').val(),
                sub_district: $('#sub_district').val(),
                phone: $('#phone').val(),
                gender: $('#gender').val()
            },
            beforeSend: () => {
                $('.btn-submit').css('display', 'none')
                $('.p-loading').css('display', 'flex')
            },
            success: (res) => {
                toastr.success('Data Berhasil diperbarui')
                $("#userAccount").html($('#name').val())
            },
            error: (err) => {
                if (err.responseJSON.errors !== null) {
                    for (let i = 0; i < err.responseJSON.errors.length; i++) {
                        toastr.error(err.responseJSON.errors[i])
                    }
                }
                else{
                    toastr.error('Aksi gagal, harap coba lagi nanti atau hubungi admin!')
                }
            },
            complete: () => {
                $('.btn-submit').css('display', 'block')
                $('.p-loading').css('display', 'none')
            }
        })
    } else {
        toastr.error('Password baru dan konfirmasi tidak sama!')
    }
}