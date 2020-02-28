<?php 
	require 'config/config.php';

	if(isset($_SESSION['username']))
    {
      $userLoggedIn=$_SESSION['username'];
      $user_details_query=mysqli_query($con,"SELECT * FROM users WHERE name='$userLoggedIn'");
      $user=mysqli_fetch_array($user_details_query);
    }
    else
    {
      header("Location: index.php");
    }

	$fName="";
	$keywords="";

	if(isset($_POST['upload']))
	{
		if(isset($_FILES['fileToUpload']['name']))
		{
			$uploadOk=1;
			$fileName=$_FILES['fileToUpload']['name'];
			$fileName=str_replace(' ', '', $fileName);
			$errorMessage="";
			$fileSize="";
			$fileExt="";

			if($fileName != "") 
			{
				$targetDir = "PPT/";
				$fileName = $targetDir . uniqid().basename($fileName);
				$fileSize = $_FILES['fileToUpload']['size'];
				$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
				$fileExt = strtolower($fileType);

				if($_FILES['fileToUpload']['size'] > 10000000)
				{
					$errorMessage = "Sorry, your file is too large";
					$uploadOk = 0;
				}

				if(strtolower($fileType) != "ppt" && strtolower($fileType) != "pptx")
				{
					$errorMessage = "Sorry, only ppt and pptx files are allowed";
					$uploadOk = 0;
				}

				if($uploadOk) 
				{
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $fileName)) 
					{
						//file uploaded okay
					}
					else 
					{
						//file did not upload
						$uploadOk = 0;
					}
				}

			}

			if($uploadOk) 
			{
				$fName=strip_tags($_POST['fileNam']);
				$keywords=strip_tags($_POST['keyword']);


				$check=mysqli_query($con,"SELECT name FROM presentations WHERE name='$fName'");
				if(mysqli_num_rows($check) == 0)
				{
					$query=mysqli_query($con,"INSERT INTO presentations VALUES('','$fName','$keywords','$fileName','$fileSize','$fileExt')");
					$fileName="";
					$fName="";
					$keywords="";
				}

			}	//$post = new Post($con, $userLoggedIn);
			//$post->submitPost($_POST['post_text'], 'none', $imageName);
		}
		else 
		{
			$fileName="";
			echo '<div class="alert alert-danger alert-dismissible">
    				<button type="button" class="close" data-dismiss="alert">&times;</button>
    				<strong>Error!</strong>'." $errorMessage".'</div>';
		}
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cloud Store</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="row">
      <div class="col-md-2">
      <img src="icloud.png" style="width: 230px; height: 230px; margin-left: 22px;">
      </div>
      <div class="col-md-5">
      	<h1 style="margin-top: 55px;
    margin-left: 32px;
    font-size: 36px;
    font-style: italic;
    font-weight: bold;
    color: white;">Community Cloud</h1> <br>
    	<h2 style="margin-top: 0px;
    margin-left: 38px;
    font-size: 24px;
    font-style: italic;
    color: white;"> Developed for Cloud Computing</h2> 
	</div>
    <div class="col-md-2">
    	<h4 style="font-style: italic;
    margin-top: 58px;
    font-size: 23px;
    color: white;
    font-weight: bold;"> Welcome <?php echo $_SESSION['username']; ?> </h4>
    </div> 
    <div class="col-md-2">
   		<a href="logout.php"><button class="btn btn-danger btn-lg" style="margin-top: 45px;
    margin-left: 0px;"> Logout </button></a>
    </div>
	</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="borders"> 				
				<form action="welcome.php" method="POST" style="margin-right: 20px;">
    <div class="input-group">
      <input type="search" class="form-control" placeholder="Search" name="search" style="margin-left: 30px;">
      <div class="input-group-btn">
        <button class="btn btn-default" name="ser" type="submit" style="background: ghostwhite;
    border-radius: 5px; height: 38px;"><i class="fa fa-search" aria-hidden="true"></i></button>
      </div>
    </div>
  </form>
  			<?php
  				if(isset($_POST['ser']))
				{
					$key=$_POST['search'];
					$query=mysqli_query($con,"SELECT * FROM presentations WHERE keywords LIKE '%$key%' ORDER BY id DESC");
					while ($row=mysqli_fetch_array($query)) 
			  		{
						$file=$row['location'];
						echo '<div class="presents"> 
								<div class="row onefile">
									<div class="col-md-12">
										<h3 style="color: aliceblue; font-style: italic;">'.$row['name'].' </h3>
										<h5 style="color: chartreuse; font-style: italic;">File Size: '.($row['size']/1000000).' MB</h5>
										<h5 style="color: red; font-style: italic;">File Extension:  '.$row['extension'].'</h5>
										<h5 style="color: cyan; font-style: italic;">Keywords :  '.$row['keywords'].'</h5>
										<a href='.$file.' font-style: italic;"><button class="btn btn-success">Download Now!</button></a>
									</div>
								</div>
								</div>';
			  		}
			  		echo '<br><br> <h4 align="center" style="color: #fff; padding: 10px;">No more results to show! </h4>';
				}
  			?>
			</div>

			<div class="borders"> 				
			<h2 style="margin-left: 50px;
    color: #fff;
    font-size: 35px;
    font-style: italic;
    font-weight: bold;
    margin-bottom: 0px;">All Files</h2>
  			<?php
  				$query=mysqli_query($con,"SELECT * FROM presentations ORDER BY id DESC");
  				while ($row=mysqli_fetch_array($query)) 
  				{
  					$file=$row['location'];
  					echo '<div class="presents"> 
  							<div class="row onefile">
  								<div class="col-md-12">
  									<h3 style="color: aliceblue; font-style: italic;">'.$row['name'].' </h3>
  									<h5 style="color: chartreuse; font-style: italic;">File Size: '.($row['size']/1000000).' MB</h5>
  									<h5 style="color: red; font-style: italic;">File Extension:  '.$row['extension'].'</h5>
  									<h5 style="color: cyan; font-style: italic;">Keywords :  '.$row['keywords'].'</h5>
  									<a href='.$file.' font-style: italic;"><button class="btn btn-success">Download Now!</button></a>
  								</div>
  							</div>
  							</div>';
  				}
  				echo '<br><br> <h4 align="center" style="color: #fff; padding: 10px;">No more results to show! </h4>';
  			?>
			</div>
		</div>
		<div class="col-md-4">
		<div class="borders">
			
<form class="text-center p-5" method="POST" enctype="multipart/form-data" action="welcome.php">

    <p class="h4 mb-4" style="color: #fff;">Upload File</p>

    <!-- Name -->
    <input type="file" name="fileToUpload" id="fileToUpload" style="height: 45px; color: #fff;">

    <!-- Name -->
    <input type="text" id="defaultContactFormName" class="form-control mb-4" name="fileNam" placeholder="Name of file..." required>

    <!-- Message -->
    <div class="form-group">
        <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" name="keyword" rows="3" placeholder="Keywords (seperated by , )" required></textarea>
    </div>

    <!-- Send button -->
    <button class="btn btn-info btn-block" name="upload" type="submit">Upload</button>

</form>
<!-- Default form contact -->
		</div>
		</div>
	</div>
</body>
</html>