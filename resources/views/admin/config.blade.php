<!-- Header Start -->
<div class="container-fluid page-heading py-5 mb-5">
    <div class="row g-5 align-items-center">
        <table id="user_table" class="table table-striped table-borderless" style="width: 100%">
            <thead>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>Username</td>
                    <td>Role</td>
                    <td>Nomor Telepon</td>
                    <td>Status Akun</td>
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
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Pengguna</h5>
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="editCustomer(event)" id="editCustomerForm">
                @method("POST")
                @csrf
                <input type="hidden" name="id_customer" id="id_customer">
                <div class="modal-body">
                    <div class="form-group">
                        <div>Username</div>
                        <input type="text" class="form-control" name="username_customer" id="username_customer" placeholder="Username">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_customer">Password</label>
                                <input type="password" placeholder="Password Baru (Opsional)" class="form-control mt-1 mb-1" id="password_customer" name="password_customer">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirm_customer">Konfirmasi Password</label>
                                <input type="password" placeholder="Konfirmasi Password Baru (Opsional)" class="form-control mt-1 mb-1" id="password_confirm_customer" name="password_confirm_customer">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <span>Nama Lengkap</span>
                        <input type="text" name="name_customer" id="name_customer" class="form-control mt-1 mb-1" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <span>Jabatan</span>
                        <select class="form-control mt-1 mb-1" name="customer_position_customer" id="customer_position_customer" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <span>Gender</span>
                        <select class="form-control mt-1 mb-1" name="gender_customer" id="gender_customer" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <span>Alamat</span>
                        <div id="address" name="address">
                            <input type="text" class="form-control mt-1 mb-1" id="street_customer" name="street_customer" placeholder="Nama Jalan">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-1 mb-1" id="rt_customer" name="rt_customer" placeholder="RT">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-1 mb-1" id="rw_customer" name="rw_customer" placeholder="RW">
                                </div>
                            </div>
                            <input type="text" class="form-control mt-1 mb-1" id="village_customer" name="village_customer" placeholder="Desa">
                            <input type="text" class="form-control mt-1 mb-1" id="sub_district_customer" name="sub_district_customer" placeholder="Kecamatan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>Nomor Telepon</div>
                        <input type="text" placeholder="Nomor Telepon" class="form-control mt-1 mb-1" name="phone_customer" id="phone_customer">
                    </div>
                    <div class="form-group mt-1 mb-1">
                        <div>SK Pengangkatan Saat Ini: <button style="color: blue" type="button" id="current_appointment_letter_customer">LINK</button></div>
                    </div>
                    <div class="form-group mt-1 mb-1">
                        <div>SK Pengangkatan</div>
                        <input type="file" name="appointment_letter_customer" id="appointment_letter_customer" class="dropify">
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
<div class="modal fade" id="editOpdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit OPD</h5>
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="editOpd(event)" id="editOpdForm">
                @method("POST")
                @csrf
                <input type="hidden" name="id_opd" id="id_opd">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username_opd">Username</label>
                        <input type="text" class="form-control mt-1 mb-1" id="username_opd" name="username_opd">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" placeholder="Password Baru (Opsional)" class="form-control mt-1 mb-1" id="password_opd" name="password_opd">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirm">Konfirmasi Password</label>
                                <input type="password" placeholder="Konfirmasi Password Baru (Opsional)" class="form-control mt-1 mb-1" id="password_confirm_opd" name="password_confirm_opd">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_opd">Name</label>
                        <input required type="text" class="form-control mt-1 mb-1" id="name_opd" name="name_opd">
                    </div>
                    <div class="form-group">
                        <label for="phone_opd">Nomor Telepon / HP</label>
                        <input required type="number" class="form-control mt-1 mb-1" id="phone_opd" name="phone_opd">
                    </div>
                    <div class="form-group">
                        <label for="location">Lokasi</label>
                        <div id="location" name="location">
                            <div class="page-heading">
                                <label for="street_opd">Nama Jalan</label>
                                <input required type="text" class="form-control mt-1 mb-1" id="street_opd" name="street_opd" placeholder="Nama Jalan">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="rt_opd">RT</label>
                                        <input required type="text" class="form-control mt-1 mb-1" id="rt_opd" name="rt_opd" placeholder="RT">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="rw_opd">RW</label>
                                        <input required type="text" class="form-control mt-1 mb-1" id="rw_opd" name="rw_opd" placeholder="RW">
                                    </div>
                                </div>
                                <label for="village_opd">Desa</label>
                                <input required type="text" class="form-control mt-1 mb-1" id="village_opd" name="village_opd" placeholder="Desa">
                                <label for="sub_district_opd">Kecamatan</label>
                                <input required type="text" class="form-control mt-1 mb-1" id="sub_district_opd" name="sub_district_opd" placeholder="Kecamatan">
                            </div>
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
                                <span>Jabatan <span style="color: red">*</span></span>
                                <select class="form-control" name="customer_position" id="customer_position" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Jenis Kelamin <span style="color: red">*</span></span>
                                <select class="form-control" name="gender" id="gender" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <span>Alamat <span style="color: red">*</span></span>
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

<!-- Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Role Pengguna</h5>
                <button type="button" class="btn-close modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="changeUserStatus(event)" id="changeUserStatusForm">
                @method("PUT")
                @csrf
                <input type="hidden" name="status" id="status">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="container">
                        Apakah anda yakin ingin mengubah status dari akun <strong class="username-strong"></strong> dengan 
                        nama <strong class="name-strong"></strong> menjadi berstatus <strong class="status-strong"></strong>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ubah Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#title-label').html('Pengaturan Pengguna')
    $('#title-desc').html('Pada halaman ini admin bisa mengatur role/peran dari setiap user yang ada. Gunanya adalah untuk menentukan pengguna mana yang menjadi petugas/pegawai dan pelanggan yang ingin melapor.')
    userTable()
    // getEnumUser()
</script>