<!DOCTYPE html>
<html>

<head>
  <meta charset=utf-8>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <link href=https://use.fontawesome.com/releases/v5.0.7/css/all.css rel=stylesheet>

  <script type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js" ></script>
  <script type="text/javascript">
      function check() {
        if($('#n').val().length==0){
          alert("과목명을 입력하세요!");
          $('#n').focus();
          return false;
        }
        else if($('#m').val().length==0){
          alert("정원을 입력하세요!");
          $('#m').focus();
          return false;
        }
        return true;
      }
  </script>
</head>
<?php
  $masterid = $_GET['masterid'];
 ?>
<body>
  <div align='center'>
  <h3>과목 만들기</h3>

  <form method='get' onsubmit="return check()" action='make_class_action.php'>
    <input style="display:none" name="masterid" value="<?php echo $masterid ?>">
    <p>과목 이름: <input id="n" name="name" type="text"></p>
    <p>정원: <input id="m" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="capacity"></p>
    <input type="submit" value="확인">
  </form>

  </div>

</body>

</html>
