<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat(Request $request)
{
    $message = strtolower($request->message); 

   
    $responses = [
        'how to rent a car?' => 'To rent a car, just sign up, choose a vehicle, and complete the reservation form.',
        'what are the available cars?' => 'You can check the available cars on our website under the "Vehicles" section.',
        'what documents are required?' => 'You will need a valid driver’s license, two valid IDs, and proof of billing.',
        'can i reserve online?' => 'Yes! You can reserve online through our ARKILA platform anytime.',
        'where are you located?' => 'We are located at Sumulong St., Brgy. San Pedro, Angono, Rizal.',
        'do you offer drivers?' => 'Yes, you can choose "With Driver" when booking a vehicle.',
        'what is the rental price?' => 'Our rental prices range from 2,300 to 5,500 pesos per day.',
        'how to contact support?' => 'You can reach us via email at support@arkila.com or call us at 0917-123-4567.',
       
    ];

    $quickReplies = [
        [
            'text' => 'How to rent a car?',
            'value' => 'how to rent a car?'
        ],
        [
            'text' => 'What documents are required?',
            'value' => 'what documents are required?'
        ],
        [
            'text' => 'Can I reserve online?',
            'value' => 'can i reserve online?'
        ],
        [
            'text' => 'Do you offer drivers?',
            'value' => 'do you offer drivers?'
        ],
        [
            'text' => 'Where are you located?',
            'value' => 'where are you located?'
        ],
        [
            'text' => 'What is the rental price?',
            'value' => 'what is the rental price?'
        ],
        [
            'text' => 'How to contact support?',
            'value' => 'how to contact support?'
        ],
       
    ];

    
    $reply = $responses[$message] ?? $this->getFallbackResponse();

    return response()->json([
        'reply' => $reply,
        'quickReplies' => $quickReplies 
    ]);
}


   
    private function getFallbackResponse()
    {
        return "
Sorry, I didn't quite get that. You can try asking:
- 'How to rent a car?'
- 'What documents are required?'
- 'Can I reserve online?'
- 'Do you offer drivers?'
- 'Where are you located?'
";
    }
}

