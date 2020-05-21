<?php
  $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");

  $classid = $_GET['number'];
  $query = "DELETE FROM classes WHERE class_id = '$classid';";
  $result = $connect->query($query);

  if($result){
?>
    <script>
      alert("<?php echo "과목이 삭제되었습니다" ?>");
      location.replace("./list_prof.php");
    </script>
<?php
  }
  else{
    echo "과목 삭제에 실패했습니다";
  }
  mysqli_close($connect);
?>
