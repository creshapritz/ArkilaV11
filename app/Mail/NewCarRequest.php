<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCarRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $carRequestData;
    public $fromEmail;

    /**
     * Create a new message instance.
     *
     * @param array $carRequestData
     * @param string $fromEmail
     * @return void
     */
    public function __construct($carRequestData, $fromEmail)
    {
        $this->carRequestData = $carRequestData;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail)
            ->subject('New Car Request Submission')
            ->view('emails.new-car-request')
            ->with([
                'name' => $this->carRequestData['name'],
                'brand' => $this->carRequestData['brand'],
                'type' => $this->carRequestData['type'],
                'location' => $this->carRequestData['location'],
                'price_per_day' => $this->carRequestData['price_per_day'],
                'seating_capacity' => $this->carRequestData['seating_capacity'],
                'num_bags' => $this->carRequestData['num_bags'],
                'gas_type' => $this->carRequestData['gas_type'],
                'transmission' => $this->carRequestData['transmission'],
                'platenum' => $this->carRequestData['platenum'],
                'mileage' => $this->carRequestData['mileage'],
                'color' => $this->carRequestData['color'],
                'regexpiry' => $this->carRequestData['regexpiry'],
                'company_name' => $this->carRequestData['company_name'],
                'sender_email' => $this->fromEmail,
            ]);
    }
}
