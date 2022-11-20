<div class="container" id="form-content">
    <div class="row g-5 mb-5">
        <div class="col-lg-6">
            <h1 class="display-6">Login Sekarang</h1>
            <p class="text-primary fs-5 mb-0">Laporkan masalah publik yang ada disekitar</p>
        </div>
    </div>
    <div class="row g-5">
        <div class="col-lg-12">
            <p class="mb-4">Belum punya akun? klik di <a class="fs-5" style="background-color: yellow" onclick="registerPage()" href="javascript:void(0)">sini</a></p>
            <div class="errors">
                
            </div>
            <form>
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary py-3 px-4" type="submit">Login Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>