<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevoEmailEditarReceptor extends Mailable
{
    use Queueable, SerializesModels;

    public $idRegistro;


    public function build()
    {
        return $this->subject('Solicitud')
            ->view('email.pages-correo-plantilla-Editar2', ['idRegistro' => $this->idRegistro]);
    }
}
