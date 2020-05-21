<?php
	require_once("dbconfig.php");
				$user_id = $_GET['user_id'];
				$lecture_id = $_GET['lecture_id'];
				$get_question_num = $_GET['question_num'];
				$get_clock = $_GET['clock'];
				$get_check = $_GET['check'];
				$class_id =$_GET['class_id'];



				//엑셀 데이터 불러오기 ---------------------------------------------------------------
			 require_once "./PHPExcel-1.8/Classes/PHPExcel.php"; // PHPExcel.php을 불러옴.

			 $objPHPExcel = new PHPExcel();

			 require_once "./PHPExcel-1.8/Classes/PHPExcel/IOFactory.php"; // IOFactory.php을 불러옴.

				//엑셀 파일 이름 얻어오기
				foreach (glob("*.xlsx") as $filename) {
					 break;
			 }

			 $filename = "testFile.xlsx";


			 $filename = "./".$filename; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.

			 try {

					 // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
					 $objReader = PHPExcel_IOFactory::createReaderForFile($filename);

					 // 읽기전용으로 설정
					 $objReader->setReadDataOnly(true);

					 // 엑셀파일을 읽는다
					 $objExcel = $objReader->load($filename);

					 // 첫번째 시트를 선택
					 $objExcel->setActiveSheetIndex(0);
					 $objWorksheet = $objExcel->getActiveSheet();
					 $rowIterator = $objWorksheet->getRowIterator();


					 foreach ($rowIterator as $row) { // 모든 행에 대해서
							 $cellIterator = $row->getCellIterator();
							 $cellIterator->setIterateOnlyExistingCells(false);
					 }

					 //테이블 비우기
					 $reset_sql = "TRUNCATE TABLE questions_pr";
					 $reset_result = $db->query($reset_sql);

					 $maxRow = $objWorksheet->getHighestRow();

					 //테이블 채우기
					 for ($i = 2 ; $i <= $maxRow ; $i++) {

							 $dataA = $objWorksheet->getCell('A' . $i)->getValue(); // A열 = question_id
							 $dataB = $objWorksheet->getCell('B' . $i)->getValue(); // B열 = key_value
							 $dataC = $objWorksheet->getCell('C' . $i)->getValue(); // C열 = pr1
							 $dataD = $objWorksheet->getCell('D' . $i)->getValue(); // D열 = pr2
							 $dataE = $objWorksheet->getCell('E' . $i)->getValue(); // E열 = pr3
							 $dataF = $objWorksheet->getCell('F' . $i)->getValue(); // F열 = pr4
							 $dataG = $objWorksheet->getCell('G' . $i)->getValue(); // G열 = pr5
							 $dataH = $objWorksheet->getCell('H' . $i)->getValue(); // H열 = answer



							 $excel_sql = "INSERT INTO `questions_pr` (`key_value`, `question_id`, `answer`) VALUES ('$dataB', '$dataA', '$dataH')";
							 $excel_result = $db->query($excel_sql);

							 if($dataC != null){
									 $update_sql = "UPDATE `questions_pr` SET `pr1` = '$dataC' WHERE `questions_pr`.`question_id` = '$dataA' AND `questions_pr`.`key_value` = $dataB";
									 $update_result = $db->query($update_sql);
							 }
							 if($dataD != null){
									 $update_sql = "UPDATE `questions_pr` SET `pr2` = '$dataD' WHERE `questions_pr`.`question_id` = '$dataA' AND `questions_pr`.`key_value` = $dataB";
									 $update_result = $db->query($update_sql);
							 }
							 if($dataE != null){
									 $update_sql = "UPDATE `questions_pr` SET `pr3` = '$dataE' WHERE `questions_pr`.`question_id` = '$dataA' AND `questions_pr`.`key_value` = $dataB";
									 $update_result = $db->query($update_sql);
							 }
							 if($dataF != null){
									 $update_sql = "UPDATE `questions_pr` SET `pr4` = '$dataF' WHERE `questions_pr`.`question_id` = '$dataA' AND `questions_pr`.`key_value` = $dataB";
									 $update_result = $db->query($update_sql);
							 }
							 if($dataG != null){
									 $update_sql = "UPDATE `questions_pr` SET `pr5` = '$dataG' WHERE `questions_pr`.`question_id` = '$dataA' AND `questions_pr`.`key_value` = $dataB";
									 $update_result = $db->query($update_sql);
							 }

					 }
			 } catch (exception $e) {
					 echo '엑셀파일을 읽는도중 오류가 발생하였습니다.<br/>';
			 }

				//엑셀 데이터 불러오기 끝---------------------------------------------------------------

?>
<html>
<head>
	<title>문항</title>

<script language="javascript">
var delay=5; //시간설정

var q_num=<?=$get_question_num?>;
var timer;
var layer;
var clock=<?=$get_clock?>;
var check = <?=$get_check?>;

function show_question(){
	if (layer=eval("document.all.question"+q_num)){
		 layer.style.display="inline";
		 document.all.timeLeft.innerHTML=clock;
								 if(check == 1){
										 print_check();
								 }
		 hide_question();
	} else {
		 document.all.timeLeft.innerHTML=0;
		 document.all.quizScore.innerHTML="모든 문제를 다 푸셨습니다.";
		 document.all.quizScore.style.display="inline";
	}
}

function hide_question(){
	if (clock>0) {
		 document.all.timeLeft.innerHTML=clock;
		 clock--;
		 timer=setTimeout("hide_question()",1000);
	} else {
		 clearTimeout(timer);
								 q_num++;
		 clock=delay;
								 check = false;
		 layer.style.display="none";
		 show_question();
	}
}

function check_answer(type, question_id, pr_num, key_value){

			 var question_num = q_num;
			 var answer = "";
			 //단답식 답 추출
			 if (type == 0 || type == 2){
					 var short_answer_id = "short_answer"+question_num;
					 answer =  document.getElementById(short_answer_id).value;
			 }
			 //객관식 답 추출
			 else if (type == 1) {
					 var bogi_id = "bogi"+question_num;
					 var values = document.getElementsByName(bogi_id);
					 var i;
					 for(i = 0; i<values.length; i++){
							 if(values[i].checked == true){
									 answer = answer + ","+ values[i].value;
							 }
					 }
					 answer = answer.substring(1);
			 }

			 var type = type;
			 var question_id = question_id;

			 var url = "question_submit_action.php?user_id=<?=$user_id?>&question_id=" + question_id+"&lecture_id=<?=$lecture_id?>&question_num="+q_num+"&clock="+clock+"&answer="+answer+"&pr_num="+pr_num+"&key_value="+key_value+"&class_id=<?=$class_id?>&type="+type;
			 location.replace(url);

			 clearTimeout(timer);
			 timer=setTimeout("hide_question()",700);
}

function print_check(){
			 var answerBoard_id = "answerBoard"+q_num;
			 document.getElementById(answerBoard_id).innerHTML= "<font color='red'>제출 됐습니다.</font>";
}

window.onload=show_question;
</script>
</head>

<body>
<?php
	 $sql = "select * from lectures where lecture_id=$lecture_id";
	 $result = $db->query($sql);
	 $row = $result->fetch_assoc();
?>

<h3><?php echo $row['name']?></h3>

제한시간 : <B><span id="timeLeft"></span></B> 초<br>
<br>
						<?php

								 $sql = "select * from questions where lecture_id=$lecture_id";
								 $result = $db->query($sql);
								 $question_num = $get_question_num;
								 for($i=0; $i< $question_num-1 ; $i++){
										 $row = $result->fetch_assoc();
								 }
								 while($row = $result->fetch_assoc())
								 {
										 $question_id = "question".$question_num;
						?>
								 <div id='<?=$question_id?>' style="display:none">
										 <p><?php echo $question_num?>.
						<?php
										 //단답
										 if($row['type'] == 0 || $row['type'] == 2){
											 $pr_num = 0;
											 $key_value = 0;
						?>
										 <?php echo $row['question']?></p>
										 <p>
						<?php
											 //매개변수 가져오는 문제일 경우
											 if( $row['type'] == 2){
													 //해당 문제의 key_value max 값 구하기
													 $max_sql = "select max(key_value) as key_max from questions_pr where question_id=".$row['question_id'];
													 $max_result = $db->query($max_sql);
													 $max_row =  $max_result->fetch_assoc();
													 $key_max = $max_row['key_max'];

													 //학생에게 key_value 정하주기
													 $key_sql ="select * from user_classes where class_id =$class_id";
													 $key_result = $db->query($key_sql);

													 while($key_row = $key_result->fetch_assoc()){
															 $key_value++;
															 if($key_row['user_id'] == $user_id){
																	 break;
															 }
													 }
													 $key_value %= $key_max;
													 if($key_value == 0){
															 $key_value = $key_max;
													 }

													 $a = $row['question_id'];

													 //key_value에 맞춰서 파라미터 불러오기 .
													 $pr_sql = "SELECT * FROM questions_pr WHERE key_value = $key_value AND question_id = $a;";
													 //$pr_sql =  "select * from questions_pr where key_value = $key_value and question_id =".$row['question_id'];
													 $pr_result = $db->query($pr_sql);
													 $pr_row =  $pr_result->fetch_assoc();

													 if($pr_row['pr1'] != null){
															 echo "(A): ".$pr_row['pr1']." ";
													 }
													 if($pr_row['pr2'] != null){
															 echo "(B): ".$pr_row['pr2']." ";
													 }
													 if($pr_row['pr3'] != null){
															 echo "(C): ".$pr_row['pr3']." ";
													 }
													 if($pr_row['pr4'] != null){
															 echo "(D): ".$pr_row['pr4']." ";
													 }
													 if($pr_row['pr5'] != null){
															 echo "(E): ".$pr_row['pr5']." ";
													 }


						?>
																	 &nbsp;&nbsp;
						<?php

											 }

						?>
										 </p>
										 <form name="Short answer">
												 (쉼표로 답을 구분합니다.)
												 <br><br>
												 <?php
													 $short_answer_id = "short_answer".$question_num;
												 ?>
												 <textarea id ='<?=$short_answer_id?>' cols="80" rows="10" name = "answer"></textarea><br>
												 <br>
												 <input type="button" name="선택" value="제출" onclick="check_answer('<?=$row['type']?>', '<?=$row['question_id']?>', '<?=$pr_num?>', '<?=$key_value?>');">
												 <?php
															 $answerBoard_id = "answerBoard".$question_num;
												 ?>
												 <p id='<?=$answerBoard_id?>'> </p>
										 </form>
								 </div>
						<?php
										 }
										 //객관식
										 else if($row['type'] == 1){
										 $bogi_sql = "select * from bogies where question_id =".$row['question_id'];
										 $bogi_re = $db->query($bogi_sql);
										 $bogi_row = $bogi_re->fetch_assoc();

										 $bogi_id = "bogi".$question_num;
						?>
										 <?php echo $row['question']?></p>
											 <form name="Multiple choice">
													 <input type="checkbox" name='<?=$bogi_id?>' value="1"><?php echo $bogi_row['bogi_1']?><br>
													 <input type="checkbox" name='<?=$bogi_id?>' value="2"><?php echo $bogi_row['bogi_2']?><br>
													 <input type="checkbox" name='<?=$bogi_id?>' value="3"><?php echo $bogi_row['bogi_3']?><br>
													 <input type="checkbox" name='<?=$bogi_id?>' value="4"><?php echo $bogi_row['bogi_4']?><br>
													 <input type="checkbox" name='<?=$bogi_id?>' value="5"><?php echo $bogi_row['bogi_5']?><br>
													 <br>
													 <input type="button" name="선택" value="제출" onclick="check_answer('<?=$row['type']?>', '<?=$row['question_id']?>', 0, 0);">
													 <?php
															 $answerBoard_id = "answerBoard".$question_num;
													 ?>
													 <p id='<?=$answerBoard_id?>'> </p>
											 </form>
								 </div>
						<?php
										 }
										 $question_num++;
								 }
					 ?>

<div id="quizScore" style="display:none">
</div>

</body>
</html>
