
<?php

    require("constants.php");
    session_start();
	if(isset($_SESSION["session_username"])){
    header("Location: intropage.php");
    }
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die(mysql_error());
    mysqli_query($db, "SET NAMES utf8");
    if(isset($_POST['register'])){
        $username = mysqli_real_escape_string($db, trim($_POST['username']));
        $email= mysqli_real_escape_string($db, trim($_POST['email']));
        $password1 = mysqli_real_escape_string($db, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($db, trim($_POST['password2']));
        if(!empty($username) && !empty($password1) && !empty($password2)&& !empty($email) ) {
            if($password1 == $password2){
            $query = "SELECT * FROM `users` WHERE username = '$username'";
            $data = mysqli_query($db, $query);
            if(mysqli_num_rows($data) == 0) {
                $query ="INSERT INTO `users` (username,email, password,auth_via) VALUES ('$username','$email', ('$password2'),'native')";
                mysqli_query($db,$query);
                $message = 'Всё готово, можете авторизоваться';
                mysqli_close($db);
                header("Location: login.php");
                echo "<script>alert(\"Введите данные!\");</script>";
            }
            else {
                $message = 'Логин уже существует';
            }
        }
        else {
            $message = 'Пароли не совпадают!';
        } 
        }
        else{
            $message = 'Не все поля заполнены!';
        }
    }
?>
<?php if (!empty($message)) {echo "<p class='error'>" . $message . "</p>";} ?>
<head>
    <meta charset="utf-8" />
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>    
    <div class="container mregister">
        <div id="login">
            <h1>Регистрация</h1>
            <form action="" id="registerform" method="POST" name="registerform">
                <p><label for="user_login">Имя пользователя<br>
                <input class="input" id="username" name="username" size="20" type="text" value=""></label></p>
                <p><label for="user_pass">E-mail<br>
                    <input class="input" id="email" name="email" size="32"type="email" value=""></label></p>
                <p><label for="user_login">Пароль<br>
                    <input class="input" id="password" name="password1" size="20" type="password" value=""></label></p>
                <p><label for="user_login">Повторите пароль<br>
                    <input class="input" id="password" name="password2" size="20" type="password" value=""></label></p><hr>
                <p class="submit"><input class="button" id="register" name="register" type="submit" value="Зарегистрироваться"></p>
                <p class="regtext">Уже зарегистрированны? <a href="login.php">Вход</a></p>
            </form>
        </div>
    </div>
</body>
</html>