<?php

namespace fishContentApiClient\exceptions;

/**
 * Class FishContentResponseException
 * @package fishContentApiClient\exceptions
 */
class FishContentResponseException extends \HttpResponseException {
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct($this->getName(), 500);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Response exception in FishContent API';
    }
}