<?php

namespace App\Console\Commands;

use App\Helpers\Telegram;
use App\Models\Keluhan;
use App\Models\LogAktivitas;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoAssignPetugas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-assign-petugas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Carbon::setLocale('id');

        $keluhans = Keluhan::whereNull('petugas_id')->where('status', '!=', 'ditolak')
            ->where('created_at', '<=', now()->subHours(2))
            ->get();

        foreach ($keluhans as $keluhan) {
            // Cari petugas yang sesuai kategori keluhan
            $petugas = Petugas::where('kategori_id', $keluhan->kategori_id)->inRandomOrder()->first();

            if ($petugas) {
                $keluhan->petugas_id = $petugas->id;
                $keluhan->status = 'proses';
                $keluhan->proses_at = Carbon::now()->toDateTimeString();
                $keluhan->save();

                // notif telegram
                $pesan = "🤖 <b>Assign Otomatis Petugas</b>\n\n"
                    . "👤 <b>Nama Penghuni</b> : {$keluhan->penghuni->nama}\n"
                    . "📁 <b>Kategori</b> : {$keluhan->kategori->nama_kategori}\n"
                    . "📝 <b>Keluhan</b> : {$keluhan->deskripsi}\n"
                    . "📌 <b>Info</b> : Petugas <b>{$keluhan->petugas->nama}</b> ditugaskan otomatis\n"
                    . "🕒 <b>Waktu</b> : " . Carbon::now()->format('d-m-Y H:i');


                Telegram::sendMessage(config('services.telegram.chat_id'), $pesan);

                LogAktivitas::create([
                    'petugas_id' => $petugas->id,
                    'aksi' => 'auto_assign',
                    'tipe_aksi' => 'keluhan',
                    'aksi_id' => $keluhan->id,
                    'deskripsi' => 'Keluhan di-assign otomatis setelah 2 jam',
                ]);
            }
        }

        $this->info('Auto assign completed.');
    }
}
