<?php

  session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:
?>
<head>
<meta charset="utf-8" />
    <title>Главная</title>
  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
  <link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<header>
<p><?php echo $_SESSION['session_username'];?>
<a  href="logout.php"><span>Выйти</span></a></p>
</header>
<body>
<div class="container nem_note">
  <div id="note">
  <h1>Новая заметка</h1><hr>
            <form action="" id="loginform" method="POST" name="loginform">
                <p><label for="user_login">Введите название<br>
                <input class="input"  size="20" type="text" value=""></label></p>
                <p><label for="user_login">Текст
                <textarea class="textarea" name="text"></textarea></p>
                <p class="submit"><input class="button" name="submit" type="submit" value="Создать"></p>
            </form>
            </div>
            </div> 
                  
</body>
<?php endif; ?>