<?php $this->layout('layout'); ?>

<ul class="videos__container" alt="videos alura">

    <?php foreach ($videos as $video) { ?>

        <li class="videos__item">
            <?php if ($video->getFilePathURL() !== null) : ?>
                <a href="<?= $video->getURL() ?>">
                    <img src="<?= $video->getFilePathURL() ?>" alt="" width="100%" height="72%" />
                </a>
            <?php else : ?>
                <iframe width="100%" height="72%" src="<?= $video->getURL() ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php endif ?>
            <div class="descricao-video">
                <img src="./img/logo.png" alt="logo canal alura">
                <h3 class="fs-6"><?= $video->getTitle() ?></h3>
                <div class="acoes-video">
                    <a href="/edit-video?id=<?= $video->getId() ?>">Editar</a>
                    <a href="/remove?id=<?= $video->getId() ?>">Excluir</a>
                </div>
            </div>
        </li>

    <?php } ?>

</ul>