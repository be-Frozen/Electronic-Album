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
$like=$_GET["like"];
$likenum=$_GET["likenum"];
echo $like;
if($like=="true"){
    echo "true";
    $sql = "insert into sharelike(sl_sid, sl_user) values('{$sid}' ,'{$user}');";
    $result = $conn->query($sql);

    $sql = "select s_likenum FROM share where s_id='{$sid}';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $likenum=$row['s_likenum']+1;
    }
}
else{
    echo "false";
    $sql = "delete FROM sharelike where sl_user='{$user}' and sl_sid='{$sid}';";
    $result = $conn->query($sql);

    $sql = "select s_likenum FROM share where s_id='{$sid}';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $likenum=$row['s_likenum']-1;
    }
}

$sql = "update share set s_likenum='{$likenum}' where s_id='{$sid}';";
$result = $conn->query($sql);
$conn->close();
