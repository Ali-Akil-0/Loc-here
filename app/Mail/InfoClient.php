<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfoClient extends Mailable
{
    use Queueable, SerializesModels;
    public  $NomClient;
    public  $PrenomClient;
    public  $UsernameClient;
    public  $EmailClient;
    public  $NomObjet;
    public  $StartDate;
    public  $EndDate;

    public function __construct($NomClient, $PrenomClient, $UsernameClient, $EmailClient, $NomObjet, $StartDate, $EndDate)
    {
        $this->EndDate = $EndDate;
        $this->PrenomClient = $PrenomClient;
        $this->NomClient = $NomClient;
        $this->UsernameClient = $UsernameClient;
        $this->EmailClient = $EmailClient;
        $this->NomObjet = $NomObjet;
        $this->StartDate = $StartDate;
    }


    public function build()
    {
        return $this->markdown('mail.info-client');
    }
}