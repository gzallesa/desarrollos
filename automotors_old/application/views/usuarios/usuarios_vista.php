<html>

<h3>Usuarios:</h3>

<h2><?php echo $titulo; ?></h2>

<?php foreach ($usuarios as $usuario_item): ?>

        <h3><?php echo $usuario_item['USUARIO']; ?></h3>
        <div class="main">
                <?php echo $usuario_item['NOMBRE_COMPLETO']; ?>
                <?php echo $usuario_item['ESTADO']; ?>
        </div>

<?php endforeach; ?>