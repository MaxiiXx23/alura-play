<?php if (array_key_exists('error-message', $_SESSION)) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error-message'] ?>
    </div>
    <?php unset($_SESSION['error-message']) ?>
<?php endif ?>