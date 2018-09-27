<?php
    include("includes/header.php"); 
    session_start();
    
    require("constants.php");
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or DIE('Ошибка подключения к базе данных');
    mysqli_query($db, "SET NAMES utf8");
	if(isset($_SESSION["session_username"])){
    header("Location: intropage.php");
    }

    
    if(isset($_POST['login'])){
	    if(!empty($_POST['username']) && !empty($_POST['password'])) {
	        $username=mysqli_real_escape_string($db, trim($_POST['username']));
	        $password=mysqli_real_escape_string($db, trim($_POST['password']));
            $query = "SELECT * FROM `users` WHERE username = '$username' AND password = ('$password')";
            $data=mysqli_query($db,$query);
	            if(mysqli_num_rows($data)==1){
                    while($row=mysqli_fetch_assoc($data)){
	                    $dbusername=$row['username'];
                        $dbpassword=$row['password'];
                        
                    }              
                    if($username == $dbusername && $password == $dbpassword){

	                    $_SESSION['session_username']=$username;	 
                        /* Перенаправление браузера */
                        header("Location: intropage.php");
	                }
                } 
                else {
	                 $message = "Invalid username or password!";
                }
    } 
    else {
        $message = "All fields are required!";
	}
    }
?>
<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} 
?>
    <div class="container mlogin">
        <div id="login">
            <h1>Вход</h1>
            <form action="" id="loginform" method="POST" name="loginform">
                <p><label for="user_login">Имя пользователя<br>
                <input class="input" id="username" name="username" size="20" type="text" value=""></label></p>
                <p><label for="user_login">Пароль<br>
                <input class="input" id="password" name="password" size="20" type="password" value=""></label></p>
                <p class="submit"><input class="button" name="login" type="submit" value="Войти"></p>
                <p class="regtext">Ещё не зарегистрированны? <a href="register.php">Регистрация</a></p>
            </form>
            <p><a href="vk.php" title="Вход через ВК">
            <img src="img/vk.png" alt="Вк" title ="Вк"></a>
            <a href="fb.php" title="Вход через facebook">
            <img src="img/fb.png" alt="Facebook" title ="Facebook"></a></p>
        </div>
    </div>
</body>
</html>