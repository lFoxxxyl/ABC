
<?php
    include("includes/header.php");
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
        if(!empty($username) && !empty($password1) && !empty($password2)&& !empty($email) && ($password1 == $password2)) {
            $query = "SELECT * FROM `users` WHERE username = '$username'";
            $data = mysqli_query($db, $query);
            if(mysqli_num_rows($data) == 0) {
                $query ="INSERT INTO `users` (username,email, password) VALUES ('$username','$email', ('$password2'))";
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
    }
?>
<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>
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
                    <input class="input" id="password" name="password2" size="20" type="password" value=""></label></p>
                <p class="submit"><input class="button" id="register" name="register" type="submit" value="Зарегистрироваться"></p>
                <p class="regtext">Уже зарегистрированны? <a href="login.php">Вход</a></p>
            </form>
        </div>
    </div>
</body>
</html>