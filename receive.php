<?php
$json_str = file_get_contents('php://input');//接收request的body
$json_obj = json_decode($json_str);//從string格式轉為jason格式

//產生回傳給line server的格式
	$sender_userid = $json_obj->events[0]->source->userId;
	$sender_txt = $json_obj->events[0]->message->text;
	$sender_replyToken = $json_obj->events[0]->replyToken;
  	$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
		);

	$myfile = fopen("log.txt","w+") or die("Unable to open file!");
	fwrite($myfile, "\xEF\xBB\xBF".$json_str);//在字串前加入\xef....轉成utf8格式，以防中文變亂碼
	fclose($myfile);

//回傳給line server
	$header[] = "Content-Type: application/json";
	$header[] = "Authorization: Bearer Nzaj6VdKQbbgKu8cYt2jyEZODY35qldsN85WDPV91SQUKCYtqyQzqPh4KIpSQU4sVSKDdtGRquFZZsLZ7U0QT+9N8w5QBIpmSd4sN5h3RecswoLRhtOBb7rSbIyyXSpv9Kb1200atA/cJUSk6OB1oQdB04t89/1O/w1cDnyilFU=";
	$ch = curl_init("https://api.line.me/v2/bot/message/reply");                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
	$result = curl_exec($ch);
	curl_close($ch); 

?>
