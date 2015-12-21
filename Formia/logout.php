<?php

// logout
// destroy the session, 
// $http_referer is at core.inc.php

require 'core.inc.php';
session_destroy();
header('Location: '.$http_referer);
?>