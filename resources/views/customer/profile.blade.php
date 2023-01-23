<div class="container-fluid page-heading py-5 mb-5">
    <div class="container py-5">
        <form onsubmit="updateProfile(event)">
            @method('PUT')
            <div class="col-md-12">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input disabled type="text" class="form-control mt-1 mb-1" id="username" name="username">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" placeholder="Password Baru (Opsional)" class="form-control mt-1 mb-1" id="password" name="password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirm">Konfirmasi Password</label>
                            <input type="password" placeholder="Konfirmasi Password Baru (Opsional)" class="form-control mt-1 mb-1" id="password_confirm" name="password_confirm">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input required type="text" class="form-control mt-1 mb-1" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="gender">Kelamin</label>
                    <select class="form-control" name="gender" id="gender">
                        <option selected disabled>Pilih Gender</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon / HP</label>
                    <input required type="number" class="form-control mt-1 mb-1" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="position">Jabatan</label>
                    <input disabled type="text" class="form-control mt-1 mb-1" id="position" name="position">
                </div>
                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <div id="location" name="location">
                        <div class="page-heading">
                            <label for="street">Nama Jalan</label>
                            <input required type="text" class="form-control mt-1 mb-1" id="street" name="street" placeholder="Nama Jalan">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rt">RT</label>
                                    <input required type="text" class="form-control mt-1 mb-1" id="rt" name="rt" placeholder="RT">
                                </div>
                                <div class="col-md-6">
                                    <label for="rw">RW</label>
                                    <input required type="text" class="form-control mt-1 mb-1" id="rw" name="rw" placeholder="RW">
                                </div>
                            </div>
                            <label for="village">Desa</label>
                            <input required type="text" class="form-control mt-1 mb-1" id="village" name="village" placeholder="Desa">
                            <label for="sub_district">Kecamatan</label>
                            <input required type="text" class="form-control mt-1 mb-1" id="sub_district" name="sub_district" placeholder="Kecamatan">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="appointment_letter">Surat Keterangan Pengangkatan </label>
                    <a href="javascript:void(0)" id="appointment_letter_link">LINK</a>
                </div>
                <p style="width:100%; display: none; justify-content: center; align-content: center" class="p-loading">Sedang mengunggah data, harap tunggu!...</p>
                <button class="btn btn-warning w-100 btn-submit"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#title-label').html("Profil")
</script>