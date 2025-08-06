<div>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span> Log Activity Table</h4>
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
        <h5 class="card-header">Data Log Activity</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped dataTable-table" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                            <th>Tipe</th>
                            <th>Aksi ID</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if ($data->admin != null )
                                    <td>{{ $data->admin->name }}</td>
                                @elseif ($data->petugas != null)
                                    <td>{{ $data->petugas->nama }}</td>
                                @elseif ($data->penghuni != null)
                                    <td>{{ $data->penghuni->nama }}</td>
                                @endif
                                <td>{{ $data->aksi }}</td>
                                <td>{{ $data->tipe_aksi }}</td>
                                <td>{{ $data->aksi_id }}</td>
                                <td>{{ $data->deskripsi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
