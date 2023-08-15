<?php

namespace Wagento\Zendesk\Helper\Api\ErrorHandler;

class Connector
{
    public const XML_PATH_ERROR = 'zendesk/config/connection_error';

    public const NO_ERROR = null;
    public const EMPTY_FIELDS_ERROR = 1;
    public const WORNG_FIELDS_VALUES_ERROR = 2;

    public const ERRO_MSG = [
        self::EMPTY_FIELDS_ERROR => "One or more credential's fields is empty.",
        self::WORNG_FIELDS_VALUES_ERROR => "One or more credential's fields is incorrect.",
    ];
}
