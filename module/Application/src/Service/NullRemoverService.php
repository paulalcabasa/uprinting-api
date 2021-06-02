<?php

namespace Application\Service;

class NullRemoverService
{
    public function unsetNullArrayValues($array)
    {
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}