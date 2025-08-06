<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Tambah Keluhan</h4>

    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Keluhan</h5>
                <small class="text-muted float-end">Form</small>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="col mb-3">
                        <label for="nameWithTitle" class="form-label">Deskripsi</label>
                        <textarea type="text" wire:model="deskripsi" id="nameWithTitle" class="form-control" placeholder="Enter Deskripsi"></textarea>
                    </div>
                    <div class="col mb-3">
                        <label for="nameWithTitle" class="form-label">Kategori</label>
                        <select wire:model="kategori_id" id="" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label for="foto_keluhan" class="form-label">Foto Keluhan</label>
                        <input type="file" wire:model.defer="foto_keluhan" id="foto_keluhan" class="form-control">
                    </div>
                    <div class="col mb-3">
                        <label for="foto_selfie" class="form-label">Foto Selfie</label>
                        <input type="file" wire:model.defer="foto_selfie" id="foto_selfie" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
