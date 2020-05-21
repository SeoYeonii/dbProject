<!DOCTYPE html>
<html>

<head>
  <meta charset=utf-8>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
  <link href="../css/basic.css?after" type="text/css" rel=stylesheet>
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js" ></script>
  <script>
    function check()
    {
      var name = $.trim($('#a').val());
      var max = $.trim($('#ch').val());
      if(name == "") {
        alert("빈칸을 꼭 채워주세요!");
        $("#a").focus()
        return false;
      }
      if (name>max) {
        alert("유효한 세트 번호를 넣어주세요!");
        $("#a").focus()
        return false;
      }
      alert("확인 누르시면 현재 문항은 모두 사라지고 선택한 세트로 대체됩니다");
      return true;
    }
  </script>
</head>
<?php
  require_once("db_info.php");
  $lectureid = $_GET['lectureid'];
  $questionnum = $_GET['question_num'];
  $from = $_GET['from'];
  $until = $_GET['until'];
  $keyword0 = $_GET['keyword'];

  $keywords = explode(', ', $keyword0);
  $k_num = count($keywords);

// 존재하는 키워드인지 확인
    $flag = -1;
    $keyword_valid = array();

    for ($i=0; $i < $k_num ; $i++) {
      $k = $keywords[$i];

      $q_0 = "SELECT * FROM bank_keywords WHERE keyword = '$k' AND lecture_id = '$lectureid';";
      $r_0 = mysqli_query($connect, $q_0);
      if (mysqli_num_rows($r_0)>0) {
        $flag = 1;
        array_push($keyword_valid, $k);
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
      $kv_num = count($keyword_valid);

      $q_ids = array();
      for ($i=0; $i < $kv_num; $i++) {
        $ks = $keyword_valid[$i];

        $q_00 = "SELECT question_id FROM bank_keywords WHERE keyword = '$ks' AND lecture_id = '$lectureid';";
        $r_00 = mysqli_query($connect, $q_00);
        $row_00 = mysqli_fetch_assoc($r_00);
        array_push($q_ids, $row_00['question_id']);
      }
    }

    $qid_arr = ("(" . implode(', ',array_values($q_ids)). ")");

    $q_1 = "SELECT * FROM questions_bank WHERE lecture_id = '$lectureid' AND difficulty BETWEEN $from AND $until AND question_id IN $qid_arr;";
    $r_1 = mysqli_query($connect, $q_1);

    $query_result_array = array();
    while ($row_1=mysqli_fetch_assoc($r_1)) {
      array_push($query_result_array, $row_1['question_id']);
    }

    $final = array_chunk($query_result_array, $questionnum);
?>
<body>
  <div align='center'>
  <h3>불러온 결과</h3><br />

  <table align = "center">
    <thead align = "center">
      <tr>
        <td width = "50" align = "center"> 세트 번호</td>
        <td width = "50" align = "center">문항 id</td>
        <td width = "100" align = "center">문항</td>
        <td width = "50" align = "center">난이도</td>
      </tr>
    </thead>
    <tbody>
<?php
      $max = -1;
       $x1 = urlencode(serialize($final));
      for ($i=0; $i < count($final); $i++) {
        $tmp =$final[$i];
        if (count($tmp)==$questionnum) {
          $max++;
          for ($j=0; $j < $questionnum; $j++) {
            ?>
            <td width = "50" align = "center"><?php echo $i ?></td>
            <td width = "50" align = "center"><?php echo $tmp[$j]?></td>
            <?php
              $aaa = $tmp[$j];
              $qq = "SELECT * FROM questions_bank WHERE question_id = $aaa;";
              $rr = mysqli_query($connect, $qq);
              $row = mysqli_fetch_assoc($rr);
             ?>
            <td width = "100" align = "center"><?php echo $row['question']?></td>
            <td width = "50" align = "center"><?php echo $row['difficulty']?></td>
            </tr>
            <?php
          }
        }
      }
?>
    </tbody>
  </table>
  <h3>세트 골라주세요</h3>
  <form method='get' onsubmit="return check()" action='load_from_question_bank_2.php'>
    <input style="display:none" id="ch" type="text" value="<?php echo $max; ?>">
    <input type='hidden' name ='data' value="<?=$x1?>">
    <p>세트 번호: <input id="a" name="set_num" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></p>
    <input type="submit" value="확인">
  </form>
</body>
