<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;

class CivilityService
{
    public function determineCivility(Collection $tenants): ?string
    {
        $sirCount = 0;
        $madamCount = 0;

        // Count the number of civility
        foreach ($tenants as $tenant) {
            if ($tenant->getCivility() === 'Mr') {
                $sirCount++;
            } elseif ($tenant->getCivility() === 'Mme') {
                $madamCount++;
            }
        }

        // Determine the greeting letter
        if ($sirCount >= 2 && $madamCount >= 2) {
            return 'Mesdames et Messieurs';
        } elseif ($sirCount == 1 && $madamCount == 1) {
            return 'Madame, Monsieur';
        } elseif ($sirCount >= 2) {
            return 'Messieurs';
        } elseif ($madamCount >= 2) {
            return 'Mesdames';
        } elseif ($sirCount == 1 && $madamCount == 0) {
            return 'Monsieur';
        } elseif ($madamCount == 1 && $sirCount == 0) {
            return 'Madame';
        }

        return null;
    }
}
