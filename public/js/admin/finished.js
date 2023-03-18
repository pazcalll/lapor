function finishedPage() {
    $.ajax({
        url: webBaseUrl + "/admin/finished-page",
        type: "GET",
        beforeSend: () => {
            $(".nav-item").removeClass('active')
            $("#finished").addClass('active')
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
        }
    })
}

function getFinishedReports(storageLink) {
    dt = $('#finished_report').DataTable({
        ajax: {
            url: apiBaseUrl + "/user/admin/finished-reports",
            type: "GET",
            cache: true,
            headers: headers
        },
        lengthChange: false,
        scrollX: true,
        language: {
            url: webBaseUrl + "/json/datatable-indonesia.json"
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Download Excel',
                className: "btn btn-success btn-add-customer-modal",
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary')
                },
                action: function (e, dt, node, config) {
                    // window.open(apiBaseUrl + '/user/admin/finished-reports-excel')
                    $.ajax({
                        url: apiBaseUrl + '/user/admin/finished-reports-excel',
                        method: "GET",
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function (response, status, xhr) {
                            var filename = "";
                            var disposition = xhr.getResponseHeader('Content-Disposition');
                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) {
                                    filename = matches[1].replace(/['"]/g, '');
                                }
                            }
                            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;
                            link.click();
                        },
                        error: function (err) {
                            console.log(err)
                        }
                    })
                }
            }
        ],
        columnDefs: [
            { width: '10%', targets: 0 },
            { width: '15%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '25%', targets: 3 },
            { width: '15%', targets: 4 },
            { width: '20%', targets: 5 },
            { width: '20%', targets: 6 },
            { width: '20%', targets: 7 },
        ],
        columns: [
            {
                data: 'referral',
            },
            {
                data: 'created_at',
            },
            {
                data: 'assignment.created_at',
            },
            {
                data: 'assignment.finished_at',
            },
            {
                data: 'facility.name',
            },
            {
                data: 'issue',
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
                            data-street="${data.report_location.street}" 
                            data-rt="${data.report_location.rt}" 
                            data-rw="${data.report_location.rw}" 
                            data-village="${data.report_location.village}" 
                            data-sub_district="${data.report_location.sub_district}"
                            data-backdrop="false" 
                            data-toggle="modal" 
                            data-target="#detailFinishedModal" 
                            type="button" 
                            class="btn btn-info btn-detail" 
                            data-issue="${data.issue}" 
                            data-facility="${data.facility.name}" 
                            data-opd="${data.assignment.opd.name}" 
                            data-reporter="${data.reporter.name}" 
                            data-additional="${data.assignment.additional}" 
                            data-referral="${data.referral}">
                                <i class="bi bi-sticky"></i> 
                                Detail
                        </button>
                        <button class="btn btn-warning btn-proof" data-backdrop="false" data-toggle="modal" data-target="#proofModal" data-referral="${data.referral}" ${dataFiles}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns-reverse" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"/>
                            </svg> 
                            Bukti Pelapor
                        </button>
                        <button class="btn btn-success btn-proof-finish" data-item="${data.assignment.file_finish}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-columns-reverse" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"/>
                            </svg> 
                            Bukti Selesai
                        </button>
                    `
                }
            },
            {
                data: 'status'
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
            $('.btn-proof-finish').on('click', function () {
                window.open($(this).data('item'), '_blank');
            })
            $('.btn-detail').on('click', function () {
                $('.referral_modal').html($(this).data('referral'))
                $('#opd').val($(this).data('opd'))
                $('#reporter').val($(this).data('reporter'))
                $('#issue').val($(this).data('issue'))
                $('#additional').val($(this).data('additional'))

                $('#street').val($(this).data('street'))
                $('#rt').val($(this).data('rt'))
                $('#rw').val($(this).data('rw'))
                $('#village').val($(this).data('village'))
                $('#sub_district').val($(this).data('sub_district'))
            })
        }
    })
}
