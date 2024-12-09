<?php
include('config.php');
$conn = new mysqli('localhost', 'root', '', 'meu_site');

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $link_pagamento = $_POST['link_pagamento'];

    
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
       
        $pastaDestino = 'uploads/';
        
        
        $nomeImagem = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $caminhoImagem = $pastaDestino . $nomeImagem;

        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            
            $sql = "INSERT INTO ebooks (titulo, descricao, valor, link_pagamento, imagem) 
                    VALUES ('$titulo', '$descricao', '$valor', '$link_pagamento', '$caminhoImagem')";
            
            if ($conn->query($sql) === TRUE) {
                echo "eBook adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar eBook: " . $conn->error;
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Por favor, envie uma imagem para a capa do eBook.";
    }
}

$conn->close();
?>
