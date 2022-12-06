<?php
//echo "ok";
if(!empty($_FILES)){
$filename=$_FILES["file"]["name"];
//echo $filename;
//$filetype=$_FILES["file"]["type"];
$filetype=substr(strrchr($filename,'.'),1);
$temppath=$_FILES["file"]["tmp_name"];
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
