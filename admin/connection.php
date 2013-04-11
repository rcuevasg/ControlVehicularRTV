<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

try
{
    $host = "127.0.0.1";
    $dbname = "BD_RTV_CONTROL_VEHICULAR";
    //$dbname = "rcgdesar_ctv";
    //$user = "dante";
    $user = "root";
    $pass = "";
    //$pass = "";
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $ex)
{
    print $ex->getMessage();
}

?>
