<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar · Arena Bravos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&family=Barlow:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/arena-bravos.css') }}">
</head>

<body class="ab-body">
    <div class="login-wrap">
        <section class="login-brand-panel">
            <div class="login-brand">
                <div class="sb-arena">Arena</div>
                <div class="login-bravos">BRAVOS</div>
                <p>Sistema de gestão de comandas</p>
            </div>
        </section>
        <section class="login-form-panel">
            <h1>Bem-vindo de volta!</h1>
            <p class="login-sub">Faça login para continuar</p>
            <form action="{{ route('dashboard') }}" method="get"><label class="form-label"
                    for="email">Usuário</label><input class="form-input" id="email" type="email"
                    placeholder="seu@email.com"><label class="form-label form-label-spaced"
                    for="password">Senha</label><input class="form-input" id="password" type="password"
                    placeholder="••••••••"><label class="remember"><input type="checkbox"> Lembrar acesso</label><button
                    class="btn-login" type="submit"><i class="ti ti-login"></i> Entrar</button></form>
            <footer>ARENA BRAVOS © 2025 — Todos os direitos reservados.</footer>
        </section>
    </div>
</body>

</html>
