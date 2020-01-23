<?php
  include("fonction.php");
  include("request_API.php");
  $url= "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=dep_etab_lib&refine.rentree_lib=2017-18";
  $parsed_json = parse($url);
  if ($parsed_json == ""){
    header('Location: errorAPI.html');
  }
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $url2 = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=diplome_lib&refine.rentree_lib=2017-18";
  $parsed_json2 = parse($url2);
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $url3="https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=sect_disciplinaire_lib&refine.rentree_lib=2017-18";
  $parsed_json3 = parse($url3);
?>
<!--
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FormationSup</title>
  <link rel="icon" type="image/png" href="favicon.png" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="accordian.css">
  <!-- Lien Font & Icon -->
  <link href="https://fonts.googleapis.com/css?family=DM+Serif+Text&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/45e9b89d09.js" crossorigin="anonymous"></script>

  <!-- Lien CSS & JS Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
</head>

<body>
  <!--////////////////////////// Barre de navigation //////////////////////////-->
  <nav>
    <div class="brand">
      <h4>Format<i class="fas fa-info-circle"></i>onSup</h4>
    </div>
    <!--
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">Home</a></li>
      <li><a href="#">Home</a></li>
      <li><a href="#">Home</a></li>
    </ul>
    -->
  </nav>
  <!--/////////////////////////////////////////////////////////////////////////-->

  <h4 class="title">Trouver ma formation</h4>
  <!--///////////////////////////// Formulaire ////////////////////////////////-->

<div class="form">
  <h4><i class="fas fa-filter"></i> Sélectionner des critères</h4>

  <form class="field" id="field" action="index.php" method="post" >
    <!--
    ////////////////////////////////////////////////////////////////////////////
    // Départements
  -->
    <select class="select" id="select" name="dep" >
      <option value="">Départements</option>
      <?php
      funct_facet($parsed_json);
      ?>

    </select>
    <!--
    ////////////////////////////////////////////////////////////////////////////
    //Type de formation
  -->
    <select class="select" name="form">
      <option value="">Type de formations</option>
      <?php
      funct_facet($parsed_json2);


      ?>
    </select>
    <!--
    ////////////////////////////////////////////////////////////////////////////
    // Discipline
    -->
    <select class="select" name="dis">
      <option value="">Discipline</option>
      <?php
      funct_facet($parsed_json3);
      ?>
    </select>
    <input type = "submit" value ="Rechercher"/>
  </form>


  </div>
  <hr>
  <!--/////////////////////////////////////////////////////////////////////////-->
  <!--/////////////////////////////////////////////////////////////////////////-->

  <div class="result">
    <!--///////////////////////////////Map Leaflet///////////////////////////////-->
    <div id="mapid">
      <script>
          var mymap = L.map('mapid').setView([46.343210, 2.603194], 6);

          	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
          		maxZoom: 18,
          		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
          		id: 'mapbox.streets'
              }).addTo(mymap);

      </script>
    </div>
    <!--/////////////////////////////////////////////////////////////////////////-->
    <!--///////////////////////////////Liste resultat////////////////////////////-->

    <ul class="list">
          <li><i class="fas fa-search"></i> Liste des résultats</li>
              <br>
              <?php

                $url2 = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=60&sort=uo_lib&refine.type_d_etablissement=Universit%C3%A9";
                $parsed_json = parse($urlForm);
                $parsed_json2 = parse($url2);
                $arrayCoor = array();
                $arrayUniv = array();
                $arrayUrl = array();
                echo "<p>".count($parsed_json["records"]). " resultat(s) </p>";
                create_accordian($parsed_json,$parsed_json2,$arrayCoor,$arrayUniv,$arrayUrl);
                $coor = array_unique($arrayCoor,SORT_REGULAR);
                $univ = array_unique($arrayUniv,SORT_REGULAR);
                $url = array_unique($arrayUrl,SORT_REGULAR);
                create_popup($corr,$univ,$url);
              ?>
    </ul>
    <!--/////////////////////////////////////////////////////////////////////////-->

  </div>

<!--////////////////////////////////// Lien JS //////////////////////////////-->
<script src="accordian.js"></script>
<script src="form.js"></script>
<!--/////////////////////////////////////////////////////////////////////////-->
<br>
<footer>
  <p>  Tony Pereira   <a href = "https://github.com/Viriathe/Webtp" target="aboutblank"><i class="fab fa-github"></i></p>

</footer>
</body>






</html>
