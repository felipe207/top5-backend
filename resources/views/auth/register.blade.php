<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>
<body>
    <h1>Registrar</h1>
    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Nome:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="email">E-mail:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar Senha:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
