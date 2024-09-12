<?php 
class Auto {
    private $patente;
    private $marca;
    private $modelo;
    private $dniDuenio;
    private $mensajeoperacion;
    
   
    public function __construct(){
        $this->patente="";
        $this->marca="";
        $this->modelo="";
        $this->dniDuenio="";
        $this->mensajeoperacion ="";
    }

    public function setear($patente, $marca, $modelo, $dniDuenio)    {
        $this->setPatente($patente);
        $this->setMarca($marca);
        $this->setModelo($modelo);
        $this->setDniDuenio($dniDuenio);
    }
    
    public function getPatente(){
        return $this->patente;
    }
    public function setPatente($valor){
        $this->patente = $valor;
    }
    
    public function getMarca(){
        return $this->marca;
    }

    public function setMarca($valor){
        $this->marca = $valor;
    }

    public function getModelo(){
        return $this->modelo;
    }

    public function setModelo($valor){
        $this->modelo = $valor;
    }

    public function getDniDuenio(){
        return $this->dniDuenio;
    }

    public function setDniDuenio($valor){
        $this->dniDuenio = $valor;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }

    public function cargar(){
        $resp = false;
        $base=new Database();
        $sql="SELECT * FROM auto WHERE patente = '".$this->getPatente()."';";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['Patente'], $row['Marca'], $row['Modelo'], $row['DniDuenio']);
                }
            }
        } else {
            $this->setmensajeoperacion("Auto->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base=new Database();
        $sql = "INSERT INTO auto(Patente, Marca, Modelo, DniDuenio) VALUES ('".$this->getPatente()."','".$this->getMarca()."','".$this->getModelo()."','".$this->getDniDuenio()."')";
        if ($base->Iniciar()) {
            $base->Ejecutar($sql);
            $resp = true;
        } else {
            $this->setmensajeoperacion("Auto->insertar: ".$base->getError());
        }
        return $resp;
    }
    
    /**
     * Cargada correctamente la patente modifica el resto de variables
     */
    public function modificar(){
        $resp = false;
        $base=new Database();
        $sql="UPDATE auto SET 
        Marca='".$this->getMarca()."',
        Modelo='".$this->getModelo()."',
        DniDuenio='".$this->getDniDuenio()."'
        WHERE patente='".$this->getPatente()."';";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Auto->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->modificar: ".$base->getError());
        }
        return $resp;
    }

    /**
     * Elimina el auto según la patente cargada
     */
    public function eliminar(){
        $resp = false;
        $base=new database();
        $sql="DELETE FROM auto WHERE patente='".$this->getPatente()."';";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Auto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->eliminar: ".$base->getError());
        }
        return $resp;
    }

    /**
     * Si se le pasa un páramentro lista los autos que lo cumplan, sino lista todos
     * @param String $paramentro
     */
    public static function listar($parametro=""){
        $arreglo = array();
        $base=new Database();
        $sql="SELECT * FROM auto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Auto();
                    $obj->setear($row['Patente'], $row['Marca'], $row['Modelo'], $row['DniDuenio']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        }
        return $arreglo;
    }

    public function __toString(){
        return "
        Patente: " . $this->getPatente() . "\n
        Marca: " . $this->getMarca() . "\n
        Modelo: " . $this->getModelo() . "\n
        DNI Dueño: " . $this->getDniDuenio() . "\n
        ";
    }
}