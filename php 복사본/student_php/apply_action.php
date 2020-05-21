<?php
	require_once("dbconfig.php");

         $user_id=$_GET['user_id'];
         $class_id=$_GET['class_id'];
         $sql = "INSERT INTO `user_classes` (`role`, `class_id`, `user_id`) VALUES ('student', '$class_id', '$user_id')";
         $result = $db->query($sql);

?>
         <script>
            location.replace("class.php?user_id=<?=$user_id?>");
         </script>
