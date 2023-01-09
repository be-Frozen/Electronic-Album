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
$user=$_GET["user"];
$words=$_GET["words"];


$sql = "insert into share(s_user, s_words) values('{$user}' ,'{$words}');";

$result = $conn->query($sql);


$sql = "SELECT s_id,s_time FROM share where s_user='{$user}' and s_words='{$words}' order by s_time desc;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$ans=[];
$ans['id']=$row['s_id'];
$ans['time']=$row['s_time'];
$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
echo $ans;
$conn->close();
