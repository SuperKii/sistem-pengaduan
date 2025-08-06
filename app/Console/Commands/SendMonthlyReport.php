<?php

namespace App\Console\Commands;

use App\Mail\ReportMail;
use App\Models\Keluhan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-monthly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Laporan Bulanan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bulan = now()->subMonth();
        $periode = $bulan->translatedFormat('F Y');

        $data = Keluhan::with(['penghuni', 'kategori'])
            ->whereMonth('created_at', $bulan->month)
            ->whereYear('created_at', $bulan->year)
            ->get();

        $pdf = Pdf::loadView('export', [
            'dataKeluhan' => $data,
            'periode' => $periode
        ])->output();

        Mail::to('rochmathidayahrizki@gmail.com')->send(new ReportMail($periode, $pdf, $data));

        $this->info('Laporan bulanan berhasil dikirim.');
    }
}
