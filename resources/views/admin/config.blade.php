<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <p class="container-fluid text-base" style="font-size: 14pt">Pada halaman ini admin bisa mengatur role/peran dari setiap user yang ada. 
            Gunanya adalah untuk menentukan pengguna mana yang menjadi petugas/pegawai dan pelanggan yang ingin melapor.</p>
        <table id="user_table" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>Username</td>
                    <td>Role</td>
                    <td>Nomor Telepon</td>
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
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addOpdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah OPD</h5>
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addOpdForm">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <label for="username">Username <span style="color: red">*</span></label>
                                <input type="text" placeholder="Username" class="form-control" name="username" id="username">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <label for="password">Password <span style="color: red">*</span></label>
                                <input type="password" placeholder="Password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <label for="name">Nama Lengkap <span style="color: red">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Alamat</span>
                                <div id="address" name="address">
                                    <input type="text" class="form-control mt-1 mb-1" id="street" name="street" placeholder="Nama Jalan">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                                    <input type="text" class="form-control mt-1 mb-1" id="sub_district" name="sub_district" placeholder="Kecamatan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <label for="phone">Nomor Telepon <span style="color: red">*</span></label>
                                <input type="text" placeholder="Nomor Telepon" class="form-control" name="phone" id="phone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambahkan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Role Pengguna</h5>
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="addCustomer(event)" id="editForm">
                @method("POST")
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- <div class="errors alert alert-danger" style="display: none">

                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-floating">
                                <div>Username <span style="color: red">*</span></div>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <div>Password <span style="color: red">*</span></div>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Nama Lengkap <span style="color: red">*</span></span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Alamat</span>
                                <div id="address" name="address">
                                    <input type="text" class="form-control mt-1 mb-1" id="street" name="street" placeholder="Nama Jalan">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                                    <input type="text" class="form-control mt-1 mb-1" id="sub_district" name="sub_district" placeholder="Kecamatan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <div>Nomor Telepon <span style="color: red">*</span></div>
                                <input type="text" placeholder="Nomor Telepon" class="form-control" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mt-1">
                                <div>SK Pengangkatan <span style="color: red">*</span></div>
                                <input type="file" name="appointment_letter" id="appointment_letter" class="dropify">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambahkan Data</button>
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