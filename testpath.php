<?php

$path="/home/servi271/public_html/new2/clients/log";
date_default_timezone_set('America/Montreal');
//$output = shell_exec('find /home/servi271/public_html/new2/clients/log/ -mtime +10 -type f -print');
$output = shell_exec('find /home/servi271/public_html/new2/clients/log/ -mtime +10 -type f -print | wc -l');
echo "<pre>$output</pre>";


  //Email information
  $admin_email = "pmkatelier@gmail.com";
  $email = "pmkatelier@gmail.com";
  $subject = 'subject';
  $comment = 'comment';
  
  //send email
  mail($admin_email, $subject, $comment, "From:" . $email);
  
   mail('pmkatelier@gmail.com', 'Test subject', '$message');
  
  //Email response
  echo "Thank you for contacting us!";
  
  
exit;



//$dir = "/images/";

// Open a directory, and read its contents
if (is_dir($path)){
  if ($dh = opendir($path)){
    while (($file = readdir($dh)) !== false){
      $filelastmodified = filemtime($file);
      echo filectime($file) . ' :: ' . filesize($file) . ' bytes' . ':' . date ("F d Y H:i:s.", filectime($file)); 
      echo "Last modified on: " . date("d-m-y", filemtime("$file"));
      echo "filename:" . $file . " : " . $filelastmodified. "<br>" ;
    }
    closedir($dh);
  }
  else {
    echo "Erreur pas un directorie <br>";
  }  
}


exit;

if ($handle = opendir($path)) {
echo $path;
echo $path;
exit;

    while (false !== ($file = readdir($handle))) { 
        echo 'HICH : ' . $file;
        $filelastmodified = filemtime($path . $file);
        //24 hours in a day * 3600 seconds per hour
        if((time() - $filelastmodified) > 24*3600)
        {
           echo $file;
           /*unlink($path . $file);*/
        }

    }

    closedir($handle); 
} 
?>