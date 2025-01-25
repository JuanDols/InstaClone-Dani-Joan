<?php
session_start();
require 'db_connection.php';
if(isset($_GET["photoid"]) && isset($_GET["userid"])){
    //comprobar que el usuario que accede a pagina eliminar foto sea el mimsmo que está logeado en la sesion actual
    if($_GET["userid"] == $_SESSION["logged_id"]){
        $sql = "DELETE FROM photos WHERE id = ".$_GET["photoid"];
        $result = execQuery(getDbConnection(), $sql);
        if(!$result){
            //error al eliminar
        }
        header('Location: profile.php');
        exit();
    }
}else{
    header('Location: index.php');
    exit();
}