<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
<?php
// revisamos si se ha enviado el formulario
if (isset($_POST["producto"])){
    //hacemos la coneccion al servidor
    include "../conexion.php";

    //recuperamos los datos enviados por el formulario
    $producto = $_POST["producto"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $nombreFoto = $_FILES["foto"]["name"];
    $tipo = $_FILES["foto"]["type"];
    $tamano = round($_FILES["foto"]["size"]/1024);

    if($nombreFoto = $_FILES["foto"]["name"] == ""){
        $sql = "insert into georgia_productos (producto, descripcion, precio) values('$producto', '$descripcion', '$precio')";
        $nada = ejecutar($sql);

        echo "<script language='javascript'>";
        echo "window.location.assign('index.php');";
        echo "window.alert('El producto se ingresó correctamente a la base de datos.');";
        echo "</script>";

    }else{
        $error = 0; /*no tenemos errores*/

        //Verificamos que el archivo sea una imagen
        if ($tipo != "image/jpeg" && $tipo != "image/jpg" && $tipo != "image/png"){
            $error = 1;

        //Verificamos el tamaño del archivo menor que 500MB
        }else if ($tamano > 500000){
            $error = 2;
        }

        //Verificamos el valor del error, para ver si hay un error o no
        if ($error != 0) {
            //Mandar a la página a index con el error con un querystring
            echo "<script language='javascript'>";
            echo "window.location.assign('index.php?error=".$error."');";
            echo "</script>";

        } else {
            //Se sube la página al servidor con el nombre del archivo a la BD
            $idProducto = "select max(idProducto) from georgia_productos";
            $nombreFinal = $producto."_".$nombreFoto;
            $archivoParaSubir = $ruta.$nombreFinal;
            //Nombre temporal del archivo para que PHP lo utiice internament para subirlo al servidor
            $temp = $_FILES["foto"]["tmp_name"]; 

            if (move_uploaded_file($temp, $archivoParaSubir)){
                $sql = "insert into georgia_productos (producto, descripcion, precio) values('$producto', '$descripcion', '$precio')";
                $nada = ejecutar($sql);

                //Ponemos el nombre del archivo en la BD, cuando se suba al servidor
                $sql_mode = "insert into georgia_fotoproductos (idProducto, foto) values((select max(idProducto) from georgia_productos), '$nombreFinal')";
                $nada = ejecutar($sql_mode);

                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?foto=yes');";
                echo "window.alert('El producto se ingresó correctamente a la base de datos.');";
                echo "</script>";

            }else{
                //No se subio el archivo al servidor
                //Redireccionamos al index con el query del error
                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?error=3');";
                echo "</script>";
            }

        }

    }

}else{
    //No se envio nada, redireccionamos a index
    echo "<script language='javascript'>";
    echo "window.location.assign('index.php');";
    echo "</script>";
}
?>
    
</body>
</html>