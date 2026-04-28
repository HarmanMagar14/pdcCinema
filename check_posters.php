<?php
$urls = [
    'Harry Potter' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/Harry_Potter_Philosopher%27s_Stone.jpg',
    'The Dark Knight' => 'https://images.moviesanywhere.com/bd47f9b7d090170d79b3085804075d41/c6140695-a35f-46e2-adb7-45ed829fc0c0.jpg',
    'Inception' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg',
    'The Shawshank Redemption' => 'https://upload.wikimedia.org/wikipedia/en/8/81/ShawshankRedemptionMoviePoster.jpg',
    'Pulp Fiction' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Pulp_Fiction.jpg',
    'The Lord of the Rings' => 'https://upload.wikimedia.org/wikipedia/en/8/87/Fellowshipofthering_ver4.jpg',
    'Forrest Gump' => 'https://upload.wikimedia.org/wikipedia/en/6/67/Forrest_Gump.png',
    'The Matrix' => 'https://upload.wikimedia.org/wikipedia/en/c/c1/The_Matrix_Poster.jpg',
    'Titanic' => 'https://upload.wikimedia.org/wikipedia/en/2/2e/Titanic_%281997%29_movie_poster.jpg',
    'The Avengers' => 'https://upload.wikimedia.org/wikipedia/en/f/f9/TheAvengers2012Poster.jpg',
    'Toy Story' => 'https://upload.wikimedia.org/wikipedia/en/1/13/Toy_Story.jpg',
    'The Conjuring' => 'https://upload.wikimedia.org/wikipedia/en/5/5f/The_Conjuring_poster.jpg',
];
foreach ($urls as $title => $url) {
    $headers = @get_headers($url);
    $status = is_array($headers) ? $headers[0] : 'ERROR';
    echo "$title => $status ($url)\n";
}
