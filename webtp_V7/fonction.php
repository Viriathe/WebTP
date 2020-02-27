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

function create_accordian($parse,$parse2){
  $array1 = array();
  $array2 = array();
  $array3 = array();
  foreach ($parse["records"] as $resul) {
    foreach ($parse2["records"] as $resul2) {
      if($resul2["fields"]["uo_lib"] == $resul['fields'][ 'etablissement_lib' ] ){
             array_push($array1,$resul2["fields"]["coordonnees"]);
             array_push($array2,$resul2["fields"]["uo_lib"]);
             array_push($array3,$resul2["fields"]["url"]);

      }
    }
      $string = $resul['fields']['etablissement_lib'];
      echo "<button  class='accordion'><i class='fas fa-university'></i>"." ".$resul["fields"][ 'diplome_lib' ]." : ".$resul["fields"][ 'sect_disciplinaire_lib' ]." ( ".$resul["fields"][ 'niveau_lib' ]." )" ;
      echo "</button>";
      echo "<div class='accordion-content'>";
      echo "<br>";
      echo "<h4><i class='fas fa-bookmark'></i>   ".$resul['fields'][ 'discipline_lib' ]."</h4>";
      echo "<h5>".$resul['fields'][ 'etablissement_lib' ].getLink($string,$array2,$array3)."</h5>";
      echo "<p>".$resul['fields'][ 'com_etab_lib' ]." (".$resul['fields'][ 'com_ins' ].") ".$resul['fields'][ 'reg_etab_lib' ]." | ".$resul['fields'][ 'dep_etab_lib' ]."</p>";
      echo "<canvas id = '".$string."' width='400' height='400'></canvas>";
      createChart($string);
      echo "<br>";
      echo "</div>";



  }
  $final_array = array();
  array_push($final_array,$array1,$array2,$array3);
  return $final_array;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getLink($string,$array2,$array3){
  foreach($array2 as $key => $val){
    if ($val == $string){
      return " <a href= '".$array3[$key]."'><i class='fas fa-eye'></i></a> ";
    }
  }
  return "    <i class='fas fa-eye-slash'></i> 0 ";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function update_compteur($string){
  $json = file_get_contents("data.json");
  $json_decode = json_decode($json);
  $empty = true;
  foreach ($json_decode as $key => $value) {
        if ($key == $string ){
          
        }
  }
  if ($empty){
    $array = array(
      $string => 0;
    );
    array_push($json_decode,$array);
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function createChart($string){
  echo "<script>";
  echo "var ctx = document.getElementById(".$string.").getContext('2D')";
  echo "var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 0.5
          }]
      },
      options: {
        responsive : false
      }
  });";
  echo "</script>";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function create_popup($array1,$array2,$array3){
  echo "\n<script>\n";
  foreach($array1 as $key => $val){
    echo 'L.marker(['.$val[0].', '.$val[1].']).addTo(mymap).bindPopup("'.$array2[$key].'</b>");';

  }
  echo "</script>";
  echo "";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 ?>
