<?php
// Simple script to update Harry Potter poster
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Movies;

$movie = Movies::where('title', 'Harry Potter and the Philosopher\'s Stone')->first();
if ($movie) {
    $movie->poster = 'https://upload.wikimedia.org/wikipedia/en/a/a7/Harry_Potter_Philosopher%27s_Stone.jpg';
    $movie->save();
    echo "✓ Updated poster for: " . $movie->title . "\n";
    echo "New URL: " . $movie->poster . "\n";
} else {
    echo "✗ Movie not found\n";
}
