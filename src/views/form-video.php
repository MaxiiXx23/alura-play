<?php $this->layout('layout') ?>

<main class="container">

    <?php $this->insert('flashErrorMessage'); ?>

    <form class="container__formulario" action="<?= $id ? '/edit-video?id=' . $video->getId() : '/add-video' ?>" method="POST" enctype="multipart/form-data">
        <h2 class="formulario__titulo">Envie um vídeo!</h2>
        <div class="formulario__campo">
            <label class="campo__etiqueta" for="url">Link embed</label>
            <input name="url" value="<?= $video->getURL() ?>" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' />
        </div>


        <div class="formulario__campo">
            <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
            <input name="title" value="<?= $video->getTitle() ?>" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='titulo' />
        </div>

        <div class="formulario__campo">
            <label class="campo__etiqueta" for="image">Thumbnail</label>
            <input name="image" accept="image/*" type="file" class="campo__escrita" placeholder="Neste campo, dê o nome do vídeo" id='titulo' />
        </div>

        <?php if ($video->getFilePathURL()) : ?>
            <input type="hidden" value="<?= $video->getFilePath() ?>" name="delete_file" />
        <?php endif ?>

        <input class="formulario__botao" type="submit" value="Enviar" />
    </form>

</main>