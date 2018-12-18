<?php

$pathCurent = getcwd();
$findme   = 'servi271';
//***** Vére si on est sur un serveur Linus ou windows pour le path
$pos = strpos($pathCurent, $findme);
if ($pos == false) {
    list($scriptPath) = get_included_files();
    $pos          = strripos($scriptPath, "\\");
    $pathCurent   = substr($scriptPath,0,$pos+1);
    $DirLogFile   = $pathCurent . "log\\$date.txt";
    $DirTempoFile = $pathCurent . "Tempo\\";
    $DirSecurite  = $pathCurent . "securite\\";
    $DirImage     = $pathCurent . "images\\";
} else {
    list($scriptPath) = get_included_files();
    $pos      = strripos($scriptPath, "/");
    $pathCurent = substr($scriptPath,0,$pos+1);
    $DirLogFile = $pathCurent . "log/$date.txt";
    $DirTempoFile = $pathCurent . "Tempo/";
    $DirSecurite  = $pathCurent . "securite/";
    $DirImage     = $pathCurent . "images/";
}
?>


