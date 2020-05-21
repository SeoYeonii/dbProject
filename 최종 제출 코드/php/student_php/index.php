<?php
	require_once("dbconfig.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset=utf-8>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <title>Preswot</title>
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
</head>

<header>
  <h1 align=center>Preswot</h1>
</header>

<body>
  <div align='center'>
  <span>로그인</span>

  <form method='get' action='login_action.php'>
    <p>ID: <input name="email" type="text"></p>
    <p>PW: <input name="pw" type="password"></p>
    <input type="submit" value="로그인">
  </form>
  <br />
  <!--<button id="join" onclick="location.href='./join.php'">회원가입</button>-->
  </div>
</body>

</html>
