<?
//conectando

$host="localhost";
$user="root";
$pass="joselito";
$banco="sae";
include "adodb5/adodb.inc.php";
$cdb = &ADONewConnection('mysql');
$cdb->PConnect($host, $user, $pass, $banco);

global $cdb;

//fecha conectando

class Telefone {
	
	//dados dos telefones
	private $Id;
	private $ProfId;
	private $DDD;
	private $Fone;
	private $Tipo;
	
	/// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setProfId($ProfId){
		$this->ProfId=$ProfId;
	}
	
	public function setDDD($DDD){
		$this->DDD=$DDD;
	}
	
	public function setFone($Fone){
		$this->Fone=$Fone;
	}
	
	public function setTipo($Tipo){
		$this->Tipo=$Tipo;
	}
	
	// getters
	
	public function getId(){
		return $this->Id;
	}
	
	public function getProfId(){
		return $this->ProfId;
	}
	
	public function getDDD(){
		return $this->DDD;
	}
	
	public function getFone(){
		return $this->Fone;
	}
	
	public function getTipo(){
		return $this->Tipo;
	}

	
	function getSQLFone(){
		$sql="SELECT * FROM tb_telefones WHERE ";
		$valor=$this->serializar();
		if(count($valor)>0){
				foreach($valor as $campo => $vlr){
					$sql.=" ".$campo."='".$vlr."' AND ";
				}

			$sql=substr($sql,0,-4);
			$rs=$GLOBALS["cdb"]->Execute($sql);

			if($rs->_numOfRows>0){
				while(!$rs->EOF){
					$a=new Telefone;
					$a->setDDD($rs->fields["tel_ddd"]);
					$a->setFone($rs->fields["tel_numero"]);
					$a->setTipo(utf8_encode($rs->fields["tel_tipo"]));
					$b[]=$a;
				$rs->MoveNext();
				}
				
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				$b=NULL;
			}
		} else {
			$b=NULL;
		}
			return $b;
	}
	
	function getArrayTipo(){

		$query = " SHOW COLUMNS FROM `tb_telefones` LIKE 'tel_tipo' ";
		$result=$GLOBALS["cdb"]->Execute($query);

		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $result->fields[1], $enum_array );
		$enum_fields = $enum_array[1];
		return( $enum_fields );

	} 
	

	public function salvar(){
		if ($this->getId() == 0){
			return $this->insere();
		} else {
			return $this->update();
		}
	}
	
	private function insere(){
		$sql="INSERT INTO tb_telefones (";
		
		$valor=$this->serializar();
		foreach($valor as $campo => $vlr){
			$sql.=" ".$campo.", ";
		}
		$sql=substr($sql,0,-2).") VALUES (";
		foreach($valor as $campo => $vlr){
			if($campo=="senha"){
				$sql.=" '".md5($vlr)."', ";
			} else {
				$sql.=" '".$vlr."', ";
			}
		}
		$sql=substr($sql,0,-2).")";
		if($GLOBALS["cdb"]->Execute($sql)){
			return $GLOBALS["cdb"]->Insert_ID();
		} else {
			$err[]=$GLOBALS["cdb"]->ErrorMsg();
			return false;
		}
	}
	
	public function delete(){
		$sql ="DELETE FROM tb_telefones WHERE tel_id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_telefones SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE tel_id='$this->Id'";
			if($GLOBALS["cdb"]->Execute($sql)){
				return $this->Id;
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	private function serializar(){
		
		if($this->ProfId!=NULL){
			$valor["tel_prof_id"]=$this->ProfId;
		}
		if($this->DDD!=NULL){
			$valor["tel_ddd"]=$this->DDD;
		}
		if($this->Fone!=NULL){
			$valor["tel_numero"]=$this->Fone;
		}
		if($this->Tipo!=NULL){
			$valor["tipo"]=$this->Tipo;
		}
		return $valor;
	}


}
?>