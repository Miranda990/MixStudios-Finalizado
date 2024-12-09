<?php
include('config.php');
$conn = new mysqli('localhost', 'root', '', 'meu_site');

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$sql = "SELECT * FROM ebooks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="arte.css">
    <title>Nossos Produtos</title>
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
        <h2>Loja</h2>
        <div class="product">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='ebook-item'>";
                    
                    if (!empty($row['imagem'])) {
                        echo "<img src='" . htmlspecialchars($row['imagem']) . "' alt='Capa do eBook' style='width:150px; height:auto;'>";
                    }
                    echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['descricao']) . "</p>";
                    echo "<p>Valor: R$" . number_format($row['valor'], 2, ',', '.') . "</p>";
                    echo "<a href='" . htmlspecialchars($row['link_pagamento']) . "' target='_blank' class='btn-comprar'>Comprar</a>";
                    echo "<hr>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhum eBook disponível.</p>";
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