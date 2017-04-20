<?php

	$cmd = "mongo db_init.js";

	exec($cmd, $output, $status);

	header('Location: index.html');	

?>