<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ProductSkuGenerator
{
    // Change pattern here anytime in future
    const PREFIX = "PRD-";   // you can change this easily
    const SEPARATOR = "-";

    public static function generate($productName)
    {
        // Example: "iPhone 15" → "IPHONE15"
        $base = strtoupper(Str::slug($productName, ''));

        // Example: random 4-digit unique suffix
        $unique = rand(1000, 9999);

        // final SKU: PRD-IPHONE15-1234
        return self::PREFIX . $base . self::SEPARATOR . $unique;
    }
}
