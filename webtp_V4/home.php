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
      <option value="">Départements</option>
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
      $arrayString = array();

      foreach ($facetForm as $form) {
        array_push($arrayString,$form["name"]);

      }
      sort($arrayString);
      foreach ($arrayString as $key => $val) {
        echo "<option value ='$val'>".$val."</option>";
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
      $arrayString = array();

      foreach ($facetDis as $dis) {
        array_push($arrayString,$dis["name"]);

      }
      sort($arrayString);
      foreach ($arrayString as $key => $val) {
        echo "<option value ='$val'>".$val."</option>";
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
    <br>
    <ul class="list">
          <li><i class="fas fa-search"></i> Liste des résultats</li>
              

              <?php
            if (isset($_POST["dep"]) || isset($_POST["form"] )|| isset($_POST["dis"] ) ){
            if ($_POST["dep"] != "" && $_POST["form"] == "" && $_POST["dis"] == "" ) // Recherche selon le département
            {
                $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.dep_etab_lib=".$_POST['dep'];
            }     
            
            if ($_POST["form"] != "" && $_POST["dep"] == "" && $_POST["dis"] == ""  ) // Recherche selon le type de formation
            {
              $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.diplome_lib=".$_POST['form'];
            }

            if ($_POST["dis"] != "" && $_POST["dep"] == "" && $_POST["form"] == "" ) // Recherche selon la discipline
            {
              $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.sect_disciplinaire_lib=".$_POST['dis'];
            }

            if ($_POST["dep"] != "" && $_POST["form"] != "" && $_POST["dis"] == "" ) // Recherche selon le département et le type de formation
            {
              $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.dep_etab_lib=".$_POST['dep']."&refine.diplome_lib=".$_POST['form'];
            }

            if ($_POST["dep"] != "" && $_POST["dis"] != "" && $_POST["form"] == "" ) // Recherche selon le département et la discipline
            {
              $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.dep_etab_lib=".$_POST['dep']."&refine.sect_disciplinaire_lib=".$_POST['dis'];
            }

            if ($_POST["form"] != "" && $_POST["dis"] != "" && $_POST["dep"] == "" ) // Recherche selon le type de formation et la discipline
            {
              $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.sect_disciplinaire_lib=".$_POST['dis']."&refine.diplome_lib=".$_POST['form'];
            }

            if ($_POST["form"] != "" && $_POST["dis"] != "" && $_POST["dep"] != "" ) // Recherche selon le département, le type de formation et la discipline
            {
              $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18&refine.sect_disciplinaire_lib=".$_POST['dis']."&refine.diplome_lib=".$_POST['form']."&refine.dep_etab_lib=".$_POST['dep'];
            }
          }
            $url2 = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=60&sort=uo_lib&refine.type_d_etablissement=Universit%C3%A9";
            $json = file_get_contents($url);
            $json2 = file_get_contents($url2);
            $parsed_json = json_decode($json,true);
            $parsed_json2 = json_decode($json2,true);
            $arrayCoor = array();
            $arrayUniv = array();
            $arrayUrl = array();
            echo "<li>".count($parsed_json["records"]). " resultat(s) </li>";
              foreach ($parsed_json["records"] as $resul) {
                foreach ($parsed_json2["records"] as $resul2) {
                  if($resul2["fields"]["uo_lib"] ==$resul['fields'][ 'etablissement_lib' ] ){
                           array_push($arrayCoor,$resul2["fields"]["coordonnees"]);
                           array_push($arrayUniv,$resul2["fields"]["uo_lib"]);
                           array_push($arrayUrl,$resul2["fields"]["url"]);
                  }
                }
                  echo "<button  class='accordion'><i class='fas fa-university'></i>"." ".$resul["fields"][ 'diplome_lib' ]." : ".$resul["fields"][ 'sect_disciplinaire_lib' ]." ( ".$resul["fields"][ 'niveau_lib' ]." )" ;
                  echo "</button>";
                  echo "<div class='accordion-content'>";
                  echo "<br>";
                  echo "<h4><i class='fas fa-bookmark'></i>   ".$resul['fields'][ 'discipline_lib' ]."</h4>";
                  echo "<p>".$resul['fields'][ 'etablissement_lib' ]."</p>";
                  echo "<p>".$resul['fields'][ 'com_etab_lib' ]." (".$resul['fields'][ 'com_ins' ].") ".$resul['fields'][ 'reg_etab_lib' ]." | ".$resul['fields'][ 'dep_etab_lib' ]."</p>";
                  echo "<br>";
                  echo "</div>";
                
                      
                    
              }
              $coor = array_unique($arrayCoor,SORT_REGULAR);
              $univ = array_unique($arrayUniv,SORT_REGULAR);
              $url = array_unique($arrayUrl,SORT_REGULAR);
              echo "\n<script>\n";
              foreach($coor as $key => $val){
               
                echo "var marker".$key."= L.marker([".$val[0].",".$val[1]."]).addTo(mymap);\n"; 
                
              }
              echo "</script>";

            
            
            
            
            
              
            
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
  <p><i class="far fa-copyright"></i>  Tony Pereira</p>

</footer>
</body>






</html>
