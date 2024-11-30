<?php

// cURL oturumunu başlat
$curl = curl_init();

// Giriş yapmak için URL ve kullanıcı bilgileri
$url = "https://api.baubuddy.de/index.php/login";  // Giriş API'sinin URL'si

// cURL seçeneklerini ayarla
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz",
        "Content-Type: application/json"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "{\"username\":\"365\", \"password\":\"1\"}",
]);

// İstek gönder ve cevabı al
$response = curl_exec($curl);






$err = curl_error($curl);
// cURL oturumunu kapat
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
    // JSON verisini diziye dönüştür
    $data = json_decode($response, true);

    // Store access token in session
    $_SESSION['access_token'] = $data['oauth']['access_token'];
    

    // HTML Tablosu Başlangıcı
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>Başlık</th><th>Açıklama</th></tr>";

    // OAuth bilgileri
    echo "<tr><td>Access Token</td><td>" . $data['oauth']['access_token'] . "</td></tr>";
    echo "<tr><td>Expires In</td><td>" . $data['oauth']['expires_in'] . " saniye</td></tr>";
    echo "<tr><td>Token Type</td><td>" . $data['oauth']['token_type'] . "</td></tr>";
    echo "<tr><td>Refresh Token</td><td>" . $data['oauth']['refresh_token'] . "</td></tr>";

    // Kullanıcı Bilgileri
    echo "<tr><td>Personal No</td><td>" . $data['userInfo']['personalNo'] . "</td></tr>";
    echo "<tr><td>First Name</td><td>" . $data['userInfo']['firstName'] . "</td></tr>";
    echo "<tr><td>Last Name</td><td>" . $data['userInfo']['lastName'] . "</td></tr>";
    echo "<tr><td>Display Name</td><td>" . $data['userInfo']['displayName'] . "</td></tr>";
    echo "<tr><td>Active</td><td>" . ($data['userInfo']['active'] ? 'Evet' : 'Hayır') . "</td></tr>";
    echo "<tr><td>Business Unit</td><td>" . $data['userInfo']['businessUnit'] . "</td></tr>";

    // API Version
    echo "<tr><td>API Version</td><td>" . $data['apiVersion'] . "</td></tr>";

    // Tablo Kapanışı
    echo "</table>";
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