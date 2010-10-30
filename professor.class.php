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

class Professor {
	
	//dados dos usuários
	private $Id;
	private $Nome;
	private $SobreNome;
	private $Rs;
	private $Sexo;
	private $Categoria;
	private $Disciplina;
	private $Escola;
	private $Turma;
	private $Turno;
	private $Telefone;
	private $Email;
	private $Usuario;
	private $Status;
	
	// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setNome($Nome){
		$this->Nome=$Nome;
	}
	
	public function setSobreNome($SobreNome){
		$this->SobreNome=$SobreNome;
	}
	
	public function setRs($Rs){
		$this->Rs=$Rs;
	}
	
	public function setSexo($Sexo){
		$this->Sexo=$Sexo;
	}
	
	public function setCategoria($Categoria){
		$this->Categoria=$Categoria;
	}
	
	public function setDisciplina($Disciplina){
		$this->Disciplina=$Disciplina;
	}
	
	public function setEscola($Escola){
		$this->Escola=$Escola;
	}
	
	public function setTurma($Turma){
		$this->Turma=$Turma;
	}
	
	public function setTurno($Turno){
		$this->Turno=$Turno;
	}
	
	public function setTelefone($Telefone){
		$this->Telefone=$Telefone;
	}
	
	public function setEmail($Email){
		$this->Email=$Email;
	}
	
	public function setUsuario($Usuario){
		$this->Usuario=$Usuario;
	}
	
	public function setStatus($Status){
		$this->Status=$Status;
	}
	
	
	// Getters
	public function getId(){
		return $this->Id;
	}
	
	public function getNome(){
		return $this->Nome;
	}
	
	public function getSobreNome(){
		return $this->SobreNome;
	}
	
	public function getRs(){
		return $this->Rs;
	}
	
	public function getSexo(){
		return $this->Sexo;
	}
	
	public function getCategoria(){
		return $this->Categoria;
	}
	
	public function getDisciplina(){
		return $this->Disciplina;
	}
	
	public function getEscola(){
		return $this->Escola;
	}
	
	public function getTurma(){
		return $this->Turma;
	}
	
	public function getTurno(){
		return $this->Turno;
	}
	
	public function getTelefone(){
		return $this->Telefone;
	}
	
	public function getEmail(){
		return $this->Email;
	}
	
	public function getUsuario(){
		return $this->Usuario;
	}
	
	public function getStatus(){
		return $this->Status;
	}
	
	function getProf(){ // pega professor referente ao ID
		if($this->Id>0){
			$rs=$GLOBALS["cdb"]->Execute("SELECT * FROM tb_professores WHERE prof_id='{$this->Id}'");
			if($rs->_numOfRows==1){
				$this->Nome=$rs->fields["prof_nome"];
				$this->SobreNome=$rs->fields["prof_sobrenome"];
				$this->Rs=$rs->fields["prof_rs"];
				$this->Sexo=$rs->fields["prof_sexo"];
				$this->Categoria=$rs->fields["prof_categoria"];
				$this->Disciplina=$rs->fields["prof_disciplina"];
				$this->Escola=$rs->fields["prof_escola"];
				$this->Turma=$rs->fields["prof_turma"];
				$this->Turno=$rs->fields["prof_turno"];
				$this->Telefone=$rs->fields["prof_telefone"];
				$this->Email=$rs->fields["prof_email"];
				$this->Usuario=$rs->fields["prof_usuario"];
				$this->Status=$rs->fields["prof_status"];
			} else {
				$this->Id=0;
				return false;
			}
		}
	}
	
	function getEscolas(){
		if($this->Id>0){
			include_once("escola.class.php");
			$esc=new Escola;
			$return=$esc->getRequestEscola($this->Id);
			if(count($return)>0){
				for($i=0;$i<count($return);$i++){
					$a[]=$return[$i]["escola"]; // pega o id de todas as escolas pertencentes e joga num array
				}
			}
			if(count($a)>0){
				return $a;
			} else {
				$this->Id=0;
				return false;
			}
		}
	}
	
	public function salvar(){
		if ($this->getId() == 0){
			return $this->insere();
		} else {
			return $this->update();
		}
	}
	
	private function insere(){
		$sql="INSERT INTO tb_professores (";
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
			print $GLOBALS["cdb"]->ErrorMsg();
			return false;
		}
	}
	
	public function delete(){
		$sql ="DELETE FROM tb_professores WHERE prof_id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}
	
	private function serializar(){
		if($this->Nome!=NULL){
			$valor["prof_nome"]=$this->Nome;
		}
		if($this->SobreNome!=NULL){
			$valor["prof_sobrenome"]=$this->SobreNome;
		}
		if($this->Rs!=NULL){
			$valor["prof_rs"]=$this->Rs;
		}
		if($this->Sexo!=NULL){
			$valor["prof_sexo"]=$this->Sexo;
		}
		if($this->Categoria!=NULL){
			$valor["prof_categoria"]=$this->Categoria;
		}
		if($this->Disciplina!=NULL){
			$valor["prof_disciplina"]=$this->Disciplina;
		}
		if($this->Escola!=NULL){
			$valor["prof_escola"]=$this->Escola;
		}
		if($this->Turma!=NULL){
			$valor["prof_turma"]=$this->Turma;
		}
		if($this->Turno!=NULL){
			$valor["prof_turno"]=$this->Turno;
		}
		if($this->Telefone!=NULL){
			$valor["prof_telefone"]=$this->Telefone;
		}
		if($this->Email!=NULL){
			$valor["prof_email"]=$this->Email;
		}
		if($this->Usuario!=NULL){
			$valor["prof_usuario"]=$this->Usuario;
		}
		if($this->Status!=NULL){
			$valor["prof_status"]=$this->Status;
		}
		
		return $valor;
	}
	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_professores SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE prof_id='$this->Id'";
			if($GLOBALS["cdb"]->Execute($sql)){
				return $this->Id;
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	function getSelectProf($selected, $escola, $multiple){
		$sql="SELECT * FROM tb_professores WHERE prof_status>0";
		if($escola>0){
			$sql.=" AND prof_escola LIKE '%;$escola;%'";
		}
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs->_numOfRows>0){
				$return="<select name='professores'";
				if($multiple==true){
					$return.=" multiple='multiple'";
				}
				$return.=">";
				while(!$rs->EOF){
					$return.="<option value='".$rs->fields["prof_id"]."'";
					if(strlen($selected)>0){
						if($rs->fields["prof_id"]==$selected){
							$return.=" selected='selected'";
						}
					}
					$return.=">".$rs->fields["prof_nome"]."</option>";
				$rs->MoveNext();
				}
				$return.="</select>";
			} else {
				$return="Nenhum professor encontrado";
			}
			return $return;
	}
	
	public function buscaProfessor($palavra="", $escola, $limite=10){
		if(strlen($palavra)>0){
			$rs=$GLOBALS["cdb"]->Execute("SELECT prof_id, prof_nome FROM tb_professores WHERE prof_nome LIKE '%".$palavra."%'  LIMIT $limite");
			if($rs->_numOfRows>0) {
				$retorno="";
				while (!$rs->EOF) {
					$retorno.='<li onClick="fill(\''.$rs->fields["prof_nome"].'\'); getCode(\''.$rs->fields["prof_id"].'\')">'.$rs->fields["prof_nome"].'</li>';
					$rs->MoveNext();
				}
			} else {
				$retorno='<li>Nenhum professor encontrado</li>';
			}
		}
		return $retorno;
	}
	
}

class Categoria{
	
	private $IdCat;
	private $NomeCat;
	private $StatusCat;
	
	//setters
	public function setIdCat($IdCat){
		$this->IdCat=$IdCat;
	}
	
	public function setNomeCat($NomeCat){
		$this->NomeCat=$NomeCat;
	}
	
	public function setStatusCat($StatusCat){
		$this->StatusCat=$StatusCat;
	}
		
	// Getters
	public function getIdCat(){
		return $this->IdCat;
	}
	
	public function getNomeCat(){
		return $this->NomeCat;
	}
	
	public function getStatusCat(){
		return $this->StatusCat;
	}
	
	
	function getSelectCategoria($selected, $multiple){
		$sql="SELECT * FROM tb_categorias WHERE cat_status>0";
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs->_numOfRows>0){
				$return="<select name='categoria'";
				if($multiple>0){
					$return.=" multiple='multiple' size='$multiple'";
				}
				$return.=">";
				$return.="<option value='0'>Nenhuma</option>";
				while(!$rs->EOF){
					$return.="<option value='".$rs->fields["cat_id"]."'";
					if(strlen($selected)>0){
						if($rs->fields["cat_id"]==$selected){
							$return.=" selected='selected'";
						}
					}
					$return.=">".$rs->fields["cat_nome"]."</option>";
				$rs->MoveNext();
				}
				$return.="</select>";
			} else {
				$return="Nenhuma categoria encontrada";
			}
			return $return;
	}
	
}
?>