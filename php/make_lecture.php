<!DOCTYPE html>
<html>

<head>
  <meta charset=utf-8>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>
  <link href="../css/basic.css?after" type="text/css" rel=stylesheet>
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js" ></script>
  <script type="text/javascript">
      function check() {
        if($('#n').val().length==0){
          alert("강의명을 입력하세요!");
          $('#n').focus();
          return false;
        }
        else if($('#s').val().length==0){
          alert("시작 시간을 입력하세요!");
          $('#s').focus();
          return false;
        }
        else if($('#e').val().length==0){
          alert("끝나는 시간을 입력하세요!");
          $('#e').focus();
          return false;
        }
        else if($('#s').val() >= $('#e').val()) {
          alert("끝나는 시간은 시작 시간보다 뒤의 시간으로 입력하세요!");
          $('#e').focus();
          return false;
        }
        return true;
      }
  </script>
  <script type="text/javascript">
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

  $query = "SELECT * FROM tmp_keyword;";
  $result = $connect->query($query);
  $total = mysqli_num_rows($result);
  $count = mysqli_num_rows($result);
?>

  <div align='center'>
  <h3>강의 만들기</h3>
  <h4 align=center>키워드</h4>

  <table align = "center">
    <thead align = "center">
      <tr>
        <td width = "100" align = "center">키워드</td>
        <td width = "50" align = "center">중요도</td>
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
  <form method='get' action='make_lecture_keyword_action.php'>
    <p>키워드: <input id="k" name="keyword" type="text"></p>
    <p>중요도: <input id="w" name="weight" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></p>
    <input type="submit" value="확인" onclick="makeTag()">
  </form>
  <br />
  <form method='get' onsubmit="return check()" action='make_lecture_action.php'>
    <p>강의 이름: <input id="n" name="name" type="text"></p>
    <p>시작 시간: <input id="s" name="start" type="datetime-local"></p>
    <p>종료 시간: <input id="e" name="end" type="datetime-local"></p>
    <br />
    <input type="submit" value="확인">
  </form>

  </div>

</body>

</html>
