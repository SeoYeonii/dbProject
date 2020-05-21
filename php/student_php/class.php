<?php
	require_once("dbconfig.php");
         $user_id=$_GET['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>수강신청</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<script>
    function popup(capacity, num, class_id){
        var capacity = capacity;
        var num = num;
        var class_id;
        if (capacity > num) {
            alert("수강신청이 완료되었습니다.");
            var but = document.getElementById("btn");
            but.value = "수강중";
            var url = "apply_action.php?user_id=<?=$user_id?>&class_id=" + class_id;
            location.replace(url);
        }
        else  {
            alert("정원이 이미 가득 찼습니다.");
        }
    }
</script>
<body>
	<article class="boardArticle">
		<h3>수강신청</h3>
		<table>

			<thead>
				<tr>
					<th scope="col" class="no">번호</th>
					<th scope="col" class="title">과목</th>
					<th scope="col" class="master">강사</th>
                                            <th scope="col" class="apply">신청</th>
				</tr>
			</thead>
			<tbody>
					<?php
                                                $sql = 'select * from classes';
                                                $result = $db->query($sql);
                                                while($row = $result->fetch_assoc())
                                                {
					?>
				<tr>
					<td class="no"><?php echo $row['class_id']?></td>
                                            <?php
                                                $user_class_sql = "select * from user_classes where user_id = '$user_id' AND class_id =".$row['class_id'];
                                                $us_check = $db->query($user_class_sql);
                                                if(mysqli_num_rows($us_check) == 0){
                                            ?>
                                                    <td class="title"><?php echo $row['name']?></td>
                                            <?php
                                                }
                                                else{
                                            ?>

                                                    <td class="title" style=cursor:pointer; onClick="document.location.href='lecture.php?class_id=<?=$row['class_id']?>&user_id=<?=$user_id?>'"><?php echo $row['name']?></td>
                                            <?php
                                                }
                                                $esql = 'select * from users where user_id ='.$row['master_id'];
                                                $re = $db->query($esql);
                                                $master_id = $re->fetch_assoc();
                                            ?>
                                            <td class="master" align="center"><?php echo $master_id['email']?></td>
                                                <?php
                                                    $num_sql = "select * from user_classes where role ='student' and class_id =".$row['class_id'];
                                                    $num_result = $db->query($num_sql);
                                                    $num = mysqli_num_rows($num_result);

                                                    if(mysqli_num_rows($us_check) == 0) { //결과 값이 없으면 수강신청 버튼 출력
                                                ?>
                                            <td class="apply" width="40" align="center" colspan="2">
                                                <input id="btn" type="button" onclick="popup('<?=$row['capacity']?>', '<?=$num?>', <?=$row['class_id']?>);" value="수강신청"><br>
                                            </td>
                                                <?php
                                                    }
                                                    else{
                                                ?>
                                            <td class="apply" width="40" align="center" colspan="2">
                                                <input type="button" value="수강중"><br>
                                            </td>
                                                <?php
                                                    }
                                                    $us_check->free();
                                                ?>
				</tr>
					<?php
                                                }
					?>
			</tbody>
		</table>
	</article>
</body>
</html>
