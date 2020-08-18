<?php 
  require_once('Crawler.class.php');
  $crawler = new Crawler();
  $url_site = 'http://conter.gov.br/site/resolucoes';
  $paginas = $crawler->run($url_site);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Resoluções</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid mt-5">
  <h2>Resoluções Conter</h2>
  <p>Realize uma pesquisa avançada, dígite um termo:</p>
  <input class="form-control" id="myInput" type="text" placeholder="Buscar..">            
  <table class="table table-hover" id="tblCustomers">
    <thead>
      <tr>
        <th>Número</th>
        <th>Descrição</th>        
        <th></th>        
      </tr>
    </thead>
    <tbody id="myTable">
      
	<?php
	foreach ($paginas as $keyPagina => $pagina) {
	 	foreach ($pagina as $keyResolucoes => $resolucoes) {
	 		$arrayResolucao = explode('|',$resolucoes);

	 		$nomeResolucao = $arrayResolucao[0];
	 		$linkResolucao = $arrayResolucao[1];
	 		$descricaoResolucao = $arrayResolucao[2];
			echo "<tr>";
				echo"<td>{$nomeResolucao}</td>";
	            echo"<td><a target='blank' href='{$linkResolucao}'>{$descricaoResolucao}</a></td>";
	            echo"<td><a target='blank' href='{$url_site}/0/{$keyPagina}'>Fonte</a></td>";
      		echo '</tr>';
	 	}	 	
	}   
	?>
	</tr>     
    </tbody>
  </table>
</div>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

</body>
</html>