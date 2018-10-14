<?php

  session_start();

if(!isset($_SESSION["session_username"])):
header("location:login.php");
else:

    require("constants.php");
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die(mysql_error());
    mysqli_query($db, "SET NAMES utf8");
    if(isset($_POST['submit'])){
        $text = mysqli_real_escape_string($db, trim($_POST['text']));
        date_default_timezone_set('europe/moscow');
        $date=date("Y-m-d H:i:s");
        $id=$_SESSION["session_user_id"];
        if(!empty($text)) {
                $query ="INSERT INTO `notes` (user_id,note,date) VALUES ('$id','$text','$date')";
                mysqli_query($db,$query);
                //exit('<meta http-equiv="refresh" content="0; url=intropage.php" />');
                header("location:intropage.php");
            }
    }

    $query = "SELECT * FROM notes, users WHERE notes.user_id=users.user_id  ORDER BY notes.note_id DESC";
    $data=mysqli_query($db,$query);
    mysqli_close($db);

?>
<?php if (!empty($message)) {echo "<p class='error'>" . $message . "</p>";} 
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
    
  <h1>Новая заметка <a class="closepopup" href="javascript:PopUpHide()">✖</a></h1>
            <form action="" id="note" method="POST" name="noteform">
                <p><label for="user_login">Текст заметки
                <textarea class="textarea" id="text" name="text"></textarea></p>
                <p class="submit"><input class="button"id="button" name="submit" type="submit" value="Создать"></p>
            </form>
            </div>
    
    </div>
</div> 
<div class="sidebar">

<div class="inner-sidebar">
    <h1>Последние заметки</h1>
</div>
<?php foreach ($data as $row): ?>
    <div class="inner-sidebar">
        
    
    <div>
    <h2><span><?=$row['username']?></span><?=$row['date']?></h2>
        <p><?=nl2br(htmlspecialchars($row['note']))?> </p> 
    </div>

    </div><?php endforeach ?>
</div> 
<div class="content">
    <div class="inner-content" >
        <h1>Мои заметки</h1>
        <!--<h2>Новая заметка</h2>
        <script>function textAreaAdjust(o) {
        o.style.height = "10px";
        o.style.height = (25+o.scrollHeight)+"px";
    }</script>
        <textarea onkeyup="textAreaAdjust(this)" style="overflow:hidden" rows=1></textarea>
       <input  name="submit" type="submit" value="Создать">-->
</div>
    <?php foreach ($data as $row): ?>
    <div class="inner-content">
    <?php if ($row['user_id']==$_SESSION["session_user_id"]): ?>
         <h2><?=$row['username']?><span><?=$row['date']?><a  href="javascript:PopUpShow()">✎</a>
         <a  href="delete.php?id=<?=$row['note_id']?>">✖</a></span></h2>
        <p><?=nl2br(htmlspecialchars($row['note']))?> </p> 
    <?php endif ?>
    </div>
    <?php endforeach ?>

</div> 
</body>
<?php endif; ?>