<?php

namespace Laradocs\Moguding\Utils;

class Json
{
    public static function decode(string $json): array
    {
        return json_decode($json, true);
    }
}
