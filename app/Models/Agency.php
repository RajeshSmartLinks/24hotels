<?php

namespace App\Models;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agency extends Model
{
    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'agency' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'agency' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/agency/';
    public static $imageThumbUrl = 'uploads/agency/thumb/';

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

   public function masterAgent(): HasOne
    {
        return $this->hasOne(User::class, 'agency_id', 'id')
            ->where('is_master_agent', 1);
    }

    /**
     * Generate Agency Code based on database id (e.g. MHA00001)
     *
     * @param int|null $agencyId
     * @return string
     */
    public static function generateAgencyCode($agencyId = null): string
    {
        if ($agencyId) {
            return 'MHA' . str_pad($agencyId, 5, '0', STR_PAD_LEFT);
        }

        $latestAgency = self::orderBy('id', 'desc')->first();
        $nextId = $latestAgency ? ($latestAgency->id + 1) : 1;

        return 'MHA' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Generate Agent Code based on database id (e.g. MHA00001-001)
     *
     * @param int|string|null $agencyId
     * @param int|null $userId
     * @return string
     */
    public static function generateAgentCode($agencyId = null, $userId = null): string
    {
        $agency = $agencyId ? self::find($agencyId) : null;
        $agencyCode = $agency && !empty($agency->agency_code)
            ? $agency->agency_code
            : self::generateAgencyCode($agencyId);

        if (!$userId) {
            $latestUser = User::orderBy('id', 'desc')->first();
            $userId = $latestUser ? ($latestUser->id + 1) : 1;
        }

        return $agencyCode . '-' . str_pad($userId, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Dump / backfill agency_code for all existing agencies based on their database id
     *
     * @return array
     */
    public static function dumpAgencyCodes(): array
    {
        $results = [];
        $agencies = self::all();
        foreach ($agencies as $agency) {
            $expectedCode = self::generateAgencyCode($agency->id);
            $oldCode = $agency->agency_code;
            $updated = false;
            if ($agency->agency_code !== $expectedCode) {
                $agency->agency_code = $expectedCode;
                $agency->save();
                $updated = true;
            }
            $results[] = [
                'id' => $agency->id,
                'name' => $agency->name,
                'old_code' => $oldCode,
                'new_code' => $expectedCode,
                'status' => $updated ? 'updated' : 'unchanged',
            ];
        }
        return $results;
    }

    /**
     * Dump / backfill agent_code for all existing agents based on their database id
     *
     * @return array
     */
    public static function dumpAgentCodes(): array
    {
        $results = [];
        $agents = User::where('is_agent', 1)->get();
        foreach ($agents as $agent) {
            if ($agent->agency_id) {
                $expectedCode = self::generateAgentCode($agent->agency_id, $agent->id);
                $oldCode = $agent->agent_code;
                $updated = false;
                if ($agent->agent_code !== $expectedCode) {
                    $agent->agent_code = $expectedCode;
                    $agent->save();
                    $updated = true;
                }
                $results[] = [
                    'id' => $agent->id,
                    'name' => trim($agent->first_name . ' ' . $agent->last_name),
                    'agency_id' => $agent->agency_id,
                    'old_code' => $oldCode,
                    'new_code' => $expectedCode,
                    'status' => $updated ? 'updated' : 'unchanged',
                ];
            }
        }
        return $results;
    }

    /**
     * Dump / backfill codes for both existing agencies and agents
     *
     * @return array
     */
    public static function dumpExistingCodes(): array
    {
        $agencyResults = self::dumpAgencyCodes();
        $agentResults = self::dumpAgentCodes();

        return [
            'status' => true,
            'message' => 'Agency and Agent codes dumped successfully',
            'agencies' => $agencyResults,
            'agents' => $agentResults,
        ];
    }
}
