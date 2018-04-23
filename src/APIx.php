<?php

namespace AbdulmatinSanni\APIx;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

class APIx
{
    /**
     * API-x API URI.
     *
     * @var string
     */
    private static $api;

    /**
     * API-x API Token.
     *
     * @var string
     */
    private static $apiToken;

    /**
     * Whether messages should logged or not.
     *
     * @var boolean
     */
    private static $islogMessagesEnabled;

    /**
     * The path of API-x Log File in Storage.
     *
     * @var string
     */
    private static $logFilePath;

    /**
     * Whether sending of SMS should be mocked or not.
     * @var
     */
    private static $isFakeSmsEnabled;

    /**
     * SMS Sender Name.
     * @var string
     */
    private static $senderName;

    /**
     * Phone numbers of Recipient(s).
     *
     * @var string|array
     */
    private static $recipient;

    /**
     * Message to be sent.
     * @var string
     */
    private static $message;

    /**
     * Request Response.
     * @var ResponseInterface
     */
    private static $response;

    /**
     * Initializes APIx Configurations.
     */
    public static function initialize()
    {
        self::$api = config('api-x.api');
        self::$apiToken = config('api-x.api_token');
        self::$islogMessagesEnabled = config('api-x.is_log_messages_enabled');
        self::$logFilePath = config('api-x.log_file_path');
        self::$isFakeSmsEnabled = config('api-x.is_fake_sms_enabled');
    }

    /**
     * Sets SMS Sender Name.
     *
     * @param $senderName
     * @return APIx
     */
    public static function from($senderName)
    {
        self::$senderName = $senderName;

        return new self;
    }

    /**
     * Sets SMS recipients
     *
     * @param $recipient
     * @return APIx
     */
    public static function to($recipient)
    {
        self::$recipient = $recipient;

        return new self;
    }

    /**
     * Sets SMS message.
     *
     * @param $message
     * @return APIx
     */
    public static function message($message)
    {
        self::$message = $message;

        return new self;
    }

    /**
     * Sends message to recipients
     *
     * @param $message
     * @return mixed
     */
    public static function send($message = null)
    {
        self::initialize();

        self::$message = $message ?? self::$message;
        self::$recipient = is_array(self::$recipient) ?
            implode(',', self::$recipient) :
            self::$recipient;

        if (self::$islogMessagesEnabled) {
            self::logMessages();
        }

        if (self::$isFakeSmsEnabled && self::$islogMessagesEnabled) {
            return "Messages has been logged";
        }

        if (self::$isFakeSmsEnabled && ! self::$islogMessagesEnabled) {
            return "Messages Wasn't Sent of Logged";
        }

        $response = null;

        try {
            $client = new Client();
            $response = $client->request('POST', self::$api, [
                'form_params' => [
                    'sender' => self::$senderName ?? config('api-x.sender_name'),
                    'to' => self::$recipient,
                    'message' => self::$message,
                    'type' => 0,
                    'routing' => 3,
                    'token' => self::$apiToken
                ]
            ]);
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }

        self::$response = (string)$response->getBody();
        return self::$response;
    }

    /**
     * Gets Balance of SmartSMSSolutions account.
     *
     * @return mixed|\Psr\Http\Message\StreamInterface
     * @throws \Exception If request wasn't successful
     */
    public static function getBalance()
    {
        self::initialize();

        $response = null;

        try {
            $client = new Client();

            $response = $client->request('POST', self::$api, [
                'form_params' => [
                    'checkbalance' => 1,
                    'token' => self::$apiToken
                ]
            ]);

            $responseArray = explode('||', $response->getBody());

            if (count($responseArray) > 1) {
                $responseMessage = self::responseMessage($responseArray[0]);
                throw new \Exception($responseMessage);
            }
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }

        return $response->getBody();
    }

    /**
     * Formats API Response into Human Understandable Format.
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    private static function formatResponse(ResponseInterface $response)
    {
        $responseCode = explode('||', $response->getBody())[0];
        $responseMessage = self::responseMessage($responseCode);

        return $responseMessage;
    }

    /**
     * Gets Formatted Request Response.
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    public function getFormattedResponse(ResponseInterface $response)
    {
        return self::formatResponse($response);
    }

    /**
     * Returns Response Message based on Code.
     *
     * @param $code
     * @return mixed
     */
    private static function responseMessage($code)
    {
        return config('api-x.response_codes')[$code];
    }

    /**
     * Logs SMS to API-x Log FIle.
     *
     * @return void
     */
    public static function logMessages()
    {
        $logMessage = null;
        $logEntryDelimiter = config('api-x.log_entry_delimiter');

        foreach (explode(',', self::$recipient) as $recipient) {
            $senderName = self::$senderName;
            $message = self::$message;
            $timestamp = Carbon::now()->toDateTimeString();

            $logMessage .= <<< EOF
            
            From: $senderName
            To: $recipient
            Date: $timestamp
            
            $message
            $logEntryDelimiter
EOF;
        }

        Storage::prepend(self::$logFilePath, $logMessage);
    }
}
