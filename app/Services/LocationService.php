<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LocationService
{
    private $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }

    /**
     * Add a new location for user
     */
    public function addUserLocation(User $user, array $data)
    {
        // Geocode the address
        $coordinates = $this->googleMapsService->geocodeAddress($data['address']);

        if (!$coordinates) {
            throw new \Exception('Unable to geocode address');
        }

        // Deactivate primary if this is new primary
        if ($data['is_primary'] ?? false) {
            $user->locations()->update(['is_primary' => false]);
        }

        return UserLocation::create([
            'user_id' => $user->id,
            'location_type' => $data['location_type'],
            'name' => $data['name'],
            'address' => $data['address'],
            'coordinates' => DB::raw("POINT({$coordinates['lng']}, {$coordinates['lat']})"),
            'city' => $coordinates['city'] ?? $this->extractCity($data['address']),
            'postcode' => $coordinates['postcode'] ?? null,
            'is_primary' => $data['is_primary'] ?? false,
            'active_from' => $data['active_from'] ?? null,
            'active_until' => $data['active_until'] ?? null,
        ]);
    }

    /**
     * Search for nannies in a specific location
     */
    public function searchNanniesInLocation($location, $radius = 20, $filters = [])
    {
        $query = User::query()
            ->role('nanny')
            ->where('is_active', true)
            ->where('verification_status', 'verified');

        // Location-based search
        if (is_array($location)) {
            // Direct coordinates provided
            $lat = $location['lat'];
            $lng = $location['lng'];
        } else {
            // Address provided, geocode it
            $coords = $this->googleMapsService->geocodeAddress($location);
            $lat = $coords['lat'];
            $lng = $coords['lng'];
        }

        // Use spatial query for distance
        $query->selectRaw(
            "*, ST_Distance_Sphere(
                location,
                ST_GeomFromText('POINT({$lng} {$lat})')
            ) / 1609.34 as distance_miles"
        )
        ->whereRaw(
            "ST_Distance_Sphere(
                location,
                ST_GeomFromText('POINT({$lng} {$lat})')
            ) <= ?",
            [$radius * 1609.34]
        );

        // Apply additional filters
        if (!empty($filters['available_dates'])) {
            $query->whereHas('availability', function ($q) use ($filters) {
                $q->whereBetween('date', [
                    $filters['available_dates']['start'],
                    $filters['available_dates']['end']
                ]);
            });
        }

        if (!empty($filters['min_rating'])) {
            $query->where('average_rating', '>=', $filters['min_rating']);
        }

        if (!empty($filters['max_hourly_rate'])) {
            $query->where('hourly_rate', '<=', $filters['max_hourly_rate']);
        }

        if (!empty($filters['languages'])) {
            $query->whereJsonContains('languages', $filters['languages']);
        }

        // Check if nannies are willing to work in vacation locations
        if ($filters['vacation_care'] ?? false) {
            $query->where('provides_vacation_care', true);
        }

        return $query->orderBy('distance_miles')->paginate(20);
    }

    /**
     * Get popular vacation destinations
     */
    public function getPopularVacationDestinations()
    {
        return Cache::remember('popular_vacation_destinations', 3600, function () {
            return DB::table('vacation_care_requests')
                ->select('destination_city', DB::raw('COUNT(*) as request_count'))
                ->where('created_at', '>', now()->subMonths(6))
                ->groupBy('destination_city')
                ->orderByDesc('request_count')
                ->limit(10)
                ->get();
        });
    }

    private function extractCity(string $address): ?string
    {
        $parts = array_map('trim', explode(',', $address));

        return $parts[1] ?? null;
    }
}
