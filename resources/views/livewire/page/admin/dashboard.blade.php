<div>
    @if (Auth::guard('web')->check())
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card p-2">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Penghuni Mengeluh</h5>
                        {{-- <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div> --}}
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($userKeluhan as $data)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="/storage/{{ $data->penghuni->foto }}" alt="User" class="rounded">
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small class="text-muted d-block mb-1">Nama Penghuni</small>
                                            <h6 class="mb-0">{{ $data->penghuni->nama }}</h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">{{ $data->total }}</h6>
                                            <span class="text-muted">Kali</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::guard('penghuni')->check())
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">Welcome {{ Auth::guard('penghuni')->user()->nama }}</h2>
            <p class="mb-4 mx-2" style="font-size: 20px">Apa Yang Bisa Kami Bantu Hari Ini ??</p>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="card">
            <h5 class="card-header">Data Keluhan Baru</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
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
                            @foreach ($newKeluhan as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->penghuni->nama }}</td>
                                    <td>{{ $data->penghuni->alamat_unit }}</td>
                                    <td>{{ $data->deskripsi }}</td>
                                    <td><span
                                            class="badge bg-label-secondary">{{ $data->kategori->nama_kategori }}</span>
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
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        const chartData = @json($chartData);


        const ctx = document.getElementById('kategoriChart').getContext('2d');

        const labels = chartData.map(item => item.label);
        const data = chartData.map(item => item.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Keluhan',
                    data: data,
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                        '#14B8A6', '#F43F5E', '#6366F1', '#EAB308', '#0EA5E9'
                    ],
                    borderRadius: 6,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 20
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Kategori Paling Banyak Dikeluhkan 🔥',
                        font: {
                            size: 20,
                            weight: 'normal',
                        },
                        color: '#374151',
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#F3F4F6',
                        padding: 12,
                        cornerRadius: 6,
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6B7280',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6B7280',
                            stepSize: 1
                        },
                        grid: {
                            color: '#E5E7EB',
                            borderDash: [4, 4]
                        }
                    }
                }
            }
        });
    </script>
@endpush
