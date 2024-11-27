<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Insira a senha, se houver
$dbname = 'prolinker';

$conn = new mysqli($host, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
