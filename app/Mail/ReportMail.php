<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $periode, $pdf, $data;

    /**
     * Create a new message instance.
     */
    public function __construct($periode, $pdf, $data)
    {
        $this->periode = $periode;
        $this->pdf = $pdf;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject("Laporan Keluhan {$this->periode}")
            ->view('export') // ← tambahin view email
            ->with([
                'periode' => $this->periode,
                'dataKeluhan' => $this->data
            ])
            ->attachData($this->pdf, "laporan-keluhan-{$this->periode}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
