<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'مترجمات',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'داتا بيز',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'أوتومات',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'الشبكات',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'الذكاء الاصطناعي',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'قواعد المعطيات',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'هندسة البرمجيات',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'أمن',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'خوارزميات',
            'level' => '0'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'هندسة البرمجيات',
            'level' => '1'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'الشبكات',
            'level' => '1'
        ]);

        DB::table('subjects')->insert([
            'uuid' => Str::uuid(),
            'specialization_id' => 6,
            'name' => 'الذكاء الاصطناعي',
            'level' => '1'
        ]);

    }
}
