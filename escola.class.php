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

class Escola {
	
	//dados dos usuários
	private $Id; // id da escola
	private $Nome; // nome da escola
	private $Cep;
	private $Logra;
	private $End;
	private $Numero;
	private $Compl;
	private $Bairro;
	private $Cidade;
	private $Estado;
	private $Professores; // Professores
	private $DE;
	private $Telefone;
	private $Turma; // Turmas -> Alunos
	private $Usuario; // Usuário responsável
	private $Status; // status 0 = Inativo, 1 = Ativo
	private $Tipo;
	private $Total; // Total de resultados
	
	// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setNome($Nome){
		$this->Nome=$Nome;
	}
	
	public function setCep($Cep){
		$this->Cep=$Cep;
	}

	public function setLogra($Logra){
		$this->Logra=$Logra;
	}
	
	public function setEnd($End){
		$this->End=$End;
	}

	public function setNumero($Numero){
		$this->Numero=$Numero;
	}

	public function setCompl($Compl){
		$this->Compl=$Compl;
	}

	public function setBairro($Bairro){
		$this->Bairro=$Bairro;
	}
	
	public function setCidade($Cidade){
		$this->Cidade=$Cidade;
	}
	
	public function setEstado($Estado){
		$this->Estado=$Estado;
	}
	
	public function setProfessores($professor_id, $professor_status){
		if($this->Id>0){
			$sql="UPDATE tb_prof_escola SET status =  '$professor_status' WHERE prof_id='$professor_id' AND escola_id='".$this->Id."'";
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs){
				return true;
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	public function setDE($DE){
		$this->DE=$DE;
	}
	
	public function setTelefone($Telefone){
		$this->Telefone=$Telefone;
	}
	
	public function setTurma($Turma){
		$this->Turma=$Turma;
	}
	
	public function setUsuario($Usuario){
		$this->Usuario=$Usuario;
	}
	
	public function setStatus($Status){
		$this->Status=$Status;
	}
	
	public function setTipo($Tipo){
		$this->Tipo=$Tipo;
	}
	
	public function setTotal($Total){
		$this->Total=$Total;
	}
	
	
	// Getters
	public function getId(){
		return $this->Id;
	}
	
	public function getNome(){
		return $this->Nome;
	}
	
	public function getCep(){
		return $this->Cep;
	}
	
	public function getLogra(){
		return $this->Logra;
	}
	
	public function getEnd(){
		return $this->End;
	}
	
	public function getNumero(){
		return $this->Numero;
	}

	public function getCompl(){
		return $this->Compl;
	}
	
	public function getBairro(){
		return $this->Bairro;
	}
	
	public function getCidade(){
		return $this->Cidade;
	}
	
	public function getEstado(){
		return $this->Estado;
	}
	
	public function getProfessores($status=2){
		if($this->Id>0){
			$sql="SELECT
			tb_prof_escola.prof_id
			FROM
			tb_prof_escola
			Inner Join tb_professores ON tb_prof_escola.prof_id = tb_professores.prof_id
			WHERE
			tb_prof_escola.escola_id = '".$this->Id."' AND 
			tb_prof_escola.`status` =  '$status'";
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs){
				if($rs->_numOfRows>0){
					$cont=0;
					while(!$rs->EOF){
						$id_prof=$rs->fields[0];
						require_once('professor.class.php');
						$prof=new Professor;
						$prof->setId($id_prof);
						$prof->getProf();
						$a[]=$prof;
					$rs->MoveNext();
					}
					return $a;
				} else {
					return false;
				}
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	public function getDE(){
		return $this->DE;
	}
	
	public function getTelefone(){
		return $this->Telefone;
	}
	
	public function getTurma(){
		return $this->Turma;
	}
	
	public function getUsuario(){
		return $this->Usuario;
	}
	
	public function getStatus(){
		return $this->Status;
	}
	
	public function getTipo(){
		return $this->Tipo;
	}
	
	public function getTotal(){
		return $this->Total;
	}
	
	
	// validando cada objeto e gravando em um array para usar no banco de dados
	private function serializar(){
	
		if($this->Id!=NULL){
			$valor["esc_id"]=$this->Id;
		}
		
		if($this->Nome!=NULL){
			$valor["esc_nome"]=$this->Nome;
		}
		
		if($this->Cep!=NULL){
			$valor["esc_cep"]=$this->Cep;
		}
		
		if($this->Logra!=NULL){
			$valor["esc_logradouro"]=$this->Logra;
		}
		
		if($this->End!=NULL){
			$valor["esc_end"]=$this->End;
		}
		
		if($this->Numero!=NULL){
			$valor["esc_num"]=$this->Numero;
		}
	
		if($this->Compl!=NULL){
			$valor["esc_compl"]=$this->Compl;
		}
		
		if($this->Bairro!=NULL){
			$valor["esc_bairro"]=$this->Bairro;
		}
		
		if($this->Cidade!=NULL){
			$valor["esc_cidade"]=$this->Cidade;
		}
		
		if($this->Estado!=NULL){
			$valor["esc_estado"]=$this->Estado;
		}
		
		if($this->Professores!=NULL){
			$valor["esc_professores"]=$this->Professores;
		}
		
		if($this->DE!=NULL){
			$valor["esc_de"]=$this->DE;
		}
		
		if($this->Telefone!=NULL){
			$valor["esc_fone"]=$this->Telefone;
		}
		
		if($this->Turma!=NULL){
			$valor["esc_turma"]=$this->Turma;
		}
		
		if($this->Usuario!=NULL){
			$valor["esc_usuario"]=$this->Usuario;
		}
		
		if($this->Status!=NULL){
			$valor["esc_status"]=$this->Status;
		}
		
		if($this->Tipo!=NULL){
			$valor["esc_tipo"]=$this->Tipo;
		}
		return $valor;
	}
	
	function getEscola(){
		if($this->Id>0){
			$rs=$GLOBALS["cdb"]->Execute("SELECT * FROM tb_escola WHERE esc_id='{$this->Id}'");
			if($rs->_numOfRows==1){
				$this->Nome=$rs->fields["esc_nome"];
				$this->Telefone=$rs->fields["esc_fone"];
				$this->Cep=$rs->fields["esc_cep"];
				$this->Logra=$rs->fields["esc_logra"];
				$this->End=$rs->fields["esc_end"];
				$this->Numero=$rs->fields["esc_num"];
				$this->Compl=$rs->fields["esc_compl"];
				$this->Bairro=$rs->fields["esc_bairro"];
				$this->Cidade=$rs->fields["esc_cidade"];
				$this->Estado=$rs->fields["esc_estado"];
				$this->Professores=$rs->fields["esc_professores"];
				$this->DE=$rs->fields["esc_de"];
				$this->Turma=$rs->fields["esc_turma"];
				$this->Tipo=$rs->fields["esc_tipo"];
				$this->Usuario=$rs->fields["esc_usuario"];
				$this->Status=$rs->fields["esc_status"];
			} else {
				$this->Id=0;
				return false;
			}
		}
	}
	
	function listaEscola($limit1=0, $limit2=999999999){
		$sql="SELECT * FROM tb_escola WHERE ";
			$valor=$this->serializar();
			if(count($valor)>0){
				foreach($valor as $campo => $vlr){
					$sql.=" ".$campo."='".$vlr."' AND ";
				}
			}
			$sql=substr($sql,0,-4)." LIMIT $limit1, $limit2";
			$rs=$GLOBALS["cdb"]->Execute($sql);
			if($rs){
				while(!$rs->EOF){
					$nova=new Escola;
					$nova->setId($rs->fields["esc_id"]);
					$nova->setNome($rs->fields["esc_nome"]);
					$nova->setCep($rs->fields["esc_cep"]);
					$nova->setEnd($rs->fields["esc_end"]);
					$nova->setNumero($rs->fields["esc_num"]);
					$nova->setCompl($rs->fields["esc_compl"]);
					$nova->setBairro($rs->fields["esc_bairro"]);
					$nova->setCidade($rs->fields["esc_cidade"]);
					$nova->setTelefone($rs->fields["esc_fone"]);
					$nova->setEstado($rs->fields["esc_estado"]);
					$nova->setProfessores($rs->fields["esc_professores"]);
					$nova->setDE($rs->fields["esc_de"]);
					$nova->setStatus($rs->fields["esc_status"]);
					$nova->setTurma($rs->fields["esc_turma"]);
					$nova->setTipo($rs->fields["esc_tipo"]);
					$nova->setUsuario($rs->fields["esc_usuario"]);
					$nova->setTotal($rs->_numOfRows);
					$a[]=$nova;
					$rs->MoveNext();
				}
				return $a;
			} else {
				return $cdb->ErrorMsg();
			}
			
	}
	
	function buscaEscola($palavra="", $limite=10){
		if(strlen($palavra)>0){
			$rs=$GLOBALS["cdb"]->Execute("SELECT esc_id, esc_nome FROM tb_escola WHERE esc_nome LIKE '%".$palavra."%' LIMIT $limite");
			if($rs->_numOfRows>0) {
				$retorno="";
				while (!$rs->EOF) {
					$retorno.='<li onClick="fill(\''.$rs->fields["esc_nome"].'\'); getCode(\''.$rs->fields["esc_id"].'\')">'.$rs->fields["esc_nome"].'</li>';
					$rs->MoveNext();
				}
			} else {
				$retorno='<li>Nenhuma escola encontrada</li>';
			}
		}
		return $retorno;
	}
	
	public function salvar(){
		if ($this->getId() == 0){
			return $this->insere();
		} else {
			return $this->update();
		}
	}
	
	private function insere(){
		$sql="INSERT INTO tb_escola (";
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
		$sql ="DELETE FROM tb_escola WHERE esc_id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_escola SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE esc_id='{$this->Id}'";
			if($GLOBALS["cdb"]->Execute($sql)){
				return $this->Id;
			} else {
				print $GLOBALS["cdb"]->ErrorMsg();
				return false;
			}
		}
	}
	
	public function requestEscola($prof_id, $escola_id){
		$sql="INSERT INTO tb_prof_escola (prof_id, escola_id, prof_desde, status) VALUES ('$prof_id', '$escola_id', '".date("y-m-d")."',1)";
		if($GLOBALS["cdb"]->Execute($sql)){
			return $GLOBALS["cdb"]->Insert_ID();
		} else {
			//print $GLOBALS["cdb"]->ErrorMsg();
			return false;
		}
	}
	
	public function getRequestEscola($prof_id=NULL, $escola_id=NULL){
		$sql="SELECT * FROM tb_prof_escola WHERE ";
		if($prof_id!=NULL){
			$sql.=" prof_id='$prof_id'";
		} elseif(($prof_id!=NULL) AND ($escola_id!=NULL)){
			$sql.=" prof_id='$prof_id' AND escola_id='$escola_id'";
		} else {
			$sql.=" escola_id='$escola_id'";
		}
		$rs=$GLOBALS["cdb"]->Execute($sql);
		if($rs){
			if($rs->_numOfRows>0){
				$cont=0;
				while(!$rs->EOF){
					$a[$cont]["id"]=$rs->fields["id"];
					$a[$cont]["professor"]=$rs->fields["prof_id"]; // id do professor
					$a[$cont]["escola"]=$rs->fields["escola_id"]; // id da escola
					$a[$cont]["principal"]=$rs->fields["principal"]; // se =1 escola principal, se 0 = outra escola
					$a[$cont]["desde"]=$rs->fields["prof_desde"]; // aceito em Y-m-d
					$a[$cont]["status"]=$rs->fields["status"]; // se 0 = negado, se 1 = aguardando, se 2 = autorizado;
					$cont++;
				$rs->MoveNext();
				}
				return $a;
			} else {
				return false;
			}
		} else {
			print $GLOBALS["cdb"]->ErrorMsg();
			return false;
		}
	}
}
?>