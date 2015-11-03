<?php
	use xPaw\MinecraftQuery;
	use xPaw\MinecraftQueryException;

	// Edit this ->
	define( 'MQ_SERVER_ADDR', '107.6.137.220' );
	define( 'MQ_SERVER_PORT', 25565 );
	define( 'MQ_TIMEOUT', 1 );
	// Edit this <-

	// Display everything in browser, because some people can't look in logs for errors
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', true );

	require __DIR__ . '/src/MinecraftQuery.php';
	require __DIR__ . '/src/MinecraftQueryException.php';

	$Timer = MicroTime( true );

	$Query = new MinecraftQuery( );

	try
	{
		$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	}
	catch( MinecraftQueryException $e )
	{
		$Exception = $e;
	}

	$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Minecraft Query PHP Class</title>

	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<style type="text/css">
		.jumbotron {
			margin-top: 30px;
			border-radius: 0;
		}

		.table thead th {
			background-color: #428BCA;
			border-color: #428BCA !important;
			color: #FFF;
		}
table {
		width: 0px;
		position: absolute;
                margin: auto;
float: left;
margin-left: -13px;
	}
	</style>
</head>

<body>
    <div class="container">

<?php if( isset( $Exception ) ): ?>
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo htmlspecialchars( $Exception->getMessage( ) ); ?></div>
			<p><?php echo nl2br( $e->getTraceAsString(), false ); ?></p>
		</div>
<?php else: ?>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-bordered table-striped" style="width:250px">
					<tbody>
<tr><td>
Status
</td><td>
<?php
	$my_server = "107.6.137.220";
	function objectToArray($d) {
		if (is_object($d)) { $d = get_object_vars($d); }
		if (is_array($d)) { return array_map(__FUNCTION__, $d); }
		else { return $d; }
	}
	$json_file = 'http://api.luke.sx/query/' . $my_server;
	$json_string = file_get_contents($json_file);
	$decoded_object = json_decode($json_string);
	$final_array = objectToArray($decoded_object);
	if ($final_array['status'] == false) {
		echo "<img src='http://i.imgur.com/xllCkC5.png'>";
	} 
else {
	echo "<img src='http://i.imgur.com/3AvlIiR.png'> \n";
	}
?>
</td></tr>
<tr><td>IP Address</td><td>play.crypticcraft.club</td></tr>
<?php if( ( $Info = $Query->GetInfo( ) ) !== false ): ?>
<?php foreach( $Info as $InfoKey => $InfoValue ): ?>

						<tr>

							<td><?php echo htmlspecialchars( $InfoKey ); ?></td>
							<td><?php
	if( Is_Array( $InfoValue ) )
	{
		echo "<pre>";
		print_r( $InfoValue );
		echo "</pre>";
	}
	else
	{
		echo htmlspecialchars( $InfoValue );
	}
?></td>
						</tr>
<?php endforeach; ?>
<?php else: ?>
						<tr>
							<td>No information received</td>
						</tr>
<?php endif; ?>
						<tr>
							<td colspan="2" align="center"><b>Player List</b></td>
						</tr>
<?php if( ( $Players = $Query->GetPlayers( ) ) !== false ): ?>
<?php foreach( $Players as $Player ): ?>
						<tr>
							<td colspan="2"><?php echo htmlspecialchars( $Player ); ?></td>

						</tr>
<?php endforeach; ?>
<?php else: ?>
						<tr>
							<td colspan="2">No players currently online.</td>
						</tr>
<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
<?php endif; ?>
	</div>



</body>
</html>
