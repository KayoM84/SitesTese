<?php
require __DIR__ . '/conexao.php';

$d = lerJson();

$email = strtolower(trim((string)($d['email'] ?? '')));
$senha = (string)($d['senha'] ?? '');

if ($email === '' || $senha === '') {
    responder(400, ['erro' => 'Informe e-mail e senha.']);
}

try {
    $pdo = conectar();
    $st = $pdo->prepare('SELECT id, nome, senha_hash FROM usuarios WHERE email = ?');
    $st->execute([$email]);
    $u = $st->fetch();

    // Mesma mensagem para e-mail inexistente e senha errada.
    if (!$u || !password_verify($senha, $u['senha_hash'])) {
        responder(401, ['erro' => 'E-mail ou senha incorretos.']);
    }

    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = (int)$u['id'];
    $_SESSION['usuario_nome'] = $u['nome'];

    // Atualiza o hash se o algoritmo padrão do PHP mudou.
    if (password_needs_rehash($u['senha_hash'], PASSWORD_DEFAULT)) {
        $pdo->prepare('UPDATE usuarios SET senha_hash = ? WHERE id = ?')
            ->execute([password_hash($senha, PASSWORD_DEFAULT), $u['id']]);
    }

    responder(200, ['ok' => true, 'redirect' => 'painel.php']);
} catch (PDOException $e) {
    error_log($e->getMessage());
    responder(500, ['erro' => 'Erro no servidor. Tente novamente mais tarde.']);
}
