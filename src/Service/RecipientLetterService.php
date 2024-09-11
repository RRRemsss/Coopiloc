<?php

namespace App\Service;

use App\Entity\Rental;

class RecipientLetterService
{
    public function getTenantsAddress(Rental $rental): array
    {
        $tenantNames = [];
        foreach ($rental->getTenants() as $tenant) {
            $tenantNames[] = $tenant->getFullName();
        }

        // Check if otherAddress is used
        $useOtherAddress = false;
        $otherAddress = null;
        foreach ($rental->getRentalDocuments() as $rentalDocument) {
            if ($rentalDocument->getHasOtherAddress() && !empty($rentalDocument->getOtherAddress())) {
                $useOtherAddress = true;
                $otherAddress = $rentalDocument->getOtherAddress();
                break;
            }
        }

        // If no otherAddress, get property Address
        if (!$useOtherAddress) {
            $propertyAddress = $rental->getProperty()->getAddress();
            $otherAddress = $propertyAddress->getStreetName() . ' ' . $propertyAddress->getPostcode() . ' ' . $propertyAddress->getCity() . ', ' . $propertyAddress->getCountry();
        }

        return [
            'tenantNames' => $tenantNames,
            'address' => $otherAddress
        ];
    }
}
