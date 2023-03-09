<?php
include('ACCESS_TOKEN.php');

$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);

$strUrl = "https://api.line.me/v2/bot/message/reply";

$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$ACCESS_TOKEN}";
http_response_code(200);
$id_line=$arrJson['events'][0]['source']['userId'];
if($arrJson['events'][0]['message']['text'] == "สวัสดี"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "สวัสดี ID คุณคือ ".$arrJson['events'][0]['source']['userId'];
}else if($arrJson['events'][0]['message']['text'] == "ชื่ออะไร"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ฉันยังไม่มีชื่อนะ";
}else if($arrJson['events'][0]['message']['text'] == "คุยกับน้องเข็มตำ"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ต้องการสอบถามข้อมูลเกี่ยวกับเรื่องใดคะ";

}else if($arrJson['events'][0]['message']['text'] == ""){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "";

}else if($arrJson['events'][0]['message']['text'] == "เข็มตำ"){

  include('config_166.php');
$sql="SELECT * FROM user_line WHERE id_line='$id_line'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) == 1){

  require "fleax_masage/New_case.php";

}else{
  require "fleax_masage/Risgister.php";
}
 

}else if($arrJson['events'][0]['message']['text'] == "Status"){

  require "fleax_masage/status.php";

// start project
}else if($arrJson['events'][0]['message']['text'] == "ลงทะเบียน"){

include('config_166.php');
$sql="SELECT * FROM user_line WHERE id_line='$id_line'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) == 1){

  require "fleax_masage/sucsess.php";

}else{
  require "fleax_masage/Risgister.php";
}
          


}else{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "น้องบอท ไม่เข้าใจคำสั่ง กรุณากรอกใหม่อีกครัง";
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);

?>