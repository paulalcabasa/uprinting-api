<?php

namespace Application\Service;

class ErrorService
{
    public function __construct() {
    }

    public function prepareCustomErrorMessage($errorSetName, $errorName, $errorMessage)
    {
        return [$errorSetName => [$errorName => $errorMessage]];
    }

    public function mergeValidationMessages($validationMessages)
    {
        if (is_array($validationMessages)) {
            $mergedValidationMessages= [];

            foreach ($validationMessages as $validationMessage) {
                $mergedValidationMessages = array_merge($mergedValidationMessages, $validationMessage);
            }

            return $mergedValidationMessages;
        }
    }
}