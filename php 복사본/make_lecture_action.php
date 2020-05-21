<?php
  require_once("db_info.php");

  session_start();

  //입력 받은 name과 capacity
  $name=$_GET['name'];
  $start=$_GET['start'];
  $end=$_GET['end'];

  $classid = $_SESSION['classid'];

  $_SESSION['classname'] = $name;

  // keyword가 있는지 검사
  $query2 = "SELECT * FROM tmp_keyword;";
  $result2 = mysqli_query($connect, $query2);

  if(mysqli_num_rows($result2)==0){
?>
    <script>
      alert("키워드를 꼭 입력해주세요!");
      history.back();
    </script>
<?php
  }
  else {
    $query = "INSERT INTO lectures VALUES (null, '$name', '$start', '$end', '$classid')";
    $result = $connect->query($query);
    if($result) {
      mysqli_close($connect);
      $connect = mysqli_connect("localhost", "SeoYeonii", "tjdusl12@", "team_project") or die("fail");
      // 방금 만든 lecture이니 가장 id가 큰 것
      $q0 = "SELECT lecture_id FROM lectures WHERE name = '$name' ORDER BY lecture_id DESC;";
      $res0 = mysqli_query($connect, $q0);
      $row = mysqli_fetch_assoc($res0);
      $lectureid = $row["lecture_id"];

      $q1 = "SELECT keyword, weight FROM tmp_keyword";
      $res1 = mysqli_query($connect, $q1);
      while ($row = mysqli_fetch_assoc($res1)) {
        $k = $row["keyword"];
        $w = $row["weight"];

        $q2 = "INSERT INTO lecture_keywords VALUES('$classid', '$lectureid', '$k', '$w');";
        $res2 = $connect->query($q2);
      }

      // tmp_keyword 비우기
      $query3 = "DELETE FROM tmp_keyword;";
      $result3 = mysqli_query($connect, $query3);
?>
      <script>
        alert("<?php echo "강의가 생성되었습니다."?>");
        opener.parent.location.reload();
        window.close();
      </script>
<?php
    }
    else {
?>
      <script>
      alert("<?php echo "강의 생성에 실패했습니다"?>");
      history.back();
      </script>
<?php
    }
  }
  mysqli_close($connect);
?>
