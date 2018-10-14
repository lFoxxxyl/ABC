<?php

if(isset($_GET['id']))
{   
    require("constants.php");
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME) or die(mysql_error());
    $id = mysqli_real_escape_string($db, $_GET['id']);
     
    $query ="DELETE FROM notes WHERE note_id = '$id'";
 
    $result = mysqli_query($db, $query) or die("Ошибка " . mysqli_error($db)); 
    mysqli_close($db);
}
header("location:intropage.php");
?>