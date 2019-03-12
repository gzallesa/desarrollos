<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jsonProsp
 *
 * @author Irra_b
 */
class jsonProsp {

    public function slider() {
        try {
            //$articulos = simplexml_load_string(file_get_contents('http://www.jornadanet.com/rss/Portada.xml'));
            //http://www3.abi.bo/rss/abi.xml
            $json = file_get_contents('http://www.oopp.gob.bo/index.php/getNews/banner');
            $v = json_decode($json);
            $fp = fopen('import/noticias.json', 'w');
            fwrite($fp, json_encode($v));
            fclose($fp);
        } catch (Exception $ex) {
            var_dump($ex);
            $v = null;
        }
    }
    public function news() {
        try {
            //$articulos = simplexml_load_string(file_get_contents('http://www.jornadanet.com/rss/Portada.xml'));
            //http://www3.abi.bo/rss/abi.xml
            $json = file_get_contents('http://www.oopp.gob.bo/index.php/getNews');
            $v = json_decode($json);
            $fp = fopen('import/news.json', 'w');
            fwrite($fp, json_encode($v));
            fclose($fp);
        } catch (Exception $ex) {
            var_dump($ex);
            $v = null;
        }
    }
    public function monitoreo() {
        $a = array();
        $b = array(
            'http://www3.abi.bo/rss/abi.xml',
            'http://www.jornadanet.com/rss/Portada.xml',
            'http://www.lostiempos.com/rss/lostiempos-titulares.xml',
        );
        try {
            $patron = '/vivienda|obras públicas|teleférico|unasur|polideportivo|camino|caminos|abc|boa|sabsa|entel|ecobol|att/';
            foreach ($b as $value) {
                $articulos = simplexml_load_string(file_get_contents($value));
                foreach ($articulos->channel->item as $value2) {
                    if (preg_match($patron, strtolower($value2->title))) {
                        array_push($a, $value2);
                    }
                }
            }
            if(count($a)>0)
            {
                $fp = fopen('import/rss.json', 'w');
                fwrite($fp, json_encode($a));
                fclose($fp);
            }
        } catch (Exception $ex) {
            $v = null;
        }
    }

}
