<?php

namespace fishContentApiClient\exceptions;

/**
 * Class FishContentInvalidParamException
 * @package fishContentApiClient\exceptions
 */
class FishContentInvalidParamException extends \BadMethodCallException {
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct($this->getName() . ': ' . $message, 500);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Invalid Parameter in FishContent API';
    }
}