<?php
  $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");

  $lectureid = $_GET['number'];
  $query = "DELETE FROM lectures WHERE lecture_id = '$lectureid';";
  $result = $connect->query($query);

  if($result){
?>
    <script>
      alert("<?php echo "강의가 삭제되었습니다" ?>");
      history.back();
    </script>
<?php
  }
  else{
    echo "강의 삭제에 실패했습니다";
  }
  mysqli_close($connect);
?>
