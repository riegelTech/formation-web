<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$props = ["nom", "espece", "age", "maladie", "activité"];
$animalList = [
	[$props[0] => "Toyant", $props[1] => "chat", $props[2] => 17, $props[3] => "Diabete", $props[4] => "calme"],
	[$props[0] => "Dent", $props[1] => "chien", $props[2] => 7, $props[3] => "aucune", $props[4] => "magique"]
];
?>  

<html xmlns="http://www.w3.org/1999/xhtml">
	<head></head>
	<body>
		<pre>
		<?php
		//print_r($animaux);
		?>
		</pre>
		<table>
			<tr>
				<?php
				foreach ($props as $prop) {
					echo "<th>$prop</th>";
				}
				?>
			</tr>
			<?php 
			foreach( $animalList as $animal ) {
			    echo "<tr>";
			    foreach( $animal as $animalValue ) {
			      echo "<td>$animalValue</td>";
			    }
			    echo "</tr>";
			  }
			?>
		</table>
	</body>
</html>

