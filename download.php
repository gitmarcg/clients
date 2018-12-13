
<?php if (isset($_GET['file'])) {
$dir = dirname(__FILE__);
$file = $_GET['file'] . ".pdf";
$pathFile = $dir ."\\billets\\" . $file;
$file = $path . $file;
$dir = dirname(__FILE__);

 <ul>
        <li>Informations personnelles
            <ul>
                <li><label for="first_name">Prénom</label></li>
                <li><label for="last_name">Nom</label></li>
</ul>
            
echo "<p>Full path to this dir: " . $pathFile . "</p>"; 


if (file_exists($pathFile) && is_readable($pathFile) && preg_match('/\.pdf$/',$pathFile)) {
 header('Content-Type: application/pdf');
 header("Content-Disposition: attachment; filename=\"/public_html/new2/login/billets/26193.pdf\"");
 readfile("/public_html/new2/login/billets/26193.pdf");
}
 else {
 header("HTTP/1.0 404 Not Found");
 echo "<h1>Error 404: File Not Found: <br /><em>$file</em></h1>";
}
} else {
 header("HTTP/1.0 404 Not Found");
 echo "<h1>Error 404: File Not Found: <br /><em>$file</em></h1>";
}
?>

