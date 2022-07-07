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
    if(!empty($_POST["remain_id"])){
        // 投稿IDのGETパラメータを取得
        $email = $_SESSION['email'];
        $remain_id = $_POST['remain_id'];
    }
    $reserve_data = array(
        'remain_id' => $remain_id,
        'user_email' => $email
    );
    $send_url = 'http://sample.homestead.test/receive.php';
    // receive.phpにJSON形式でデータを投げる
    $json = json_encode($event_data, JSON_PRETTY_PRINT);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, '\register_reserve');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    $result = curl_exec($ch);
    $result = json_decode($result, true);
    if($result["id"] == 200) :?>
        予約しました<br>
        <a href="reserve_home.php" class="btn">戻る</a>
    <?php else :?>
        失敗しました。やり直してください。<br>
        <a href="reserve_home.php" class="btn">戻る</a>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>