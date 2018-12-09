<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Programming Interface
    |--------------------------------------------------------------------------
    |
    | This is the link to the SmartSMSSolutions API-x API calls.
    |
    */

    'api' => env('SMARTSMSSOLUTIONS_API', 'https://smartsmssolutions.com/api/'),

    /*
    |--------------------------------------------------------------------------
    | API Token
    |--------------------------------------------------------------------------
    |
    | This is the API-x token for the provider's SmartSMSSolutions account.
    |
    */

    'api_token' => env('SMARTSMSSOLUTIONS_API_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Sender Name
    |--------------------------------------------------------------------------
    |
    | This sets the sender name to display on sent sms messages.
    |
    */

    'sender_name' => env('SMARTSMSSOLUTIONS_SENDER_NAME', 'API-x Pckg'),

    /*
    |--------------------------------------------------------------------------
    | Log Messages
    |--------------------------------------------------------------------------
    |
    | This sets whether messages should be logged to file or not.
    |
    */

    'is_log_messages_enabled' => env('SMARTSMSSOLUTIONS_LOG_MESSAGES', false),

    /*
    |--------------------------------------------------------------------------
    | Fake SMS
    |--------------------------------------------------------------------------
    |
    | This sets whether messages should be sent or pretend to be sent.
    |
    */

    'is_fake_sms_enabled' => env('SMARTSMSSOLUTIONS_FAKE_SMS', false),

    /*
    |--------------------------------------------------------------------------
    | Log File Path
    |--------------------------------------------------------------------------
    |
    | This sets the path of API-x SMS Log.
    |
    */

    'log_file_path' => env('SMARTSMSSOLUTIONS_LOG_FILE_PATH', 'logs/api-x.log'),

    /*
    |--------------------------------------------------------------------------
    | Response Codes
    |--------------------------------------------------------------------------
    |
    | Response Codes and Messages for SmartSMSSolutions API Responses
    |
    */

    'response_codes' => [
        "1000" => "Successful",
        "1001" => "Invalid Token",
        "1002" => "Error Sending SMS",
        "1003" => "Insufficient Balance",
        "1004" => "No valid phone number found",
        "1005" => "Application Error",
        "1006" => "Application Error",
        "1007" => "Message schedule error"
    ]
];
