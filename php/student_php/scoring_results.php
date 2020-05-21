<?php
    require_once("dbconfig.php");
    
    $question_id = $_GET['question_id'];
    $class_id = $_GET['class_id']; 
            
    $average = 0;
    $real_difficulty = 0; 
    $student_num = 0;
 
?>


<head>
	<meta charset="utf-8" />
	<title>채점결과보기</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
    <?php
        //강의(과목)을 듣는 모든 학생 불러오기
        $cu_sql = "select user_id from user_classes where class_id = '$class_id' and role = 'student'";
        $cu_result = $db->query($cu_sql);
        
        //수강중인 학생이 있는 경우 
        if($cu_row = $cu_result->fetch_assoc()){
    ?>       
            <div>
                <table border="1">
                    <thead>
                        <tr>
                            <th scope="col" class="average">user_id</th>
                            <th scope="col" class="real_difficulty">점수</th>
                        </tr>
                    </thead>
                    <tbody>
                       
    <?php       
            do {  
                $point=0; //문제를 풀지 않은 경우 0점. 
                $max_sql = "select student_id, max(submit_time) as 'max_time' from student_answer_log where question_id ='$question_id' group by student_id";
                $max_result = $db->query($max_sql);
                while($max_row = $max_result->fetch_assoc()){
                    if($max_row['student_id'] == $cu_row['user_id']){
                        $max_time = $max_row['max_time'];
   
                        $right_sql = "select point from student_answer_log where question_id ='$question_id' and submit_time='$max_time' and student_id=".$cu_row['user_id'];
                        $right_result = $db->query($right_sql);
                        $right_row = $right_result->fetch_assoc();
                        $point = $right_row['point'];
                        break;
                    }
                }
                
                $average += $point;
     ?>         
                         <tr>
                            <td class="average" align="center"><?php echo $cu_row['user_id'] ?></td>
                            <td class="real_difficulty" align="center"><?php echo $point ?></td>
                        </tr>
    <?php   
                $student_num++;
            } while ($cu_row = $cu_result->fetch_assoc());
            
            $average /= $student_num;
           
            //실질 난이도 불러오기 
            $rd_sql = "select * from questions where question_id = $question_id";
            $rd_result = $db->query($rd_sql);
            $rd_row = $rd_result->fetch_assoc();
            
            $real_difficulty = $rd_row['real_difficulty'];
         
  
    ?>    
                    </tbody>   
                </table>
            </div>
     <br> 
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th scope="col" class="average">평균</th>
                    <th scope="col" class="real_difficulty">실질 난이도</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="average" align="center"><?php echo $average ?></td>
                    <td class="real_difficulty" align="center"><?php echo $real_difficulty ?></td>
                </tr>
            </tbody>   
        </table>
    </div> 
    <?php
        }
        //수강중인 학생이 없는 경우 
        else{
    ?> 
            <p>아직 이 과목을 수강 중인 학생이 없습니다.</p>
    <?php
        }
    ?>
</body>