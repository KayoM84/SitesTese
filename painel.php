<?php
// Página protegida: só entra quem fez login (a sessão é criada no login.php).
session_start();
if (empty($_SESSION['usuario_id'])) {
    header('Location: login.html');   // sem sessão, volta para o login
    exit;
}
$nome = htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8');   // evita injeção de HTML
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Painel</title>
<style>
  body { margin: 0; min-height: 100vh; display: grid; place-items: center; background: #f1f4f6; color: #15202a;
         font: 16px/1.4 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
  .card { background: #fff; border: 1px solid #cbd4dc; border-radius: 14px; padding: 28px 24px; max-width: 400px; width: 90%; text-align: center; }
  a { display: inline-block; margin-top: 14px; color: #0b7a75; }
</style>
</head>
<body>
  <div class="card">
    <h1>Olá, <?= $nome ?>!</h1>
    <p>Você está logado. Aqui vai o conteúdo do seu sistema.</p>
    <a href="logout.php">Sair</a>
  </div>
</body>
</html>
