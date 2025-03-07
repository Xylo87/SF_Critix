<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NumberFormatterExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('format_short', [$this, 'formatshort']),
        ];
    }

    // > Sub Numbers short
    public function formatShort($number, $decimals = 2)
    {
        if (!is_numeric($number)) {
            return $number;
        }

        $number = (float) $number;
        $suffixes = ['', 'k', 'M', 'G', 'T', 'P', 'E'];
        $suffixIndex = 0;

        while ($number >= 1000 && $suffixIndex < count($suffixes) - 1) {
            $number /= 1000;
            $suffixIndex++;
        }

        $formattedNumber = number_format($number, $decimals, '.', '');

        
        

        if ($decimals > 0) {
            $formattedNumber = rtrim(rtrim($formattedNumber, '0'), '.');
        }

        return $formattedNumber . $suffixes[$suffixIndex];
    }
}

