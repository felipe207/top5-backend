<!DOCTYPE html>
<html>

@include('includes.header')
<body>
    <div class="dashboard-box">
        <h1>Dashboard</h1>
        <p>Olá, {{ Auth::user()->name }}</p>

        <div class="total-box">
            <h2>Total de usuários</h2>
            <p>{{ $users }}</p>
        </div>
        <div class="total-box">
            <h2>Total de músicas </h2>
            <p>{{ $musicas }}</p>
        </div>

    </div>
</body>
</html>
