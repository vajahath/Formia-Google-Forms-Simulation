<!-- sign in at index.php -->	
<content class="sign-in"><!--same class-->
			<header class="content-header"><h3>Sign in</h3></header>
			<div class="content-in"><!--same class-->
				<form action=<?php echo $current_file; ?> method="POST" id="form-register">
					<p class="form-label">Email or UserID:</p>
					<p class="label-desc">If you have registered with your Email, you can use that.<br>Otherwise, use your userID.</p>
					<input type="text" name="username" placeholder="billy@example.com" value="<?php global $username; echo $username; ?>">
					<p class="form-label">Password:</p>
					<input type="password" name="password" placeholder="********">
					<br>
					<?php
					global $loginErr;
					if(!empty($loginErr)){

						echo ("<div class=\"errTag\">".$loginErr."</div>");						
					}

					?>
					
					<input class="submit0" type="submit" value="Sign in">
					<p class="sign-up1">Don't have an account?</p>
					<a href="sign_up.php"><div class="sign-up2">Sign up now</div></a>
				</form>
			</div>
		</content>
