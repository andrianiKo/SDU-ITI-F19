<?php

session_start();

require_once "db_conn.php";

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
	echo "You need to login to upload pictures.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	$target_dir = "images/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$i = 0;
	while (file_exists($target_file)) {
		$i++;
		$target_file = str_replace(".", "_" . $i . ".", $target_file);
	}


	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			echo "Sorry, there was an error uploading your file.";
			$uploadOk = 0;
		}
	}
	
	$sql = "INSERT INTO images(title,description,source) VALUES(:title,:description,:source)";
	
	if($stmt = $conn->prepare($sql) and $uploadOk == 1){
		
		$stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
		$stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
		$stmt->bindParam(":source", $target_file, PDO::PARAM_STR);

		$param_title = trim($_POST["title"]);
		$param_description = trim($_POST["description"]);		
			
		if($stmt->execute()){
			echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		} else {
			unlink($target_file);
			echo "Sorry, there was an error uploading your file.";
		}
	}
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hydrogen</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<!-- Google Webfonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- Salvattore -->
	<link rel="stylesheet" href="css/salvattore.css">
	<!-- Theme Style -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
		
	<div id="fh5co-offcanvass">
		<a href="#" class="fh5co-offcanvass-close js-fh5co-offcanvass-close">Menu <i class="icon-cross"></i> </a>
		<h1 class="fh5co-logo"><a class="navbar-brand" href="index.php">Hydrogen</a></h1>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li class="active"><a href="upload.php">Upload</a></li>
			<li><a href="users.php">Users</a></li>
			<li><a href="register.php">Register</a></li>
		</ul>
		<?php if((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
			echo '<a href="logout.php" class="btn btn-primary">Logout</a>';
		} ?>
	</div>
	<header id="fh5co-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="#" class="fh5co-menu-btn js-fh5co-menu-btn">Menu <i class="icon-menu"></i></a>
					<a class="navbar-brand" href="index.php">Hydrogen</a>		
				</div>
			</div>
		</div>
	</header>
	<!-- END .header -->
	
	<div id="fh5co-main">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h2>Upload</h2>
					<div class="fh5co-spacer fh5co-spacer-sm"></div>
					<form name="registerform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="form-group">
								<input type="file" name="file" placeholder="Username" required>	
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" name="title" placeholder="Title" required>	
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<textarea name="description" id="description" cols="30" class="form-control" rows="5" placeholder="Description"></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Upload">
								</div>
							</div>
						</div>
					</form>
				</div>
        	</div>
       </div>
	</div>

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<!-- Salvattore -->
	<script src="js/salvattore.min.js"></script>
	<!-- Main JS -->
	<script src="js/main.js"></script>
	
	</body>
</html>
