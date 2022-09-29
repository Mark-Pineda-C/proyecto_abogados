<?PHP
    $carpeta = $_POST['CaseID'];
    $nombre = $_FILES['ArcFile']['name'];
    $ruta = $_FILES['ArcFile']['tmp_name'];
    $destino = "../../uploads/".$carpeta.'/'.$nombre;
    if($nombre != ""){
        copy($ruta, $destino);
        //echo "<p>listo</p>";
    }

?>