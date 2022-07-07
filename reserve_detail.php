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
    if(!empty($_GET["event_id"])){
        // 投稿IDのGETパラメータを取得
        $event_id = $_GET['event_id'];
    }
    $event_data = array(
        'event_id' => $event_id
    );
    $send_url = 'http://sample.homestead.test/receive.php';
    // receive.phpにJSON形式でデータを投げる
    $json = json_encode($event_data, JSON_PRETTY_PRINT);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, '/event_detail');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    $result = curl_exec($ch);
    $days = json_decode($result, true);
    $days = Array(
        "0" => Array(
            "id" => 0,
            "day" => "2022/07/07",
            "remaining" => 10,
            "event_id" => $event_id
        ),
        "1" => Array(
            "id" => 1,
            "day" => "2022/07/08",
            "remaining" => 10,
            "event_id" => $event_id
        ),
        "2" => Array(
            "id" => 2,
            "day" => "2022/07/09",
            "remaining" => 10,
            "event_id" => $event_id
        )
        );
    $count = count($days);
    for($i = 0 ; $i < $count ; $i ++){
        echo "<div class='card w-50 mb-3' style='margin: auto;'>";
        echo "<div class='card-body'>";
        echo "<h2 class='card-title'>".$days[$i]["day"]."</h2>";
        echo "<h3 class='card-text mb-2'>残席数：".$days[$i]["remaining"]."</h3>";
        echo "<form  action='reserve_make_check.php' method='post'><input type='hidden' name='remain_id' value=".$days[$i]["id"]."><div class='btn btn-secondary btn-sm'><input type='submit' value='予約'></div></form>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <?php endif; ?>
</body>
</html>