

function processPage() {
    $.ajax({
        url: webBaseUrl + '/admin/process-page',
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#process").addClass('active')
            $("#content").html(`
                <span class="d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; background-color: white; width: 100%; height: 80%; align-content: center">
                    <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </span>
            `)
        },
        success: (res) => {
            $("#content").html(res)
        },
        error: (err) => {
            console.log(err)
            console.log(err.responseJSON)
            console.log(err.responseText)
        }
    })
}

function getAcceptedReports(storageLink) {
    dt = $('#inprocess_report').DataTable({
        ajax: {
            url: apiBaseUrl + "/user/admin/accepted-reports",
            type: "GET",
            cache: true,
            headers: headers
        },
        lengthChange: false,
        processing: true,
        scrollX: true,
        language: {
            url: webBaseUrl + "/json/datatable-indonesia.json"
        },
        columnDefs: [
            { width: '15%', targets: 0 },
            { width: '30%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '25%', targets: 4 },
        ],
        columns: [
            {
                data: 'referral',
            },
            {
                data: null,
                render: function (data, type, full, meta) {
                    let options = ``
                    opds.forEach(opd => {
                        options += `
                            <option value="${opd.id}" ${opd.id == data.assignment.opd.id ? 'selected' : ''}>${opd.name}</option>
                        `
                    });
                    return `
                        <div>
                            <select class="form-control opd-changer" data-referral="${data.referral}">
                                ${options}
                            </select>
                        </div>
                        <span style="display: none" class="opd-${data.referral}">Loading...</span>
                    `
                }
            },
            {
                data: 'assignment.created_at',
            },
            {
                data: null,
                render: function (data, type, full, meta) {
                    let deadline = new Date(data.deadline_at)
                    deadline = `${deadline.getFullYear()}-${String(deadline.getMonth() + 1).padStart(2, '0')}-${String(deadline.getDate()).padStart(2, '0')}`
                    if (new Date() > new Date(data.deadline_at)) return deadline + ' <span style="color:red">Melewati tenggat waktu</span>'
                    else return deadline
                }
            },
            {
                data: null,
                render: function (data, type, full, meta) {
                    let dataFiles = ``
                    data.report_file.forEach((ele, _index) => {
                        dataFiles += `data-file${(_index + 1)}="${ele.proof_file}" `
                    })
                    return `
                        <button 
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#detailModal" 
                            type="button" 
                            class="btn btn-info btn-detail" 
                            data-issue="${data.issue}" 
                            data-facility="${data.facility.name}" 
                            data-opd="${data.assignment.opd.name}" 
                            data-street="${data.report_location.street}" 
                            data-rt="${data.report_location.rt}" 
                            data-rw="${data.report_location.rw}" 
                            data-village="${data.report_location.village}" 
                            data-sub_district="${data.report_location.sub_district}" 
                            data-reporter="${data.reporter.name}" 
                            data-additional="${data.assignment.additional}" 
                            data-referral="${data.referral}">
                                Detail
                        </button>
                        <button
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#proofModal" 
                            class="btn btn-warning btn-proof" 
                            data-referral="${data.referral}"
                            ${dataFiles}>
                                Lihat Bukti
                        </button>
                    `
                }
            }
        ],
        drawCallback: (res) => {
            $('.btn-proof').on('click', function () {
                $('.referral_proof').html($(this).data('referral'))
                let proofs = ``
                let i = 0
                while (true) {
                    i += 1
                    if ($(this).data(`file${i}`) === undefined) {
                        break
                    }
                    proofs += `<a href="javascript:void(0)" onclick="window.open('${webBaseUrl}/storage/proof/${$(this).data(`file${i}`)}', '_blank')" class="btn btn-primary">Bukti ${i}</a>`
                }
                $('.proof-container').html(proofs)
            })
            $('.btn-detail').on('click', function () {
                $('.referral_modal').html($(this).data('referral'))
                $('#opd').val($(this).data('opd'))
                $('#reporter').val($(this).data('reporter'))
                $('#street').val($(this).data('street'))
                $('#rt').val($(this).data('rt'))
                $('#rw').val($(this).data('rw'))
                $('#village').val($(this).data('village'))
                $('#sub_district').val($(this).data('sub_district'))
                $('#issue').val($(this).data('issue'))
                $('#additional').val($(this).data('additional'))
            })
            // $.ajax({
            //     url: apiBaseUrl + "/user/get-facilities",
            //     type: "GET",
            //     success: (res) => {
            //         let facilityHTML = '<option value="0" selected disabled hidden>Pilih Fasilitas</option>'
            //         res.forEach(facility => {
            //             facilityHTML += `
            //                 <option value="${facility.id}">${facility.name}</option>
            //             `
            //         });
            //         $('#facility').html(facilityHTML)
            //     },
            //     error: (err) => {
            //         console.log(err)
            //         window.location.reload()
            //     }
            // })
            $('select').select2()
            $('.opd-changer').on('change', function () {
                $(this).parent().css('display', 'none')
                $(`.opd-${$(this).data('referral')}`).css('display', 'block')

                let fd = new FormData();
                fd.append('_method', 'PUT')
                fd.append('referral', $(this).data('referral'))
                fd.append('opd_id', $(this).val())
                $.ajax({
                    url: apiBaseUrl + '/user/admin/change-assignment-opd',
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        toastr.success('OPD telah diganti')
                    },
                    error: (err) => {
                        toastr.error(err.responseJSON.message)
                    },
                    complete: () => {
                        dt.ajax.reload()
                        $(this).parent().css('display', 'block')
                        $(`.opd-${$(this).data('referral')}`).css('display', 'none')
                    }
                })
            })
        }
    })
}