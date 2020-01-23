<?php
function parse($url){
  $js = file_get_contents($url);
  $parsed = json_decode($js,true);
  return $parsed;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function funct_facet($parsed){
  $arrayString = array();
  $facet = $parsed["facet_groups"][0]["facets"] ;


  foreach ($facet as $d) {
    array_push($arrayString,$d["name"]);

  }
  sort($arrayString);
  foreach ($arrayString as $key => $val) {
    echo "<option value ='$val'>".$val."</option>";
  }

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function create_accordian($parse,$parse2,$array1,$array2,$array3){
  foreach ($parse["records"] as $resul) {
    foreach ($parse2["records"] as $resul2) {
      if($resul2["fields"]["uo_lib"] ==$resul['fields'][ 'etablissement_lib' ] ){
               array_push($array1,$resul2["fields"]["coordonnees"]);
               array_push($array2,$resul2["fields"]["uo_lib"]);
               array_push($array3,$resul2["fields"]["url"]);
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
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function create_popup($array1,$array2,$array3){
  echo "\n<script>\n";
  foreach($array1 as $key => $val){

    echo "var marker".$key."= L.marker([".$val[0].",".$val[1]."]).addTo(mymap).bindPopup('".$array2[$key]."<br><a href =".$array3[$key].">".$array3[$key]."');\n";

  }
  echo "</script>";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 ?>
