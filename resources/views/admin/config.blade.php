<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <p class="container-fluid text-base">Pada halaman ini admin bisa mengatur role/peran dari setiap user yang ada. 
            Gunanya adalah untuk menentukan pengguna mana yang menjadi petugas/pegawai dan pelanggan yang ingin melapor.</p>
        <table id="user_table" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>Username</td>
                    <td>Role</td>
                    <td>Nomor Telepon</td>
                    <td>Alamat</td>
                    <td>Tindakan</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="container py-5">
    </div>
</div>
<!-- Header End -->

<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Role Pengguna</h5>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form onsubmit="editUser(event)" id="editForm">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Username : </span><span class="username"></span>
                                <input type="hidden" name="username" id="username">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control" disabled>
                                <label for="name">Nama Lengkap</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-select" aria-placeholder="">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#title-label').html('Pengaturan Pengguna')
    $('#title-desc').html('Pada halaman ini admin bisa mengatur role/peran dari setiap user yang ada. Gunanya adalah untuk menentukan pengguna mana yang menjadi petugas/pegawai dan pelanggan yang ingin melapor.')
    userTable()
    getEnumUser()
</script>