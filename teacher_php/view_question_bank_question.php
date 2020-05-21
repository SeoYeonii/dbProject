<!DOCTYPE html>
<html>

<head>
  <meta charset = 'utf-8'>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <title>Preswot</title>
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
  <link href="../css/basic.css?after" type="text/css" rel=stylesheet>
  <link href="../css/header.css?after" type="text/css" rel=stylesheet>
  <link href="../css/view.css?after" type="text/css" rel=stylesheet>
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js" ></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".bogi").hide();
      var t = $('#type').val();
      if (t==1) {
        $(".bogi").show('fast');
      }
    });
  </script>
</head>

<body>
<?php
  $masterid = $_GET['masterid'];
  session_start();
  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project');
  $question_id = $_GET['number'];

  $q0 = "SELECT * FROM questions_bank WHERE question_id = '$question_id';";
  $r0 = mysqli_query($connect, $q0);
  $rows = mysqli_fetch_assoc($r0);
  $lectureid = $rows['lecture_id'];

  $q1 = "SELECT * FROM bank_bogies WHERE question_id = '$question_id';";
  $r1 = $connect->query($q1);
  $boggies = mysqli_fetch_assoc($r1);

  $q2 = "SELECT * FROM bank_keywords WHERE question_id = '$question_id';";
  $r2 = mysqli_query($connect, $q2);
?>

<input id='type' style="display:none" value="<?php echo $rows['type']?>"></p>

<table class="view_table" align=center>
<tr>
    <td colspan="4" class="view_title">
      <?php echo $rows['question_id'] ?>
    </td>
</tr>
<tr>
    <td class="view_l">문항 id</td>
    <td class="view_l2"><?php echo $rows['question_id']?></td>
    <td class="view_r">타입</td>
    <td class="view_r2"><?php echo $rows['type']?></td>
</tr>
<tr>
    <td colspan="4" class="view_content" valign="top">
    <?php echo $rows['question']?></td>
</tr>
<tr>
  <td class="view_l">정답</td>
  <td colspan="4" class="view_answer" valign="top">
    <?php echo $rows['answer']?></td>
</tr>
<tr class="bogi">
  <td class="view_l">보기1</td>
  <td colspan="4" class="view_l3"><?php echo $boggies['bogi_1']?></td>
</tr>
<tr class="bogi">
  <td class="view_l">보기2</td>
  <td colspan="4" class="view_l3"><?php echo $boggies['bogi_2']?></td>
</tr>
<tr class="bogi">
  <td class="view_l">보기3</td>
  <td colspan="4" class="view_l3"><?php echo $boggies['bogi_3']?></td>
</tr>
<tr class="bogi">
  <td class="view_l">보기4</td>
  <td colspan="4" class="view_l3"><?php echo $boggies['bogi_4']?></td>
</tr>
<tr class="bogi">
  <td class="view_l">보기5</td>
  <td colspan="4" class="view_l3"><?php echo $boggies['bogi_5']?></td>
</tr>
<tr>
    <td class="view_l">난이도</td>
    <td class="view_l2"><?php echo $rows['difficulty']?></td>
    <td class="view_r">실제 난이도</td>
    <td class="view_r2"><?php echo $rows['real_difficulty']?></td>
</tr>
</table>
<br />
<table align = "center">
  <thead align = "center">
    <tr>
      <td width = "100" align = "center">키워드</td>
      <td width = "50" align = "center">배점</td>
    </tr>
  </thead>
  <tbody>
    <?php
        while($row2 = mysqli_fetch_assoc($r2)){
    ?>
          <td width = "100" align = "center"><?php echo $row2['keyword']?></td>
          <td width = "50" align = "center"><?php echo $row2['score_portion']?></td>
        </tr>
    <?php
              //$total--;
        }
    ?>
  </tbody>
</table>

  <div class="view_btn">
  <button class="view_btn1" onclick="location.href='./delete_question_bank_question.php?number=<?php echo "$question_id";?>'">삭제</button>
  </div>

</body>
</html>
