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
    // $_POST["email"] = $email;
    // $_POST["password"] = $pass;
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $login_data = array(
        'email' => $email,
        'password' => $pass
    );

    // $send_url = 'http://sample.homestead.test/receive.php';
    $send_url = 'http://localhost:8090/login';
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

    if($httpcode == 200){
        $_SESSION["email"] = $email;
    }
    if(!isset($_SESSION["email"])): ?>
    <h2>ログインに失敗しました</h2><br>
    <a href="reserve_login.php" class="btn btn-border">戻る</a>
<?php else: ?>
    <h2>ログインに成功しました</h2><br>
    <a href="reserve_home.php" class="btn btn-border">ホームへ</a>
<?php endif; ?>
</body>
</html>