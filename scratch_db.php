<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$packages = DB::table('packages')->get();
foreach ($packages as $p) {
    echo "ID: " . $p->id . " | Name: " . $p->name . "\n";
    echo "  UPSI: " . ($p->price_upsi ?? 'N/A') . "\n";
    echo "  GOV: " . ($p->price_gov ?? 'N/A') . "\n";
    echo "  INTL: " . ($p->price_international ?? 'N/A') . "\n";
    echo "  PUB: " . ($p->price_public ?? 'N/A') . "\n";
}
