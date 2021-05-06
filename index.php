<?php
include_once 'upload.php';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Upload Image with Watermark using PHP by Codeat21</title>
<meta charset="utf-8">

<!-- Stylesheet file -->
<link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container">
	<h1>Upload and Add Watermark to Image using PHP</h1>
	<!-- Display status message -->
	<div class="status">
		<?php echo !empty($statusMsg)?$statusMsg:''; ?>
	</div>
		<div class="form-group">
		
	<!-- Image upload form -->
	<form action="" method="post" enctype="multipart/form-data" class="form-inline">
		<div class="groups">
			<label for="file">Select Image File to Upload:</label>
			<input type="file" name="file" class="form-control">
			<input type="submit" name="submit" value="Upload" class="btn btn-success">
		</div>
		
	</form>
	
	<?php if(!empty($uploadedFileName)){ ?>
	<h5>Watermarked Image</h5>
	<div class="gallery">
		<img src="<?php echo 'uploads/'.$uploadedFileName; ?>" alt="">
	</div>
	<?php } ?>  
	</div>
</div>
</body>
</html>