<div class="container-fluid hero-header py-5 mb-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-xs-12 col-md-8 offset-md-2 border block" style="border-radius: 50px;">
                <h3 class="m-0 text-primary justify-content-center d-flex m-5">Alur Pelaporan Aplikasi</h3>
                <div class="wrapper-progressBar">
                    <ul class="progressBar">
                        <li class="text-primary active mb-5">1<br><i class="fa fa-user-plus fa-2x mt-4 mb-1" aria-hidden="true"></i><br>Mendaftar ke Aplikasi</li>
                        <li class="text-primary active mb-5">2<br><i class="fa fa-file fa-2x mt-4 mb-1" aria-hidden="true"></i><br>Membuat Laporan</li>
                        <li class="text-primary active mb-5">3<br><i class="fa fa-check-square fa-2x mt-4 mb-1" aria-hidden="true"></i><br>Cek Status Laporan</li>
                        <li class="text-primary active mb-5">4<br><i class="fa fa-comment fa-2x mt-4 mb-1" aria-hidden="true"></i><br>Feedback</li>
                        <li class="text-primary active mb-5">5<br><i class="fa fa-flag-checkered fa-2x mt-4 mb-1" aria-hidden="true"></i><br>Selesai</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl bg-light report-form" style="padding-bottom: 200px">
    <span class="visually-hidden d-flex align-items-center justify-content-center form-spinner" style="z-index: 3; position: absolute; width: 100%; height: 80%; align-content: center;">
        <span style="position: absolute; width: 200px; height: 200px;" class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </span>
    </span>
    <div class="container" id="form-content">
        <div class="row g-5 mb-5 wow fadeInUp">
            <div class="col-lg-6">
                <h1 class="display-6">Buat Laporan</h1>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                <div class="errors">
                    
                </div>
                <form id="makeReport">
                    @method("POST")
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="location" name="location" placeholder="Lokasi">
                                <label for="location">Lokasi</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <select name="facility" id="facility" class="form-select" aria-placeholder="">
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                {{-- <input type="password" class="form-control" id="password" name="password" placeholder="Password"> --}}
                                <textarea class="form-control" style="height: 100px" name="issue" id="issue" placeholder="Detail Masalah" cols="30" rows="50"></textarea>
                                <label for="issue">Detail Masalah</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="file" name="proof" id="proof" class="dropify" required type="file" data-plugin="dropify" data-max-file-size="1M" >
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Buat Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>