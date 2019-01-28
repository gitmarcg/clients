<?php
    list($scriptPath) = get_included_files();
    $pos          = strripos($scriptPath, DIRECTORY_SEPARATOR);
    $pathCurent   = substr($scriptPath,0,$pos+1);
    $DirLog       = $pathCurent . "log"      . DIRECTORY_SEPARATOR; 
    $DirTempoFile = $pathCurent . "Tempo"    . DIRECTORY_SEPARATOR;
    $DirSecurite  = $pathCurent . "securite" . DIRECTORY_SEPARATOR;
    $DirImage     = $pathCurent . "images"   . DIRECTORY_SEPARATOR;
    $PHPMailer    = ".." . DIRECTORY_SEPARATOR . "PHPMailer". DIRECTORY_SEPARATOR; 

/*echo PHP_OS;
echo DIRECTORY_SEPARATOR;
echo $DirLogFile   . '<br>';
echo $DirTempoFile . '<br>';
echo $DirSecurite  . '<br>';
echo $DirImage     . '<br>';
exit;*/

?>


