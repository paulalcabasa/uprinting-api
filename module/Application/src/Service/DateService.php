<?php

namespace Application\Service;

class DateService
{
    public function __construct()
    {
    }

    public function getCurrentDateTime()
    {
        return date('Y-m-d H:i:s');
    }
}