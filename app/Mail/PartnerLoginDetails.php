<?php

namespace App\Mail;

use App\Models\PartnerAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerLoginDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $partnerAdmin;
    public $password;

    public function __construct(PartnerAdmin $partnerAdmin, $password)
    {
        $this->partnerAdmin = $partnerAdmin;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Partner Account Details')
                    ->view('emails.partner_login_details')
                    ->with([
                        'email' => $this->partnerAdmin->email,
                        'password' => $this->password,
                    ]);
    }
}
