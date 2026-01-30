<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::firstOrCreate(
            ['email' => 'contact@naralvoyage.com'],
            [
                'name'                 => 'Naral Voyage',
                'acronym'              => 'NV',
                'headquarters_address' => 'Yaoundé, Rue de la République',
                'phone'                => '+237 677 123 456',
                'taxpayer_number'      => 'TX-NAR-2024-001',
                'description'          => 'Entreprise de transport routier interurbain au Cameroun',
                'status'               => 'active',
            ]
        );
    }
}
