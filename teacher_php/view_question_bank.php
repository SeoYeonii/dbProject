<!DOCTYPE html>
<html>

<head>
  <meta charset = 'utf-8'>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <title>Preswot</title>
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
  <link href="../css/basic.css?after" type="text/css" rel=stylesheet>
  <link href="../css/header.css?after" type="text/css" rel=stylesheet>
  <script type="text/javascript">
    function location_log()
    {
     var here = window.location.href;
     var weight = document.getElementById("w");

     if (!keyword.value || !weight.value) {
       alert("키워드와 중요도를 모두 넣어주세요");
      }
    }
  </script>
</head>

<body>
<?php
  session_start();
  $masterid = $_GET['masterid'];
  $lectureid = $_GET['number'];

  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project');

  $query = "SELECT name FROM lectures WHERE lecture_id = '$lectureid';";
  $result = $connect->query($query);
  $row = mysqli_fetch_assoc($result);
  $title = $row['name'];

  $query = "SELECT * FROM questions_bank WHERE master_id = '$masterid'";
  $result = $connect->query($query);
  $total = mysqli_num_rows($result);
  if (isset($_SESSION['userid'])) {
?>
  강사님 안녕하세요!!
  <button onclick="location.href='./logout.php'">로그아웃</button>
  <button onclick="location.href='view_lecture.php?masterid=<?php echo "$masterid"; ?>&number=<?php echo $lectureid ?>';" style="float: right;">강의로 돌아가기</button>
<?php
  }
  else {
?>
    <button onClick="location.href='./login.php'">로그인</button>
    <br />
<?php
  }
?>
<h2 align=center>문제 은행</h2>
<table align = center style = "table-layout:fixed">
  <thead align = "center">
    <tr>
      <td width = "80" align = "center">문항 id</td>
      <td width = "80" align = "center">타입</td>
      <td width = "400" align = "center">문항</td>
      <td width = "60" align = "center"></td>
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
      <td width = "80" align = "center">
        <button class="aa" onclick="window.open('view_question_bank_question.php?number=<?php echo $rows['question_id']?>', 'window팝업', 'width=700, height=800');"><?php echo $rows['question_id']?></button>
      </td>
      <td width = "80" align = "center"><?php echo $rows['type']?></td>
      <td width = "400" align = "center" style="text-overflow:ellipsis; overflow:hidden">
        <div class="etc">
          <button class="aa" onclick="window.open('view_question_bank_question.php?number=<?php echo $rows['question_id']?>', 'window팝업', 'width=700, height=800');"><?php echo $rows['question']?></button>
        </div>
      </td>
      <td width = "60" align = "center">
        <button><a href="delete_question_bank_question.php?number=<?php echo $rows['question_id']?>">삭제</button>
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
