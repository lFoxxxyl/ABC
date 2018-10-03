<?php

  session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:




?>

<script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
<script>
    $(document).ready(function(){
        //Скрыть PopUp при загрузке страницы    
        PopUpHide();
    });
    //Функция отображения PopUp
    function PopUpShow(){
        $("#popup1").show();
    }
    //Функция скрытия PopUp
    function PopUpHide(){
        $("#popup1").hide();
    }
</script>

<head>
<meta charset="utf-8" />
    <title>Главная</title>
  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
  <link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<header>
    <div class="huser">
<?php echo $_SESSION['session_username'];?>
</div>
<a class="hbutton" href="logout.php">Выйти</a>
<a class="hbutton" href="javascript:PopUpShow()">Создать заметку</a>
</header>
<body>
<div class="b-popup" id="popup1">
    <div class="container nem_note">
    <div id="note">
    
  <h1>Новая заметка <a class="closepopup" href="javascript:PopUpHide()"><span>×</span></a></h1>
  <hr>
            <form action="" id="note" method="POST" name="noteform">
                <p><label for="user_login">Текст заметки
                <textarea class="textarea" name="text"></textarea></p>
                <p class="submit"><input class="button" name="submit" type="submit" value="Создать"></p>

            </form>
            </div>
    
    </div>
</div>       
</body>
<?php endif; ?>