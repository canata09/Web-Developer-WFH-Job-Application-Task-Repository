<?php
session_start();

if (!isset($_SESSION['access_token'])) {
    // Eğer token yoksa, giriş sayfasına yönlendiriyoruz
    header("Location: index.php");
    exit();
}

$access_token = $_SESSION['access_token'];  // Oturumdan token'ı alıyoruz

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // To-do oluşturma isteği
    $task_name = $_POST['task_name'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    // API URL
    $url = "https://api.baubuddy.de/dev/index.php/v1/tasks/select";

    // Gönderilecek JSON verisi
    $data = json_encode([
        "task_name" => $task_name,
        "due_date" => $due_date,
        "priority" => $priority
    ]);

    // cURL ile API'ye POST isteği gönderiyoruz
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: Bearer $access_token"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);  // API'den gelen yanıtı alıyoruz
    curl_close($ch);

    // Yanıtı JSON olarak decode ediyoruz
    $response_data = json_decode($response, true);

    if (isset($response_data['task_id'])) {
        echo "To-do görev başarıyla oluşturuldu!";
    } else {
        echo "To-do oluşturulamadı. Hata: " . $response_data['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni To-Do Oluştur</title>
</head>

<body>
    <h2>Yeni To-Do Görevi Oluştur</h2>
    <form action="todo.php" method="post">
        <label for="task_name">Görev Adı:</label><br>
        <input type="text" id="task_name" name="task_name" required><br><br>

        <label for="due_date">Son Tarih:</label><br>
        <input type="date" id="due_date" name="due_date" required><br><br>

        <label for="priority">Öncelik:</label><br>
        <select id="priority" name="priority" required>
            <option value="low">Düşük</option>
            <option value="medium">Orta</option>
            <option value="high">Yüksek</option>
        </select><br><br>

        <button type="submit">Görevi Oluştur</button>
    </form>
</body>

</html>