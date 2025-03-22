<?php include("template/cabecera.php");?>
<?php
include ("administrador/config/bd.php");
$sentenciaSQL= $conexion->prepare("SELECT * FROM reclutamiento");
$sentenciaSQL->execute();
$listaReclutamiento=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);


?>

    <?php foreach ($listaReclutamiento as $reclutar) {?>  
    <div class="col-md-3">
    <div class="card">

    <img class="card-img-top" src="./img/<?php echo $reclutar['imagen'];?>"  alt="">

    <div class="card-body">
       <h4 class="card-title"><?php echo $reclutar['nombre'];?></h4>
       <p class="card-text"><?php echo $reclutar['descripcion'];?></p>
       <a name="" id="" class="btn btn-primary" href="#" role="button">ver mas </a>
    </div>

    </div>

    </div>
    <?php }?>

   

<?php include("template/pie.php");?>