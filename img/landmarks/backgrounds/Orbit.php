<?php
/* 	DOWNLOADED FROM http://www.marcofolio.net/
	INSTRUCTIONS
	1. Modify the $folder setting in the configuration section below.
	2. Add image types if needed (most users can ignore that part).
	3. Upload this file (rotate.php) to your webserver.  I recommend
	   uploading it to the same folder as your images.
	4. Link to the file as you would any normal image file, like this:

			<img src="http://example.com/rotate.php">

	5. You can also specify the image to display like this:

			<img src="http://example.com/rotate.php?img=gorilla.jpg">
		
		This would specify that an image named "gorilla.jpg" located
		in the image-rotation folder should be displayed.
	
	That's it, you're done. */
	$folder = './Orbit';
    
    $extList = array(
		'gif'	=> 'image/gif',
		'jpg'	=> 'image/jpeg',
		'jpeg'	=> 'image/jpeg',
		'png'	=> 'image/png',
		'pdf'	=> 'application/pdf',
		'html'	=> 'text/html',
		'htm'	=> 'text/html',
		'css'	=> 'text/css',
	);

	$img = null;

	if (substr($folder,-1) != '/') {
		$folder = $folder.'/';
	}

	if (isset($_GET['img'])) {
		$imageInfo = pathinfo($_GET['img']);
		if (isset( $extList[ strtolower( $imageInfo['extension'] ) ] ) && file_exists( $folder.$imageInfo['basename'] )){
			$img = $folder.$imageInfo['basename'];
		}
	} else {
		$fileList = array();
		$handle = opendir($folder);
		while ( false !== ( $file = readdir($handle) ) ) {
			$file_info = pathinfo($file);
			if (
				isset( $extList[ strtolower( $file_info['extension'] ) ] )
			) {
				$fileList[] = $file;
			}
		}
		closedir($handle);

		if (count($fileList) > 0) {
			$imageNumber = time() % count($fileList);
			$img = $folder.$fileList[$imageNumber];
		}
	}

	if ($img!=null) {
		$imageInfo = pathinfo($img);
		$contentType = 'Content-type: '.$extList[ $imageInfo['extension'] ];
		header ($contentType);
		readfile($img);
	} else {
		if ( function_exists('imagecreate') ) {
			header ("Content-type: image/png");
			$im = @imagecreate (100, 100)
				or die ("Cannot initialize new GD image stream");
			$background_color = imagecolorallocate ($im, 255, 255, 255);
			$text_color = imagecolorallocate ($im, 0,0,0);
			imagestring ($im, 2, 5, 5,  "IMAGE ERROR", $text_color);
			imagepng ($im);
			imagedestroy($im);
		}
	}
?>