<?php

require("config.php");
$db=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);
?>

<!DOCTYPE html>
<html>

<head>

<title><?php echo $config_blogname; ?></title>
<link  rel="stylesheet" href="stylesheet.css" type="text/css">

</head>

<body>

<div id="header">
  <h1><?php // echo $config_blogname ?></h1> 
<a href="index.php">home</a>
</div>

<div id="main">
