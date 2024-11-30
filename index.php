<?php
$ch_post = curl_init();

// POST cURL isteği
$url_post = 'https://api.baubuddy.de/index.php/login';  // POST isteği yapılacak URL

// cURL seçeneklerini ayarla
curl_setopt_array($ch_post, [
    CURLOPT_URL => $url_post,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz",
        "Content-Type: application/json"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "{\"username\":\"365\", \"password\":\"1\"}",
]);
// POST isteğini gönder
$response_post = curl_exec($ch_post);
curl_close($ch_post);
if (curl_errno($ch_post)) {
    echo 'Curl error: ' . curl_error($ch_post);
} else {
    $data = json_decode($response_post, true);
    // Store access token in session
    $_SESSION['access_token'] = $data['oauth']['access_token'];
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>App</title>
</head>

<body>
    <?php include 'templates/header.php'; ?>
</body>

</html>
