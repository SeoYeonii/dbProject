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
      if(name == "") {
        alert("빈칸을 꼭 채워주세요!");
        $("#a").focus()
        return false;
      }
      var name = $.trim($('#b').val());
      var name2 = $.trim($('#bb').val());
      if(name == "" || name2 == "") {
        alert("빈칸을 꼭 채워주세요!");
        if (name=="") {
          $("#b").focus()
        }
        else {
          $("#bb").focus()
        }
        return false;
      }
      var name = $.trim($('#c').val());
      if(name == "") {
        alert("빈칸을 꼭 채워주세요!");
        $("#c").focus()
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
<?php
  $lectureid = $_GET['lectureid'];
  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project') or die ("Database와의 연결이 실패했습니다!! ㅠㅠ");

  $query = "SELECT * FROM bank_keywords WHERE lecture_id = '$lectureid';";
  $result = $connect->query($query);
?>

  <div align='center'>
  <h3>문제은행에서 문항 불러오기</h3><br />

  <table align = "center">
    <thead align = "center">
      <tr>
        <td width = "100" align = "center">키워드</td>
        <td width = "50" align = "center">배점</td>
      </tr>
    </thead>
    <tbody>
<?php
      while($rows = mysqli_fetch_assoc($result)){
?>
        <td width = "100" align = "center"><?php echo $rows['keyword']?></td>
        <td width = "50" align = "center"><?php echo $rows['score_portion']?></td>
      </tr>
<?php
            }
?>
    </tbody>
  </table>
<h3>조건</h3>
  <form method='get' onsubmit="return check()" action='load_from_question_bank_action.php?lectureid=<?php echo $lectureid; ?>'>
    <input style="display:none" name="lectureid" type="text" value="<?php echo $lectureid; ?>">
    <p id="show_1">문항 수: <input id="a" name="question_num" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></p>
    <p id="show_2">평균 난이도: <input id="b" name="from" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"> ~ <input id="bb" name="until" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></p>
    <p id="show_3">키워드: <input id="c" name="keyword" type="text" placeholder="해당 강의에 있는 문제에 존재하는 키워드만 넣어주세요!"></p>
    <input type="submit" value="확인">
  </form>
  </div>
</body>

</html>
