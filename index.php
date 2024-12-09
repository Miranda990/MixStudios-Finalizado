<?php
include('config.php');
$conn = new mysqli('localhost', 'root', '', 'meu_site');

if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MixStudio</title>
    <link rel="stylesheet" href="arte.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
</head>

<body>
    <main>
    <header>
        <h1>MixStudio</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Login.php">Login</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="sobre_nos.php">Sobre Nós</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Bem-vindo ao MixStudio</h2>
        <p>Encontre os melhores eBooks para você!</p>
    </section>


    <section id="recentes">
    <h2>Novidades</h2>
    <div class="ebooks-recentes">
    <?php

        $sql_recentes = "SELECT * FROM ebooks ORDER BY id DESC LIMIT 4";
        $result_recentes = $conn->query($sql_recentes);

        if ($result_recentes && $result_recentes->num_rows > 0) {
            while ($row = $result_recentes->fetch_assoc()) {
            echo "<div class='ebook-item'>";
        
        if (!empty($row['imagem'])) {
            echo "<img src='" . htmlspecialchars($row['imagem']) . "' alt='Capa do eBook' style='width:150px; height:auto;'>";
        }
            echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['descricao']) . "</p>";
            echo "<p>Valor: R$" . number_format($row['valor'], 2, ',', '.') . "</p>";
            echo "<a href='" . htmlspecialchars($row['link_pagamento']) . "' class='btn-comprar' target='_blank'>Comprar</a>";
            echo "</div>";
            }
            } else {
            echo "<p>Nenhum eBook recente disponível.</p>";
            }
            ?>
    </div>
</section>
    </main>
    <footer>
        <p>&copy; 2024 MixStudio. Todos os direitos reservados.</p>
    </footer>


</body>
</html>
