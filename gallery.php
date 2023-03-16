<?php include("head.php"); ?>
<?php include("conexion.php"); ?>

<?php

if($_POST) {

    $nombre = $_POST['nombre'];
    $descripcion= $_POST['descripcion'];

    $fecha= new DateTime();
    $imagen=$fecha->getTimestamp()."_".$_FILES['archivo']['name'];
    $imagen_temporal=$_FILES['archivo']['tmp_name'];
  
    move_uploaded_file($imagen_temporal,"imagenes/".$imagen);

    $objConexion= new conexion();
    $sql="INSERT INTO `portafolio` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion');";
    $objConexion->ejecutar($sql);
    header("location:gallery.php");

}

if($_GET){

    //DELETE FROM `portafolio` WHERE `portafolio`.`id` = 3
    $id=$_GET['borrar'];
    $objConexion= new conexion();

    $imagen=$objConexion->consultar("SELECT imagen FROM `portafolio` WHERE id=".$id);
    unlink("imagenes/".$imagen[0]['imagen']);
    
    $sql="DELETE FROM `portafolio` WHERE `portafolio`.`id` =".$_GET['borrar'];
    $objConexion->ejecutar($sql);
    header("location:gallery.php");
}

$objConexion= new conexion();
$proyectos=$objConexion->consultar("SELECT * FROM `portafolio`");
//print_r($proyectos);


?>
<br/>
<div class="container">
    <div class="row">
        <div class="col-md-6">
        <div class="card">

<div class="card-header">
Datos del proyecto
</div>
<div class="card-body">
<form action="gallery.php" method="post" enctype="multipart/form-data">

Nombre del Proyecto: <input required class="form-control" type="text" name="nombre" id="">
</br>
Imagen del proyecto: <input required class="form-control" type="file" name="archivo" id="">
</br>
Descripción:
<textarea required class="form-control" name="descripcion" id="" rows="3"></textarea>
</br>
<input class="btn btn-success" type="submit" value="Enviar proyecto">

</form>
</div>

</div>
        </div>
        <div class="col-md-6">
        <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Imagen</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($proyectos as $proyecto) { ?>
                <tr>
                <td><?php echo $proyecto['id']; ?></td>
                <td><?php echo $proyecto['nombre']; ?></td>
                <td>
                <img width="100" src="imagenes/<?php echo $proyecto['imagen']; ?>" alt="" srcset="">    
               </td>

                <td><?php echo $proyecto['descripcion']; ?></td>
                <td><a class="btn btn-danger" href="?borrar=<?php echo $proyecto['id']; ?>">Eliminar</a></td>
            </tr>
            <?php } ?>
          
        </tbody>
    </table>
</div>

        </div>
        
    </div>
</div>

<?php include("footer.php"); ?>