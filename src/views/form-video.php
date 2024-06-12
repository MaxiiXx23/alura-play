<?php require_once 'header.php' ?>

<main class="container">

    <form class="container__formulario" action="<?= $id ? '/edit-video?id=' . $videoFound->getId() : '/add-video' ?>" method="POST" enctype="multipart/form-data">
        <h2 class="formulario__titulo">Envie um vídeo!</h2>
        <div class="formulario__campo">
            <label class="campo__etiqueta" for="url">Link embed</label>
            <input name="url" value="<?= $videoFound->getURL() ?>" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' />
        </div>


        <div class="formulario__campo">
            <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
            <input name="title" value="<?= $videoFound->getTitle() ?>" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='titulo' />
        </div>

        <div class="formulario__campo">
            <label class="campo__etiqueta" for="image">Thumbnail</label>
            <input name="image" accept="image/*" type="file" class="campo__escrita" placeholder="Neste campo, dê o nome do vídeo" id='titulo' />
        </div>

        <?php if ($videoFound->getFilePathURL()) : ?>
            <input type="hidden" value="<?= $videoFound->getFilePath() ?>" name="delete_file" />
        <?php endif ?>

        <input class="formulario__botao" type="submit" value="Enviar" />
    </form>

</main>
<?php require_once 'final.php' ?>