<?php 
// Incluir a conexão com o banco de dados
require_once 'PHP/db.php';

// Conectar ao banco de dados
$db = new Database('localhost', 'sistemalunos', 'root1', '123456', 3307);
$db->connect();
$pdo = $db->getConnection(); // Obtém a conexão PDO

// Verificar se há um termo de pesquisa
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Preparar a consulta SQL com base na pesquisa inserida no campo
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM alunos WHERE nome LIKE :search OR curso LIKE :search");
    $stmt->execute([':search' => '%' . $search . '%']);
} else {
    $stmt = $pdo->prepare("SELECT * FROM alunos");
    $stmt->execute();
}

// Buscar todos os alunos encontrados
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
