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
$address=$_GET["address"];

$sql = "select * FROM photo where p_owner='{$owner}' and p_album='{$album}' and p_address='{$address}';";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
    echo "同名图片已存在";
unlink("./".$address);
    return;
}


$sql = "insert into photo(p_album, p_owner, p_address,p_time) values('{$album}' ,'{$owner}','{$address}',now());";

$result = $conn->query($sql);
rename("./".$address,"./../照片/".$owner."/".$album."/".$address);

$sql = "SELECT a_size FROM album where a_owner='{$owner}' and a_name='{$album}';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$size=$row['a_size'];

$size+=1;
$sql = "UPDATE album SET a_size={$size},a_edittime=NOW() where a_owner='{$owner}' and a_name='{$album}';";
$result = $conn->query($sql);

$sql = "SELECT a_edittime FROM album where a_owner='{$owner}' and a_name='{$album}';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$time=$row['a_edittime'];
$ans=[];
$ans['time']=$time;

$sql = "SELECT p_address, p_time FROM photo where p_owner='{$owner}' and p_album='{$album}' and p_address='{$address}';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $p['p_address']=$row['p_address'];
        $p['p_time']=$row['p_time'];
        //$ans[]=$p;
        $ans['photo']=$p;
    }
}
$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
$conn->close();
echo $ans;
