<?php

class Crawler
{	
	private function pr($exp1, $exp2, $subject,$replace=""){
		return preg_replace("/({$exp1})(.*)({$exp2})/", $replace, $subject);
	 }
	 private function prs($exp1, $exp2, $subject,$replace=""){
		return preg_replace("/({$exp1})(.*)({$exp2})/s", $replace, $subject);
	 }
	 private function prAll($exp1, $exp2, $subject){
		preg_match("/({$exp1})(.*)({$exp2})/s", $subject, $matches);
		return $matches;
	 }
	 
	 private function limpaHtml($subject)
	 {
		 $result_1 = $this->prAll('<ul class="list-unstyled noticias','<div class="text-center">', $subject);
		 $result_2 = $this->pr(' class="','"', $result_1[2], "");
		 $result_2 = str_replace("</ul>", "", $result_2);
		 $result_2 = str_replace("<hr />", "", $result_2);
		 $result_2 = str_replace('pdf">', "pdf|", $result_2);
		 $result_2 = str_replace('">', "", $result_2);
		 $result_2 = str_replace("</li>", "", $result_2);
		 $result_2 = str_replace("<p>", "", $result_2);
		 $result_2 = str_replace("</p>", "", $result_2);
		 $result_2 = str_replace("<h3>", "", $result_2);
		 $result_2 = str_replace('<a href="', "", $result_2);
		 $result_2 = str_replace("</h3>", "|", $result_2);
		 $result_2 = str_replace("<li>", "", $result_2);
		 $result_2 = str_replace("\n", "", $result_2);
		 $result_2 = str_replace("\t", "", $result_2);
		 $result_2 = str_replace("</a>", "@@FIMLINHA@@", $result_2);
		
		 $search_1 = array("Nº","N°","N.º","nº","nº");
		 $result_2 = str_replace($search_1, "n.º", $result_2);
	 
		 for ($i=0; $i <= 99; $i++) { 
			 $dt = DateTime::createFromFormat('y', $i);
			 $ano = str_pad($i, 2, "0", STR_PAD_LEFT);			 
			 $result_2 = str_replace("/{$ano}|", "/{$dt->format('Y')}|", $result_2);
			 $result_2 = str_replace("/{$ano} |", "/{$dt->format('Y')}|", $result_2);
			 $result_2 = str_replace("/{$ano} (", "/{$dt->format('Y')} (", $result_2);
			 $result_2 = str_replace("/{$ano} [", "/{$dt->format('Y')} [", $result_2);		 
		 }
	 
		 $result_2 = substr($result_2, 0, -12);
		 return explode("@@FIMLINHA@@",$result_2);
	 }
	 
	 public function run($url_server, $numeroUltimaPagina = 320){
		 $paginas = array();	
		 $subject = file_get_contents($url_server); 
		 $paginas[0] = $this->limpaHtml($subject);
		  
		 for ($i=10; $i < $numeroUltimaPagina; $i+=10) { 
			 $subject = file_get_contents($url_server . "/0/{$i}");		
			 $paginas[$i] = $this->limpaHtml($subject);
		 }
		 return $paginas;
	 }
}
?>