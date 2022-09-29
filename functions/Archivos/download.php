<?php
    if(!empty($_GET['File'])){
        $caseName = $_GET['Case'];
        $fileName = basename($_GET['File']);
        $filePath = '../../uploads/'.$caseName.'/'.$fileName;
        if(!empty($fileName) && file_exists($filePath)){
            // Define headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");
            
            // Read the file
            readfile($filePath);
            echo "descarga con exito";
            exit;
        }else{
            echo 'The file does not exist.';
        }
    }
?>