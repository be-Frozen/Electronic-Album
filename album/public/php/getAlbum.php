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
$name=$_GET["name"];
$order=$_GET["order"];
if($order==0) $sql = "SELECT a_name, a_size, a_edittime, a_introduction FROM album where a_owner='{$name}' order by a_edittime desc, a_name";
else if($order==1) $sql = "SELECT a_name, a_size, a_edittime, a_introduction FROM album where a_owner='{$name}' order by a_edittime, a_name";
else if($order==2) $sql = "SELECT a_name, a_size, a_edittime, a_introduction FROM album where a_owner='{$name}' order by CONVERT(a_name USING gbk) desc";
else if($order==3) $sql = "SELECT a_name, a_size, a_edittime, a_introduction FROM album where a_owner='{$name}' order by CONVERT(a_name USING gbk)";
else if($order==4) $sql = "SELECT a_name, a_size, a_edittime, a_introduction FROM album where a_owner='{$name}' order by a_size desc, a_name";
else if($order==5) $sql = "SELECT a_name, a_size, a_edittime, a_introduction FROM album where a_owner='{$name}' order by a_size, a_name";

$result = $conn->query($sql);
$ans=[];
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
	$p['a_name']=$row["a_name"];
	$p['a_size']=$row["a_size"];
	$p['a_edittime']=$row["a_edittime"];
	$p['a_introduction']=$row["a_introduction"];
        $ans[]=$p;
    }
} 
$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
$conn->close();
echo $ans;