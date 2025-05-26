<?php

namespace Database\Seeders;

use App\Models\MarkUp;
use Illuminate\Database\Seeder;

class MarkUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'fee_type'=>'addition',
                'fee_value'=>'fixed',
                'fee_amount'=>0,
                'status'=> 'Active',
            ],
            
        ];
  
        foreach ($user as $key => $value) {
            MarkUp::create($value);
        }
    }
}
