<?PHP

    $Nro = (isset($_POST["Nro"])) ? $_POST["Nro"] : "";
    $Dist = (isset($_POST["Dist"])) ? $_POST["Dist"] : "";
    $Year = (isset($_POST["Year"])) ? $_POST["Year"] : "";
    $Ins = (isset($_POST["Ins"])) ? $_POST["Ins"] : "";
    $Mat = (isset($_POST["Mat"])) ? $_POST["Mat"] : "";
    $NumC = (isset($_POST["NumC"])) ? $_POST["NumC"] : "";
    $NumJ = (isset($_POST["NumJ"])) ? $_POST["NumJ"] : "";
    $ExpCode = $Nro.'-'.$Year.'-'.$Dist.'-'.$NumC.'-'.$Ins.'-'.$Mat.'-'.$NumJ;

    mkdir("../../uploads/".$ExpCode,0700);
    if(is_dir("../../uploads/".$ExpCode)!=true){
        echo "error";
    } else echo "perfecto"

?>