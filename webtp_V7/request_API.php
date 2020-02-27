<?php
include("API.php");
$api = new API;

$api->init_post($_POST["dep"],$_POST["form"] ,$_POST["dis"]);

if ($_POST["dep"] != "" && $_POST["form"] == "" && $_POST["dis"] == "" ) // Recherche selon le département
{
  $urlForm = $api->init_dep();

}

else if ($_POST["form"] != "" && $_POST["dep"] == "" && $_POST["dis"] == ""  ) // Recherche selon le type de formation
{
  $urlForm = $api->init_form();
}

else if ($_POST["dis"] != "" && $_POST["dep"] == "" && $_POST["form"] == "" ) // Recherche selon la discipline
{
  $urlForm = $api->init_dis();
}

else if ($_POST["form"] != "" || $_POST["dis"] != "" || $_POST["dep"] != "" ) // Recherche selon le département et/ou le type de formation et/ou la discipline
{
  $urlForm = $api->init_three();
  
}


 ?>
