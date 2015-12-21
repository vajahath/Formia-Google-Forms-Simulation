<?php
//
// sign up page and functions to assist sign up.
//
require 'connect.inc.php';
require 'core.inc.php';
$loginErr ="";
$username ="";
$userData;
$sinErr;
$firstName;
$lastName;

if(loggedin())
{
	global $sinErr;
	$sinErr = "You're logged in. <a href=\"logout.php\">Logout</a> to create a new account.";
	header('Location:'.$http_referer);

}
else if (isset($_POST['signin']))
{
	if(isset($_POST['username']) && isset($_POST['password']))
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
					header('Location:'.$http_referer);
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

}
else if(isset($_POST['signup']))
{
	if(	isset($_POST['firstName'])&&
		isset($_POST['lastName'])&&
		isset($_POST['username'])&&
		isset($_POST['password'])&&
		isset($_POST['password-again'])) //if statement
	{
		global $firstName, $lastName, $username;
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$username  = $_POST['username'];
		$password;

		if(	!empty($firstName)&&
			!empty($lastName)&&
			!empty($username)&&
			!empty($_POST['password'])&&
			!empty($_POST['password-again'])) //if statement
		{
			if(strlen($firstName)<30 && strlen($lastName)<30 && strlen($username)<30)
			{
				//existance of username.
				$query = "SELECT id FROM logindata WHERE username='$username'";
				$query = $conn->query($query);
				if($query->num_rows == 0)
				{
					//password match?
					if($_POST['password']==$_POST['password-again'])
					{
						$password = md5($_POST['password']);
						//////////////////////
						//insert data //
						//////////////////////
						$query= "INSERT INTO logindata (id, username, password, firstname, lastname)
								VALUES ('', '$username', '$password', '$firstName', '$lastName');";

						if($conn->query($query))
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
									
									$query = "CREATE TABLE t".@$userData[0]." (
												formID INT(4) PRIMARY KEY AUTO_INCREMENT,
												name VARCHAR(60),
												fileLoc VARCHAR(60),
												published BOOLEAN NOT NULL DEFAULT 0,
												link VARCHAR(100));";
									if ($conn->query($query))
									{
										header('Location:'.$http_referer);
									}
									else
									{
										die("could not create baseTable. Please inform me at vajuoff.1@gmail.com OR 773 6600 957");
										///////////////////////////////
										///////////////////////////////////////////////////////////
										//delete that row. roll back sign up process// //
										//report Admin
										///////////////////////////////////////////////////////////
										///////////////////////////////
									}
									
								}
								else if($query->num_rows == 0)
								{
									global $loginErr;
									$sinErr = "could not sign in. incorrect username-password combination";
									//access denied.
								}
								else
								{
									global $loginErr;
									$sinErr = "username duplicates...!";
									//username duplicates.. REPORT ADMIN.
								}
							}
							else
							{
								global $sinErr;
								$sinErr = "sign in query failed.";
							}
						}
						else
						{
							global $sinErr;
							$sinErr = "insertion aborted.";
						}

					}
					else
					{
						global $sinErr;
						$sinErr = "password mismatch!";
					}
				}
				else
				{
					global $sinErr;
					$sinErr = "username, ".$username." already exists. if you have an account, login with it. Else try another userrname.";
				}
			}
			else
			{
				global $sinErr;
					$sinErr = "fied overflows!";
			}
		}
		else
		{
			global $sinErr;
			$sinErr = "all fields are required";

		}
	}
	else{
		global $sinErr;
		$sinErr = "sign up error";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign Up | Formia</title>
	<link rel="stylesheet" type="text/css" href="css/sign_up_style.css">
	<link rel="stylesheet" type="text/css" href="cssreset.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu|Roboto+Condensed:700,300,400' rel='stylesheet' type='text/css'>
</head>

<body class="body">
	<!--MAIN HEADER-->
	<header class="header">
		<h1>Formia</h1>
		<h3>Feedback Analytics</h3>

		<div class="navbar">
			<ul>
				<a href="index.php"><li>HOME</li></a>
				<a class="active" href="sign_up.php"><li>SIGN UP</li></a>
				<a href="#"><li>LEARN HOW</li></a>
				<a id="help" href="#"><li>ABOUT US</li></a>
			</ul>
		</div>
	</header><!--MAIN HEADER OVER-->
	<div id="left-cont">
		<header id="sugs">Sign Up to Get Started</header>

		<article>
			<h3 id="maxp">Maximize Productivity</h3>
			<img src="images/comm.png">
			<article>
				If you are new to Formia, plaease take signup.<br>
				Formia stores your forms and responses in your account, where you can come back any time.<br>
				If you have already an account, please sign in.<br>
			</article>
		</article>
		<section id="signin">
			<header>Already have an account?<br>Sign in here.</header>
			<form action= <?php echo $current_file; ?> method="POST">
					<p class="form-label">Email or UserID:</p>
					<p class="label-desc">If you have registered with your Email, you can use that.<br>Otherwise, use your userID.</p>
					<input type="text" name="username" placeholder="billy@example.com" value="<?php global $username; echo $username; ?>">
					<p class="form-label">Password:</p>
					<input type="password" name="password" placeholder="********">
					<br>
					<?php
					global $loginErr;
					if(!empty($loginErr)){
						echo "<div class=\"err-Tag\">".$loginErr."</div>";
					}

					?>
					<input class="submit0" type="submit" name="signin" value="Sign in">
				</form>
		</section>
	</div>


	<aside>
<!--SIGN UP-->
		<div>
			<header id="signup"><h3>Sign up</h3></header>
			<div id="form-cont">
				<form action=<?php echo $current_file; ?> method="POST">
					<p class="form-label">First Name:</p>
					<input type="text" name="firstName" placeholder="Billy" maxlength="30" value="<?php global $firstName; echo $firstName; ?>">
					<p class="form-label">Last Name:</p>
					<input type="text" name="lastName" placeholder="Anderson" maxlength="30" value="<?php global $lastName; echo $lastName; ?>">
					<p class="form-label">email:</p>
					<p class="label-desc">Note: your email will be your user id</p>
					<input type="text" name="username" placeholder="billy@example.com" maxlength="30" value="<?php global $username; echo $username; ?>">
					<p class="form-label">Password:</p>
					<input type="password" name="password" placeholder="********">
					<p class="form-label">Retype Password:</p>
					<input type="password" name="password-again" placeholder="********">
					<br>
					<?php
					global $sinErr;
					if(!empty($sinErr)){
						echo "<div class=\"err-Tagup\">".$sinErr."</div>";
					}
					?>
					<input class="submit0" type="submit" name="signup" value="Sign up">
				</form>
			</div>
		</div>
	</aside>
	<section id="foot">
		<div>
			<ul>
				<a href="#"><li>How it Works</li></a>
				<a href="#"><li>About this Project</li></a>
				<a href="#"><li>The Dev Team</li></a>
			</ul>
		</div>
		<div>
			<a href="#"><h2>Formia</h2></a>
		</div>
		<footer>
			<p>Copyright 2015 | Formia</p>
		</footer>
	</section>
</body>
</html>