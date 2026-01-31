<?php
namespace App\Mail;

use App\Models\Turno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TurnoBarberoMail extends Mailable
{
	use Queueable, SerializesModels;

	public $turno;

	public function __construct(Turno $turno)
	{
		$this->turno = $turno;
	}

	public function build()
	{
		return $this->subject('Tienes un nuevo turno asignado')
			->view('emails.turno_barbero');
	}
}
