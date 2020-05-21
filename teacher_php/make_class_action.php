<?php
  require_once("db_info.php");
  session_start();

  //입력 받은 name과 capacity
  $name=$_GET['name'];
  $capacity=$_GET['capacity'];
  $masterid = $_GET['masterid'];
  echo "$name";
  echo "$capacity";
  echo "$masterid";

  $query = "INSERT INTO classes VALUES (null, '$name', '$capacity', '$masterid')";
  $result = $connect->query($query);
  if($result) {
?>
  <script>
    alert("<?php echo "과목이 생성되었습니다."?>");
    opener.parent.location.reload();
    window.close();
  </script>
<?php
  }
  else {
?>
    <script>
      alert("과목 생성에 실패했습니다");
      //history.back();
    </script>
<?php
  }
  mysqli_close($connect);
?>
