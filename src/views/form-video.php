<?php require_once 'header.php' ?>

<main class="container">

    <form class="container__formulario" action="<?= $id ? '/edit-video?id=' . $videoFound->getId() : '/add-video' ?>" method="POST">
        <h2 class="formulario__titulo">Envie um vídeo!</h2>
        <div class="formulario__campo">
            <label class="campo__etiqueta" for="url">Link embed</label>
            <input name="url" value="<?= $videoFound->getURL() ?>" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' />
        </div>


        <div class="formulario__campo">
            <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
            <input name="title" value="<?= $videoFound->getTitle() ?>" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='titulo' />
        </div>

        <input class="formulario__botao" type="submit" value="Enviar" />
    </form>

</main>
<?php require_once 'final.php' ?>