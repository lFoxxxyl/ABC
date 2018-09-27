<?php
session_start ();
$id_app     =  '252174675488543';
$secret_app =   'a01c2c457fe7d4eb02daf240e6fad0f8';
$url_script = 'http://localhost/ABC/fb.php';
$url= 'https://graph.facebook.com/oauth/authorize?client_id='.$id_app.'&scope=user_events&redirect_uri='.$url_script;
header("Location: $url");
if  (!empty($_GET ['code']))  {
$token = json_decode(file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.$id_app.'&client_secret='.$secret_app.'&code='.$_GET['code'].'&redirect_uri='.$url_script), true);
$fields       = 'id,first_name,last_name';

$unif = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$token['access_token']), true);  

    $_SESSION['session_username']=$unif['name'] ;
    require("constants.php");
       $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die(mysql_error());
       mysqli_query($db, "SET NAMES utf8");
       $fb_id=mysqli_real_escape_string($db, trim($unif['id']));
       $token=mysqli_real_escape_string($db, trim($token['access_token']));
       $username = mysqli_real_escape_string($db, trim($unif['name']));
               $query = "SELECT * FROM `users_fb` WHERE fb_id = '$fb_id'";
               $data = mysqli_query($db, $query);
               if(mysqli_num_rows($data) == 0) {
                   $query ="INSERT INTO `users_fb` (fb_id,token, username) VALUES ('$fb_id','$token', '$username')";
                   mysqli_query($db,$query);
                   mysqli_close($db);
                   header("Location: /ABC/intropage.php");
               }
               else if(mysqli_num_rows($data) == 1) {
                   $query="UPDATE `users_fb` SET token='$token', username='$username'";
                   mysqli_query($db, $query);
                   mysqli_close($db);
                   header("Location: /ABC/intropage.php");
               }
            }
?>