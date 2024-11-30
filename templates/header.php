<?php

if (!isset($_SESSION['access_token'])) {
    // Eğer token yoksa, giriş sayfasına yönlendiriyoruz
    header("Location: index.php");
    exit();
}

$access_token = $_SESSION['access_token'];  // Oturumdan token'ı alıyoruz


$ch_get = curl_init();

// GET cURL isteği
$url_get = 'https://api.baubuddy.de/dev/index.php/v1/tasks/select';  // GET isteği yapılacak URL

curl_setopt_array($ch_get, [
    CURLOPT_URL => $url_get,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $access_token,
        "Content-Type: application/json"
    ],
]);

// GET isteğini gönder
$response_get = curl_exec($ch_get);
curl_close($ch_get);
if (curl_errno($ch_get)) {
    echo 'Curl error: ' . curl_error($ch_get);
} else {

    $info = json_decode($response_get, true);


    // HTML tablosunu oluştur
    echo "<table border='1'>
        <tr>
            <th>Task</th>
            <th>Title</th>
            <th>Description</th>
            <th>Sort</th>
            <th>Wage Type</th>
            <th>Business Unit</th>
            <th>Parent Task ID</th>
            <th>Color Code</th>
            <th>Working Time</th>
            <th>Available in Kiosk Mode</th>
        </tr>";

    // JSON'dan gelen her bir öğe için tablo satırı oluştur
    foreach ($info as $item) {
        echo "<tr>
            <td>" . $item['task'] . "</td>
            <td>" . $item['title'] . "</td>
            <td>" . $item['description'] . "</td>
            <td>" . $item['sort'] . "</td>
            <td>" . $item['wageType'] . "</td>
            <td>" . $item['businessUnit'] . "</td>
            <td>" . $item['parentTaskID'] . "</td>
            <td>" . $item['colorCode'] . "</td>
            <td>" . $item['workingTime'] . "</td>
            <td>" . ($item['isAvailableInTimeTrackingKioskMode'] ? 'Yes' : 'No') . "</td>
        </tr>";
    }

    echo "</table>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
</head>

<body>
    <h2>List</h2>

</body>

</html>
