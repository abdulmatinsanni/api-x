<?php

namespace AbdulmatinSanni\APIx\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("API-x responded with an error: {$response->getStatusCode()} {$response->getReasonPhrase()} - {$response->getBody()}");
    }
}
