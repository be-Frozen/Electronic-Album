<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "album";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("Set names 'utf8'");
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$name='"'.$_GET["name"].'"';


$sql = "select * FROM user where u_name={$name};";
$user=[];
$result = $conn->query($sql);
if ($result->num_rows > 0) {

    $row = mysqli_fetch_assoc($result);
    $user['u_head']=$row['u_head'];
    $user['u_sex']=$row['u_sex'];
    $user['u_birthday']=$row['u_birthday'];
    $user['u_signature']=$row['u_signature'];
    $user['u_status']=$row['u_status'];
    $user['u_registertime']=$row['u_registertime'];

//echo gettype($row['u_head']);
	$user=json_encode($user,JSON_UNESCAPED_UNICODE);
//echo $user['u_sex'];
//if($user==true) echo gettype($user);
   echo $user;

} else {
    echo "false";
}
$conn->close();
return "success";