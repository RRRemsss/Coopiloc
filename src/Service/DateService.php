<?php
namespace App\Service;

use DateTime;

class DateService
{
    public function getFirstWorkingDayOfNextMonth(DateTime $date): DateTime
    {
        // Créer une copie de l'objet DateTime pour éviter de modifier l'original
        $newDate = clone $date;

        // Se déplacer au premier jour du mois prochain
        $newDate->modify('first day of next month');

        // Vérifier si le premier jour est un week-end (samedi ou dimanche)
        while (in_array($newDate->format('N'), [6, 7])) {
            // Si c'est samedi (6) ou dimanche (7), passer au jour suivant
            $newDate->modify('+1 day');
        }

        return $newDate;
    }
}
