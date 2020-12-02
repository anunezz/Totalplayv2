<?php

function dateFormat($format,$date){
    return $date === null || $date === ''? 'Sin formato': date_format(date_create($date), $format);
}

function code($sort_code){
    $cels = preg_split("/[-]/", $sort_code);
    return str_replace('SRE.',"", $cels[0]);
}
