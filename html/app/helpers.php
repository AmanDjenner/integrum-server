<?php

//"30 Dec 1899"+dni + (86400 sek* cz.ulamkowa)
function dateFormatChange($dateDelphi)
{
    if (!isset($dateDelphi)) {
        return '';
    }
    $dateSplit = explode('.', $dateDelphi);

    $day    = $dateSplit[0];
    $second = (int) (86400 * ($dateDelphi - $dateSplit[0]));

    $date = new DateTime("30 Dec 1899");
    $date->add(new DateInterval('P'.$day.'D'));
    $date->add(new DateInterval('PT'.$second.'S'));
    return $date->format('Y-m-d H:i:s');
}
