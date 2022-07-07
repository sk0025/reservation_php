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
    $send_url = 'http://localhost:8090/show_events_info';
        // receive.phpにJSON形式でデータを投げる
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $send_url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $events = json_decode($result, true);
        $events = $events['events'];
        $count = count($events);
        for($i = 0 ; $i < $count ; $i ++){
            if($events[$i]["event_id"] == $event_id){
                $days = $events[$i]["remains"];
            }
        }
    #$days = Array(
    #    "0" => Array(
    #        "id" => 0,
    #        "day" => "2022/07/07",
    #        "remaining" => 10,
    #        "event_id" => $event_id
    #    ),
    #    "1" => Array(
    #        "id" => 1,
    #        "remaining" => 10,
    #        "event_id" => $event_id
    #    ),
    #    "2" => Array(
    #        "id" => 2,
    #        "day" => "2022/07/09",
    #        "event_id" => $event_id
    #    )
    #    );
    $count = count($days);
    for($i = 0 ; $i < $count ; $i ++){
        echo "<div class='card w-50 mb-3' style='margin: auto;'>";
        echo "<div class='card-body'>";
        echo "<h2 class='card-title'>".$days[$i]["day"]."</h2>";
        echo "<h3 class='card-text mb-2'>残席数：".$days[$i]["remain_num_of_people"]."</h3>";
        echo "<form  action='reserve_make_check.php' method='post'><input type='hidden' name='remain_id' value=".$days[$i]["remain_id"]."><input type='submit' value='予約'></form>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <?php endif; ?>
</body>
</html>