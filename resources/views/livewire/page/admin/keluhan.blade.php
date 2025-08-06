<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span> Keluhan Table</h4>
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
    <div class="card">
        <h5 class="card-header">Data Keluhan</h5>
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
                            @if (Auth::user()->role != 'supervisor')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keluhans as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->penghuni->nama }}</td>
                                <td>{{ $data->penghuni->alamat_unit }}</td>
                                <td>{{ $data->deskripsi }}</td>
                                <td><span class="badge bg-label-secondary">{{ $data->kategori->nama_kategori }}</span>
                                </td>
                                <td><span class="badge bg-label-primary">{{ $data->status }}</span></td>
                                @if (Auth::user()->role != 'supervisor')
                                    <td>
                                        <a href="{{ route('keluhan-detail', $data->id) }}"
                                            class="btn btn-icon btn-outline-primary">
                                            <i class='bx  bx-eye'></i>
                                        </a>
                                        <button type="button" class="btn btn-icon btn-outline-warning"
                                            wire:click="openModal('edit',{{ $data->id }})">
                                            <i class='bx  bx-edit'></i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-outline-danger"
                                            wire:click="delete({{ $data->id }})">
                                            <i class='bx  bx-trash'></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="modal fade show" id="modalCenter" tabindex="-1" style="display: block;" aria-modal="true"
            role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle" style="text-transform: uppercase;">
                            {{ $mode }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <div>
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Status</label>
                                    <select wire:model="status" id="statusSelect" class="form-control"
                                        {{ $mode == 'show' ? 'disabled' : '' }}>
                                        <option value="">Pilih Status</option>
                                        @if ($status == 'proses')
                                            <option value="selesai">Selesai</option>
                                        @elseif ($status == 'pending')
                                            <option value="proses">Proses</option>
                                            <option value="ditolak">Ditolak</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col mb-3" id="petugasWrapper" style="display: none">
                                    <label for="nameWithTitle" class="form-label">Petugas</label>
                                    <select wire:model="petugas_id" id="" class="form-control"
                                        {{ $mode == 'show' ? 'disabled' : '' }}>
                                        <option value="">Pilih Petugas</option>
                                        @foreach ($petugas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
        Livewire.on('editMode', () => {
            setTimeout(() => {
                const statusSelect = document.getElementById('statusSelect');
                const petugasWrapper = document.getElementById('petugasWrapper');

                // langsung deteksi awal kalau defaultnya proses
                if (statusSelect.value === 'proses') {
                    petugasWrapper.style.display = 'block';
                } else {
                    petugasWrapper.style.display = 'none';
                }

                // on change handler
                statusSelect.addEventListener('change', function() {
                    if (this.value === 'proses') {
                        petugasWrapper.style.display = 'block';
                    } else {
                        petugasWrapper.style.display = 'none';
                    }
                });
            });

        }, 1000);
    </script>
@endpush
