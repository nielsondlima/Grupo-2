<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'prolinker';

// Criar conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
