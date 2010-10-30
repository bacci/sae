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

class Alunos {
	
	//dados dos telefones
	private $Id;
	private $Ra;
	private $Nome;
	private $Numero;
	private $Classe;
	private $Escola;
	private $Status;
	
	/// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setRa($Ra){
		$this->Ra=$Ra;
	}
	
	public function setNome($Nome){
		$this->Nome=$Nome;
	}
	
	public function setNumero($Numero){
		$this->Numero=$Numero;
	}
	
	public function setClasse($Classe){
		$this->Classe=$Classe;
	}
	
	public function setEscola($Escola){
		$this->Escola=$Escola;
	}
	
	public function setStatus($Status){
		$this->Status=$Status;
	}
	

	// getters
	
	public function getId(){
		return $this->Id;
	}
	
	public function getRa(){
		return $this->Ra;
	}
	
	public function getNome(){
		return $this->Nome;
	}
	
	public function getNumero(){
		return $this->Numero;
	}
	
	public function getClasse(){
		include "classes.class.php";
		$classe=new Classes;
		$classe->setId($this->Classe);
		$a=$classe->getSQLClasse();
		return $a;
	}
	
	public function getEscola(){
		include "escola.class.php";
		$escola=new Escola;
		$escola->setId($this->Escola);
		$a=$escola->getEscola();
		return $a;
	}

	public function getStatus(){
		return $this->Status;
	}

	
	function getSQLAlunos(){
		$sql="SELECT * FROM tb_alunos WHERE ";
		$valor=$this->serializar();
		if(count($valor)>0){
				foreach($valor as $campo => $vlr){
					$sql.=" ".$campo."='".$vlr."' AND ";
				}

			$sql=substr($sql,0,-4);
			$rs=$GLOBALS["cdb"]->Execute($sql);

			if($rs->_numOfRows>0){
				while(!$rs->EOF){
					$a=new Classe;
					$a->setId($rs->fields["id"]);
					$a->setRa($rs->fields["ra"]);
					$a->setNome($rs->fields["nome"]);
					$a->setNumero($rs->fields["numero"]);
					$a->setClasse($rs->fields["classe"]);
					$a->setEscola($rs->fields["escola"]);
					$a->setStatus($rs->fields["classe_status"]);
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
	

	public function salvar(){
		if ($this->getId() == 0){
			return $this->insere();
		} else {
			return $this->update();
		}
	}
	
	private function insere(){
		$sql="INSERT INTO tb_alunos (";
		
		$valor=$this->serializar();
		foreach($valor as $campo => $vlr){
			$sql.=" ".$campo.", ";
		}
		$sql=substr($sql,0,-2).") VALUES (";
		foreach($valor as $campo => $vlr){
			$sql.=" '".$vlr."', ";
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
		$sql ="DELETE FROM tb_alunos WHERE id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_alunos SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE id='$this->Id'";
			if($GLOBALS["cdb"]->Execute($sql)){
				return $this->Id;
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	private function serializar(){
		
		if($this->Id!=NULL){
			$valor["id"]=$this->Id;
		}
		if($this->Ra!=NULL){
			$valor["ra"]=$this->Ra;
		}
		if($this->Nome!=NULL){
			$valor["nome"]=$this->Nome;
		}
		if($this->Numero!=NULL){
			$valor["numero"]=$this->Numero;
		}
		if($this->Classe!=NULL){
			$valor["classe"]=$this->Classe;
		}
		if($this->Escola!=NULL){
			$valor["escola"]=$this->Escola;
		}
		if($this->Status!=NULL){
			$valor["status"]=$this->Status;
		}
		return $valor;
	}

}
?>