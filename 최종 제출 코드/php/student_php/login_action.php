<?php
	require_once("dbconfig.php");
?>
<?php
  
  session_start();

  //입력 받은 id와 password
  $email=$_GET['email'];
  $pw=$_GET['pw'];

  //아이디가 있는지 검사
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = $db->query($query);

  //아이디가 있다면 비밀번호 검사
  // 이메일 중복 안되었다고 가정
  if(mysqli_num_rows($result)==1) {
    $row=mysqli_fetch_assoc($result);

    //비밀번호가 맞다면
    if($row['password']==$pw){
      // 타입 검사 - 강사이면
      if($row['type']==1){
        //세션 생성
        $query2 = "SELECT user_id
                    FROM users
                    WHERE email='$email'";
        $result2 = $db->query($query2);
        $row2 = mysqli_fetch_assoc($result2);

        $_SESSION['userid']=$row2['user_id'];
        if(isset($_SESSION['userid'])){
?>
        <script>
          alert("강사님 로그인 되었습니다.");
          location.replace("./list_prof.php");
        </script>
<?php
        }
        else{
          echo "session fail";
        }
      }
      // 타입 검사 - 학생이면 
      else if($row['type'] == 0){
          $sql = "select * from users where email='$email'";
          $result = $db->query($sql);
          $user = $result->fetch_assoc();
          $user_id = $user['user_id'];
 ?>
         <script>
          alert("학생이 로그인 되었습니다.");
          location.replace("class.php?user_id=<?=$user_id?>");
         </script>
 <?php       
      }
    }
    else{
?>
      <script>
        alert("비밀번호가 잘못되었습니다.");
        history.back();
      </script>
<?php
    }
  }
  else{
?>
  <script>
    alert("존재하지 않는 아이디 입니다.");
    history.back();
  </script>
<?php
  }
?>
