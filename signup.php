<?
require_once('conection.php');
if(isset($_POST['enviar']) && isset($_POST['nombre']) && isset($_POST['password'])){
    $nombre = htmlentities(addslashes($_POST['nombre']));
    $password =htmlentities(addslashes($_POST['password']));
    
    $con = new Conection();

    try{
        $query = $con->getCon()->prepare("INSERT INTO user (nombre, password) VALUES (:nom, :pass)");
        $query->execute([
            ':nom'=>$nombre,
            ':pass'=>password_hash($password, PASSWORD_DEFAULT, ['cost'=>10])
        ]);
        $result = "Se guardo el usuario correctamente.";

    }catch(PDOException $e){
        echo $e;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Registrarse</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <section>
            <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
                <table>
                    <tr>
                        <th colspan="2">Registrar Usuario</th>
                    </tr>
                    <tr>
                        <td><label for="nombre">Nombre</label></td>
                        <td><input type="text" name="nombre" id="nombre"></td>
                    </tr>
                    <tr>
                        <td><label for="password">Contraseña</label></td>
                        <td><input type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                        <th colspan="2"><input type="submit" value="Registrar" name="enviar"></th>
                    </tr>
                    <tr>
                        <th colspan="2"><? if(!empty($result)) {echo $result;} ?></th>
                    </tr>
                    <tr>
                        <th colspan="2"><a href="login.php"><input type="button" value="Login"></a></th>
                    </tr>
                </table>
            </form>
        </section>
    </body>
</html>