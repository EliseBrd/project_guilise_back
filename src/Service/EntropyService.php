<?php

namespace App\Service;

class EntropyService
{


    private int $AvailableCaractersNbr = 95;

    public function calculerEntropieTheorique(string $chaine): float
    {
        if (empty($chaine)) {
            return 0.0;
        }

        // 1️⃣ Taille de l'alphabet selon types de caractères
        $alphabetSize = 0;
        if (preg_match('/[a-z]/', $chaine)) $alphabetSize += 26;
        if (preg_match('/[A-Z]/', $chaine)) $alphabetSize += 26;
        if (preg_match('/[0-9]/', $chaine)) $alphabetSize += 10;
        if (preg_match('/[^a-zA-Z0-9]/', $chaine)) $alphabetSize += 33;

        $longueur = strlen($chaine);

        // 2️⃣ Entropie théorique (bits)
        $entropy = log(pow($alphabetSize, $longueur), 2);

        // 3️⃣ Pénalisation pour répétitions
        $chars = str_split($chaine);
        $uniqueChars = count(array_unique($chars));
        if ($uniqueChars < $longueur) {
            $repetitionPenalty = $longueur / $uniqueChars;
            $entropy /= $repetitionPenalty;
        }

        return $entropy;
    }

    public function checkEntropieTheorique(string $chaine, float $threshold = 36.0): bool
    {
        return $this->calculerEntropieTheorique($chaine) >= $threshold;
    }
}
