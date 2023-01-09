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
$album=$_GET["album"];
$address=$_GET["address"];
$sid=$_GET["sid"];

$sql = "SELECT p_id FROM photo where p_owner='{$user}' and p_album='{$album}' and p_address='{$address}';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pid=$row['p_id'];

$sql = "insert into sharepic(sp_sid, sp_pid) values('{$sid}' ,'{$pid}');";

$result = $conn->query($sql);

$conn->close();
