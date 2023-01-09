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

$name=$_GET["name"];

$sql = "SELECT * FROM share order by s_time desc;";
$result = $conn->query($sql);

$ans=[];
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $p=[];
        $p['id']=$row["s_id"];
        $p['user']=$row["s_user"];
        $p['words']=$row["s_words"];
        $p['likenum']=$row["s_likenum"];
        //$p['commentnum']=$row["s_commentnum"];
        $p['time']=$row["s_time"];
        $p['photo']=[];
        $p['cmt']=false;
        $p['commentnum']=$row['s_commentnum'];
        $p['content']="";
        $ssql = "SELECT u_head FROM user where u_name='{$p['user']}';";
        $sresult = $conn->query($ssql);
        $srow = $sresult->fetch_assoc();
        $p['head']=$srow['u_head'];
	$p['comment']=[];

        if($p['user']==$name||$name==""){
            $p['delete']=true;
        }


        $ssql = "SELECT sl_user FROM sharelike where sl_sid='{$p['id']}' and sl_user='{$name}';";
        $sresult = $conn->query($ssql);
        if ($sresult->num_rows > 0 && $name!="") {
            $p['like'] = true;
        }
        else{
            $p['like'] = false;
        }
        $ssql = "SELECT sp_id, p_owner,p_album,p_address FROM sharepic,photo where sharepic.sp_pid=photo.p_id and sharepic.sp_sid='{$p['id']}' order by sp_id;";
        $sresult = $conn->query($ssql);
        if ($sresult->num_rows > 0) {
            // 输出数据
            while ($srow = $sresult->fetch_assoc()) {
                $addr=$srow['p_owner']."/".$srow['p_album']."/".$srow['p_address'];
                $p['photo'][]=$addr;
            }
        }

        $ssql = "SELECT distinct u_head,sc_id, sc_user,sc_words,sc_time FROM sharecmt,share,user where u_name=sharecmt.sc_user and sharecmt.sc_sid='{$p['id']}' order by sc_time;";
        $sresult = $conn->query($ssql);
        if ($sresult->num_rows > 0) {
            // 输出数据
            while ($srow = $sresult->fetch_assoc()) {
                $addr=[];
                $addr['id']=$srow['sc_id'];
                $addr['head']=$srow['u_head'];
                $addr['user']=$srow['sc_user'];
                $addr['words']=$srow['sc_words'];
                $addr['time']=$srow['sc_time'];
                if($addr['user']==$name||$name==""){
                    $addr['delete']=true;
                }
                $p['comment'][]=$addr;
            }
        }
        $ans[]=$p;
    }
}
$ans=json_encode($ans,JSON_UNESCAPED_UNICODE);
$conn->close();
echo $ans;