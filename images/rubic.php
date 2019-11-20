<?php
/**
 * Crop all images to 1024 pixels square from x=1961 y=1075
 *
 */

$step = 32;
for ( $index = 1448; $index <= 1480; $index++ ) {
	$file = "IMG_$index.jpg";
	$cropped = "step_$step.jpg";
	$step--;
	if ( file_exists( $file )) {
		echo $file;
		echo PHP_EOL;
		rubic( $file, $cropped );
	}
}

function rubic( $file, $cropped ) {
	echo $cropped;
	echo PHP_EOL;
	echo PHP_EOL;
	cropper( $file, $cropped );

}

function cropper( $file, $cropped ) {
	$im  = imagecreatefromjpeg( $file );
	$im2 = cropto( $im );
	if ($im2 !== false ) {
		imagepng($im2, $cropped );
		imagedestroy($im2);
	}
	imagedestroy($im);
}

function cropto( $image, $x=1961, $y=1075, $width=1024, $height=1024 ) {
	$parms = [];
	$parms['x'] = $x;
	$parms['y'] = $y;
	$parms['width'] = $width;
	$parms['height'] = $height;
	$image2 = imagecrop( $image, $parms );
	return $image2;
}