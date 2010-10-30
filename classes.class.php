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

class Classes {
	
	//dados dos telefones
	private $Id;
	private $NomeClasse;
	private $Escola;
	private $MateriaGrupo;
	private $PeriodoIni;
	private $PeriodoFim;
	private $Status;
	
	/// setters
	public function setId($Id){
		$this->Id=$Id;
	}
	
	public function setNomeClasse($NomeClasse){
		$this->NomeClasse=$NomeClasse;
	}
	
	public function setEscola($Escola){
		$this->Escola=$Escola;
	}
	
	public function setMateriaGrupo($MateriaGrupo){
		$this->MateriaGrupo=$MateriaGrupo;
	}
	
	public function setPeriodoIni($PeriodoIni){
		$this->PeriodoIni=$PeriodoIni;
	}
	
	public function setPeriodoFim($PeriodoFim){
		$this->PeriodoFim=$PeriodoFim;
	}
	
	public function setStatus($Status){
		$this->Status=$Status;
	}
	

	// getters
	
	public function getId(){
		return $this->Id;
	}
	
	public function getNomeClasse(){
		return $this->NomeClasse;
	}
	
	public function getEscola(){
		return $this->Escola;
	}
	
	public function getMateriaGrupo(){
		return $this->MateriaGrupo;
	}
	
	public function getPeriodoIni(){
		return $this->PeriodoIni;
	}
	
	public function getPeriodoFim(){
		return $this->PeriodoFim;
	}
	
	public function getStatus(){
		return $this->Status;
	}

	
	function getSQLClasse(){
		$sql="SELECT * FROM tb_classe WHERE ";
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
					$a->setNome($rs->fields["classe_nome"]);
					$a->setEscola($rs->fields["classe_escola"]);
					$a->setMateriaGrupo($rs->fields["classe_materia_grupo"]);
					$a->setPeriodoIni($rs->fields["classe_periodo_ini"]);
					$a->setPeriodoFim($rs->fields["classe_periodo_fim"]);
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
		$sql="INSERT INTO tb_classe (";
		
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
		$sql ="DELETE FROM tb_classe WHERE classe_id = '".$this->getId()."'"; 
		if($GLOBALS["cdb"]->Execute($sql)){
			$this->setId(0);
		}
	}

	
	private function update(){
		if($this->Id>0){
			$sql="UPDATE tb_classe SET ";
			$valor=$this->serializar();
			foreach($valor as $campo => $vlr){
				$sql.=" ".$campo."='".$vlr."', ";
			}
			$sql=substr($sql,0,-2)." WHERE classe_id='$this->Id'";
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
			$valor["classe_id"]=$this->Id;
		}
		if($this->NomeClasse!=NULL){
			$valor["classe_nome"]=$this->ClasseNome;
		}
		if($this->Escola!=NULL){
			$valor["classe_escola"]=$this->Escola;
		}
		if($this->MateriaGrupo!=NULL){
			$valor["classe_materia_grupo"]=$this->MateriaGrupo;
		}
		if($this->PeriodoIni!=NULL){
			$valor["classe_periodo_ini"]=$this->PeriodoIni;
		}
		if($this->PeriodoFim!=NULL){
			$valor["classe_periodo_fim"]=$this->PeriodoFim;
		}
		if($this->Status!=NULL){
			$valor["classe_status"]=$this->Status;
		}
		return $valor;
	}
	
	public function getClassesProf($prof_id, $escola_id){
		$sql="SELECT
		tb_classe.classe_id,
		tb_classe.classe_nome,
		tb_classe.classe_escola,
		tb_classe.classe_materia_grupo,
		tb_classe.classe_periodo_ini,
		tb_classe.classe_periodo_fim,
		tb_classe.classe_status
		FROM
		tb_classe
		Inner Join tb_prof_classe ON tb_classe.classe_escola = tb_prof_classe.escola_id
		WHERE
		tb_prof_classe.prof_id =  '$prof_id' AND
		tb_prof_classe.escola_id =  '$escola_id'";
		$rs=$GLOBALS["cdb"]->Execute($sql);

			if($rs->_numOfRows>0){ // se conter resultados
				while(!$rs->EOF){
					$a=new Classe;
					$a->setNome($rs->fields["classe_nome"]);
					$a->setEscola($rs->fields["classe_escola"]);
					$a->setMateriaGrupo($rs->fields["classe_materia_grupo"]);
					$a->setPeriodoIni($rs->fields["classe_periodo_ini"]);
					$a->setPeriodoFim($rs->fields["classe_periodo_fim"]);
					$a->setStatus($rs->fields["classe_status"]);
					$b[]=$a;
				$rs->MoveNext();
				}
				
			} else { // se não conter resultados
				print $GLOBALS["cdb"]->ErrorMsg();
				$b=NULL; // anula
			}
		return $b;
	}

}
?>