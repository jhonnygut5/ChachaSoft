<?php
	require_once('conexion2.php');
	// creando una variable para llamar a la base de datos
	$conexion2=conectarBD();
?>
<?php
	if (isset($_POST['sub'])) {
		// recuperar direccion
		$ar=$_POST['file'];
		echo $ar . "<br>";
		//******the enable codigo in sql**********
		// INSERTAR DATOS A LA BASE DE DATOS DE PRUEBA
		$consul="COPY public.usuariop FROM 'C:\wamp64\www\prueba\\" . $ar . "' using delimiters ';';";
		echo $consul . "<br>";
		$query=$consul;
		pg_query($conexion2,$query) or die("Error en la Consulta");
		//****************
		// para porder insertar indice	
		$query="SELECT * FROM usuariop";
		$resultado= pg_query($conexion2,$query) or die("Error en la Consulta");
		$nr=pg_num_rows($resultado);
		//$contador=0;
		//***************************
			$query="SELECT * FROM usuario;";
			$resultado2= pg_query($conexion2,$query) or die("Error en la Consulta");
			$nr=pg_num_rows($resultado2);
			$cont=0;
			while($filas2=pg_fetch_array($resultado2)){
				$cont=$cont+1;
			}
			echo "El numero espera es: " . $cont;
			//****************
			$contador=$cont;
		//****************************
		while($filas=pg_fetch_array($resultado)){
			$contador = $contador + 1;
			//echo "<br> el ultimo ide es:::: " . $contador;
			$id=$contador;
			$usu=$filas["usuario"];
			$pass=$filas["password"];

			// INSERTAR DATOS A LA BASE DE DATOS DE ORIGINAL
			$query="insert into usuario values ('$id','$usu','$pass')";
			pg_query($conexion2,$query) or die("Error en la Consulta");
			//****************
		}
		//****************
		echo "guardado";
		//****ELIMINA LA SEGUNDA TABLA******
		$query="DELETE FROM USUARIOP WHERE password!=10";
		pg_query($conexion2,$query) or die("Error en la Consulta");
		//**********************************
	}
	if (isset($_POST['exp'])) {
		// INSERTAR DATOS A LA BASE DE DATOS DE PRUEBA
		echo "CREADO";
		// recuperar direccion
		$ar=$_POST['file'];
		echo $ar . "<br>";
		// en esta se debe exportar el documente en cualquier parte que uno desea
		$query="copy public.usuario to 'C:\wamp64\www\prueba\prueba13.csv' delimiters ';'";
		pg_query($conexion2,$query) or die("Error en la Consulta");
		
		//****************
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method="post" enctype="multipart/from-date">
		<input type="file" name="file">
		<input type="submit" name="sub" value="import">
	</form>
	<br>
	<form method="post">
		<input type="file" name="file">
		<input type="submit" name="exp" value="Exportar">
	</form>
</body>
</html>