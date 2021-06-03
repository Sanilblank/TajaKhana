<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Branch::insert([
            [
                'branchname' => 'TajaKhana',
                'branchlocation' => 'Kamaladi, Kathmandu',
                'longitude' => '85.318486',
                'latitude' => '27.707792',
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
