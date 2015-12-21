<?php
require 'core.inc.php';
require 'connect.inc.php';
$loginErr ="";
$username ="";
$userData;

if(isset($_POST['username']) && isset($_POST['password'])&& !loggedin())
{
	global $username;
	$username = $_POST['username'];
	$username = $conn->real_escape_string($username);
	$password = md5($_POST['password']);

	if(!empty($username))
	{ 
		$query = "SELECT id FROM logindata WHERE username='$username' AND password='$password'";
		if ($query = $conn->query($query))
		{
			if($query->num_rows == 1)
			{
				global $userData;
				//allow access.
				$userData = $query->fetch_row();
				$_SESSION["userid"] = @$userData[0];//userID setting to  session var_.
			}
			else if($query->num_rows == 0)
			{
				global $loginErr;
				$loginErr = "incorrect username-password combination";
				//access denied.
			}
			else
			{
				global $loginErr;
				$loginErr = "username duplicates...!";
				//username duplicates.. REPORT ADMIN.
			}

		}
		else 
		{
			global $loginErr;
			$loginErr = "query failed.";
		}
	}
	else 
		{
			global $loginErr;
			$loginErr = "username not set";
		}
}
if (loggedin())
	{
		global $userData;	
		$userData = getfield('firstname', 'logindata', $conn);
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home | Formia</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<link rel="stylesheet" type="text/css" href="cssreset.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu|Roboto+Condensed:700,300,400' rel='stylesheet' type='text/css'>
</head>

<body class="body">
	<!--MAIN HEADER-->
	<header class="header">
		<div class="head-wrapper">
		<h1>Formia</h1>
		<h3>Feedback Analytics</h3>
		</div>
		<?php
		if(loggedin())
		{	?>
			<div class="logout-wrapper"><p><a href="logout.php">Sign out</a></p></div>
			<?php }
		else ;
		?>
		
		<div class="navbar">
			<ul>
				<a class="active" href="#"><li>HOME</li></a>
				<?php
				if(!loggedin())
					{ ?>
					<a href="sign_up.php"><li>SIGN UP</li></a> 
				<?php }
				?>
				
				<a href="#"><li>LEARN HOW</li></a>
				<a id="help" href="#"><li>ABOUT US</li></a>
			</ul>
		</div>
		
	</header><!--MAIN HEADER OVER-->
	
	<!--main content-->
	<section class="main-content">
		
		
		<!--SIGN IN-->
		<?php
		if(loggedin())
		{
			include 'fill_signin_space.php';
		}
		else
		{
			include 'index_signin_form.php';
		}

		?>
			
		<picture class="pic">
                <img src="images/pic1.png">
		</picture>
		<content class="learn-how">
			<header class="content-header">
				Collect & Organize your Data.
			</header>
			<article class="learn-article">
				<p>Collect and organize Data big & small with Formia, for free.<br>
				Formia is a massive feedback analysis service. Here you can create
				 forms and send it to your friends to be surveyed. No matter if they
				  are in dozens of size, let it be in hundreds or even thousands,
				   Formia handles everything in fast. </p>
			</article>
		</content>
	</section>
	<!--strip1 over-->
	<section id="strip2">
		<header>More than just Surveys</header>
		<content>
			Plan your next camping trip, manage event registrations, whip up a quick poll, collect email addresses for a newsletter, create a pop quiz, and much more.
		</content>
		<a href="sign_up.php"><div>Get Started</div></a>
	</section>
	<!--strip2 over-->

	<!--strip3 over-->
	<section id="strip4">
		<header>Survey Faster, Smarter, Better</header>
		<content>
			Our efficient algorithm can collect and process large amount of data.
		</content>
		<div>
		<a id="lm" href="#"><div>Learn More</div></a>
		<a id="gs" href="#"><div>Get Started</div></a>
		</div>
	</section>

	<section id="foot">
		<content>
			<ul>
				<a href="#"><li>How it Works</li></a>
				<a href="#"><li>About this Project</li></a>
				<a href="#"><li>The Dev Team</li></a>
			</ul>
		</content>
		<div>
			<a href="index.php"><h2>Formia</h2></a>
		</div>
		<footer>
			<p>Copyright 2015 | Formia</p>
		</footer>
	</section>
</body>
</html>