<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$animal1 = [
	'email' => 'foo@foo.fr',
	'nom' => 'Foo',
	'age' => 18,
	'age_unit' => 'year'
];
$animal2 = [
	'email' => 'foo@foo.fr',
	'nom' => 'Bar',
	'age' => 36,
	'age_unit' => 'year'
];
$animal3 = [
	'email' => 'foo@foo.fr',
	'nom' => 'FooBar',
	'age' => 48,
	'age_unit' => 'month'
];
$animal4 = [
	'email' => 'foo@foo.fr',
	'nom' => 'FooBar',
	'age' => null,
	'age_unit' => 'month'
];
$animaux = [$animal1, $animal2, $animal3, $animal4];
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
				<th>Email</th>
				<th>Nom</th>
				<th>Age</th>
			</tr>
			<?php
			$longueur_du_tableau = count($animaux);
			?>
			<?php for ($i = 0; $i < $longueur_du_tableau; $i++) { ?>
				<tr>
					<td><?php echo $animaux[$i]['email']; ?></td>
					<td><?php echo $animaux[$i]['nom']; ?></td>
					<td>
					<?php
					if ($animaux[$i]['age'] <= 10 && $animaux[$i]['age_unit'] === 'year') {
						$stade = 'jeune';
					} elseif ($animaux[$i]['age'] <= 120 && $animaux[$i]['age_unit'] === 'month') { 
						$stade = 'jeune';
					} else {
						$stade = 'adulte';
					}

					if (strlen($animaux[$i]['age']) === 0) {
						echo 'N/A';
					} else {
						echo $animaux[$i]['age'].' ( '.$stade.' )';
					}
					?>
					</td>
				</tr>
			<?php } ?>
		</table>
	</body>
</html>
