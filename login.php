<?
    session_start();
    require_once('conection.php');
    if(!empty($_SESSION['USER'])){
        $con = new Conection();
        $nombre = $_SESSION['USER'];
        try{
            $query = $con->getCon()->prepare("SELECT * FROM user WHERE nombre=:nom");
            $query->execute([
                ':nom'=>$nombre
            ]);
            if($query->rowCount() == 1){
                $user = $query->fetch(PDO::FETCH_ASSOC);
                header("Location: " . constant('URL') . "user.php");
            }
        }catch(PDOException $e){
            return $e;
        }
    }else{
        if(!empty($_COOKIE['recordar'])){
            $con = new Conection();
            $nombre = $_COOKIE['recordar'];
        
            try{
                $query = $con->getCon()->prepare("SELECT * FROM user WHERE nombre=:nom");
                $query->execute([
                    ':nom'=>$nombre
                ]);
                if($query->rowCount() == 1){
                    $user = $query->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['USER'] = $user['nombre'];
                    header("Location: " . constant('URL') . "user.php");
                }
                }catch(PDOException $e){
                    return $e;
                }
        }else{
            if(isset($_POST['nombre']) && isset($_POST['password'])){
                $con = new Conection();
                $nombre=htmlentities(addslashes($_POST['nombre']));
                $password=htmlentities(addslashes($_POST['password']));
                $recordar = !empty($_POST['recordar']) ? true : false;
                try{
                    $query = $con->getCon()->prepare("SELECT * FROM user WHERE nombre=:nom");
                    $query->execute([
                        ':nom'=>$nombre
                    ]);
                    if($query->rowCount() == 1){
                        $user = $query->fetch(PDO::FETCH_ASSOC);
                        
                        if(password_verify($password, $user['password'])){
                            session_start();
                            $_SESSION['USER'] = $user['nombre'];
                            if($recordar){
                                setcookie('recordar', $user['nombre'], time()+60*60*24*30);
                            }
                            header("Location: " . constant('URL') . "user.php");
                            
                        }else{
                            $result = "Contraseña Incorrecta, Intentalo Nuevamente";
                        }
                    }else{
                        $result = "Este usuario no esta registrado, registrese para ingresar.";
                    }
                }catch(PDOException $e){
                    return $e;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <section>
            <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
                <table>
                    <tr>
                        <th colspan="2">Login</th>
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
                        <td><label for="recordar">Recordar Usuario</label></td>
                        <td><input type="checkbox" name="recordar" id="recordar"></td>
                    </tr>
                    <tr>
                        <th colspan="2"><input type="submit" value="Entrar"></th>
                    </tr>
                    <tr>
                        <th colspan="2"><? if(!empty($result)){ echo $result; } ?></th>
                    </tr>
                    <tr>
                        <th colspan="2"><a href="signup.php"><input type="button" value="Registrarse"></a></th>
                    </tr>
                </table>
            </form>
        </section>
    </body>
</html>