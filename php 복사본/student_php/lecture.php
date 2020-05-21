<?php
        require_once("dbconfig.php");
        $user_id=$_GET['user_id'];
        $class_id = $_GET['class_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>강의목록</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<script>
    
    function open_popup(lecture_id, start_time, end_time){
        
        var time_check = 0; //0이면 시간내 X
        var lecture_id = lecture_id;
  
        //시작 날자, 끝날짜 
        var start_Date = new Date(parseInt(start_time.substring(0,4), 10),
                                  parseInt(start_time.substring(5,7), 10)-1,
                                  parseInt(start_time.substring(8,10), 10),
                                  parseInt(start_time.substring(11,13), 10),
                                  parseInt(start_time.substring(14,16), 10),
                                  parseInt(start_time.substring(17,19), 10)
                                  );
                          
        var end_Date = new Date(parseInt(end_time.substring(0,4), 10),
                                  parseInt(end_time.substring(5,7), 10)-1,
                                  parseInt(end_time.substring(8,10), 10),
                                  parseInt(end_time.substring(11,13), 10),
                                  parseInt(end_time.substring(14,16), 10),
                                  parseInt(end_time.substring(17,19), 10)
                                  );

        //현재 시간 받아오기.
        var today = new Date();
  
        
        //시간 검사하기 
        if(today.getTime() >= start_Date.getTime() && today.getTime() <= end_Date.getTime()){
            time_check = 1;
        }


        //강의 시간 내일 때 
        if(time_check == 1){
            var question_num = 1;
            var delay = 5;
            var check = 0;
            var url ="question.php?lecture_id="+lecture_id+"&user_id=<?=$user_id?>&question_num="+question_num+"&clock="+delay+"&check="+check+"&class_id=<?=$class_id?>";
            location.replace(url);
        }
        else{
            alert("해당 강의가 열려 있지 않습니다.");
        }
        
    }
    
    function numFormat(variable) { 
        var variable = Number(variable).toString(); 
        if(Number(variable) < 10 && variable.length == 1) {
            variable = "0" + variable; 
        }
        return variable;
    }


</script>
<body>
	<article class="boardArticle">
		<h3>강의 목록</h3>
		<table>
			<thead>
				<tr>
					<th scope="col" class="no">번호</th>
					<th scope="col" class="title">강의</th>
					<th scope="col" class="start_time">시작 시간</th>
                                            <th scope="col" class="end_time">끝나는 시간</th>
                                            <th scope="col" class="view">-</th>
				</tr>
			</thead>
			<tbody>
					<?php
                                                $sql = "select * from lectures where class_id=$class_id";
                                                $result = $db->query($sql);
                                                while($row = $result->fetch_assoc())
                                                {
                                            
                                            ?>
                                   <tr style=cursor:pointer; onClick="open_popup('<?=$row['lecture_id']?>','<?=$row['start_time']?>','<?=$row['end_time']?>');">  
                                     
					<td class="no"><?php echo $row['lecture_id']?></td>
					<td class="title" align="center"><?php echo $row['name']?></td>
					<td class="start_time" align="center"><?php echo $row['start_time']?></td>
                                            <td class="end_time" align="center"><?php echo $row['end_time']?></td>
                                            <td class="view" width="40" align="center" colspan="2">
                                                <input type="button" value="강의보기"><br>
                                            </td>  
				</tr>
					<?php
                                                }
					?>
			</tbody>
		</table>
	</article>
</body>
</html>