### Projeto Curso - Alura (Público) - 2024

### **CURSO ALURA PHP COM MVC**

#### Sobre o projeto:

- Projeto focado no Pattern MVC com PHP Web, utilizando as melhores práticas para o seu desenvolvimento como: DDD, Injeção de Dependências e POO para criação de páginas dinâmicas;

### Principais tecnologias usadas no desenvolvimento:

- Composer

### Etapa do desenvolvimento:

- Em desenvolvimento

### Passo-a-passo para rodar a aplicação:

1. Entre na pasta alura-play;
2. use o comando: **composer install** para instalar os pacotes:

```bash
composer install
```

3. copie o comando para rodar a aplicação:

```bash
php -S localhost:8080 -t public/
```

4. SQL query para a criação das tabelas(MYSQL):
   1. **users**: "CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password TEXT);"
   2. **videos**: "CREATE TABLE videos (id INTEGER PRIMARY KEY, url TEXT, title TEXT, image_path TEXT);"
