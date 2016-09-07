<?php

use Illuminate\Database\Seeder;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('regions')->insert([
            'id'         => 1,
            'name'       => 'عمل مؤقت في موسم الحج',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 2,
            'name'       => 'others',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 3,
            'name'       => 'مكة المكرمة',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 4,
            'name'       => 'المدينة المنورة',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 5,
            'name'       => 'القصيم',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 6,
            'name'       => 'الشرقية',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 7,
            'name'       => 'عسير',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 8,
            'name'       => 'تبوك',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 9,
            'name'       => 'حائل',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 10,
            'name'       => 'الحدود الشمالية',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 11,
            'name'       => 'جازان',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 12,
            'name'       => 'نجران',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 13,
            'name'       => 'الباحة',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 14,
            'name'       => 'الجوف',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('regions')->insert([
            'id'         => 15,
            'name'       => 'الرياض',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
