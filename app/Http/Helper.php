<?php

if (! function_exists('generateRandomString')) {
    function generateRandomString($length_of_string) {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle($str_result),0, $length_of_string);
    }
}

if (! function_exists('imageUpload')) {
    function imageUpload($file,$path) {
        if($file){
            $image = $file;
            $name = rand().time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($path);
            $image->move($destinationPath, $name);
        }else{
            $name=null;
        }
        return $name;
    }
}

if (! function_exists('abreviateTotalCount')) {
    function abreviateTotalCount($value){

        $abbreviations = array(12 => 'T', 7 => 'Cr', 5 => 'Lac', 3 => 'K', 0 => '');

        foreach($abbreviations as $exponent => $abbreviation){
            if($value >= pow(10, $exponent)){
                return round(floatval($value / pow(10, $exponent))).$abbreviation;
            }
        }
        return $value;
    }
}

if (! function_exists('moneyFormatIndia')) {
    function moneyFormatIndia($num) {
        $explrestunits = "" ;
        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3);
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].",";
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash;
    }
}
