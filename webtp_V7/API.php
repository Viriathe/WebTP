<?php
class API {


  private $url_basic = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=100&sort=-rentree_lib&facet=rentree_lib&facet=etablissement_type2&facet=etablissement_type_lib&facet=etablissement&facet=etablissement_lib&facet=champ_statistique&facet=dn_de_lib&facet=cursus_lmd_lib&facet=diplome_rgp&facet=diplome_lib&facet=typ_diplome_lib&facet=diplom&facet=niveau_lib&facet=disciplines_selection&facet=gd_disciscipline_lib&facet=discipline_lib&facet=sect_disciplinaire_lib&facet=spec_dut_lib&facet=localisation_ins&facet=com_etab&facet=com_etab_lib&facet=uucr_etab&facet=uucr_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=com_ins&facet=com_ins_lib&facet=uucr_ins&facet=dep_ins&facet=dep_ins_lib&facet=aca_ins&facet=aca_ins_lib&facet=reg_ins&facet=reg_ins_lib&refine.rentree_lib=2017-18";
  private $url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=dep_etab_lib&refine.rentree_lib=2017-18&apikey=e0b79b2bc585516ae85be6e4f041239153ea9aaf98c61724e6bc364e";
  private $url2 = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=diplome_lib&refine.rentree_lib=2017-18&apikey=e0b79b2bc585516ae85be6e4f041239153ea9aaf98c61724e6bc364e";
  private $url3="https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&sort=-rentree_lib&facet=sect_disciplinaire_lib&refine.rentree_lib=2017-18&apikey=e0b79b2bc585516ae85be6e4f041239153ea9aaf98c61724e6bc364e";
  private $dep = "";
  private $form = "" ;
  private $dis = "";
  private $apikey = "&apikey=e0b79b2bc585516ae85be6e4f041239153ea9aaf98c61724e6bc364e";

    public function init_post($post_dep,$post_form,$post_dis){
      $this->dep = $post_dep;
      $this->form = $post_form;
      $this->dis = $post_dis;
    }

    public function url_facet($i){
      if ($i == 1){
        return $this->url;
      }
      else if ($i == 2){
        return $this->url2;
      }
      else if ($i == 3){
        return $this->url3;
      }

    }

    public function init_dep(){
      return $this->url_basic."&refine.dep_etab_lib=".$this->dep.$this->apikey;
    }

    public function init_dis(){
      return  $this->url_basic."&refine.sect_disciplinaire_lib=".$this->dis.$this->apikey;
    }

    public function init_form(){
      return $this->url_basic."&refine.diplome_lib=".$this->form.$this->apikey;
    }
    public function init_three(){
      if ($this->dep == ""){
        return $this->url_basic."&refine.diplome_lib=".$this->form."&refine.sect_disciplinaire_lib=".$this->dis.$this->apikey;
      }
      else if ($this->dis == ""){
        return $this->url_basic."&refine.diplome_lib=".$this->form."&refine.dep_etab_lib=".$this->dep.$this->apikey;
      }
      else if ($this->form == ""){
        return $this->url_basic."&refine.dep_etab_lib=".$this->dep."&refine.sect_disciplinaire_lib=".$this->dis.$this->apikey;
      }else {
        return $this->url_basic."&refine.diplome_lib=".$this->form."&refine.sect_disciplinaire_lib=".$this->dis."&refine.dep_etab_lib=".$this->dep.$this->apikey;
      }

    }







}





 ?>
