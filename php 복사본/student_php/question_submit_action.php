<?php
    require_once("dbconfig.php");  
    
    $user_id=$_GET['user_id'];
    $question_id=$_GET['question_id'];
    $lecture_id=$_GET['lecture_id'];
    $class_id =$_GET['class_id'];
    $question_num=$_GET['question_num'];
    $clock = $_GET['clock'];
    $check = 1;
    $answer = $_GET['answer'];
    $pr_num =  $_GET['pr_num'];
    $key_value = $_GET['key_value'];
    $type = $_GET['type'];
    
    $current_time = date("Y-m-d H:i:s");
    $point = 0; 
    
    //문제 진짜 답 구해오기
    if($type == 2){
        $answer_sql = "select * from questions_pr where question_id ='$question_id' and key_value='$key_value'";
    }
    else{ 
        $answer_sql = "select * from questions where question_id ='$question_id'";
    }
    $answer_result = $db->query($answer_sql);
    $answer_row = $answer_result->fetch_assoc();
    $question_answer = $answer_row['answer'];
    
    $is_right = true;
    $get_point = 0;
   
    //배점 얻어오기 
    $point_sql = "select * from question_keywords where question_id ='$question_id'";
    $point_result = $db->query($point_sql);
    while($point_row = $point_result->fetch_assoc()){
        $get_point += $point_row['score_portion'];
    }
                
    
    //답을 뭐라도 체크하거나 적은 경우 
    if(!empty( $answer )){
        //답이 하나인 경우 
        if(!strpos($question_answer,',')){
            //답이 맞음 
            $question_answer = trim($question_answer," ");  //앞뒤 공백 제거 
            $answer = trim($answer," "); //앞뒤 공백 제거 
            if(!strcmp($question_answer, $answer)){
                $point = $get_point; 
            }
        }
        //답이 여러개인 경우 
        else{
            //제출 답 역시 여러개인 경우  
            if(strpos($answer,',')){
                
                $question_Tok =explode(',' , $question_answer); // ',' 기준으로 자르기 
                $answer_Tok =explode(',' , $answer);
                $question_len = count($question_Tok); //답의 갯수 
                $answer_len = count($answer_Tok);
                
                //정답과 제출한 답의 갯수가 같은 경우 
                if($question_len == $answer_len ){
                    for($i=0; $i < $question_len; $i++){
                        $answer_Tok[$i] = trim($answer_Tok[$i]," "); //앞뒤 공백 제거
                        $question_Tok[$i] = trim($question_Tok[$i]," "); //앞뒤 공백 제거
                        if(strcmp($question_Tok[$i], $answer_Tok[$i])){
                            $is_right = false;
                        }
                    }
                    if($is_right){
                        $point = $get_point; 
                    }
                }
            }
            
        }
    }
 
   
    $sql = "INSERT INTO `student_answer_log` (`student_id`, `question_id`, `submit_time`, `answer`, `point`) VALUES ('$user_id', '$question_id', '$current_time', '$answer', '$point')";
    $result = $db->query($sql);
    
        
    //------------------실질 난이도 구하기-------------------------
    
    $total_num = 0;
    $total_sql = "select user_id from user_classes where class_id = '$class_id' and role = 'student'";
    $total_result = $db->query($total_sql);
    $total_num= mysqli_num_rows($total_result);

    $right_num = 0;
    $max_sql = "select student_id, max(submit_time) as 'max_time' from student_answer_log where question_id ='$question_id' group by student_id";
    $max_result = $db->query($max_sql);
    while($max_row = $max_result->fetch_assoc()){
        $max_time = $max_row['max_time'];
        $fetch_user_id = $max_row['student_id'];
    
        $right_sql = "select point from student_answer_log where question_id ='$question_id' and submit_time='$max_time' and student_id='$fetch_user_id'";
        $right_result = $db->query($right_sql);
        $right_row = $right_result->fetch_assoc();
        if($right_row['point'] != 0){
            $right_num++;
         }
        
    }
    
   
    
    $real_difficulty = 10 - (10*($right_num/$total_num));
    
    $re_di_sql = "UPDATE `questions` SET `real_difficulty` = '$real_difficulty' WHERE `questions`.`question_id` = '$question_id'";
    $result = $db->query($re_di_sql);
    
?>
         <script>
            location.replace("question.php?lecture_id=<?=$lecture_id?>&user_id=<?=$user_id?>&question_num=<?=$question_num?>&clock=<?=$clock?>&check=<?=$check?>&class_id=<?=$class_id?>");
         </script>