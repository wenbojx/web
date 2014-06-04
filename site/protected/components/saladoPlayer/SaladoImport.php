<?php
class SaladoImport{

    public function analyze_file($path){
        if(!file_exists($path)){
            return false;
        }
        $string = file_get_contents($path);

    }
    private function read_file($path){

    }
    private function analyze_modules($datas){

    }
    private function analyze_global(){

    }
    private function analyze_actions(){

    }
    private function analyze_panorams(){

    }
    private function analyze_modules(){

    }
}