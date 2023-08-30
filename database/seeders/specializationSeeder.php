<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class specializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->insert([
            'uuid' => Str::uuid(),
            'name' => 'طب بشري',
            'type' => '1',
            'photo' => 'DR.svg',
        ]);

        DB::table('specializations')->insert([
            'uuid' => Str::uuid(),
            'name' => 'طب أسنان',
            'type' => '1',
            'photo' => 'dentist.svg',
        ]);

        DB::table('specializations')->insert([
            'uuid' => Str::uuid(),
            'name' => 'تمريض',
            'type' => '1',
            'photo' => 'nurs.svg',
        ]);

        DB::table('specializations')->insert([
            'uuid' => Str::uuid(),
            'name' => 'صيدلة',
            'type' => '1',
            'photo' => 'pharmacy.svg',
        ]);

        DB::table('specializations')->insert([
            'uuid' => Str::uuid(),
            'name' => 'هندسة معمارية',
            'type' => '0',
            'photo' => 'ARCH.svg',
        ]);

        DB::table('specializations')->insert([
            'uuid' => Str::uuid(),
            'name' => 'هندسة معلوماتية',
            'type' => '0',
            'photo' => 'It.svg',
        ]);
    }
}
