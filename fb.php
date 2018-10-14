<?php
session_start ();
$id_app     =  '252174675488543';
$secret_app =   'a01c2c457fe7d4eb02daf240e6fad0f8';
$url_script = 'http://localhost/ABC/fb.php';
$url= 'https://graph.facebook.com/oauth/authorize?client_id='.$id_app.'&scope=user_events,email&redirect_uri='.$url_script;
header("Location: $url");
if  (!empty($_GET ['code']))  {
$token = json_decode(file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.$id_app.'&client_secret='.$secret_app.'&code='.$_GET['code'].'&redirect_uri='.$url_script), true);
$fields       = 'id,first_name,last_name';

$unif = json_decode(file_get_contents('https://graph.facebook.com/v2.9/me?client_id='.$id_app.'&redirect_uri='.$url_script.'&client_secret='.$secret_app.'&code='.$_GET['code'].'&access_token='.$token['access_token'].'&fields=id,name,email,gender,location'), true);  

    $_SESSION['session_username']=$unif['name'] ;
    require("constants.php");
       $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die(mysql_error());
       mysqli_query($db, "SET NAMES utf8");
       $email=mysqli_real_escape_string($db, trim($unif['email']));
       $fb_id=mysqli_real_escape_string($db, trim($unif['id']));
       $token=mysqli_real_escape_string($db, trim($token['access_token']));
       $username = mysqli_real_escape_string($db, trim($unif['name']));
               $query = "SELECT * FROM `users` WHERE social_id = '$fb_id'";
               $data = mysqli_query($db, $query);
               if(mysqli_num_rows($data) == 0) {
                $query ="INSERT INTO `users` (email, username,auth_via,social_id) VALUES ('$email','$username','fb' ,'$fb_id')";
                   mysqli_query($db,$query);
                   $_SESSION['session_user_id']=mysqli_insert_id($db);
               }
               else if(mysqli_num_rows($data) == 1){
                $row = mysqli_fetch_row($data);
                $_SESSION['session_user_id']=$row[0];
                if($email!=$row[1]){
                    $query="UPDATE `users` SET email='$email' WHERE social_id = '$fb_id'";
                    mysqli_query($db, $query);
                }
                if($username!=$row[2]){
                    $query="UPDATE `users` SET username='$username'WHERE social_id = '$fb_id'";
                    mysqli_query($db, $query);
                }
            }

               mysqli_close($db);
                   header("Location: /ABC/intropage.php");
            }
?>