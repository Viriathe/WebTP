<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FormationSup</title>
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
      <h4>FormationSup</h4>
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
<?php
  $url= "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=dep_etab_lib&refine.rentree_lib=2017-18";
  $json = file_get_contents($url);
  $parsed_json = json_decode($json,true);

?>

<div class="form">
  <h4><i class="fas fa-filter"></i> Sélectionner des critères</h4>

  <form class="field" id="field" action="home.php" method="post" >
    <select class="select" id="select" name="dep" >
      <option value="0">Départements</option>
      <option value="1">re</option>
      <?php
      $facetDep = $parsed_json["facet_groups"][0]["facets"] ;
      $arrayString = array();

      foreach ($facetDep as $dep) {
        array_push($arrayString,$dep["name"]);

      }
      sort($arrayString);
      foreach ($arrayString as $key => $val) {
        echo "<option value ='$val'>".$val."</option>";
      }
      ?>



    </select>

  <?php
  $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=diplome_lib&refine.rentree_lib=2017-18";
  $json = file_get_contents($url);
  $parsed_json = json_decode($json,true);
   ?>


    <select class="select" name="form">
      <option value="">Type de formations</option>
      <?php
      $facetForm = $parsed_json["facet_groups"][0]["facets"] ;
      foreach ($facetForm as $form) {
        $val = $form["name"];
        echo "<option value ='$val'>".$form["name"]."</option>";
      }

      ?>
    </select>

  <?php
  $url="https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=sect_disciplinaire_lib&refine.rentree_lib=2017-18";
  $json = file_get_contents($url);
  $parsed_json = json_decode($json,true);
   ?>

    <select class="select" name="dis">
      <option value="">Discipline</option>
      <?php
      $facetDis = $parsed_json["facet_groups"][0]["facets"] ;
      foreach ($facetDis as $dis) {
        $val = $dis["name"];
        echo "<option value ='$val'>".$dis["name"]."</option>";
      }

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


              <?php

            echo $_POST["dep"];
            if (isset($_POST["dep"])){
                $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.dep_etab_lib=".$_POST['dep'];

            }

            echo $_POST["dep"];
            $json = file_get_contents($url);
            $parsed_json = json_decode($json,true);
              foreach ($parsed_json["records"] as $resul) {
                echo "<button  class='accordion'><i class='fas fa-university'></i>".$parsed_json["fields"]["diplome_lib"];
                echo "</button>";
                echo "<div class='accordion-content'>";
                echo "<h4>Détail</h4>";
                echo "<p>blabla</p>";
                echo "</div>";

              }

          ?>
    </ul>
    <!--/////////////////////////////////////////////////////////////////////////-->

  </div>
<!--////////////////////////////////// Lien JS //////////////////////////////-->
<script src="accordian.js"></script>
<script src="form.js"></script>
<!--/////////////////////////////////////////////////////////////////////////-->
<footer>
  <p><i class="far fa-copyright"></i>  Tony Pereira</p>

</footer>
</body>






</html>
