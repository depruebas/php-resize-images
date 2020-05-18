<?php

	# usage:  php resize_images.php 0.5

	$filename = '';

	# Directorio donde estan la imagenes a redimensionar
	$directorio_in = dirname(__FILE__) . "/in/";

	# Directorio de salida
	$directorio_out = dirname(__FILE__) . "/out/";

	# Porcentaje que queremos reducir, se pasa como parametro
	$porcentaje = $argv[1];

	# Obtenemos todos los ficheros del directorio de entrada
	$files = scandir( $directorio_in);

	# Si el directori de salida no existe lo creamos
	if ( !file_exists( $directorio_out))
	{
	    mkdir( $directorio_out, 0764, true);
	}

	# Recorremos el array de ficheros del directorio in
	foreach ($files as $f)
	{

		$filename = $directorio_in."/".$f;

		# Miramos si el fichero es una imagen
		$mine_type = mime_content_type( $filename);

		# Y si es una imagen le pasamos el proceso de redimension
		if ( $mine_type == "image/jpeg")
		{

			# Obtenemos las medidas de la imagen
			list($width, $height) = getimagesize($filename);

			# Escalamos la medida al tanto por ciento que le pasamos
			$newwidth = $width * $porcentaje;
			$newheight = $height * $porcentaje;


			# Redimensionamos la imagen
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefromjpeg($filename);
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			# Grabanos en disco
			$file = pathinfo( $filename);
			$new_filename = $file['filename']."_p.".$file['extension'];

			# Creamos la nueva imagen
			imagejpeg($thumb, $directorio_out.$new_filename);

			echo $directorio_out.$new_filename."\n";

		}

	}




