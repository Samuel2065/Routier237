<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Agency;
use App\Models\City;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;

class OverlineManagersSeeder extends Seeder
{
    public function run(): void
    {
        $agencyManagerRole = Role::where('slug', 'agency_manager')->first();
        $overlineCompany = Company::where('name', 'Overline Voyage')->first();

        if (!$agencyManagerRole || !$overlineCompany) {
            $this->command->warn('Missing agency_manager role or Overline Voyage company.');
            return;
        }

        $yaoundeCity = City::where('name', 'YaoundÃ©')->first() ?? City::where('name', 'Yaounde')->first();
        $bertouaCity = City::where('name', 'Bertoua')->first();

        $yaoundeAgency = Agency::where('name', 'Overline Voyage YaoundÃ©')->first()
            ?? Agency::where('name', 'Overline Voyage Yaounde')->first();
        $bertouaAgency = Agency::where('name', 'Overline Voyage Bertoua')->first();

        if (!$yaoundeAgency && $yaoundeCity) {
            $yaoundeAgency = Agency::firstOrCreate(
                ['name' => 'Overline Voyage YaoundÃ©'],
                [
                    'company_id' => $overlineCompany->id,
                    'city_id' => $yaoundeCity->id,
                    'agency_code' => 'AG-OV-YAO',
                    'district' => 'Messa',
                    'full_address' => 'Messa, YaoundÃ©',
                    'slug' => Str::slug('Overline Voyage Yaounde'),
                    'rating' => 4.5,
                    'phone' => '678001111',
                    'email' => 'overline.yaounde@gmail.com',
                    'type' => 'main',
                    'status' => 'active',
                    'approval_status' => 'approved',
                ]
            );
        }

        if (!$bertouaAgency && $bertouaCity) {
            $bertouaAgency = Agency::firstOrCreate(
                ['name' => 'Overline Voyage Bertoua'],
                [
                    'company_id' => $overlineCompany->id,
                    'city_id' => $bertouaCity->id,
                    'agency_code' => 'AG-OV-BER',
                    'district' => 'Nkolbisson',
                    'full_address' => 'Nkolbisson, Bertoua',
                    'slug' => Str::slug('Overline Voyage Bertoua'),
                    'rating' => 4.5,
                    'phone' => '678001112',
                    'email' => 'overline.bertoua@gmail.com',
                    'type' => 'secondary',
                    'status' => 'active',
                    'approval_status' => 'approved',
                ]
            );
        }

        if ($yaoundeAgency) {
            $yaoundeManager = User::firstOrCreate(
                ['email' => 'overline.yaounde.manager@gmail.com'],
                [
                    'full_name' => 'Overline Yaounde Manager',
                    'phone' => '690100201',
                    'password' => bcrypt('password'),
                    'user_type' => 'staff',
                    'role_id' => $agencyManagerRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            $yaoundeAgency->manager_id = $yaoundeManager->id;
            $yaoundeAgency->save();
        }

        if ($bertouaAgency) {
            $bertouaManager = User::firstOrCreate(
                ['email' => 'overline.bertoua.manager@gmail.com'],
                [
                    'full_name' => 'Overline Bertoua Manager',
                    'phone' => '690100202',
                    'password' => bcrypt('password'),
                    'user_type' => 'staff',
                    'role_id' => $agencyManagerRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            $bertouaAgency->manager_id = $bertouaManager->id;
            $bertouaAgency->save();
        }

        $this->command->info('Overline managers seeded successfully.');
    }
}
