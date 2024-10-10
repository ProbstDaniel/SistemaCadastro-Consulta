<?php
// Inclui o arquivo do database que  logo irá executar um código para realizar a sua conexão
require 'PHP/db.php';

// Código para realizar a conexão
$db = new Database('localhost', 'sistemalunos', 'root1', '123456', 3307);
$db->connect(); // Conecta ao banco de dados

// Exibe mensagens de sucesso ou erro com base no resultado e na informação capturada
$status = isset($_GET['status']) ? $_GET['status'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

// Busca os alunos cadastrados no banco de dados
$alunos = []; //define a variável aluno como vazia, que dá possibilidade para que ela seja preenchida com os dados inseridos
try {
    $pdo = $db->getConnection(); //faz com q o PDO(q faz a conexão e realiza consulta) se conecte com o database
    $stmt = $pdo->prepare("SELECT * FROM sistemalunos.alunos");//o prepare "prepara" uma consulta pra ser realizada no sql
    //* from pega todos os dados da table alunos do db sistema_alunos
    $stmt->execute();//Stmt ele pega a consulta preparada e executa ela
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Erro ao buscar alunos: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
    <link rel="stylesheet" href="CSS/StyleCadastrar.css">
</head>
<body>
    <div class="ContainerGrande">
        <h1>Cadastro de Alunos</h1>
        <!-- Formulário de cadastro que envia os dados para o cadastro.php para que sejam inseridos os dados no db-->
        <form action="cadastro.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome aqui" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" placeholder="Qual sua idade?" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Insira seu email" required>

            <label for="curso">Curso:</label>
            <input type="text" id="curso" name="curso" placeholder="Insira o seu curso" required>

            <input class="Cadastrar" type="submit" value="Cadastrar">
        </form>
                <!-- Exibe mensagem de sucesso ou erro com base na variável status, criada anteriormente-->
                <?php if ($status == 'success'): ?>
        <p class="Successo">Aluno cadastrado com sucesso!</p>
    <?php elseif ($status == 'error'): ?>
        <p class="Erro">Erro ao cadastrar aluno: <?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    </div>
</body>
</html>
