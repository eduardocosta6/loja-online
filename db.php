<?php
// Ligação a base de Dados 

// Dados de ligação 
$host = 'localhost';
$dbname = 'loja';
$user = 'root';
$pass = 'admin';

// Criar ligação com PDO 
 try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
    die("Erro na ligação a BD: " . $e->getMessage());
 }

// Iniciar uma sessão se ainda não estiver iniciada 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
 
