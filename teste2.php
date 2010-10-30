<?php
   function xml2array($xml) {
      $arXML=array();
      $arXML['name']=trim($xml->getName());
      $arXML['value']=trim((string)$xml);
      $t=array();
      foreach($xml->attributes() as $name => $value) $t[$name]=trim($value);
      $arXML['attr']=$t;
      $t=array();
      foreach($xml->children() as $name => $xmlchild) $t[$name]=xml2array($xmlchild);
      $arXML['children']=$t;
      return($arXML);
   }

   $xml = simplexml_load_file('teste.xml');
   echo '<pre>';
   print_r(xml2array($xml));
   echo '</pre>';
?>