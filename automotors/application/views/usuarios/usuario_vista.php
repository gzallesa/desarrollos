<h2><?php echo $titulo; ?></h2>


<h3>Usuario: <?php echo $usuario['USUARIO']; ?></h3>
<div class="main">
    <p>Nombre: <?= $usuario['NOMBRE_COMPLETO']; ?></p>
   <p>Web: <?= $usuario['WEB']; ?></p>
   <p>Mobile: <?= $usuario['MOBILE']; ?></p>
   <p>Estado: <?= $usuario['ESTADO']; ?></p>
   <p>Fecha de creación: <?= $usuario['FECHA_CREACION']; ?></p>
   <p>Fecha de modificación: <?= $usuario['FECHA_MODIFICACION']; ?></p>
</div>