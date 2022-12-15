<div>
    <p class="mb-4 animated slideInDown">Sudah punya akun? klik di <a class="fs-5" style="background-color: yellow" onclick="loginPage()" href="javascript:void(0)">sini</a></p>
    <div class="alert alert-danger errors visually-hidden">
        
    </div>
    
    <form onsubmit="register(event)">
        @csrf
        <div class="row g-3">
            <div class="col-md-12">
                <div class="form-floating animated slideInDown">
                    <input type="text" class="form-control" id="fullname" name="name" placeholder="Nama Lengkap">
                    <label for="fullname">Nama Lengkap <span style="color: red">*</span></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating animated slideInDown">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <label for="username">Username <span style="color: red">*</span></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating animated slideInDown">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password <span style="color: red">*</span></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating animated slideInDown">
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Telepon">
                    <label for="phone">Nomor Telepon</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating animated slideInDown">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Alamat">
                    <label for="address">Alamat</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-success py-3 px-4 animated slideInDown" type="submit">Daftar</button>
            </div>
        </div>
    </form>
</div>