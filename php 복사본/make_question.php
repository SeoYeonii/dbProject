<!DOCTYPE html>
<html>

<head>
  <meta charset=utf-8>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
  <link href="../css/basic.css?after" type="text/css" rel=stylesheet>

  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js" ></script>

  <script type="text/javascript">

    $(document).ready(function() {

      $('#bogies').hide();

      $("#t0").click(function() {
          //3000 : 3초, 'slow', 'normal', 'fast'
          $("#bogies").hide('fast');
          $("#ans").show('fast');
      });
      $("#t1").click(function() {
          $("#bogies").show('fast');
          $("#ans").show('fast');
      });
      $("#t2").click(function() {
          //3000 : 3초, 'slow', 'normal', 'fast'
          $("#bogies").hide('fast');
          $("#ans").hide('fast');
      });
    });s
</script>
<script>
  function check() {

    var q = $.trim($('#q').val());
    var a = $.trim($('#a').val());
    var d = $.trim($('#d').val());

    var b1 = $.trim($('#b1').val());
    var b2 = $.trim($('#b2').val());
    var b3 = $.trim($('#b3').val());
    var b4 = $.trim($('#b4').val());
    var b5 = $.trim($('#b5').val());

    if ($("#t0").is(":checked")) {

      if(q == "") {
        alert("문항을 꼭 채워주세요!");
        $("#q").focus()
        return false;
      } else if(a == "") {
        alert("답을 꼭 채워주세요!");
        $("#a").focus()
        return false;
      } else if(d == "") {
        alert("난이도를 꼭 채워주세요!");
        $("#d").focus()
        return false;
      }
    }
    else if ($("#t1").is(":checked")) {

      if(q == "") {
        alert("문항을 꼭 채워주세요!");
        $("#q").focus()
        return false;
      } else if(a == "") {
        alert("답을 꼭 채워주세요!");
        $("#a").focus()
        return false;
      } else if(d == "") {
        alert("난이도를 꼭 채워주세요!");
        $("#d").focus()
        return false;
      } else if(b1 == "") {
        alert("보기를 꼭 채워주세요!");
        $("#b1").focus()
        return false;
      } else if(b2 == "") {
        alert("보기를 꼭 채워주세요!");
        $("#b2").focus()
        return false;
      } else if(b3 == "") {
        alert("보기를 꼭 채워주세요!");
        $("#b3").focus()
        return false;
      } else if(b4 == "") {
        alert("보기를 꼭 채워주세요!");
        $("#b4").focus()
        return false;
      } else if(b5 == "") {
        alert("보기를 꼭 채워주세요!");
        $("#b5").focus()
        return false;
      }
    }
    else if ($("#t2").is(":checked")) {
      if(q == "") {
        alert("문항을 꼭 채워주세요!");
        $("#q").focus()
        return false;
      } else if(d == "") {
        alert("난이도를 꼭 채워주세요!");
        $("#d").focus()
        return false;
      }
    }
    return true;
  }
</script>
<script>
  function makeTag()
  {
   var keyword = document.getElementById("k");
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

  $connect = mysqli_connect('localhost', 'SeoYeonii', 'tjdusl12@', 'team_project') or die ("Database와의 연결이 실패했습니다!! ㅠㅠ");
  $lectureid = $_GET['number'];
  $query = "SELECT * FROM tmp_keyword;";
  $result = $connect->query($query);
  $total = mysqli_num_rows($result);
  $count = mysqli_num_rows($result);
?>

  <div align='center'>
  <h3>문항 만들기</h3>
  <h4 align=center>키워드</h4>
  <table align = "center">
    <thead align = "center">
      <tr>
        <td width = "100" align = "center">키워드</td>
        <td width = "50" align = "center">배점</td>
        <td width = "50" align = "center"></td>
      </tr>
    </thead>
    <tbody>
<?php

      while($rows = mysqli_fetch_assoc($result)){
?>
        <td width = "100" align = "center"><?php echo $rows['keyword']?></td>
        <td width = "50" align = "center"><?php echo $rows['weight']?></td>
        <td width = "50" align = "center">
          <button><a href="delete_keyword_action.php?number=<?php echo $rows['id']?>">삭제</button>
        </td>
      </tr>
<?php
            $total--;
            }
?>
    </tbody>
  </table>
  <br />
  <br />

  <form method='get' action='make_question_keyword_action.php?number=<?php echo $lectureid ?>;'>
    <p>키워드: <input id="k" name="keyword" type="text"></p>
    <p>배점: <input id="w" name="weight" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></p>
    <input type="submit" value="확인" onclick="makeTag()">
  </form>
  <br />
  <form method='get' onsubmit="return check()" action='make_question_action.php'>
    <input name='lectureid' style="display:none;" value="<?php echo $lectureid ?>">
    <input id="t0" type="radio" name="type" value="0" checked="checked"> 단답형
    <input id="t1" type="radio" name="type" value="1"> 객관식
    <input id="t2" type="radio" name="type" value="2"> 단답형(파라미터)
    <p>문제: <input id="q" name="question" type="text"></p>
    <span id="bogies">
      <p>보기1: <input id="b1" name="bogi1" type="text"></p>
      <p>보기2: <input id="b2" name="bogi2" type="text"></p>
      <p>보기3: <input id="b3" name="bogi3" type="text"></p>
      <p>보기4: <input id="b4" name="bogi4" type="text"></p>
      <p>보기5: <input id="b5" name="bogi5" type="text"></p>
    </span>
    <p id="ans">정답: <input id="a" name="answer" type="text"></p>
    <p>난이도: <input id="d" name="difficulty" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></p>
    <input type="submit" value="확인">
  </form> <br />
  </div>

</body>

</html>
