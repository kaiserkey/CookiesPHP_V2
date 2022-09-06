<?
session_start();
var_dump($_SESSION);
var_dump($_COOKIE);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Del Usuario</title>
</head>
<body>
    <h1>Bienvenido <? if(!empty($_SESSION['USER'])){echo $_SESSION['USER'];} ?></h1>
</body>
</html>

<?
session_unset();
session_destroy();
?>