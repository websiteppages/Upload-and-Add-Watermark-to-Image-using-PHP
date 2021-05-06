<?php
// Path configuration
include_once 'dbConfig.php';
$targetDir = "uploads/";
$watermarkImagePath = 'codeat21-logo.png';

$uploadedFileName = $statusMsg = '';
if(isset($_POST["submit"])){
	if(!empty($_FILES["file"]["name"])){
		// File upload path
		$fileName = time().'_'.basename($_FILES["file"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		
		// Allow certain file formats
		$allowTypes = array('jpg','png','jpeg');
		if(in_array($fileType, $allowTypes)){
			// Upload file to the server
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
				
				// Load the stamp and the photo to apply the watermark to
				$watermarkImg = imagecreatefrompng($watermarkImagePath);
				switch($fileType){
					case 'jpg':
						$im = imagecreatefromjpeg($targetFilePath);
						break;
					case 'jpeg':
						$im = imagecreatefromjpeg($targetFilePath);
						break;
					case 'png':
						$im = imagecreatefrompng($targetFilePath);
						break;
					default:
						$im = imagecreatefromjpeg($targetFilePath);
				}
				
				// Set the margins for the watermark
				$marge_right = 10;
				$marge_bottom = 10;
				
				// Get the height/width of the watermark image
				$sx = imagesx($watermarkImg);
				$sy = imagesy($watermarkImg);
				
				// Copy the watermark image onto our photo using the margin offsets and 
				// the photo width to calculate the positioning of the watermark.
				imagecopy($im, $watermarkImg, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermarkImg), imagesy($watermarkImg));
				
				
				// Save image and free memory
				imagepng($im, $targetFilePath);
				imagedestroy($im);
				
				$uploadedFileName = $fileName;
	
				if(file_exists($targetFilePath)){
					
					$add = mysqli_query($db,"insert into posts (title) values('$targetFilePath')");
						if($add){
							$statusMsg = '<p style="color: #07c707;">The image with watermark has been uploaded successfully.</p>';
						}else{
							$statusMsg = '<p style="color: #EA4335;"> Server Problem, please try again.</p>';
						}
				}else{
					$statusMsg = '<p style="color: #EA4335;">Image upload failed, please try again.</p>';
				} 
			}else{
				$statusMsg = '<p style="color: #EA4335;">Sorry, there was an error uploading your file.</p>';
			}
		}else{
			$statusMsg = '<p style="color: #EA4335;">Sorry, only JPG, JPEG, and PNG files are allowed to upload.</p>';
		}
	}else{
		$statusMsg = '<p style="color: #EA4335;">Please select a file to upload.</p>';
	}
}

// Display status message
//echo $statusMsg;
