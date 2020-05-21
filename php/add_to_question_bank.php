<?php
  $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");
  session_start();
  $masterid = $_GET['masterid'];
  $questionid = $_GET['questionid'];
  $type = $_GET['type'];
  $question = $_GET['question'];
  $answer = $_GET['answer'];
  $difficulty = $_GET['difficulty'];
  $realdifficulty = $_GET['realdifficulty'];
  $bogi1 = $_GET['bogi1'];
  $bogi2 = $_GET['bogi2'];
  $bogi3 = $_GET['bogi3'];
  $bogi4 = $_GET['bogi4'];
  $bogi5 = $_GET['bogi5'];
  $lectureid = $_GET['lectureid'];

  // 키워드 가져오기
  $q0 = "SELECT * FROM question_keywords WHERE question_id = '$questionid';";
  $r0 = $connect->query($q0);

  if ($realdifficulty==null) {
    $q1= "INSERT INTO questions_bank VALUES ('$questionid', '$type', '$question', '$answer', '$difficulty', null, '$lectureid', '$masterid');";
  }
  else {
    $q1= "INSERT INTO questions_bank VALUES ('$questionid', '$type', '$question', '$answer', '$difficulty', '$realdifficulty', '$lectureid', '$masterid');";
  }
  $r1 = $connect->query($q1);
  if($r1) {

    // 키워드 넣기
    while ($row0 = mysqli_fetch_assoc($r0)) {
      $k = $row0["keyword"];
      $s = $row0["score_portion"];
      $q2 = "INSERT INTO bank_keywords VALUES('$questionid', '$k', '$lectureid', '$s');";
      $res2 = mysqli_query($connect, $q2);
    }

    // 객관식이면 보기 테이블에 넣어놓기
    if ($type==1) {
      $q3 = "INSERT INTO bank_bogies VALUES('$questionid', '$bogi1', '$bogi2', '$bogi3', '$bogi4', '$bogi5');";
      $r3 = mysqli_query($connect, $q3);
    }
?>
    <script>
      alert("<?php echo "문제은행에 저장되었습니다."?>");
      opener.parent.location.reload();
      window.close();
    </script>
<?php
  }
  else {
?>
    <script>
      alert("문제은행 저장에 실패했습니다. 이미 저장되어 있을 수 있습니다.");
      history.back();
    </script>
<?php
  }

?>
