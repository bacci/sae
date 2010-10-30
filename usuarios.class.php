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

class Usuario {
	
	//dados dos usuários
	private $Id = 0;
	private $Nome = NULL;
	private $Usuario = NULL;
	private $Senha;
	private $Tipo;
	private $ProfId;
	private $EscolaId;
	private $Email;
	private $LastIp;
	private $DataCad = NULL;
	private $Status;
	
	/// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setNome($Nome){
		$this->Nome=$Nome;
	}
	
	public function setUsuario($Usuario){
		$this->Usuario=$Usuario;
	}
	
	public function setSenha($Senha){
		$this->Senha=$Senha;
	}
	
	public function setTipo($Tipo){
		$this->Tipo=$Tipo;
	}
	
	public function setProfId($ProfId){
		$this->ProfId=$ProfId;
	}
	
	public function setEscolaId($EscolaId){
		$this->EscolaId=$EscolaId;
	}
	
	public function setEmail($Email){
		$this->Email=$Email;
	}
	
	public function setLastIp($LastIp){
		$this->LastIp=$LastIp;
	}
	
	public function setDataCad($DataCad){
		$this->DataCad=$DataCad;
	}
	
	public function setAtualiza($Atualiza){
		$this->Atualiza=$Atualiza;
	}
	
	public function setStatus($Status){
		$this->Status=$Status;
	}
	
	// getters
	
	public function getId(){
		return $this->Id;
	}
	
	public function getNome(){
		return $this->Nome;
	}
	
	public function getUsuario(){
		return $this->Usuario;
	}
	
	public function getSenha(){
		return $this->Senha;
	}
	
	public function getTipo(){
		if($this->Tipo<1){
			return 1;
		} else {
			return $this->Tipo;
		}
	}
	
	public function getProfId(){
		return $this->ProfId;
	}
	
	public function getEscolaId(){
		return $this->EscolaId;
	}
	
	public function getEmail(){
		return $this->Email;
	}
	
	public function getLastIp(){
		return $this->LastIp;
	}
	
	public function getDataCad(){
		return $this->DataCad;
	}
	
	public function getAtualiza(){
		return $this->Atualiza;
	}
	
	public function getStatus(){
		return $this->Status;
	}
	
	public function testeUser(){
		
	}
	
	function getUser(){
		if($this->Id>0){
			$rs=$GLOBALS["cdb"]->Execute("SELECT * FROM tb_usuarios WHERE id='{$this->Id}'");
			if($rs->_numOfRows==1){
				$this->Nome=$rs->fields["nome1"];
				$this->Usuario=$rs->fields["usuario"];
				$this->Senha=$rs->fields["senha"];
				$this->Tipo=$rs->fields["tipo"];
				$this->ProfId=$rs->fields["prof_id"];
				$this->EscolaId=$rs->fields["escola_id"];
				$this->Email=$rs->fields["email"];
				$this->LastIp=$rs->fields["last_ip"];
				$this->DataCad=$rs->fields["data_cad"];
				$this->Atualiza=$rs->fields["atualiza"];
				$this->Status=$rs->fields["status"];
				return $this;
			} else {
				echo "Nenhum resultado encontrado";
			}
		}
	}
	
	function getSelectUser($selected, $tipo, $multiple){
			$rs=$GLOBALS["cdb"]->Execute("SELECT * FROM tb_usuarios WHERE tipo<'$tipo' AND status>0");
			if($rs->_numOfRows>0){
				$return="<select name='usuarios'";
				if($multiple==true){
					$return.=" multiple='multiple'";
				}
				$return.=">";
				while(!$rs->EOF){
					$return.="<option value='".$rs->fields["id"]."'";
					if(strlen($selected)>0){
						if(($rs->fields["id"]==$selected) OR ($rs->fields["usuario"]==$selected)){
							$return.=" selected='selected'";
						}
					}
					$return.=">".$rs->fields["nome1"]."(".$rs->fields["usuario"].")</option>";
				$rs->MoveNext();
				}
				$return.="</select>";
			} else {
				$return="Nenhum usuário encontrado";
			}
			return $return;
	}
	
	function checkUser(){
		$sql="SELECT * FROM tb_usuarios WHERE usuario LIKE '{$this->Usuario}'";
		if(strlen($this->Senha)>0){
			$sql.=" AND senha='".md5($this->Senha)."'";
		}
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs->_numOfRows==1){
				$this->Id=$rs->fields["id"];
				$this->Nome=$rs->fields["nome1"];
				$this->Tipo=$rs->fields["tipo"];
				$this->ProfId=$rs->fields["prof_id"];
				$this->EscolaId=$rs->fields["escola_id"];
				$this->Email=$rs->fields["email"];
				$this->LastIp=$rs->fields["last_ip"];
				$this->DataCad=$rs->fields["data_cad"];
				$this->Atualiza=$rs->fields["atualiza"];
				$this->Status=$rs->fields["status"];
				return $this;
			} else {
				return false;
			}
	}
	
	function isDuplicated($username){
		$sql="SELECT id FROM tb_usuarios WHERE usuario LIKE '{$username}'";
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs->_numOfRows>0){
				return true;
			} else {
				return false;
			}
	}
	
	
	public function salvar(){
		if ($this->getId() == 0){
			return $this->insere();
		} else {
			return $this->update();
		}
		return false;
	}
	
	private function insere(){
		$sql="INSERT INTO tb_usuarios (";
		
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
			return true;
		} else {
			$err[]=$GLOBALS["cdb"]->ErrorMsg();
			return false;
		}
	}
	
	public function delete(){
		$sql ="DELETE FROM tb_usuarios WHERE id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_usuarios SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE id='$this->Id'";
			if($GLOBALS["cdb"]->Execute($sql)){
				return $GLOBALS["cdb"]->Insert_ID();
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	private function serializar(){
		if($this->Nome!=NULL){
			$valor["nome1"]=$this->Nome;
		}
		if($this->Usuario!=NULL){
			$valor["usuario"]=$this->Usuario;
		}
		if($this->Senha!=NULL){
			$valor["senha"]=$this->Senha;
		}
		if($this->Tipo!=NULL){
			$valor["tipo"]=$this->Tipo;
		}
		if($this->ProfId!=NULL){
			$valor["prof_id"]=$this->ProfId;
		}
		if($this->EscolaId!=NULL){
			$valor["escola_id"]=$this->EscolaId;
		}
		if($this->Email!=NULL){
			$valor["email"]=$this->Email;
		}
		if($this->LastIp!=NULL){
			$valor["last_ip"]=$this->LastIp;
		}
		if($this->DataCad!=NULL){
			$valor["data_cad"]=$this->DataCad;
		}
		if($this->Atualiza!=NULL){
			$valor["atualiza"]=$this->Atualiza;
		}
		if($this->Status!=NULL){
			$valor["status"]=$this->Status;
		}
		return $valor;
	}


}
?>