<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    public function run()
    {
        Agency::create([
            'name' => 'Garantie Express',
            'description' => 'Transport rapide et sécurisé dans tout le Cameroun',
            'phone' => '+237 123 456 789',
            'email' => 'info@garantie-express.com',
            'address' => 'Rue de la République',
            'city' => 'Yaoundé',
            'rating' => 4.5,
            'is_active' => true
        ]);

        Agency::create([
            'name' => 'Binam Voyage',
            'description' => 'Votre partenaire voyage de confiance depuis 1995',
            'phone' => '+237 987 654 321',
            'email' => 'contact@binam-voyage.com',
            'address' => 'Avenue Kennedy',
            'city' => 'Douala',
            'rating' => 4.2,
            'is_active' => true
        ]);

        Agency::create([
            'name' => 'Central Voyage',
            'description' => 'Excellence et ponctualité à votre service',
            'phone' => '+237 555 123 456',
            'email' => 'info@central-voyage.com',
            'address' => 'Carrefour Central',
            'city' => 'Bafoussam',
            'rating' => 4.7,
            'is_active' => true
        ]);
    }
}