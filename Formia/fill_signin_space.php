<!-- the file to display after signed in at index.php-->

<content class="sign-in"><!--same class-->
			<header class="content-header"><h5><?php global $userData; echo "hi ".$userData[0]; ?></h3></header>
			<div class="content-in"><!--same class-->
					<p class="loggedin1">Go to Admin Console to view and manage your forms.</p>
					<p class="label-desc"><a href="console1.php"></a></p>
					<img src="
					<?php
						$x=rand(1,5);

						switch ($x) {
							case 1:
								echo "images/surv.jpg";
								break;
							case 2:
								echo "images/surv1.jpg";
								break;
							case 3:
								echo "images/surv2.png";
								break;
							case 4:
								echo "images/surv3.jpg";
								break;
							default:
								echo "images/surv4.jpg";
								break;
						}
					?>
					" alt="goto Admin Console">

					<p class="loggedin2">
						You can create new forms and publish them with Admin Console. Copy the link of live form and send it across the web. Let it generate massive data.
					</p>
					<a href="console1.php"><div class="sign-up2">Admin Console</div></a>
				
					</div>
		</content>

