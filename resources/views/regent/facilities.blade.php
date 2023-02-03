<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="facilities_table" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>Nama Fasilitas</td>
                    <td>Tanggal Ditambahkan</td>
                    <td>Tanggal Diubah</td>
                    <td>Tindakan</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form onsubmit="addFacility(event)">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Fasilitas</h5>
                    <button type="button" class="btn-close modal-close btn btn-danger" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12 mt-3">
                            <div class="form-floating">
                                <label for="facility_name_add">Nama Fasilitas</label>
                                <input placeholder="Masukkan Nama Fasilitas Baru" class="form-control" name="facility_name_add" id="facility_name_add">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editFacilityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form onsubmit="editFacility(event)">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Fasilitas</h5>
                    <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Nama : </span><span class="facility_name_modal_edit"></span>
                                <input type="hidden" name="facility_name_old" id="facility_name_old">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-floating">
                                <div class="form-floating">
                                    <label for="facility_name_new">Nama Baru Fasilitas</label>
                                    <input placeholder="Masukkan Nama Baru Fasilitas Ini" class="form-control" name="facility_name_new" id="facility_name_new">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteFacilityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <form onsubmit="deleteFacility(event)">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Fasilitas</h5>
                    <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12" style="width: 100%">
                            <div class="form-floating">
                                <span>Apakah anda yakin ingin menghapus fasilitas </span><b><span class="facility_name_modal_delete"></span></b>?
                                <input type="hidden" name="facility_name_delete" id="facility_name_delete">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Iya</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#title-label').html('Fasilitas')
    getFacilitiesDatatable()
</script>