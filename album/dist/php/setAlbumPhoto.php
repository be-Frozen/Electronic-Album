<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "album";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$name='"'.$_GET["name"].'"';
if($name=="") return false;
$dir="./../照片/op";
//echo $dir;
//$type=$_GET["type"];
//$dir=iconv('UTF-8', 'GB2312', $dir);
$picarray=[];
//echo $dir;
if(!is_dir($dir)) return false;
//echo "???";
$handle = opendir($dir);
//$readall=$_GET["readall"];
if($handle) {
    while (($fl = readdir($handle)) !== false) {
        //$temp = iconv('GBK','utf-8',$dir.DIRECTORY_SEPARATOR.$fl);//转换成utf-8格式
        //echo $temp;
        $temp = $dir . DIRECTORY_SEPARATOR . $fl;
        //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来
        if (is_dir($temp) && $fl != '.' && $fl != '..') {
            $temp = substr($temp, strripos($temp, '\\') + 1);
            //echo $temp;
            //if($type==0) $picarray[] = $temp;
            $sql = "insert into album(a_name,a_owner) values('{$temp}' ,{$name});";
            $result = $conn->query($sql);
            //echo "true";

            $picarray[] = $temp;
            //echo '目录：' . $temp . "\n";
            //read_all($temp);
        } else {
            if ($fl != '.' && $fl != '..') {
                $temp = substr($temp, strripos($temp, '\\') + 1);
                $filename=$temp;
                $pictype=substr($temp, strripos($temp, '.') + 1);

                /*if($type==1&&($pictype =="jpg"||$pictype=="png"))
                    $picarray[] = $filename;*/
                //if($readall==0) return $picarray;
                //echo '文件：' . $temp . "\n";
            }
        }
    }
}




foreach ($picarray as $album)
{
    $dir="./../照片/op/".$album;
    $num=0;
//echo $dir;
//$type=$_GET["type"];
//$dir=iconv('UTF-8', 'GB2312', $dir);
//echo $dir;
    if(!is_dir($dir)) return false;
//echo "???";
    $handle = opendir($dir);
//$readall=$_GET["readall"];
    if($handle) {
        while (($fl = readdir($handle)) !== false) {
            //$temp = iconv('GBK','utf-8',$dir.DIRECTORY_SEPARATOR.$fl);//转换成utf-8格式
            //echo $temp;
            $temp = $dir . DIRECTORY_SEPARATOR . $fl;
            //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来
            if (is_dir($temp) && $fl != '.' && $fl != '..') {
                $temp = substr($temp, strripos($temp, '\\') + 1);
                //echo $temp;
                //if($type==0) $picarray[] = $temp;
                $sql = "insert into album(a_name,a_owner) values('{$temp}' ,{$name});";
                $result = $conn->query($sql);
                //echo "true";

                $picarray[] = $temp;
                //echo '目录：' . $temp . "\n";
                //read_all($temp);
            } else {
                if ($fl != '.' && $fl != '..') {
                    $temp = substr($temp, strripos($temp, '\\') + 1);
                    $filename=$temp;
                    //$pictype=substr($temp, strripos($temp, '.') + 1);
                    $sql = "insert into photo(p_album,p_owner,p_address) values('{$album}' ,{$name},'{$filename}');";
                    $result = $conn->query($sql);
                    /*if($type==1&&($pictype =="jpg"||$pictype=="png"))
                        $picarray[] = $filename;*/
                    //if($readall==0) return $picarray;
                    //echo '文件：' . $temp . "\n";
                    $num+=1;
                }
            }
        }
    }
    $sql = "update album SET a_size={$num} WHERE a_name='{$album}' and a_owner={$name};";
    $result = $conn->query($sql);
}