<?php
class noticiasView {
    
    public function showNoticias($noticias) {
        echo("<ul>");
        foreach($noticias as $noticia) {
            echo("Sección: " . $noticia->nombre_seccion);
            echo("<li>");
            echo("<a href='?action=noticia/" . $noticia->id_noticia . "'>" . $noticia->titulo . "</a>");
            echo("<br>");
            echo($noticia->cuerpo);

            // Botón Editar
            echo("<a href='editar/" . $noticia->id_noticia . "'>Editar</a>");

            // Botón Eliminar
            echo("
                <form action='' method='post'>
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='id' value='" . $noticia->id_noticia . "'>
                    <button type='submit'>Eliminar</button>
                </form>
            ");

            echo("</li>");
        }
        echo("</ul>");
    }

    public function showNoticia($noticia) {
        echo("Sección: " . $noticia->nombre_seccion);
        echo("<h1>" . $noticia->titulo . "</h1>");
        echo("<p>" . $noticia->cuerpo . "</p>");
        echo("<p>" . $noticia->fecha . "</p>");
    }

    public function showEditForm($secciones, $noticia) {
        ?>
        <p>Editar Noticia</p>
        <form action="" method="post">
            <input type="hidden" name="action" value="editar">
            <input type="hidden" name="editar_id" value="<?= $noticia->id_noticia ?>">
            <input type="text" name="editar_titulo" required placeholder="editar titulo">
            <input type="text" name="editar_cuerpo" required placeholder="editar cuerpo">
            <input type="date" name="editar_fecha" required>
            <select name="editar_id_seccion_fk">
                <option value="">-- Elegí una sección --</option>
                <?php foreach ($secciones as $seccion): ?>
                    <option value="<?= $seccion['id_seccion'] ?>">
                        <?= $seccion['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Enviar">
        </form>
        <?php
    }

    public function showForm($secciones) {
        ?>
        <p>Agregar Noticia</p>
        <form action="" method="post">
            <input type="hidden" name="action" value="add">
            <input type="text" name="titulo" required placeholder="titulo">
            <input type="text" name="cuerpo" required placeholder="cuerpo">
            <input type="date" name="fecha" required>
            <select name="id_seccion_fk">
                <option value="">-- Elegí una sección --</option>
                <?php foreach ($secciones as $seccion): ?>
                    <option value="<?= $seccion['id_seccion'] ?>">
                        <?= $seccion['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Enviar">
        </form>
        <?php
    }    
    
}