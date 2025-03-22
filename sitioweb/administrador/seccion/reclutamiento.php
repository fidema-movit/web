<?php include ("../template/cabecera.php");?>
<?php 

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtDescripcion=(isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
$txtImagen=(isset($_FILES['txtImagen']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include ("../config/bd.php");

switch($accion){

    //INSERT INTO `reclutamiento` (`id`, `nombre`, `imagen`) VALUES (NULL, 'reclutamiento php', 'imagen.jpg')
    //INSERT INTO `reclutamiento` (`id`, `nombre`, `descripcion`, `imagen`) VALUES (NULL, '', '', '')
    //INSERT INTO `reclutamiento` (`id`, `nombre`, `descripcion`, `imagen`) VALUES (NULL, 'reclutamiento php', 'texto php', 'imagen.jpg');
    case "Agregar":

        $sentenciaSQL= $conexion->prepare("INSERT INTO reclutamiento (nombre,descripcion,imagen) VALUES (:nombre,:descripcion,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen!="") {
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }

    

        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        header("Location:Reclutamiento.php");

        break;
    case "Modificar":

        $sentenciaSQL= $conexion->prepare("UPDATE reclutamiento SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        if ($txtDescripcion!="") {
            $sentenciaSQL= $conexion->prepare("UPDATE reclutamiento SET descripcion=:descripcion WHERE id=:id");
            $sentenciaSQL->bindParam(':descripcion',$txtDescripcion);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
        }

        

        if ($txtImagen!="") {

            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM reclutamiento WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $reclutar=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            if (isset($reclutar["imagen"]) &&($reclutar["imagen"]!="imagen.jpg") ){
                if (file_exists("../../img/".$reclutar["imagen"])) {
                    unlink("../../img/".$reclutar["imagen"]);
                }
            }
                
            
            $sentenciaSQL= $conexion->prepare("UPDATE reclutamiento SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            
        }
        

        
        
        

        //echo "Presionado boton Modificar";

        header("Location:Reclutamiento.php");

        break;

    case "Cancelar":

        header("Location:Reclutamiento.php");

       //echo "Presionado boton Cancelar";
        break;

    case "Seleccionar":

        $sentenciaSQL= $conexion->prepare("SELECT * FROM reclutamiento WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $reclutar=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$reclutar['nombre'];
        $txtDescripcion=$reclutar['descripcion'];
        $txtImagen=$reclutar['imagen'];
        //echo "Presionado boton Seleccionar";
        break;

    case "Borrar":

        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM reclutamiento WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $reclutar=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($reclutar["imagen"]) &&($reclutar["imagen"]!="imagen.jpg") ){
            if (file_exists("../../img/".$reclutar["imagen"])) {
                unlink("../../img/".$reclutar["imagen"]);
            }
        }

        $sentenciaSQL= $conexion->prepare("DELETE FROM reclutamiento WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
    
       // "DELETE FROM `reclutamiento` WHERE `reclutamiento`.`id` = 25"?
        //echo "Presionado boton Borrar";

        header("Location:Reclutamiento.php");
        break;

        //"DELETE FROM `reclutamiento` WHERE `reclutamiento`.`id` = 25"?

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM reclutamiento");
$sentenciaSQL->execute();
$listaReclutamiento=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>


<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del Reclutamiento
        </div>


        <div class="card-body">

        <form method="POST" enctype="multipart/form-data" >

    <div class = "form-group">
    <label for="txtID">ID:</label>
    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
    </div>

    <div class = "form-group">
    <label for="txtNombre">Nombre:</label>
    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Cargo">
    </div>

    <div class = "form-group">
    <label for="txtDescripcion">Descripcion:</label>
    <?php echo $txtDescripcion; ?>

    <textarea  class="form-control"  name="txtDescripcion" id="txtDescripcion" rows="10" placeholder="Descripcion del cargo"></textarea>
    </div>

    <div class = "form-group">
    <label for="txtNombre">Imagen:</label>

    <br/>


    <?php if ($txtImagen!="") { ?>
        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>"width= "50" alt="" srcset=""> 
     
    
    <?php  }?>

    <input type="file"  class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre de la imagen">
    </div>

           <div class="btn-group" role="group" aria-label="">
           <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" valueclass="btn btn-success">Agregar</button>
           <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
           <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar"class="btn btn-info">Cancelar</button>
           </div>
        </form>

        </div>      
    </div>
</div>

<br/><br/><br/><br/><br/><br/><br/>

<div class="col-md-7">
     <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Acciones</th>
                <th>Facebook</th>
                <th>Linkedin</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaReclutamiento as $reclutamiento) { ?>
            <tr>
                <td><?php echo $reclutamiento['id']; ?></td>
                <td><?php echo $reclutamiento['nombre']; ?></td>
                <td><?php echo $reclutamiento['descripcion']; ?></td>
                <td>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $reclutamiento['imagen']; ?>"width= "50" alt="" srcset="">

                    

                </td>

                <td>


                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $reclutamiento['id']; ?>" />

                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                </form>

                </td>
                <td>
                
                
                     <div class="card-body">
                     <div id="fb-root"></div>
                     <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v21.0"></script>
                         
                      
                         <div class="fb-share-button" data-href="" data-layout="" data-size=""><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fweb.facebook.com%2Fprofile.php%3Fid%3D61561957916906&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>
                         <div class="fb-page" data-href="https://web.facebook.com/profile.php?id=61561957916906" data-tabs="timeline" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://web.facebook.com/profile.php?id=61561957916906" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/profile.php?id=61561957916906">Reclutamiento Metal</a></blockquote></div>
                        
                        
                        
                        
                </td>
                <td>
                </div>
                     <div class="card-body">
                     <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                     <script type="IN/Share" data-url=""></script>
                         
                     </div>
                </td>
            </tr>
        <?php } ?>
            
        </tbody>
    </table>

</div>


<?php include ("../template/pie.php");?>


