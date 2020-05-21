<?php
  $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");

  $id = $_GET['number'];
  $query = "DELETE FROM tmp_keyword WHERE id = '$id';";
  $result = $connect->query($query);

  if($result){
?>
    <script>
      history.back();
    </script>
<?php
  }
  else{
    echo "키워드 삭제에 실패했습니다";
  }
  mysqli_close($connect);
?>
