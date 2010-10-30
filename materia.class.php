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

class Materias {
	
	//dados da matéria
	private $Id;
	private $Materia;
	private $Grupo;
	private $Abrev;
	private $Status;
	
	/// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setMateria($Materia){
		$this->Materia=$Materia;
	}
	
	public function setGrupo($Grupo){
		$this->Grupo=$Grupo;
	}
	
	public function setAbrev($Abrev){
		$this->Abrev=$Abrev;
	}
	
	public function setStatus($Status){
		$this->Status=$Status;
	}
	

	// getters
	
	public function getId(){
		return $this->Id;
	}
	
	public function getMateria(){
		return $this->Materia;
	}
	
	public function getGrupo(){
		return $this->Grupo;
	}
	
	public function getAbrev(){
		return $this->Abrev;
	}
	
	public function getStatus(){
		return $this->Status;
	}

	
	function getSQLMateria(){
		$sql="SELECT * FROM tb_materias WHERE ";
		$valor=$this->serializar();
		if(count($valor)>0){
				foreach($valor as $campo => $vlr){
					$sql.=" ".$campo."='".$vlr."' AND ";
				}

			$sql=substr($sql,0,-4);
			$rs=$GLOBALS["cdb"]->Execute($sql);

			if($rs->_numOfRows>0){
				while(!$rs->EOF){
					$a=new Materias;
					$a->setId($rs->fields["id"]);
					$a->setMateria($rs->fields["materia"]);
					$a->setGrupo($rs->fields["grupo"]);
					$a->setAbrev($rs->fields["abrev"]);
					$a->setStatus($rs->fields["status"]);
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
		$sql="INSERT INTO tb_materias (";
		
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
		$sql ="DELETE FROM tb_materias WHERE id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_materias SET ";
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
		if($this->Materia!=NULL){
			$valor["materia"]=$this->Materia;
		}
		if($this->Grupo!=NULL){
			$valor["grupo"]=$this->Grupo;
		}
		if($this->Abrev!=NULL){
			$valor["abrev"]=$this->Abrev;
		}
		if($this->Status!=NULL){
			$valor["status"]=$this->Status;
		}
		return $valor;
	}

}

class GrupoMateria{
	
	private $Id;
	private $NomeGrupo;
	private $Escola;
	private $Status;
	
	/// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setNomeGrupo($NomeGrupo){
		$this->NomeGrupo=$NomeGrupo;
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
	
	public function getNomeGrupo(){
		return $this->NomeGrupo;
	}
	
	public function getEscola(){
		return $this->Escola;
	}
	
	public function getStatus(){
		return $this->Status;
	}
	
		public function salvar(){
		if ($this->getId() == 0){
			return $this->insere();
		} else {
			return $this->update();
		}
	}
	
	private function insere(){
		$sql="INSERT INTO tb_materia_grupos (";
		
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
			print $GLOBALS["cdb"]->ErrorMsg();
			return false;
		}
	}
	
	public function delete(){
		$sql ="DELETE FROM tb_materia_grupos WHERE grupo_id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_materia_grupos SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE grupo_id='$this->Id'";
			if($GLOBALS["cdb"]->Execute($sql)){
				return $this->Id;
			} else {
				$err[]=$GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	function getSelectGrupoMateria($selected, $multiple){
	$sql="SELECT * FROM tb_materia_grupos WHERE grupo_status>0";
		$rs=$GLOBALS["cdb"]->Execute($sql);
		if($rs->_numOfRows>0){
			$return="<select name='grupo_materia'";
			if($multiple>0){
				$return.=" multiple='multiple' size='$multiple'";
			}
			$return.=">";
			$return.="<option value='0'>Nenhuma</option>";
			while(!$rs->EOF){
				$return.="<option value='".$rs->fields["grupo_id"]."'";
				if(strlen($selected)>0){
					if($rs->fields["grupo_id"]==$selected){
						$return.=" selected='selected'";
					}
				}
				$return.=">".$rs->fields["grupo_nome"]."</option>";
			$rs->MoveNext();
			}
			$return.="</select>";
		} else {
			$return="Nenhum grupo encontrado";
		}
		return $return;
	}
	
	private function serializar(){
		
		if($this->Id!=NULL){
			$valor["grupo_id"]=$this->Id;
		}
		if($this->NomeGrupo!=NULL){
			$valor["grupo_nome"]=$this->NomeGrupo;
		}
		if($this->Escola!=NULL){
			$valor["grupo_escola_id"]=$this->Escola;
		}
		if($this->Status!=NULL){
			$valor["grupo_status"]=$this->Status;
		}
		return $valor;
	}
}
?>