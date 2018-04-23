<?php

namespace AbdulmatinSanni\APIx\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send API-x Notifications you need to add your API Token to the `api_token` key of `api-x.api_token`.');
    }
}
