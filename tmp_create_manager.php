<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Agency;

$role = Role::where('slug', 'agency_manager')->first();
if (!$role) {
    fwrite(STDERR, "Missing role: agency_manager\n");
    exit(1);
}

$company = Company::where('name', 'Overline Voyage')->first();
if (!$company) {
    fwrite(STDERR, "Missing company: Overline Voyage\n");
    exit(1);
}

$agency = Agency::where('company_id', $company->id)->orderBy('id')->first();
if (!$agency) {
    fwrite(STDERR, "No agency found for Overline Voyage\n");
    exit(1);
}

$email = 'overline.manager@test.com';
$passwordPlain = 'password123';
$basePhone = '678900111';
$phone = $basePhone;
if (User::where('phone', $phone)->where('email', '!=', $email)->exists()) {
    $phone = '678900112';
}

$manager = User::firstOrNew(['email' => $email]);
$manager->full_name = 'Overline Manager';
$manager->phone = $phone;
$manager->password = bcrypt($passwordPlain);
$manager->user_type = 'staff';
$manager->role_id = $role->id;
$manager->status = 'active';
$manager->email_verified_at = $manager->email_verified_at ?? now();
$manager->save();

if ($agency->manager_id !== $manager->id) {
    $agency->manager_id = $manager->id;
    $agency->save();
}

echo "OK\n";
echo "Agency: {$agency->name}\n";
echo "Email: {$manager->email}\n";
echo "Password: {$passwordPlain}\n";
?>
