<?php
  $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");

  $questionid = $_GET['number'];
  $query = "DELETE FROM questions WHERE question_id = '$questionid';";
  $result = $connect->query($query);

  if($result){
?>
    <script>
      alert("<?php echo "문항이 삭제되었습니다" ?>");
      history.back();
    </script>
<?php
  }
  else{
    echo "문항 삭제에 실패했습니다";
  }
  mysqli_close($connect);
?>
