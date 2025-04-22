<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    
    public function run()
    {
        Faq::create([
            'question' => 'What is ARKILA?',
            'answer' => 'ARKILA is a car rental platform that allows you to rent vehicles easily.',
        ]);

        Faq::create([
            'question' => 'how do i book a car',
            'answer' => 'To book a car, simply visit our website, select a vehicle, choose your rental dates, and proceed with payment.',
        ]);

        Faq::create([
            'question' => 'what are the requirements to rent a car',
            'answer' => 'You need a valid drivers license select a vehicle, a government-issued ID, and a security deposit (if applicable).',
        ]);


        Faq::create([
            'question' => 'is there a cancellation fee',
            'answer' => 'Cancellation policies vary. Please check our terms and conditions for more details.',
        ]);
        Faq::create([
            'question' => 'how much does it cost to rent a car',
            'answer' => 'Our rental prices vary depending on the car type and rental duration. Visit our website for more details.',
        ]);
    }


}
