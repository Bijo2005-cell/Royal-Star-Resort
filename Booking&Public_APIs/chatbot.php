<?php

$apiKey = 'AIzaSyBnn4TpptOSCLMUsxaXoe431GnCalFm4CQ'; // !!! SECURITY RISK: Move this to an environment variable

// --- START: PREDEFINED QUESTIONS & ANSWERS ---
$predefinedQA = [
    // Booking & Contact
    "How can I book a room at Royal Star Resort?" => "You can book your stay by calling our reservations desk directly at 9400258163. Our team will be happy to assist you with availability, room types, and current offers.",
    "What is the best way to contact the resort for inquiries?" => "For any questions about your booking, directions, or special requests, please call us at 9400258163. This is the best number for direct and immediate assistance.",
    "Do you have any special packages, like for honeymoons or family trips?" => "Yes, we offer a variety of packages tailored for different occasions. Please call us at 9400258163 to learn about our latest honeymoon packages, family deals, and group discounts.",
    
    // Location & Travel
    "Where exactly is the Royal Star Resort located?" => "We are located in Ponmudi, Rajakad, nestled in the beautiful hill station region of Kerala. Our location offers a peaceful retreat away from the city with stunning views of the surrounding hills and tea gardens.",
    "How can I reach the resort? What is the nearest airport or railway station?" => "By Air: The nearest airport is Cochin International Airport (COK), approximately a 3-4 hour drive away.\nBy Rail: The nearest major railway station is Aluva (AWY) or Ernakulam (ERN), from where you can hire a taxi.\nBy Road: Rajakad is well-connected by road. You can drive or hire a cab from nearby towns like Munnar or Adimali. For precise directions, please call us at 9400258163.",
    "Is there parking available at the resort?" => "Yes, we provide complimentary and secure parking for all our guests.",
    
    // Rooms & Amenities
    "What types of rooms are available at the resort?" => "We offer a range of accommodation options to suit different needs, including Deluxe Rooms, Premium Valley View Rooms, and Family CottAGES. Each room is designed to offer comfort and a splendid view of the natural surroundings.",
    "What amenities are included in the rooms?" => "All our rooms are equipped with modern amenities such as a comfortable bed, an attached bathroom with hot water, a television, and complimentary Wi-Fi. Many rooms also feature a private balcony to enjoy the scenic beauty of Ponmudi.",
    "Is Wi-Fi available at the resort?" => "Yes, complimentary Wi-Fi is available in the main lobby area and most guest rooms. However, due to our remote hill station location, signal strength can sometimes vary.",
    
    
    // Resort Policies & Rules
    "What are the check-in and check-out times?" => "Our standard check-in time is 2:00 PM and check-out is at 11:00 AM. For requests regarding early check-in or late check-out, please call us at 9400258163.",
    "What is your cancellation policy?" => "We have a flexible cancellation policy which can vary based on the season and offer. For specific details regarding your booking, please contact our reservation desk directly at 9400258163.",
    "Are pets allowed at the resort?" => "We understand you love your pets, but unfortunately, we do not have a pet-friendly policy at the moment.",
    "What documents are required during check-in?" => "As per government regulations, all guests are required to present a valid government-issued photo ID (like Aadhaar Card, Driver's License, or Passport) upon check-in.",

    // Payments & Pricing
    "What payment methods do you accept?" => "We accept cash, all major credit and debit cards, and UPI payments at the resort.",
    "Do you require an advance payment to confirm a booking?" => "Yes, we typically require an advance payment to confirm reservations. Our team will provide you with the details when you call us for your booking at 9400258163.",
    "Are there any hidden charges or taxes?" => "Our pricing is transparent. The final amount, including all applicable taxes, will be clearly communicated to you at the time of booking.",
];
// --- END: PREDEFINED QUESTIONS & ANSWERS ---


// Get the user's message from the POST request
$requestData = json_decode(file_get_contents('php://input'), true);
$userMessage = $requestData['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Please send a message.']);
    exit;
}

// --- START: LOGIC TO CHECK PREDEFINED Q&A ---
$botReply = null;
$bestMatchPercent = 0;
$bestMatchAnswer = '';
$threshold = 75; // Set a similarity threshold (e.g., 75%). Adjust as needed.

foreach ($predefinedQA as $question => $answer) {
    // Use similar_text to find the best match based on percentage similarity
    similar_text(strtolower($userMessage), strtolower($question), $percent);
    if ($percent > $bestMatchPercent) {
        $bestMatchPercent = $percent;
        $bestMatchAnswer = $answer;
    }
}

// If a match is found above the threshold, use the predefined answer
if ($bestMatchPercent >= $threshold) {
    $botReply = $bestMatchAnswer;
}
// --- END: LOG-IC TO CHECK PREDEFINED Q&A ---


// --- If no predefined answer was found, call the Gemini API ---
if ($botReply === null) {
    // Prepare the API request to Google Gemini
   
    // *** THIS IS THE FIXED LINE ***
    $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

    // A better prompt for a resort assistant
    $prompt = "You are a friendly assistant for Royal Star Resort in Ponmudi, Rajakad. Answer the following user question: " . $userMessage;

    $postData = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => $prompt
                    ]
                ]
            ]
        ]
    ];

    // Use cURL to send the request
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);

    // First, check if curl_exec failed entirely.
    if ($response === false) {
        // If the cURL request fails, get the specific error message
        $curlError = curl_error($ch);
        $botReply = 'cURL Error: ' . $curlError;
        error_log("cURL failed with error: " . $curlError);
    } else {
        // If cURL executed, then check the HTTP status code
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode == 200) {
            $responseData = json_decode($response, true);
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $botReply = $responseData['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $botReply = "I received a response, but couldn't understand it. Please try again.";
                error_log("Invalid API response structure: " . $response);
            }
        } else {
            // Handle API errors
            $botReply = 'Sorry, I am having trouble connecting to the AI. HTTP Status: ' . $httpcode . '. Response: ' . $response;
            error_log("API Error Response: " . $response); 
        }
    }

    curl_close($ch);
}

// --- Send the final response back to the front-end ---
header('Content-Type: application/json');
echo json_encode(['reply' => trim($botReply)]);

?>