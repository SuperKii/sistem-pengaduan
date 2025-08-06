<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div id="foto-user">
                            <span class="form-label">Foto User</span>
                            <img src="/storage/{{ $keluhans->penghuni->foto }}" alt="user-avatar"
                                class="d-block rounded" height="200" width="200" id="uploadedAvatar">
                        </div>
                        <div id="foto-selfie">
                            <span class="form-label">Foto Selfie</span>
                            <img src="/storage/{{ $keluhans->foto_selfie }}" alt="user-avatar" class="d-block rounded"
                                height="200" width="200" id="uploadedAvatar">
                        </div>
                        <div id="foto-keluhan">
                            <span class="form-label">Foto Keluhan</span>
                            <img src="/storage/{{ $keluhans->foto_keluhan }}" alt="user-avatar" class="d-block rounded"
                                height="200" width="200" id="uploadedAvatar">
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Deskripsi</label>
                                <textarea class="form-control" disabled>{{ $keluhans->deskripsi }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Nama Penghuni</label>
                                <input class="form-control" type="text" value="{{ $keluhans->penghuni->nama }}"
                                    disabled>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Kategori Keluhan</label>
                                <input class="form-control" type="text"
                                    value="{{ $keluhans->kategori->nama_kategori }}" disabled>
                            </div>
                            @if ($keluhans->status == 'proses' || $keluhans->status == 'selesai')
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Petugas</label>
                                    <input class="form-control" type="text" value="{{ $keluhans->petugas->nama }}"
                                        disabled>
                                </div>
                            @endif
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Status</label>
                                <div class="">
                                    <span class="badge bg-label-primary" type="text">{{ $keluhans->status }}</span>
                                </div>
                            </div>
                            @if ($keluhans->status == 'proses')
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Proses</label>
                                    <input class="form-control" type="text" value="{{ $keluhans->proses_at }}"
                                        disabled>
                                </div>
                            @endif
                            @if ($keluhans->status == 'selesai')
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Proses</label>
                                    <input class="form-control" type="text" value="{{ $keluhans->proses_at }}"
                                        disabled>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Selesai</label>
                                    <input class="form-control" type="text" value="{{ $keluhans->selesai_at }}"
                                        disabled>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <a href="{{ url()->previous() }}"" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Komentar --}}
            <div class="card">
                <h5 class="card-header">Admin Komentar</h5>
                <div class="card-body">
                    @foreach ($komentars as $data)
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-dark alert-dismissible mb-0">
                                <h6 class="alert-heading fw-bold mb-1">{{ $data->admin->name }}</h6>
                                <p class="mb-0">{{ $data->deskripsi }}</p>
                                @if (Auth::guard('web')->check())
                                    @if (Auth::guard('web')->user()->role == 'admin')
                                        <button type="submit"
                                            wire:click="delete({{ $data->id }},{{ $data->keluhan_id }})"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus komentar')"
                                            class="btn-close" aria-label="Close"></button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if (Auth::guard('web')->check())
                        @if (Auth::guard('web')->user()->role == 'admin')
                            <form wire:submit.prevent="store({{ $keluhans->id }})">
                                <div class="mb-3">
                                    <label class="form-check-label" for="deskripsi-komentar">Komentar</label>
                                    <input class="form-control" type="text" wire:model="deskripsi"
                                        id="deskripsi-komentar">
                                </div>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bx  bx-send"></i> <span>Kirim</span>
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
