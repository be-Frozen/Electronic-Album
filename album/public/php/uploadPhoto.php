<?php
//echo "ok";
if(!empty($_FILES)){
$filename=$_FILES["file"]["name"];
//$ans=$_FILES["file"];
//$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
//echo $ans;
//$filetype=$_FILES["file"]["type"];
$filetype=substr(strrchr($filename,'.'),1);
$temppath=$_FILES["file"]["tmp_name"];
//$temppath="";
//echo $temppath;
//echo $filename;
//echo $filetype;
if($filetype!='jpg'&&$filetype!='jpeg'&&$filetype!='png') {
echo "false";
return;
}
copy($_FILES["file"]["tmp_name"],'./'.$_FILES["file"]["name"]);
echo $filename;
}
