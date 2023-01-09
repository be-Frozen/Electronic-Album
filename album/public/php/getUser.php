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
$conn->query("Set names 'utf8'");


$sql = "SELECT * FROM user order by u_registertime desc;";
$result = $conn->query($sql);

$ans=[];
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $p=[];
        $p['name']=$row["u_name"];
        $p['password']=$row["u_password"];
        $p['head']=$row["u_head"];
        $p['sex']=$row["u_sex"];
        //$p['commentnum']=$row["s_commentnum"];
        $p['birthday']=$row["u_birthday"];
        $p['signature']=$row['u_signature'];
        $p['registertime']=$row['u_registertime'];


        $ssql = "SELECT a_id FROM album where a_owner='{$p['name']}';";
        $sresult = $conn->query($ssql);
        $p['albumnum']=$sresult->num_rows;
        $ans[]=$p;
    }
}
$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
$conn->close();
echo $ans;