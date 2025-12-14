<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configs')->insert([
            [
                'field' => 'current_bcs',
                'value' => 48,
            ],
            [
                'field' => 'current_bcs_type',
                'value' => 'Special',
            ],
            [
                'field' => 'reg_all_table',
                'value' => 'registrations48',
            ],
            [
                'field' => 'select_all_table',
                'value' => 'results48',
            ],
        ]);
    }
}
