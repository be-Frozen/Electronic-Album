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
$sid=$_GET["sid"];
$words=$_GET["words"];
$commentnum=$_GET["commentnum"];
$ans=[];


$sql = "insert into sharecmt(sc_sid,sc_words, sc_user) values('{$sid}' ,'{$words}','{$user}');";
$result = $conn->query($sql);


$sql = "select sc_id,sc_time FROM sharecmt where sc_user='{$user}' and sc_sid='{$sid}' order by sc_time desc;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ans['id']=$row['sc_id'];
    $ans['time']=$row['sc_time'];
}

$sql = "select u_head FROM user where u_name='{$user}';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ans['head']=$row['u_head'];
}

$sql = "select s_commentnum FROM share where s_id='{$sid}';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $commentnum=$row['s_commentnum']+1;
}

$sql = "update share set s_commentnum='{$commentnum}' where s_id='{$sid}';";
$result = $conn->query($sql);

$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
$conn->close();
echo $ans;
