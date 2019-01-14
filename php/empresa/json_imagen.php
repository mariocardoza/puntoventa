<?php 
    include_once("../../Conexion/Empresa.php");
    $file_path = "../../img/empresa/";
    $file_path = $file_path . basename($_FILES['file-0']['name']);
    $file_path2 = "../../img/empresa/";

    $trozos = explode(".", $file_path); 
    $extension = end($trozos);

    $id_prod=$_GET['id'];

    $nombre2=$file_path2."img_".$id_prod.".".$extension;

    $nombre3="img_".$id_prod.".".$extension;

    $nombre_anterior="";

    $result = Empresa::get_img_anterior($id_prod);
    if($result[0]==1){
        foreach ($result[1] as $value) {
            $nombre_anterior = $value['imagen'];
        }
        
    }
    
    if ($nombre_anterior!="") {
        unlink($file_path2.$nombre_anterior);
    } 

    if(move_uploaded_file($_FILES['file-0']['tmp_name'], $file_path)) {

        rename($file_path, $nombre2);

        $result = Empresa::set_img($id_prod,$nombre3);

        if($result[0]==1){
            echo json_encode(array("exito" => "exito",$result,$id_prod,$nombre3));
        }else{
            echo json_encode(array("error" => "NO se puedo insertar adentro adentro adentro adentro ",$result ));
        }     
     }else{
          echo json_encode(array("error" => "NO se puedo insertar adentro adentro adentro adentro ",$result ));
    }
?>