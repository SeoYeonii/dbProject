
<?php
    require_once("dbconfig.php");
         //엑셀 데이터 불러오기 ---------------------------------------------------------------
        require_once "./PHPExcel-1.8/Classes/PHPExcel.php"; // PHPExcel.php을 불러옴.

        $objPHPExcel = new PHPExcel();

        require_once "./PHPExcel-1.8/Classes/PHPExcel/IOFactory.php"; // IOFactory.php을 불러옴.

				/*
         //엑셀 파일 이름 얻어오기
         foreach (glob("*.xlsx") as $filename) {
            break;
        }*/
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
                $dataC = $objWorksheet->getCell('C' . $i)->getValue(); // C열 = pr2
                $dataD = $objWorksheet->getCell('D' . $i)->getValue(); // D열 = pr3
                $dataE = $objWorksheet->getCell('E' . $i)->getValue(); // E열 = pr4
                $dataF = $objWorksheet->getCell('F' . $i)->getValue(); // F열 = pr5
                $dataG = $objWorksheet->getCell('G' . $i)->getValue(); // G열 = pr6
                $dataH = $objWorksheet->getCell('H' . $i)->getValue(); // H열 = answer

                
                echo $i." ".$dataA." ".$dataB." ".$dataC." ".$dataD." ".$dataE." ".$dataF." ".$dataG." ".$dataH;
                $excel_sql = "INSERT INTO `questions_pr` VALUES ('$dataB', '$dataA', '$dataC', '$dataD', null, null, null, '$dataH')";
                $excel_result = $db->query($excel_sql);
                if ($excel_result) {
                  echo "$excel_result";
                }

            }
        } catch (exception $e) {
            echo '엑셀파일을 읽는도중 오류가 발생하였습니다.<br/>';
        }
        ?>
