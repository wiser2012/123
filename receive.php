<?php
$json_str = file_get_contents('php://input');//接收request的body
$json_obj = json_decode($json_str);//從string格式轉為jason格式
$myfile = fopen("log.txt","w+") or die("Unable to open file!");
fwrite($myfile, "\xEF\xBB\xBF".$json_str);//在字串前加入\xef....轉成utf8格式，以防中文變亂碼
fclose($myfile);
?>
