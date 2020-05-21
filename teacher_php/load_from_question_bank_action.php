<?php
  $lectureid = $_GET['lectureid'];
  $questionnum = $_GET['question_num'];
  $from = $_GET['from'];
  $until = $_GET['until'];
  $keyword0 = $_GET['keyword'];

  $keywords = explode(', ', $keyword0);
  $k_num = count($keywords);

  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project') or die ("Database와의 연결이 실패했습니다!! ㅠㅠ");

  // 문제가 이미 존재하면 빼고 생각
  $q_0 = "SELECT * FROM questions WHERE lecture_id = '$lectureid';";
  $r_0 = mysqli_query($connect, $q_0);
  $qis = array();
  while ($row_0 = mysqli_fetch_assoc($r_0)) {
    array_push($qis, $row_0['question_id']);
  }
  if (count($qis)==0) {
    array_push($qis, -1);
  }
  $qi_arr = ("(" . implode(', ',array_values($qis)). ")");

  // 만약 문제 개수만 주어진다면,
  if ($questionnum!=null && $from==null && $until==null && $keyword0==null) {

    $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND question_id NOT IN $qi_arr LIMIT $questionnum;";
  }
  // 평균 난이도만 (둘 중에 하나라도)주어진다면
  else if($questionnum==null && ($from!=null || $until!=null) && $keyword0==null) {
    if ($from != null && $until == null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty >= '$from' AND question_id NOT IN $qi_arr;";
    } else if($from == null && $until != null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty <= '$until' AND question_id NOT IN $qi_arr;";
    } else if($from != null && $until != null){
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND question_id NOT IN $qi_arr AND difficulty BETWEEN $from AND $until;";
    }
  }
  // 키워드만 주어진다면
  else if($questionnum==null && $from==null && $until==null && $keyword0 != null) {
    // 존재하는 키워드인지 확인
    $flag = -1;
    $kkk = array();

    for ($i=0; $i < $k_num ; $i++) {
      $k = $keywords[$i];

      $q_0 = "SELECT * FROM bank_keywords WHERE keyword = '$k' AND lecture_id = '$lectureid';";
      $r_0 = mysqli_query($connect, $q_0);
      if (mysqli_num_rows($r_0)>0) {
        $flag = 1;
        array_push($kkk, $k);
      }
    }

    if ($flag == -1) {
?>
      <script>
        alert("해당 강의에 있는 문제에 존재하는 키워드를 하나 이상 써주세요.");
        history.back();
      </script>
<?php
    }
    else {
      $kkk_num = count($kkk);

      $q_ids = array();
      for ($i=0; $i < $kkk_num; $i++) {
        $ks = $kkk[$i];

        $q_00 = "SELECT question_id FROM bank_keywords WHERE keyword = '$ks' AND lecture_id = '$lectureid';";
        $r_00 = mysqli_query($connect, $q_00);
        $row_00 = mysqli_fetch_assoc($r_00);
        array_push($q_ids, $row_00['question_id']);
      }
    }

    $qid_arr = ("(" . implode(', ',array_values($q_ids)). ")");
    $q_1 = "SELECT * FROM questions_bank WHERE question_id IN $qid_arr AND question_id NOT IN $qi_arr;";
  }
  // 문항수와 평균 난이도 만 주어진 경우
  else if($questionnum!=null && ($from!=null || $until!=null) && $keyword0 == null) {
    if ($from != null && $until == null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty >= '$from' AND question_id NOT IN $qi_arr LIMIT $questionnum;";
    } else if($from == null && $until != null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty <= '$until' AND question_id NOT IN $qi_arr LIMIT $questionnum;";
    } else if($from != null && $until != null){
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND question_id NOT IN $qi_arr AND difficulty BETWEEN $from AND $until LIMIT $questionnum;";
    }
  }
  // 문항수와 키워드만 주어진 경우
  else if($questionnum!=null && $from==null && $until==null && $keyword0 != null) {
    // 존재하는 키워드인지 확인
    $flag = -1;
    $kkk = array();

    for ($i=0; $i < $k_num ; $i++) {
      $k = $keywords[$i];

      $q_0 = "SELECT * FROM bank_keywords WHERE keyword = '$k' AND lecture_id = '$lectureid';";
      $r_0 = mysqli_query($connect, $q_0);
      if (mysqli_num_rows($r_0)>0) {
        $flag = 1;
        array_push($kkk, $k);
      }
    }

    if ($flag == -1) {
?>
      <script>
        alert("해당 강의에 있는 문제에 존재하는 키워드를 하나 이상 써주세요.");
        history.back();
      </script>
<?php
    }
    else {
      $kkk_num = count($kkk);

      $q_ids = array();
      for ($i=0; $i < $kkk_num; $i++) {
        $ks = $kkk[$i];

        $q_00 = "SELECT question_id FROM bank_keywords WHERE keyword = '$ks' AND lecture_id = '$lectureid';";
        $r_00 = mysqli_query($connect, $q_00);
        $row_00 = mysqli_fetch_assoc($r_00);
        array_push($q_ids, $row_00['question_id']);
      }
    }

    $qid_arr = ("(" . implode(', ',array_values($q_ids)). ")");
    $q_1 = "SELECT * FROM questions_bank WHERE question_id IN $qid_arr AND question_id NOT IN $qi_arr LIMIT $questionnum;";
  }
  // 평균 난이도와 키워드만 주어진 경우
  else if($questionnum!=null && ($from!=null || $until!=null) && $keyword0 != null) {
    // 존재하는 키워드인지 확인
    $flag = -1;
    $kkk = array();

    for ($i=0; $i < $k_num ; $i++) {
      $k = $keywords[$i];

      $q_0 = "SELECT * FROM bank_keywords WHERE keyword = '$k' AND lecture_id = '$lectureid';";
      $r_0 = mysqli_query($connect, $q_0);
      if (mysqli_num_rows($r_0)>0) {
        $flag = 1;
        array_push($kkk, $k);
      }
    }

    if ($flag == -1) {
?>
      <script>
        alert("해당 강의에 있는 문제에 존재하는 키워드를 하나 이상 써주세요.");
        history.back();
      </script>
<?php
    }
    else {
      $kkk_num = count($kkk);

      $q_ids = array();
      for ($i=0; $i < $kkk_num; $i++) {
        $ks = $kkk[$i];

        $q_00 = "SELECT question_id FROM bank_keywords WHERE keyword = '$ks' AND lecture_id = '$lectureid';";
        $r_00 = mysqli_query($connect, $q_00);
        $row_00 = mysqli_fetch_assoc($r_00);
        array_push($q_ids, $row_00['question_id']);
      }
    }

    $qid_arr = ("(" . implode(', ',array_values($q_ids)). ")");

    if ($from != null && $until == null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty >= '$from' AND question_id NOT IN $qi_arr AND question_id IN $qid_arr;";
    } else if($from == null && $until != null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty <= '$until' AND question_id NOT IN $qi_arr AND question_id IN $qid_arr;";
    } else if($from != null && $until != null){
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND question_id NOT IN $qi_arr AND difficulty BETWEEN $from AND $until AND question_id IN $qid_arr;";
    }
  }
  // 문항수 평균 난이도 키워드 다 주어진 경우
  else {
    // 존재하는 키워드인지 확인
    $flag = -1;
    $kkk = array();

    for ($i=0; $i < $k_num ; $i++) {
      $k = $keywords[$i];

      $q_0 = "SELECT * FROM bank_keywords WHERE keyword = '$k' AND lecture_id = '$lectureid';";
      $r_0 = mysqli_query($connect, $q_0);
      if (mysqli_num_rows($r_0)>0) {
        $flag = 1;
        array_push($kkk, $k);
      }
    }

    if ($flag == -1) {
?>
      <script>
        alert("해당 강의에 있는 문제에 존재하는 키워드를 하나 이상 써주세요.");
        history.back();
      </script>
<?php
    }
    else {
      $kkk_num = count($kkk);

      $q_ids = array();
      for ($i=0; $i < $kkk_num; $i++) {
        $ks = $kkk[$i];

        $q_00 = "SELECT question_id FROM bank_keywords WHERE keyword = '$ks' AND lecture_id = '$lectureid';";
        $r_00 = mysqli_query($connect, $q_00);
        $row_00 = mysqli_fetch_assoc($r_00);
        array_push($q_ids, $row_00['question_id']);
      }
    }

    $qid_arr = ("(" . implode(', ',array_values($q_ids)). ")");

    if ($from != null && $until == null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty >= '$from' AND question_id NOT IN $qi_arr AND question_id IN $qid_arr LIMIT $questionnum;";
    } else if($from == null && $until != null) {
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty <= '$until' AND question_id NOT IN $qi_arr AND question_id IN $qid_arr LIMIT $questionnum;";
    } else if($from != null && $until != null){
      $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND question_id NOT IN $qi_arr AND difficulty BETWEEN $from AND $until AND question_id IN $qid_arr LIMIT $questionnum;";
    }
  }

  $r_1 = mysqli_query($connect, $q_1);
  while ($row_1 = mysqli_fetch_assoc($r_1)) {
    $questionid = $row_1['question_id'];
    $type = $row_1['type'];
    $question = $row_1['question'];
    $answer = $row_1['answer'];
    $difficulty = $row_1['difficulty'];
    $realdifficulty = $row_1['real_difficulty'];
    if ($realdifficulty==null) {
      $q_2 = "INSERT INTO questions VALUES('$questionid', '$type', '$question', '$answer', '$difficulty', null, '$lectureid');";
    }
    else {
      $q_2 = "INSERT INTO questions VALUES('$questionid', '$type', '$question', '$answer', '$difficulty', null, '$lectureid');";
    }
    $r_2 = mysqli_query($connect, $q_2);

    // 문제 키워드 넣고
    $q_3 = "SELECT * FROM bank_keywords WHERE question_id = '$questionid';";
    $r_3 = mysqli_query($connect, $q_3);
    while ($row_3 = mysqli_fetch_assoc($r_3)) {
      $keyword3 = $row_3['keyword'];
      $scoreportion3 = $row_3['score_portion'];
      $q_4 = "INSERT INTO question_keywords VALUES('$questionid', '$keyword3', '$lectureid', '$scoreportion3');";
      $r_4 = mysqli_query($connect, $q_4);
    }
    // 보기 넣어야 되면 보기 넣기
    if ($type == 1) {
      $q_5 = "SELECT * FROM bank_bogies WHERE question_id = '$questionid';";
      $r_5 = mysqli_query($connect, $q_5);
      $row_5 = mysqli_fetch_assoc($r_5);
      $bogi1 = $row_5['bogi_1'];
      $bogi2 = $row_5['bogi_2'];
      $bogi3 = $row_5['bogi_3'];
      $bogi4 = $row_5['bogi_4'];
      $bogi5 = $row_5['bogi_5'];

      $q_6 = "INSERT INTO bogies VALUES('$questionid', '$bogi1', '$bogi2', '$bogi3', '$bogi4', '$bogi5');";
      $r_6 = mysqli_query($connect, $q_6);
    }
  }
  if ($r_6) {
?>
    <script>
      opener.parent.location.reload();
      window.close();
    </script>
<?php
} else {
?>
    <script>
      opener.parent.location.reload();
      window.close();
    </script>
<?php
}
  ?>
