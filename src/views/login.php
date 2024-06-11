<?php require_once 'header.php' ?>

<main class="container">

    <form class="container__formulario" action="/login" method="POST">
        <h2 class="formulario__titulo">Efetue login</h3>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="usuario">E-mail</label>
                <input name="email" class="campo__escrita" required placeholder="Digite seu e-mail" id='usuario' />
            </div>


            <div class="formulario__campo">
                <label class="campo__etiqueta" for="senha">Senha</label>
                <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha" id='senha' />
            </div>

            <input class="formulario__botao" type="submit" value="Entrar" />
    </form>

</main>
<?php require_once 'final.php' ?>