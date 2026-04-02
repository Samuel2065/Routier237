<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$cities = \App\Models\City::whereIn('slug', ['bertoua','yaounde'])->get(['name','slug'])->toArray();
var_export($cities);
