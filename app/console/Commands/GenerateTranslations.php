<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\File;

class GenerateTranslations extends Command
{
    protected $signature = 'translations:generate {--from=fr} {--to=en}';
    protected $description = 'Generate translations automatically using Google Translate';

    public function handle()
    {
        $from = $this->option('from');
        $to = $this->option('to');
        
        $sourcePath = lang_path("{$from}/messages.php");
        $targetPath = lang_path("{$to}/messages.php");

        if (!File::exists($sourcePath)) {
            $this->error("Source file not found: {$sourcePath}");
            $this->info("Creating French translation file...");
            
            if (!File::exists(lang_path($from))) {
                File::makeDirectory(lang_path($from), 0755, true);
            }
            
            $defaultTranslations = [
                'home' => 'Accueil',
                'marketplace' => 'Marketplace',
                'agencies' => 'Agences',
                'destinations' => 'Destinations',
                'cities' => 'Villes',
                'major_cities' => 'Grandes Villes',
                'login' => 'Connexion',
                'sign_up' => 'Inscription',
                'toggle_theme' => 'Changer le thème',
                'footer_description' => 'La plateforme de transport routier du Cameroun. Voyagez en toute sécurité avec des agences validées.',
                'services' => 'Services',
                'bus_schedules' => 'Horaires de bus',
                'partner_agencies' => 'Agences partenaires',
                'bookings' => 'Réservations',
                'popular_cities' => 'Villes populaires',
                'contact' => 'Contact',
                'whatsapp_support' => 'Support WhatsApp',
                'all_rights_reserved' => 'Tous droits réservés',
                'privacy' => 'Confidentialité',
                'terms_of_use' => "Conditions d'utilisation",
                'support' => 'Assistance',
            ];
            
            $content = "<?php\n\nreturn " . var_export($defaultTranslations, true) . ";\n";
            File::put($sourcePath, $content);
            $this->info("French translation file created!");
        }

        $sourceTranslations = require $sourcePath;
        
        try {
            $translator = new GoogleTranslate($to);
            $translator->setSource($from);
        } catch (\Exception $e) {
            $this->error("Google Translate error: " . $e->getMessage());
            return 1;
        }

        $translations = [];
        $this->info("Translating from {$from} to {$to}...");
        $bar = $this->output->createProgressBar(count($sourceTranslations));

        foreach ($sourceTranslations as $key => $value) {
            try {
                $translations[$key] = $translator->translate($value);
                $bar->advance();
                usleep(100000);
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Error on '{$key}': " . $e->getMessage());
                $translations[$key] = $value;
            }
        }

        $bar->finish();
        $this->newLine(2);

        if (!File::exists(lang_path($to))) {
            File::makeDirectory(lang_path($to), 0755, true);
        }

        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        File::put($targetPath, $content);

        $this->info("✓ Translations generated successfully!");
        $this->info("File: {$targetPath}");
        return 0;
    }
}