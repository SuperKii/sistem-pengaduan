<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span> Petugas Table</h4>
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
    <button type="button" class="btn btn-outline-primary mb-4" wire:click="openModal('create')">Create</button>
    <div class="card">
        <h5 class="card-header">Data Petugas</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped dataTable-table" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($petugas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->email }}</td>
                                <td><span class="badge bg-label-secondary">{{ $data->kategori->nama_kategori }}</span></td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-outline-primary"
                                        wire:click="openModal('show',{{ $data->id }})">
                                        <i class='bx  bx-eye'></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-outline-warning"
                                        wire:click="openModal('edit',{{ $data->id }})">
                                        <i class='bx  bx-edit'></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-outline-danger"
                                        wire:click="delete({{ $data->id }})">
                                        <i class='bx  bx-trash'></i>
                                    </button>
                                </td>
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
                    <form wire:submit.prevent="{{ $mode == 'create' ? 'store' : 'update' }}">
                        <div class="modal-body">
                            <div>
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama</label>
                                    <input type="text" wire:model="nama" id="nameWithTitle" class="form-control"
                                        placeholder="Enter Nama" {{ $mode == 'show' ? 'disabled' : '' }}>
                                </div>
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Email</label>
                                    <input type="email" wire:model="email" id="nameWithTitle" class="form-control"
                                        placeholder="Enter Email" {{ $mode == 'show' ? 'disabled' : '' }}>
                                </div>
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Password</label>
                                    <input type="text" wire:model="password" id="nameWithTitle" class="form-control"
                                        placeholder="Enter Password" {{ $mode == 'show' ? 'disabled' : '' }}>
                                </div>
                                <div class="col">
                                    <label for="nameWithTitle" class="form-label">Kategori</label>
                                    <select wire:model="kategori_id" id="" class="form-control"
                                        {{ $mode == 'show' ? 'disabled' : '' }}>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary"
                                {{ $mode == 'show' ? 'disabled' : '' }}>{{ $mode == 'create' ? 'Save' : 'Update' }}</button>
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
    </script>
@endpush