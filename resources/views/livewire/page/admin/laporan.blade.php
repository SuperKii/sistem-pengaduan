<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span> Laporan Table</h4>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form wire:submit.prevent="getLaporan" class="mb-3">
        <div class="row">
            <div class="form-group mb-3 col-md-4">
                <label for="" class="form-label">Tanggal Awal</label>
                <input type="date" wire:model.defer="tanggal_awal" class="form-control">
            </div>
            <div class="form-group mb-3 col-md-4">
                <label for="" class="form-label">Tanggal Akhir</label>
                <input type="date" wire:model.defer="tanggal_akhir" class="form-control">
            </div>
            <div class="form-group mb-3 col-md-4">
                <label for="" class="form-label">Status *opsional</label>
                <select type="date" wire:model.defer="status" class="form-control">
                    <option value="">Pilih Status</option>
                    <option value="pending">Pending</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Di Tolak</option>
                </select>
            </div>
        </div>
        <button class="btn btn-outline-success col-lg-12" type="submit">Submit</button>
    </form>
    <div class="card">
        <h5 class="card-header">Data Laporan</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped dataTable-table" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Deskripsi</th>
                            <th>Ketegori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporans as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->penghuni->nama }}</td>
                                <td>{{ $data->penghuni->alamat_unit }}</td>
                                <td>{{ $data->deskripsi }}</td>
                                <td><span class="badge bg-label-secondary">{{ $data->kategori->nama_kategori }}</span>
                                </td>
                                <td><span class="badge bg-label-primary">{{ $data->status }}</span></td>
                                <td>
                                    <a href="{{ route('keluhan-detail', $data->id) }}"
                                        class="btn btn-icon btn-outline-primary">
                                        <i class='bx  bx-eye'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($laporans != [] || $laporans != null)
                    <button type="button" class="btn btn-outline-success mt-4" wire:click="generatePdf">Export
                        Laporan</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('reinitDatatable', () => {
                // destroy datatable kalo udah di-init sebelumnya


                // inisialisasi ulang setelah update DOM
                setTimeout(() => {
                    $('#table').DataTable();
                }, 100);
            });
        });
    </script>
@endpush
