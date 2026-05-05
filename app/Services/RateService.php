<?php

namespace App\Services;

use App\Models\Rate;

class RateService
{
    /**
     * Calculate shipping rate with volumetric weight & 0.3kg tolerance.
     * @param int $originLocationId
     * @param int $destinationLocationId
     * @param float $weightKg  Actual Weight in KILOGRAMS
     * @param int|null $length  Length in cm
     * @param int|null $width   Width in cm
     * @param int|null $height  Height in cm
     */
    public function calculate($originLocationId, $destinationLocationId, $weightKg, $length = null, $width = null, $height = null)
    {
        $rate = Rate::where('origin_location_id', $originLocationId)
                    ->where('destination_location_id', $destinationLocationId)
                    ->first();

        if (!$rate) {
            return null;
        }

        // 1. Calculate Volumetric Weight
        $volumetricWeight = 0;
        if ($length && $width && $height) {
            $volumetricWeight = ($length * $width * $height) / 6000;
        }

        // 2. Determine Chargeable Weight (Max of Actual vs Volumetric)
        $chargeableWeight = max((float) $weightKg, $volumetricWeight);

        // 3. Apply 0.3kg Tolerance Rule
        // Example: 1.3kg -> 1kg. 1.31kg -> 2kg.
        $floor = floor($chargeableWeight);
        $fraction = $chargeableWeight - $floor;
        
        if ($fraction <= 0.3 && $fraction > 0) {
            $finalWeight = $floor > 0 ? $floor : 1; // Minimum 1kg
        } else {
            $finalWeight = ceil($chargeableWeight);
            $finalWeight = max(1, $finalWeight); // Minimum 1kg
        }

        return [
            'total_price'       => $rate->price_per_kg * $finalWeight,
            'estimated_days'    => $rate->estimated_days,
            'price_per_kg'      => $rate->price_per_kg,
            'chargeable_weight' => $finalWeight,
            'volumetric_weight' => $volumetricWeight > 0 ? round($volumetricWeight, 2) : null
        ];
    }
}
