<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Movies;
$data = "";
foreach (Movies::all() as $movie) {
    $data .= $movie->title . " => " . $movie->poster . "\n";
}
file_put_contents(__DIR__ . '/poster_check.txt', $data);
echo "done\n";
