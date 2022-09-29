<?PHP
    include "../conexion.php";

    $User = (isset($_POST['User'])) ? $_POST['User'] : "";
    $Nom = (isset($_POST['Nom'])) ? $_POST['Nom'] : "";
    $Ape = (isset($_POST['Ape'])) ? $_POST['Ape'] : "";
    $DNI = (isset($_POST['DNI'])) ? $_POST['DNI'] : "";
    $Dir = (isset($_POST['Dir'])) ? $_POST['Dir'] : "";
    $Cor = (isset($_POST['Cor'])) ? $_POST['Cor'] : "";
    echo "a: ".$User.",".$Nom.",".$Ape.",".$DNI.",".$Dir;
    $tsql = "UPDATE CLiente SET Nombre_Cliente = '$Nom', Apellido_Cliente = '$Ape', DNI = '$DNI', Direccion = '$Dir', Correo = '$Cor' WHERE ID_Cliente = '$User'";
    $stmt = sqlsrv_query($conn,$tsql);

?>