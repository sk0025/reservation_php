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
    $_POST["email"] = $email;
    $_POST["password"] = $pass;
    $login_data = array(
        'email' => $email,
        'password' => $pass
    );
    $send_url = 'http://sample.homestead.test/receive.php';
    // receive.phpにJSON形式でデータを投げる
    $json = json_encode($login_data, JSON_PRETTY_PRINT);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, '/login');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    $result = curl_exec($ch);
    $result = json_decode($result, true);
    if($result[0] == 200){
        $_SESSION["email"] = $email;
    }
    if(!isset($_SESSION["email"])): ?>
    ログインに失敗しました<br>
    <a href="reserve_login.php" class="btn">戻る</a>
<?php else: ?>
    ログインに成功しました<br>
    <a href="reserve_home.php" class="btn">ホームへ</a>
<?php endif; ?>
</body>
</html>