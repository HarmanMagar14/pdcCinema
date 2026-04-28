<?php
/**
 * Download poster images from URLs and save them locally
 * This script helps populate the local storage/app/public/posters directory
 */

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Movies;

// Movie posters URLs (sources)
$posterUrls = [
    'Harry Potter and the Philosopher\'s Stone' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/Harry_Potter_Philosopher%27s_Stone.jpg',
    'The Dark Knight' => 'https://images.moviesanywhere.com/bd47f9b7d090170d79b3085804075d41/c6140695-a35f-46e2-adb7-45ed829fc0c0.jpg',
    'Inception' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg',
    'The Shawshank Redemption' => 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg',
    'Pulp Fiction' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Pulp_Fiction.jpg',
    'The Lord of the Rings: The Fellowship of the Ring' => 'https://upload.wikimedia.org/wikipedia/en/8/87/Fellowshipofthering_ver4.jpg',
    'Forrest Gump' => 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump.png',
    'The Matrix' => 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg',
    'Titanic' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Titanic_%281997%29_movie_poster.jpg',
    'The Avengers' => 'https://upload.wikimedia.org/wikipedia/en/f/f9/TheAvengers2012Poster.jpg',
    'Toy Story' => 'https://upload.wikimedia.org/wikipedia/en/1/13/Toy_Story.jpg',
    'The Conjuring' => 'https://upload.wikimedia.org/wikipedia/en/5/5f/The_Conjuring_poster.jpg',
];

$posterDir = __DIR__ . '/storage/app/public/posters';

// Create directory if it doesn't exist
if (!is_dir($posterDir)) {
    mkdir($posterDir, 0755, true);
    echo "✓ Created poster directory: $posterDir\n\n";
}

$downloaded = 0;
$failed = 0;

foreach ($posterUrls as $movieTitle => $url) {
    // Generate filename from movie title
    $filename = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $movieTitle));
    $filename = preg_replace('/-+/', '-', $filename);
    $filename = trim($filename, '-');
    
    // Get file extension from URL
    $urlPath = parse_url($url, PHP_URL_PATH);
    $ext = pathinfo($urlPath, PATHINFO_EXTENSION);
    if (empty($ext) || !in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        $ext = 'jpg';
    }
    
    $filePath = $posterDir . '/' . $filename . '.' . $ext;
    
    // Skip if file already exists
    if (file_exists($filePath)) {
        echo "↷ Already exists: $filename.$ext\n";
        continue;
    }
    
    // Download the image
    echo "⬇ Downloading: $movieTitle... ";
    
    try {
        $imageData = @file_get_contents($url);
        if ($imageData === false) {
            echo "✗ Failed to download\n";
            $failed++;
            continue;
        }
        
        // Save the image
        if (file_put_contents($filePath, $imageData)) {
            echo "✓ Saved\n";
            
            // Update the movie record in database
            $movie = Movies::where('title', $movieTitle)->first();
            if ($movie) {
                $relativePath = 'storage/app/public/posters/' . $filename . '.' . $ext;
                $movie->update(['poster' => $relativePath]);
            }
            
            $downloaded++;
        } else {
            echo "✗ Failed to save\n";
            $failed++;
        }
    } catch (Exception $e) {
        echo "✗ Error: {$e->getMessage()}\n";
        $failed++;
    }
}

echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Summary:\n";
echo "  Downloaded: $downloaded\n";
echo "  Failed: $failed\n";
echo "  Directory: $posterDir\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
