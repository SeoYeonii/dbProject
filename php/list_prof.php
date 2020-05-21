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
  require_once("db_info.php");
  session_start();
  $userid = $_SESSION['userid'];

  $query ="SELECT * FROM classes WHERE master_id = '$userid'";

  $result = $connect->query($query);
  $total = mysqli_num_rows($result);
  //session_start();

  if (isset($_SESSION['userid'])) {
    //echo $_SESSION['userid'];
?>
  강사님 안녕하세요!!
  <button onclick="location.href='./logout.php'">로그아웃</button>
  <button onclick="window.open('make_class.php?masterid=<?php echo $userid;?>', 'window팝업', 'width=300, height=200');" style="float: right;">과목 만들기</button>

<?php
  }
  else {
?>
    <button onClick="location.href='./login.php'">로그인</button>
    <br />
<?php
  }
?>

<h2 align=center>과목</h2>

<table align = center>

  <thead align = "center">
    <tr>
      <td width = "80" align = "center">과목 id</td>
      <td width = "300" align = "center">과목명</td>
      <td width = "100" align = "center">정원</td>
      <td width = "80" align = "center"></td>
      <td width = "80" align = "center"></td>
      <!--<td width = "50" align = "center">조회수</td>-->
    </tr>
  </thead>

  <tbody>
<?php
    while($rows = mysqli_fetch_assoc($result)){ //DB에 저장된 데이터 수 (열 기준)
      if($total%2==0){
?>
    <tr class = "even">
<?php
      }
      else{
?>
    <tr>
<?php
      }
?>
      <td width = "80" align = "center"><?php echo $rows['class_id']?></td>
      <td width = "300" align = "center">
        <a href = "view_class.php?masterid=<?php echo "$userid"; ?>&number=<?php echo $rows['class_id']?>">
        <?php echo $rows['name']?>
      </td>
      <td width = "100" align = "center"><?php echo $rows['capacity']?></td>
      <td width = "80" align = "center">
        <button><a href = "view_class.php?masterid=<?php echo "$userid"; ?>&number=<?php echo $rows['class_id']?>">이동</button>
      </td>
      <td width = "80" align = "center">
        <button><a href="delete_class_action.php?number=<?php echo $rows['class_id']?>">삭제</button>
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
