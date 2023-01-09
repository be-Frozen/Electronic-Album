<?php


function read_all ($dir){
//echo $dir;
    $type=$_GET["type"];
//$dir=iconv('UTF-8', 'GB2312', $dir);
    $picarray=[];
    //echo $dir;
    if(!is_dir($dir)) return false;
    //echo "???";
    $handle = opendir($dir);
    $readall=$_GET["readall"];
    if($handle) {
        while (($fl = readdir($handle)) !== false) {
            //$temp = iconv('GBK','utf-8',$dir.DIRECTORY_SEPARATOR.$fl);//转换成utf-8格式
            //echo $temp;
            $temp = $dir . DIRECTORY_SEPARATOR . $fl;
            //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来
            if (is_dir($temp) && $fl != '.' && $fl != '..') {
                $temp = substr($temp, strripos($temp, '\\') + 1);
                //echo $temp;
                if($type==0) $picarray[] = $temp;
                //echo '目录：' . $temp . "\n";
                read_all($temp);
            } else {
                if ($fl != '.' && $fl != '..') {

                    if($type==1&&substr($temp, strripos($temp, '.') + 1) =='jpg'||substr($temp, strripos($temp, '\\') + 1)=='png') $picarray[] = $temp;
                    if($readall==0) return $picarray;
                    //echo '文件：' . $temp . "\n";
                }
            }
        }
    }
    return $picarray;
}
$addr=$_GET["addr"];
//$addr="原神";
//echo "__DIR__:  ========>  ".__DIR__;
//mkdir(".");
//$pic_array=read_all('http://www.cnbruce.com/');
$pic_array=read_all('./../'.$addr);
$pic_array=json_encode($pic_array,JSON_UNESCAPED_UNICODE);
echo $pic_array;
return "where";
?>