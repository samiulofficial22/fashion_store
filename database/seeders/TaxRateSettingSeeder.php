<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxRateSetting;

class TaxRateSettingSeeder extends Seeder
{
    public function run(): void
    {
        TaxRateSetting::firstOrCreate(['id' => 1], ['tax_rate' => 2.00]);
    }
}
