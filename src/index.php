<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	$animalList = [
		[
			"ownerEmail" => "cbe@croquetteland.com", 
			"nom" => "Toyant", 		
			"espece" => "chat",  	
			"infos" => [
				"age" => 17, 	
				"maladie" => "Diabete", 
				"activity" => "calme"
			]
		],
		[
			"ownerEmail" => "cbe@croquetteland.com",
			"nom" => "Dent",
			"espece" => "chien",
			"infos" => [
				"age" => 7, 
				"maladie" => "aucune", 
				"activity" => "magique"
			]
		],
		["ownerEmail" => "bri@croquetteland.com", 	"nom" => "Peau", 		"espece" => "chat",  	"infos" => ["age" => 12, 	"maladie" => "Schizophrenie", 	"activity" => "babyfoot"]],
		["ownerEmail" => "bri@croquetteland.com", 	"nom" => "Chaud", 		"espece" => "chien",  	"infos" => ["age" => 7, 	"maladie" => "Alcoolique", 			"activity" => "pornfood"]]
	];
?>  
<html xmlns="http://www.w3.org/1999/xhtml">
	<head></head>
	<body>
		<pre>
			<?php
			// var_dump($animalList);
			?>
		</pre>
		<table>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Email Propriétaire</th>
					<th>Espèce</th>
					<th>Infos</th>
				</tr>
			</thead>
			<tbody> <!-- DM : Dynamiser le Tbody (les données sont dans la variable php $animalList -->
				<?php
				foreach ($animalList as $animal) { ?>
					<tr>
						<td>
							<?php echo $animal["nom"]; ?>
						</td>
						<td>
							<?php echo $animal["ownerEmail"]; ?>
						</td>
						<td>
							<?php echo $animal["espece"]; ?>
						</td>
						<td>
							<ul>
								<?php foreach ($animal["infos"] as $nomInfo => $valeurInfo) { ?>
									<li>
										<?php echo ucfirst($nomInfo) . " : " . ucfirst($valeurInfo); ?>
									</li>
								<?php } ?>
							</ul>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</body>
</html>