<?
//------------------------------------------------------------------------
// Web Service CEP, desenvolvido por Evanil Rosano de Paula.
// Este Web Service está habilitado para funcionar em qualquer servidor, 
// no entanto terá melhor desempenho em sites hospedados pela Via Virtual.
// Visite nosso site e conheça nossos serviços.
// Via Virtual - Solucões WEB
// http://www.viavirtual.com.br
//-------------------------------------------------------------------------
$consulta = 'http://viavirtual.com.br/webservicecep.php?cep='.$_GET['cep'];
$consulta = file($consulta);
$consulta = explode('||',$consulta[0]);
// Caso seja necessário poderá salvar os dados em SESSION
$end=explode(" ",utf8_encode($consulta[0]));

$rua=str_replace($end[0]." ", "", utf8_encode($consulta[0]));
$bairro=utf8_encode($consulta[1]);
$cidade=utf8_encode($consulta[2]);
$uf=$consulta[4];
?>{"logradouro":"<? echo $end[0]; ?>", "rua":"<? echo $rua; ?>","bairro":"<? echo $bairro; ?>","cidade":"<? echo $cidade; ?>","uf":"<? echo $uf; ?>"}