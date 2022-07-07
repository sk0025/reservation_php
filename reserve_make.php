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
    if(!empty($_GET["remain_id"])){
        // 投稿IDのGETパラメータを取得
        $remain_id = $_GET['remain_id'];
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
    /*
    $host = "mysql57.kemco.sakura.ne.jp";
    $dbName = "kemco_hakkei";
    $username = "kemco";
    $password = "h76-id_z";
    $dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
    try {
        $dbh = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $sql = "SELECT * FROM Availability　WHERE id = :reserve_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->execute();
    $days = $stmt->fetchAll();
    
    */
    $reserve_event = Array(
        "0" => Array(
            "id" => $reserve_id,
            "day" => "2022/07/07",
            "remaining" => 10,
            "event_id" => 0
        )
        );
    echo $reserve_event[0]["day"]."のイベントを予約します";
    ?>
    <form action="reserve_make_check.php" class='card w-50 mb-3'  method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
            <input type="hidden" name="reserve_id" value=<?php echo $reserve_id; ?>>
        </div>
        <p></p>
        <button type="submit" class="btn btn-primary">予約する</button>
        </form>
</body>
</html>