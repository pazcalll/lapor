
function facilitiesPage() {
    $.ajax({
        url: webBaseUrl + "/admin/facilities-page",
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#content").html(`
                <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                    <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </span>
            `)
        },
        success: (res) => {
            $('#content').html(res)
        }
    })
}

function getFacilitiesDatatable() {
    dt = $('#facilities_table').DataTable({
        ajax : {
            url: apiBaseUrl + "/user/admin/facilities-datatable",
            type: "GET",
            headers: headers
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Tambah Fasilitas',
                className: "btn btn-success btn-add-facility-modal",
                attr:  {
                    "data-backdrop": 'false',
                    "data-toggle": 'modal',
                    "data-target": "#addFacilityModal"
                }
            }
        ],
        lengthChange: false,
        scrollX: true,
        language: {
            url: webBaseUrl + "/json/datatable-indonesia.json"
        },
        columnDefs: [
            { width: '20%', targets: 0 },
            { width: '25%', targets: 1 },
            { width: '25%', targets: 2 },
            { width: '30%', targets: 3 },
        ],
        columns: [
            {
                data: 'name',
            },
            {
                data: 'created_at',
            },
            {
                data: 'updated_at',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `
                        <button 
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#editFacilityModal" 
                            data-name="${data.name}"
                            type="button" 
                            class="btn btn-info btn-edit-facility" 
                        >
                            <i class="bi bi-pencil-square"></i> 
                            Edit
                        </button>
                        <button
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#deleteFacilityModal" 
                            data-delete="${data.name}"
                            class="btn btn-danger btn-delete-facility"
                        >
                            Hapus
                        </button>
                    `
                }
            }
        ],
        drawCallback: () => {
            $('.btn-edit-facility').on('click', function () {  
                $('.facility_name_modal_edit').html($(this).data('name'))
                $('#facility_name_old').val($(this).data('name'))
            })
            $(".btn-delete-facility").on("click", function () {  
                $('.facility_name_modal_delete').html($(this).data('delete'))
                $('#facility_name_delete').val($(this).data('delete'))
            })
        }
    })
}

function addFacility(e) {
    e.preventDefault()
    let fd = new FormData()
    fd.append('name', $('#facility_name_add').val())
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    $.ajax({
        url: apiBaseUrl + "/user/admin/facility",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        beforeSend: () => {
            $(".modal-close").click()
            $('.facility_name_modal_edit').val("")
            $('#facility_name_old').val("")
            $('#facility_name_new').val("")
            toastr.warning("Mohon tunggu")
        },
        success: (res) => {
            console.log(res)
            toastr.remove()
            toastr.success("Penambahan fasilitas berhasil")
            dt.ajax.reload()
        },
        error: (err) => {
            console.log(err)
            toastr.error("Penambahan fasilitas gagal")
        }
    })
}

function editFacility(e) {
    let name_old = $('#facility_name_old').val()
    let name_new = $('#facility_name_new').val()
    let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    $.ajax({
        url: apiBaseUrl + "/user/admin/facility",
        type: "PATCH",
        data: {
            name_old: name_old,
            name_new: name_new,
            _token: _token,
        },
        beforeSend: () => {
            $(".modal-close").click()
            $('#facility_name_old').val("")
            $('#facility_name_new').val("")
            toastr.warning("Mohon tunggu")
        },
        success: (res) => {
            console.log(res)
            toastr.remove()
            toastr.success("Perubahan fasilitas berhasil")
            dt.ajax.reload()
        },
        error: (err) => {
            console.log(err)
            toastr.error("Perubahan fasilitas gagal")
        }
    })
}

function deleteFacility(e) {
    e.preventDefault()
    let name_delete = $('#facility_name_delete').val()
    let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    $.ajax({
        url: apiBaseUrl + "/user/admin/facility",
        type: "DELETE",
        data: {
            name_delete: name_delete,
            _token: _token,
        },
        beforeSend: () => {
            $(".modal-close").click()
            $('#facility_name_delete').val("")
            toastr.warning("Mohon tunggu")
        },
        success: (res) => {
            toastr.remove()
            toastr.success("Penghapusan fasilitas berhasil")
            dt.ajax.reload()
        },
        error: (err) => {
            toastr.error("Penghapusan fasilitas gagal")
        }
    })
}