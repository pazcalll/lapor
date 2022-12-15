<div>
    <p class="mb-4 animated slideInDown">Belum punya akun? klik di <a class="fs-5" style="background-color: yellow" onclick="registerPage()" href="javascript:void(0)">sini</a></p>
    <div class="errors alert alert-danger visually-hidden" id="errors">
        
    </div>
    <form onsubmit="login(event)">
        @csrf
        <div class="row g-3">
            <div class="col-md-12">
                <div class="form-floating animated slideInDown">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating animated slideInDown">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="col-12 animated slideInDown">
                <button class="btn btn-primary py-3 px-4" type="submit">Login</button>
            </div>
        </div>
    </form>
</div>