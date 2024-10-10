<?php
// Inclui a classe Database
require 'PHP/db.php';

// Cria a conexão com o banco de dados
$db = new Database('localhost', 'sistemalunos', 'root1', '123456', 3307);
$db->connect(); // Conecta ao banco de dados

// Exibe mensagens de sucesso ou erro baseadas nos parâmetros da URL
$status = isset($_GET['status']) ? $_GET['status'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

// Busca os alunos cadastrados no banco de dados
$alunos = [];
try {
    $pdo = $db->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM sistemalunos.alunos");
    $stmt->execute();
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
    <title>Listagem de Alunos Cadastrados</title>
    <link rel="stylesheet" href="CSS/Style.css">
</head>
<body>
    <!-- Tabela para listar os alunos cadastrados -->
    <div class="ContainerGrande">
        <h2>Alunos Cadastrados</h2>
        <?php
// Verifica se acha algo igual ao pesquisado
$search = $_GET['search'] ?? '';
?>

<form method="GET" action="pesquisar.php" class="Pesquisar">
<input type="text" name="search" placeholder="Pesquisar por Nome ou Curso" value="<?= htmlspecialchars($search) ?>">
<button type="submit" class="BtnPesquisar">Pesquisar</button>


        <?php if (count($alunos) > 0): ?>
        <!--Se o número de alunos for maior q zero irá "puxar" os dados do DB-->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Email</th>
                        <th>Curso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno['id']) ?></td>
                            <td><?= htmlspecialchars($aluno['nome']) ?></td>
                            <td><?= htmlspecialchars($aluno['idade']) ?></td>
                            <td><?= htmlspecialchars($aluno['email']) ?></td>
                            <td><?= htmlspecialchars($aluno['curso']) ?></td>
                            <td>
                                <a href="deletar.php?id=<?= $aluno['id'] ?>" class="deletar" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
        <!--Se n houver nenhum aluno cadastrado vai aparecer essa mensagen-->
            <p>Nenhum aluno cadastrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
