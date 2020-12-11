<?php

class ControladorBanner {
    /****************************************************************
    * CREANDO UN REGISTRO NUEVO
    ********************************************************************/

    public function create($data) {
    
        if(ModelBanner::there_is_banner()){
            ModelBanner::updateBanner($data['nombre'], $data['img'], $data['link']);
        }else{
            ModelBanner::uploadBanner($data['nombre'], $data['img'], $data['link']);
        }

        $json = array(
            "status"  => 200,
            "DETAILS" => 'BANNERS SUBIDOS'
        );

        echo json_encode($json, true);

        return;
    }

    public function getBanners(){
        $banner = ModelBanner::getBanners();

        $json = json_encode($banner, true);

        return $json;
    }

}