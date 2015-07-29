<?php

	$contents = file_get_contents('http://localhost:4000/test');

	echo count(json_decode($contents));