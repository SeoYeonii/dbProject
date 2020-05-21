<?php
  $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");
  session_start();
  $type = $_GET['type'];
  $lectureid = $_GET['lectureid'];
  $question = $_GET['question'];
  $bogi1 = $_GET['bogi1'];
  $bogi2 = $_GET['bogi2'];
  $bogi3 = $_GET['bogi3'];
  $bogi4 = $_GET['bogi4'];
  $bogi5 = $_GET['bogi5'];
  $answer = $_GET['answer'];
  $difficulty = $_GET['difficulty'];

  // keyword가 있는지 검사
  $q1 = "SELECT * FROM tmp_keyword;";
  $r1 = mysqli_query($connect, $q1);

  // question type과 question 검사
  $q2 = "SELECT * FROM questions WHERE question = '$question' AND lecture_id = '$lectureid' AND type = '$type';";
  $r2 = $connect->query($q2);

  // 키워드가 없으면 삽입 불가
  if(mysqli_num_rows($r1)==0){
?>
    <script>
      alert("키워드를 꼭 입력해주세요!");
      history.back();
    </script>
<?php
  }

  // 이미 존재하는 문항이면 삽입 불가
  else if(mysqli_num_rows($r2)!=0) {
?>
    <script>
      alert("같은 문항이 존재합니다.");
      history.back();
    </script>
<?php
  }
  else {
    $query = "INSERT INTO questions VALUES (null, '$type', '$question', '$answer', '$difficulty', null, '$lectureid')";
    $result = $connect->query($query);
    if($result) {
      mysqli_close($connect);
      $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");

      $q0 = "SELECT * FROM questions WHERE question = '$question' AND type = '$type';";
      $r0 = mysqli_query($connect, $q0);
      $row = mysqli_fetch_assoc($r0);
      $questionid = $row["question_id"];

      // 키워드 넣기
      $q100 = "SELECT keyword, weight FROM tmp_keyword";
      $r100 = mysqli_query($connect, $q100);
      while ($row100 = mysqli_fetch_assoc($r100)) {
        $k = $row100["keyword"];
        $w = $row100["weight"];

        $q200 = "INSERT INTO question_keywords VALUES('$questionid', '$k', '$lectureid', '$w');";
        $res200 = $connect->query($q200);
      }

      // tmp_keyword 비우기
      $query3 = "DELETE FROM tmp_keyword;";
      $result3 = mysqli_query($connect, $query3);

      // 객관식이면 보기 테이블에 넣어놓기
      if ($type==1) {
        mysqli_close($connect);
        $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");

        $q4 = "SELECT question_id FROM questions WHERE question='$question' AND type='$type';";
        $r4 = mysqli_query($connect, $q4);
        $row = mysqli_fetch_assoc($r4);
        $questionid = $row['question_id'];

        $q5 = "INSERT INTO bogies VALUES('$questionid', '$bogi1', '$bogi2', '$bogi3', '$bogi4', '$bogi5');";
        $r5 = mysqli_query($connect, $q5);
      }
?>
      <script>
        alert("<?php echo "문항이 생성되었습니다."?>");
        opener.parent.location.reload();
        window.close();
      </script>
<?php
    }
    else {
?>
      <script>
      alert("<?php echo "문항 생성에 실패했습니다"?>");
      history.back();
      </script>
<?php
    }
  }

  mysqli_close($connect);
?>
