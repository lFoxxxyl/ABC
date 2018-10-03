<?php 
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
	                 $message = "Неверный логин или пароль!";
                }
    } 
    else {
        $message = "Не все поля заполнены!";
	}
    }
?>
<?php if (!empty($message)) {echo "<p class='error'>" . $message . "</p>";} 
?>
<head>
    <meta charset="utf-8" />
    <title>Вход</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="container mlogin">
        <div id="login">
            <h1>Вход</h1><hr>
            <form action="" id="loginform" method="POST" name="loginform">
                <p><label for="user_login">Имя пользователя<br>
                <input class="input" id="username" name="username" size="20" type="text" value=""></label></p>
                <p><label for="user_login">Пароль<br>
                <input class="input" id="password" name="password" size="20" type="password" value=""></label></p><hr>
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