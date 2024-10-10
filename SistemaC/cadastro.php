<?php
// Inclui a classe Database para que seja realizado depois um código com a conexão do servidor
require 'PHP/db.php';

// Cria a conexão com o banco de dados
$db = new Database('localhost', 'sistemalunos', 'root1', '123456', 3307);
$db->connect(); // Conecta ao banco de dados

// Verifica se o formulário foi enviado corretamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    try {
        // Prepara a 
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("INSERT INTO alunos (nome, idade, email, curso) VALUES (:nome, :idade, :email, :curso)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':curso', $curso);
        
        // Executa a inserção
        if ($stmt->execute()) {
            // Se a inserção for bem-sucedida, redireciona para a página index.php com uma mensagem de sucesso
            header("Location: index.php?status=success");
            exit();
        } else {
            // Se houver algum erro, redireciona para index.php com uma mensagem de erro
            header("Location: index.php?status=error");
            exit();
        }
    } catch (PDOException $e) {
        // Em caso de exceção, redireciona com uma mensagem de erro e exibe o erro
        header("Location: index.php?status=error&message=" . $e->getMessage());
        exit();
    }
} else {
    // Se o formulário não foi enviado, redireciona para a página inicial
    header("Location: index.php");
    exit();
}
