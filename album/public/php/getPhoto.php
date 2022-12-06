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
$owner=$_GET["owner"];
$album=$_GET["album"];
$sql = "SELECT p_address, p_time FROM photo where p_owner='{$owner}' and p_album='{$album}'";
$result = $conn->query($sql);
$ans=[];
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
	$p['p_address']=$row['p_address'];
	$p['p_time']=$row['p_time'];
        $ans[]=$p;
    }
} 
$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
$conn->close();
echo $ans;