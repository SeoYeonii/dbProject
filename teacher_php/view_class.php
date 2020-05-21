<!DOCTYPE html>
<html>

<head>
  <meta charset = 'utf-8'>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <title>Preswot</title>
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
  <link href="../css/basic.css" type="text/css" rel=stylesheet>
  <link href="../css/header.css" type="text/css" rel=stylesheet>
</head>

<body>
<?php
  session_start();

  $masterid = $_GET['masterid'];

  $_here = $_SERVER['REQUEST_URI'];
  $_SESSION['class_url'] = $_here;

  $classid = $_GET['number'];
  $_SESSION['classid'] = $classid;

  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project');

  $query = "SELECT name FROM classes WHERE class_id = '$classid'";
  $result = $connect->query($query);
  $row = mysqli_fetch_assoc($result);
  $title = $row['name'];

  $query = "SELECT * FROM lectures WHERE class_id = '$classid'";
  $result = $connect->query($query);
  $total = mysqli_num_rows($result);
  if (isset($_SESSION['userid'])) {
?>
  강사님 안녕하세요!!
  <button onclick="location.href='./logout.php'">로그아웃</button>
  <button onclick="window.open('make_lecture.php', 'window팝업', 'width=400, height=600');" style="float: right;">강의 만들기</button>

<?php
  }
  else {
?>
    <button onClick="location.href='./login.php'">로그인</button>
    <br />
<?php
  }
?>
<h2 align=center>
    <a href = "./list_prof.php">
      <?php echo $title ?>
    </a>
</h2>
<table align = center>
  <thead align = "center">
    <tr>
      <td width = "80" align = "center">강의 id</td>
      <td width = "80" align = "center">강의명</td>
      <td width = "160" align = "center">시작 시간</td>
      <td width = "30" align = "center">~</td>
      <td width = "160" align = "center">종료 시간</td>
      <td width = "80" align = "center"></td>
      <td width = "80" align = "center"></td>
    </tr>
  <tbody>
<?php
  while($rows = mysqli_fetch_assoc($result)){ //DB에 저장된 데이터 수 (열 기준)
    if($total%2==0){
?>
    <tr class = "even">
<?php
    }
    else {
?>
    <tr>
<?php
    }
?>
      <td width = "80" align = "center"><?php echo $rows['lecture_id']?></td>
      <td width = "80" align = "center">
        <a href = "view_lecture.php?masterid=<?php echo "$masterid"; ?>&number=<?php echo $rows['lecture_id']?>">
        <?php echo $rows['name']?>
      </td>
      <td width = "160" align = "center"><?php echo $rows['start_time']?></td>
      <td width = "30" align = "center">~</td>
      <td width = "160" align = "center"><?php echo $rows['end_time']?></td>
      <td width = "80" align = "center">
        <button><a href = "view_lecture.php?masterid=<?php echo "$masterid"; ?>&number=<?php echo $rows['lecture_id']?>">이동</button>
      </td>
      <td width = "80" align = "center">
        <button><a href="delete_lecture_action.php?number=<?php echo $rows['lecture_id']?>">삭제</button>
      </td>
    </tr>
<?php
    $total--;
  }
?>
</tbody>
</table>
</body>

</html>
