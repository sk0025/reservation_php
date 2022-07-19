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
    if(!empty($_POST["reserve_id"])){
        // 投稿IDのGETパラメータを取得
        $email = $_SESSION['email'];
        $reserve_id = $_POST['reserve_id'];
    }
    $delete_data = array(
        'reserve_id' => $reserve_id
    );
    $send_url = 'http://localhost:8090/delete_reserve';
    // receive.phpにJSON形式でデータを投げる
    $json = json_encode($delete_data, JSON_PRETTY_PRINT);
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
    if($httpcode == 200) :?>
        <h2>削除しました</h2><br>
        <a href="reserve_mypage.php" class="btn btn-border">戻る</a>
    <?php else :
        $message = $result["message"];
        echo $message;?>
        <h2>失敗しました。やり直してください。</h2><br>
        <a href="reserve_mypage.php" class="btn btn-border">戻る</a>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>