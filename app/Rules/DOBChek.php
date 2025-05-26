<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DOBChek implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $passengerType = '';
    public function __construct($passengerType)
    {
        $this->passengerType = $passengerType;
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date1=date_create($value);
        $date2=date_create(date('y-m-d'));
        $diff=date_diff($date1,$date2);
        $years = $diff->format("%y");
        if($this->passengerType == 'ADT')
        {
            return ($years > 12) ? true : false; 
        }
        if($this->passengerType == 'CNN')
        {
            return ($years <= 12 && $years >= 2) ? true : false; 
        }
        if($this->passengerType == 'INF')
        {
            $days = $diff->format("%a");
            return ($years < 2 && $days >14) ? true : false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->passengerType == 'ADT')
        {
            return 'please select valid Adult DOB';
        }
        if($this->passengerType == 'CNN')
        {
            return 'please select valid child DOB';
        }
        if($this->passengerType == 'INF')
        {
            return 'please select valid Infant DOB';
        }

       
    }
}
