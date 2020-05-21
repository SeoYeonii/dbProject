<?php
  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project') or die ("Database와의 연결이 실패했습니다!! ㅠㅠ");
  $arrVar1 = $_GET['data'];
  $setnum = $_GET['set_num'];
  $x2 = unserialize(urldecode($arrVar1));
  $res = $x2[$setnum];

  $q0 = "SELECT * FROM questions;";
  $r0 = mysqli_query($connect, $q0);
  while ($row0 = mysqli_fetch_assoc($r0)) {
    $a = $row0['question_id'];
    $q1 = "DELETE FROM questions WHERE question_id = $a;";
    $r1 = mysqli_query($connect, $q1);
  }
  mysqli_close($connect);
  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project') or die ("Database와의 연결이 실패했습니다!! ㅠㅠ");

  for ($i=0; $i < count($res); $i++) {
    $id = $res[$i];

    $q2 = "SELECT * FROM questions_bank WHERE question_id = $id;";
    $r2 = mysqli_query($connect, $q2);
    $row = mysqli_fetch_assoc($r2);
    $a = $row['question_id'];
    $b = $row['type'];
    $c = "'".$row['question']."'";
    $d = $row['answer'];
    $e = $row['difficulty'];
    $f = $row['real_difficulty'];
    $g = $row['lecture_id'];

    if ($d == null && $f == null) {
      $q3 = "INSERT INTO questions VALUES($a, $b, $c, null, $e, null, $g);";
    } else if($d==null && $f != null) {
      $q3 = "INSERT INTO questions VALUES($a, $b, $c, null, $e, $f, $g);";
    } else if($d!=null && $f==null) {
      $q3 = "INSERT INTO questions VALUES($a, $b, $c, $d, $e, null, $g);";
    } else if($d!=null && $f!=null) {
      $q3 = "INSERT INTO questions VALUES($a, $b, $c, $d, $e, $f, $g);";
    }
    $r3 = mysqli_query($connect, $q3);

    // 키워드
    $q4 = "SELECT * FROM bank_keywords WHERE question_id = $a;";
    $r4 = mysqli_query($connect, $q4);
    while ($row4 = mysqli_fetch_assoc($r4)) {
      $aa = $row4['question_id'];
      $bb = $row4['keyword'];
      $cc = $row4['lecture_id'];
      $dd = $row4['score_portion'];
      $q5 = "INSERT INTO question_keywords VALUES($aa, $bb, $cc, $dd);";
      $r5 = mysqli_query($connect, $q5);
    }

    // 보기
    if ($b==1) {
      $q6 = "SELECT * FROM bank_bogies WHERE question_id = $a;";
      $r6 = mysqli_query($connect, $q6);
      $row6 = mysqli_fetch_assoc($r6);
      $aaa = $row6['question_id'];
      $bbb = $row6['bogi_1'];
      $ccc = $row6['bogi_2'];
      $ddd = $row6['bogi_3'];
      $eee = $row6['bogi_4'];
      $fff = $row6['bogi_5'];
      $q7 = "INSERT INTO bogies VALUES($aaa, $bbb, $ccc, $ddd, $eee, $fff);";
      $r7 = mysqli_query($connect, $q7);
    }
    if ($r3) {
?>
<script>
  alert("성공적으로 문제은행에서 불러왔습니다!");
  opener.parent.location.reload();
  window.close();
</script>
<?php
    }
    else {
?>
      <script>
        alert("문제은행에서 불러오는데 실패했습니다!");
        //window.close();
      </script>
<?php
    }
  }
  mysqli_close($connect);
?>
