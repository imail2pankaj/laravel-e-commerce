<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\AttributeValue;

class VariantSkuGenerator
{
    public static function generate($productSku, $valueIds)
    {
        $codes = [];

        $values = AttributeValue::whereIn('id', $valueIds)->get();

        foreach ($values as $val) {

            $valueText = trim($val->value);
            $clean = preg_replace('/[^A-Za-z0-9]/', '', $valueText); // remove symbols

            // If numeric (like 128GB or 500ml)
            if (is_numeric(substr($clean, 0, 1))) {

                // extract digits → 128GB becomes "128"
                preg_match('/\d+/', $clean, $matches);
                $short = $matches[0] ?? substr($clean, 0, 2);
            } 
            
            else {
                // first 2 letters
                $short = strtoupper(substr($clean, 0, 2));
            }

            $codes[] = strtoupper($short);
        }

        return strtoupper($productSku . "-" . implode("-", $codes));
    }
}
