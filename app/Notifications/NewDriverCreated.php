<?php
namespace App\Notifications;

use App\Models\Driver;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewDriverCreated extends Notification
{
    use Queueable;

    public $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $email = (new MailMessage)
            ->subject('New Driver Submission Request')
            ->greeting('Hello Admin,')
            ->line('A new driver has been submitted by a partner and is pending your approval.')
            ->line('**Driver Name**: ' . $this->driver->name)
            ->line('**Email**: ' . $this->driver->email)
            ->line('**Contact Number**: ' . $this->driver->contact_number)
            ->line('**Company Name**: ' . $this->driver->company_name)
            ->action('View Driver', url('/admin/drivers/' . $this->driver->id))
            ->line('Thank you for using ARKILA!');
    
        // Attach images if they exist
        $attachments = [
            'profile_picture',
            'license_front',
            'license_back',
            'second_id_front',
            'second_id_back'
        ];
    
        foreach ($attachments as $field) {
            if (!empty($this->driver->$field) && file_exists(public_path($this->driver->$field))) {
                $email->attach(public_path($this->driver->$field));
            }
        }
    
        return $email;
    }
}

