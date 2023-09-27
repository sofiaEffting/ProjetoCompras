<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>SCA - Sistema de Compras Acadêmicas</title>
    <link rel="icon" type="image/x-icon" href="/img/logoifc.png">
</head>
<body>
    <header>
        <h1 id="sca" style="color:white">SCA - Sistema de Compras Acadêmicas IFC Blumenau</h1>    
    </header>
    <div class="div1">
        <div class="container">
            <h3 id="cdt">Entrar no Sistema</h3><br>
            <form action="./loginFormDo.php" method="post">
                <div class="form-group">
                    <input type="text" name="siape" id="username" class="form-control" placeholder="Número SIAPE" required>
                </div><br>
                <div class="form-group">
                    <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                    <br>
                    <input type="submit" value="Entrar" class="btn-log">
                </div>
            </form>
        </div>
    </div>
</body>
</html>