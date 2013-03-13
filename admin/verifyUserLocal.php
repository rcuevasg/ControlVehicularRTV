<?php
header('Content-Type: text/html; charset=UTF-8');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$usuario = "";
$password = "";

if (isset ($_POST['txtUser']))
{
    $usuario = $_POST['txtUser'];
}

if (isset ($_POST['txtPassword']))
{
    $password = $_POST['txtPassword'];
}

//print $usuario . " " . $password;

include "utilitiesUsuarios.php";

$userLogged = logueaUsuario($usuario, $password);

//print "Datos usuario: $userLogged";

if (!empty ($userLogged))
{
    //Logueo exitoso
    $dataUser = explode("|", $userLogged);

    $id = $dataUser[0];
    $nombre = $dataUser[1];
    $email = $dataUser[2];
    $tipoUsuario = $dataUser[3];

    
    session_start();
    $_SESSION['idUsuario'] = $id;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['email'] = $email;
    $_SESSION['tipoUsuario'] = $tipoUsuario;

    //header("Location: http://ciapemregional.veracruz.gob.mx/sistema-ciapem/");
    print "admin/index.php";
}
else
{
    //Logueo incorrecto
    //print "<script> document.location = 'login.php?err=1'; </script>";
    //print "Usuario: " . $usuario . " password:" . $password;
    print "<div class='error'>Usuario incorrecto</div> ";
    //header("Location: http://ciapemregional.veracruz.gob.mx/usuario-no-registrado/");
}

?>