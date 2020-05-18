<?php


	$filename = '';
	$directorio_in = dirname(__FILE__) . "/in/";
	$directorio_out = dirname(__FILE__) . "/out/";
	$porcentaje = $argv[1];


	$files = scandir( $directorio_in);

	if ( !file_exists( $directorio_out))
	{
	    mkdir( $directorio_out, 0764, true);
	}

	foreach ($files as $f)
	{

		$filename = $directorio_in."/".$f;
		$mine_type = mime_content_type( $filename);

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

			imagejpeg($thumb, $directorio_out.$new_filename);

			echo $directorio_out.$new_filename."\n";

		}

	}




