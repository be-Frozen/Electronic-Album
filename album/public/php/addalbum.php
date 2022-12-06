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
$name=$_GET["name"];
$introduction=$_GET["introduction"];
$exsit=$_GET["exsit"];
$oldname=$_GET["oldname"];
$oldintroduction=$_GET["oldintroduction"];
//echo $exsit;
if($exsit==0){
$sql = "select a_edittime FROM album where a_name='{$name}' and a_owner='{$owner}';";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
    echo "false";
    return;
}


$sql = "insert into album(a_name,a_owner,a_introduction, a_edittime) values('{$name}' ,'{$owner}','{$introduction}',NOW());";

$result = $conn->query($sql);
mkdir("./../照片/".$owner."/".$name);
$sql = "select a_edittime FROM album where a_name='{$name}' and a_owner='{$owner}';";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
$row = mysqli_fetch_assoc($result);

    echo $row['a_edittime'];
}
}
else{
$sql = "select a_edittime FROM album where a_name='{$name}' and a_owner='{$owner}';";

$result = $conn->query($sql);
if ($result->num_rows > 0&&$name!=$oldname) {
    // 输出数据
//echo $name;
//echo $oldname;
    echo "false";
    return;
}


$sql = "UPDATE album SET a_name='{$name}', a_introduction='{$introduction}',a_edittime=NOW() WHERE a_name='{$oldname}' ;";

$result = $conn->query($sql);
rename("./../照片/".$owner."/".$oldname, "./../照片/".$owner."/".$name);
$sql = "select a_edittime FROM album where a_name='{$name}' and a_owner='{$owner}';";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 输出数据
$row = mysqli_fetch_assoc($result);

    echo $row['a_edittime'];
}
}
$conn->close();
