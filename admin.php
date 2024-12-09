<?php
session_start();
ob_start();
include('config.php');

 
$conn = new mysqli('localhost', 'root', '', 'meu_site');

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}


if (isset($_POST['add_ebook'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $link_pagamento = $_POST['link_pagamento'];

    $sql = "INSERT INTO ebooks (titulo, descricao, valor, link_pagamento) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $titulo, $descricao, $valor, $link_pagamento);

    if ($stmt->execute()) {
        echo "<p>eBook adicionado com sucesso!</p>";
    } else {
        echo "<p>Erro ao adicionar eBook: " . $stmt->error . "</p>";
    }
}



$conn = new mysqli('localhost', 'root', '', 'meu_site');

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_ebook'])) {
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $link_pagamento = $_POST['link_pagamento'];

    
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_dir = 'uploads/' . basename($imagem_nome);
        
        
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        
        if (move_uploaded_file($imagem_temp, $imagem_dir)) {
            
            $sql = "INSERT INTO ebooks (titulo, descricao, valor, link_pagamento, imagem) 
                    VALUES ('$titulo', '$descricao', '$valor', '$link_pagamento', '$imagem_dir')";
            if ($conn->query($sql) === TRUE) {
                echo "eBook adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar eBook: " . $conn->error;
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    $sql = "DELETE FROM ebooks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "<p>eBook excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir eBook: " . $stmt->error . "</p>";
    }
}


$sql = "SELECT * FROM ebooks";
$result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Enviar ebooks</h2>
    
    <form action="adicionar_ebook.php" method="POST" enctype="multipart/form-data">

        <label for="imagem">Capa do eBook:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*" required><br><br>

        <label for="titulo">Título do eBook:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea><br><br>

        <label for="valor">Valor (R$):</label>
        <input type="number" id="valor" name="valor" step="0.01" required><br><br>

        <label for="link_pagamento">Link de Pagamento:</label>
        <input type="url" id="link_pagamento" name="link_pagamento" required><br><br>

        <button type="submit" name="add_ebook">Adicionar eBook</button>
    </form>

    <h3>eBooks Adicionados</h3>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h4>" . $row['titulo'] . "</h4>";
            echo "<p>" . $row['descricao'] . "</p>";
            echo "<p>Valor: R$" . number_format($row['valor'], 2, ',', '.') . "</p>";
            echo "<a href='" . $row['link_pagamento'] . "' target='_blank'>Comprar</a>";
            echo " | <a href='admin.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este eBook?\");'>Excluir</a>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Nenhum eBook adicionado.</p>";
    }
    ?>
</body>
</html>
