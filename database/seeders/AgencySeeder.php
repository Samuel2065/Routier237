<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->error('Aucune company trouvée. Lance CompanySeeder avant.');
            return;
        }

        Agency::firstOrCreate(
            ['agency_code' => 'NAR-YAO-001'],
            [
                'company_id'   => $company->id,
                'name'         => 'Naral Voyage - Yaoundé',
                'city'         => 'Yaoundé',
                'district'     => 'Centre-ville',
                'full_address' => 'Yaoundé, Rue de la République',
                'phone'        => '+237 123 456 789',
                'email'        => 'info@naralvoyage.com',
                'type'         => 'secondary',
                'status'       => 'active',
                'latitude'     => 3.8667,
                'longitude'    => 11.5167,
            ]
        );
    }
}
