<?php
    $id_app     = '6703231';                             //Айди приложения
    $url_script = 'http://localhost/ABC/vk.php'; //ссылка на скрипт auth_vk.php
    ?>

<?php
session_start ();
$url='https://oauth.vk.com/authorize?client_id='.$id_app.'&redirect_uri='.$url_script.'&response_type=code&scope=email';
header("Location: $url");
if  (!empty($_GET ['code']))  {
 $id_app     =     '6703231' ;                      //Айди приложения
 $secret_app =    'TFvwRA5v1aC2ICJuuBmW';         // Защищённый ключ. Можно узнать там же где и айди
 $url_script   =    'http://localhost/ABC/vk.php'; //ссылка на этот скрипт
 $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.$id_app.'&client_secret='.$secret_app.'&code='.$_GET['code'].'&redirect_uri='.$url_script), true);
 $fields       = 'first_name,last_name';
 $uinf = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids='.$token['user_id'].'&fields='.$fields.'&access_token='.$token['access_token'].'&v=5.80'), true); 
 //$_SESSION['name']         = $uinf['response'][0]['first_name'];
 //$_SESSION['name_family']  = $uinf['response'][0]['last_name'];
 //$_SESSION['uid']          = $token['user_id'];
 //$_SESSION['access_token'] = $token['access_token'];
$_SESSION['session_username']= $uinf['response'][0]['first_name'] . " " . $uinf['response'][0]['last_name'];
 require("constants.php");
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die(mysql_error());
    mysqli_query($db, "SET NAMES utf8");
    $vk_id=mysqli_real_escape_string($db, trim($token['user_id']));
    $token=mysqli_real_escape_string($db, trim($token['access_token']));
    $username = mysqli_real_escape_string($db, trim($uinf['response'][0]['first_name'] . " ". $uinf['response'][0]['last_name'] ));
            $query = "SELECT * FROM `users_vk` WHERE vk_id = '$vk_id'";
            $data = mysqli_query($db, $query);
            if(mysqli_num_rows($data) == 0) {
                $query ="INSERT INTO `users_vk` (vk_id,token, username) VALUES ('$vk_id','$token', '$username')";
                mysqli_query($db,$query);
                mysqli_close($db);
                header("Location: intropage.php");
            }
            if(mysqli_num_rows($data) == 1) {
                $query="UPDATE `users_vk` SET token='$token', username='$username'";
                mysqli_query($db, $query);
                mysqli_close($db);
                header("Location: /ABC/intropage.php");
            }
    }
?>