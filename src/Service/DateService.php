<?php
namespace App\Service;

use DateTime;

class DateService
{
    public function getFirstWorkingDayOfNextMonth(DateTime $date): DateTime
    {
        // Create a copy of the object DateTime to avoid overwriting the original
        $newDate = clone $date;

        // Go to the fisrt of the following month
        $newDate->modify('first day of next month');

        // Verify if the fisrt day is a in the weekend (Check if its Saturday or Sunday)
        while (in_array($newDate->format('N'), [6, 7])) {
            // If it's saturday (6) or sunday (7), go to the next day.
            $newDate->modify('+1 day');
        }

        return $newDate;
    }
}
