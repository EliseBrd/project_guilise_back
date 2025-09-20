<?php

namespace App\Service;

class EntropyService
{


    private int $AvailableCaractersNbr = 95;
    public function calculateEntropy(string $string): float
    {
        $length = strlen($string);
        if ($length === 0) {
            return 0.0;
        }

        $entropy = 0.0;
        for ($i = 32; $i <= 126; $i++) {
            $count = substr_count($string, chr($i));
            if ($count > 0) {
                $p = $count / $length;
                $entropy -= $p * log($p, 2);
            }
        }

        return $entropy; // entropie par caractère
    }

    public function calculateTotalEntropy(string $string): float
    {
        return $this->calculateEntropy($string) * strlen($string);
    }

    public function calculateFrequency(string $string): array
    {
        $length = strlen($string);
        $frequencies = [];
        for ($i = 32; $i <= 126; $i++) {
            $frequencies[chr($i)] = $length > 0 ? substr_count($string, chr($i)) / $length : 0;
        }
        return $frequencies;
    }

    public function calculateVariance(string $string): float
    {
        $frequencies = $this->calculateFrequency($string);
        $mean = 1 / $this->AvailableCaractersNbr;
        $variance = 0.0;
        foreach ($frequencies as $freq) {
            $variance += pow($freq - $mean, 2);
        }
        return $variance / $this->AvailableCaractersNbr;
    }

    public function checkEntropy(string $string, float $threshold = 3.0): bool
    {
        return $this->calculateEntropy($string) >= $threshold;
    }

    public function checkTotalEntropy(string $string, float $threshold = 3.0): bool
    {
        return $this->calculateTotalEntropy($string) >= $threshold;
    }
}
