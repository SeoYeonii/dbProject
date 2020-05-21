<?php
  require_once("db_info.php");

  session_start();

  $keyword=$_GET['keyword'];
  $weight=$_GET['weight'];

  // keyword 10개 넘으면 안되게
  $q0 = "SELECT * FROM tmp_keyword;";
  $r0 = $connect->query($q0);
  if (mysqli_num_rows($r0)==4) {
?>
    <script>
      alert("문항 하나에 지정할 수 있는 키워드는 최대 4개 입니다!");
      history.back();
    </script>
<?php
  }
  else {
    // keyword 있는지 검사
    $query = "SELECT * FROM tmp_keyword WHERE keyword = '$keyword'";
    $result = $connect->query($query);

    // 이미 존재하는 키워드이면 삽입 불가
    if(mysqli_num_rows($result)!=0) {
  ?>
      <script>
        alert("이미 존재하는 키워드입니다.");
        history.back();
      </script>
  <?php
    }
    else {
      $query = "INSERT INTO tmp_keyword VALUES ('$keyword', '$weight', null)";
      $result = $connect->query($query);
      if($result) {
  ?>
    <script>
    alert("<?php echo "키워드가 생성되었습니다."?>");
    history.back();
    </script>
  <?php
      }
      else {
        echo "키워드 생성에 실패했습니다";
        history.back();
      }
    }
    mysqli_close($connect);
  }
  ?>
