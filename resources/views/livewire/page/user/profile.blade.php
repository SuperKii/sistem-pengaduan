<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Profile</h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Profile</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="/storage/{{ Auth::guard('penghuni')->user()->foto }}" alt="user-avatar"
                            class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nama</label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                    value="{{ Auth::guard('penghuni')->user()->nama }}" autofocus="" disabled>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Email</label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                    value="{{ Auth::guard('penghuni')->user()->email }}" autofocus="" disabled>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">No Hp</label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                    value="{{ Auth::guard('penghuni')->user()->no_hp }}" autofocus="" disabled>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Alamat Unit</label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                    value="{{ Auth::guard('penghuni')->user()->alamat_unit }}" autofocus="" disabled>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
