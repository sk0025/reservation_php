<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>予約</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/home.css">
</head>
<body>
    <?php
    if(!isset($_SESSION["email"])): ?>
    ログインしてください<br>
    <a href="reserve_login.php" class="btn">戻る</a>
    <?php else : 
        $email = $_SESSION["email"];
        $login_data = array(
            'email' => $email
        );
        $send_url = 'http://localhost:8090/reservation';
        // receive.phpにJSON形式でデータを投げる
        $json = json_encode($login_data, JSON_PRETTY_PRINT);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $send_url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $reservations = $result['reservation'];
        $count = count($reservations);
   
        for($i = 0 ; $i < $count ; $i ++){
            echo "<div class='card w-50 mb-3' style='margin: auto;'>";
            echo "<div class='card-body'>";
            echo "<h2 class='card-title'>".$reservations[$i]["event_name"]."</h2>";
            echo "<h3 class='card-text mb-2'>日にち：".$reservations[$i]["day"]."</h3>";
            echo "<form  action='reserve_delete.php' method='get'><input type='hidden' name='event_id' value=".$reservations[$i]["id"]."><div class='btn btn-secondary btn-sm'><input type='submit' value='Delete'></div></form>";
            echo "</div>";
            echo "</div>";
        }
    ?>
    <a href="reserve_home.php" class="btn">ホームへ</a>
    <?php endif; ?>
</body>

</html>