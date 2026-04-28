<?php
/**
 * Generate placeholder poster images using SVG (no GD library needed)
 * Creates colorful SVG posters with movie titles
 */

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Movies;

// Color palette for posters
$colors = [
    ['bg' => '#1a1a4d', 'accent' => '#ff006e'],
    ['bg' => '#2d1b4e', 'accent' => '#00d9ff'],
    ['bg' => '#1a3a3a', 'accent' => '#ff6b35'],
    ['bg' => '#4a1a1a', 'accent' => '#ffd700'],
    ['bg' => '#1a2d4a', 'accent' => '#00ff88'],
    ['bg' => '#3a1a4a', 'accent' => '#ff1493'],
    ['bg' => '#2a3a1a', 'accent' => '#00bfff'],
    ['bg' => '#4a2a1a', 'accent' => '#ff69b4'],
    ['bg' => '#1a4a3a', 'accent' => '#ffaa00'],
    ['bg' => '#3a1a2a', 'accent' => '#00ff00'],
    ['bg' => '#1a3a2a', 'accent' => '#ff4500'],
    ['bg' => '#2a1a4a', 'accent' => '#00ced1'],
];

$posterDir = __DIR__ . '/storage/app/public/posters';

// Create directory if it doesn't exist
if (!is_dir($posterDir)) {
    mkdir($posterDir, 0755, true);
    echo "✓ Created poster directory\n\n";
}

$movies = Movies::all();
$created = 0;
$skipped = 0;

echo "Generating SVG placeholder posters...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

foreach ($movies as $index => $movie) {
    // Generate filename
    $filename = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $movie->title));
    $filename = preg_replace('/-+/', '-', $filename);
    $filename = trim($filename, '-');
    $filePath = $posterDir . '/' . $filename . '.svg';
    
    // Skip if already exists
    if (file_exists($filePath)) {
        echo "↷ Already exists: $filename.svg\n";
        $skipped++;
        continue;
    }
    
    // Get color for this movie
    $colorIndex = $index % count($colors);
    $bgColor = $colors[$colorIndex]['bg'];
    $accentColor = $colors[$colorIndex]['accent'];
    
    // Truncate title for display
    $displayTitle = strlen($movie->title) > 30 ? substr($movie->title, 0, 27) . '...' : $movie->title;
    $titleLines = wordwrap($displayTitle, 16, "\n", true);
    $lines = explode("\n", $titleLines);
    
    // Calculate text positioning
    $textY = 50;
    if (count($lines) > 1) {
        $textY = 140 / (count($lines) + 1);
    }
    
    // Build text elements
    $textElements = '';
    $yPos = $textY;
    foreach ($lines as $line) {
        $textElements .= '<text x="136" y="' . intval($yPos) . '" font-size="20" font-weight="bold" text-anchor="middle" fill="white" font-family="Arial, sans-serif">' . htmlspecialchars($line) . '</text>';
        $yPos += 35;
    }
    
    // Create SVG with proper gradient
    $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg width="272" height="400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 272 400">
    <!-- Background -->
    <rect width="272" height="400" fill="{$bgColor}"/>
    
    <!-- Accent circles -->
    <circle cx="220" cy="80" r="50" fill="{$accentColor}" opacity="0.3"/>
    <circle cx="50" cy="320" r="60" fill="{$accentColor}" opacity="0.2"/>
    
    <!-- Title -->
    <g text-anchor="middle">
        {$textElements}
    </g>
    
    <!-- NEW badge -->
    <rect x="12" y="12" width="50" height="25" fill="#e8340a" rx="3"/>
    <text x="37" y="29" font-size="12" font-weight="bold" fill="white" text-anchor="middle" font-family="Arial, sans-serif">NEW</text>
    
    <!-- Decorative bars -->
    <rect x="0" y="195" width="272" height="2" fill="{$accentColor}" opacity="0.6"/>
    <rect x="0" y="200" width="272" height="1" fill="{$accentColor}" opacity="0.3"/>
</svg>
SVG;
    
    // Save SVG
    if (file_put_contents($filePath, $svg)) {
        echo "✓ Created: $filename.svg\n";
        $created++;
    } else {
        echo "✗ Failed: $filename.svg\n";
    }
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Summary:\n";
echo "  Created:  $created\n";
echo "  Skipped:  $skipped\n";
echo "  Location: $posterDir\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

