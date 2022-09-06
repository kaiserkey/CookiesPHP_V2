<?
require_once('config.php');
class Conection{
    private $con;
    
    public function __construct()
    {
        $this->setCon($this->conectionDB());
    }

    public function conectionDB(){
        try{
            $conect = new PDO(DATABASE . 'host='. HOST . '; dbname=' . DBNAME, DBUSER, DBPASSWORD);
            $conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conect->exec('SET CHARACTER SET ' . CHARSET);
            return $conect;
        }catch(PDOException $e){
            return 'ERROR: No se ha posido establecer la copnexion a la base de datos:' . $e;
        }
    }

    public function setCon($con){$this->con = $con;}
    public function getCon(){return $this->con;}

}
?>