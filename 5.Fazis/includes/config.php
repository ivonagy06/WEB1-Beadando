<?php
$servername = "localhost";
$username = "fecske";
$password = "Admin2004";
$dbname = "fecske";

$conn = new mysqli($servername, $username, $password, $dbname);
$menu = array(
    '/' => array('fajl' => 'index', 'szoveg' => 'Főoldal', 'menun' => array(0,1)),
    'gondozottak' => array('fajl' => 'gondozottak', 'szoveg' => 'Gondozottak', 'menun' =>array(1,1)),
    'elerhetoseg' => array('fajl' => 'elerhetoseg', 'szoveg' => 'Elérhetőség', 'menun' => array(1,1)),
    'regisztralas' => array('fajl' => 'regisztralas', 'szoveg' => 'Regisztrálás', 'menun' => array(1,1)),
    'display_images' => array('fajl' => 'display_images', 'szoveg' => 'Kép Galéria', 'menun' => array(1,1)),
    'display_messages' => array('fajl' => 'display_messages', 'szoveg' => 'Üzenetek', 'menun' => array(1,1)),
    'messages' => array('fajl' => 'messages', 'szoveg' => 'Kapcsolat', 'menun' => array(1,1)),
    'uploaded' => array('fajl' => 'uploaded', 'szoveg' => 'Kép Feltöltése', 'menun' => array(1,1)),
    'belepes' => array('fajl' => 'belepes', 'szoveg' => 'Belépés', 'menun' =>array(0,0)),
    '404' => array('fajl' => '404', 'szoveg' => '404', 'menun' => array(0,0)),
);



$hiba_oldal = array ('fajl' => '404', 'szoveg' => 'A keresett oldal nem található!');
?>