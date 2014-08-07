<?php
// Prevent caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

// Configuration defaults
$config = array(
	'content' => array(
		'headline' => 'Hello, I\'m Blastyr',
		'subheading' => 'There is nothing here yet. ;)',
		'footer' => 'Visual page design <span class="strike">blatantly stolen</span> lovingly borrowed from <a href="http://nekinie.com/" target="_blank">nekinie.com</a>.'
	),
	'backgroundColor' => call_user_func(function () {
		$colors = array('#CC0000', '#CC6600', '#CCCC00', '#00CC00', '#0000CC', '#6600CC');
		return $colors[array_rand($colors)];
	}),
	'headlinePosition' => 50
);

// Allows easily setting a variable using an anonymous function
function setFromFunc(&$cfg, $func) {
	// If $func is not callable, return
	if (!is_callable($func)) return;
	// Call $func() and pass argument of current value of $cfg
	$cfg = call_user_func($func, $cfg);
}

// Load configuration, if it exists
if (file_exists(dirname(__FILE__) . '/config.php'))
	include dirname(__FILE__) . '/config.php';

// Validate that headlinePosition is an integer between 10 and 90, otherwise we have problems
$config['headlinePosition'] = max(10, min(90, (int)$config['headlinePosition']));

// Calculate footer height
$config['footerHeight'] = (max(1, substr_count($config['content']['footer'], '<br/>') + substr_count($config['content']['footer'], '<br />')) * 16);

// Calculate subheading position
$config['subheadingPosition'] = (100 - $config['headlinePosition']);

?><!DOCTYPE html>
<!--
	blastyr.net landing page
	Project at	https://github.com/blandin/blastyr.net
	Forked from	https://github.com/nekinie/nekinie.com
-->
<html lang="en">
	<head>
		<title>blastyr.net</title>
		<meta charset="utf-8"/>
		<link href="http://fonts.googleapis.com/css?family=Vollkorn" rel="stylesheet" type="text/css"/>
		<style type="text/css">
			body {
				margin: 0px;
				padding: 0px;
				background-color: <?php echo $config['backgroundColor']; ?>;
				color: #FFFFFF;
				font-family: 'Vollkorn', serif;
				font-size: 16px;
				line-height: 20px;
				font-weight: 400;
				text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.9);
			}
			p {
				margin: 0px auto;
				padding: 0px;
				width: 480px;
				text-align: center;
			}
			p#headline {
				position: absolute;
				bottom: <?php echo $config['headlinePosition']; ?>vh;
				left: 50vw;
				margin: 0px 0px 0px -240px;
				font-size: 26px;
				line-height: 30px;
			}
			p#subheading {
				position: absolute;
				top: <?php echo $config['subheadingPosition']; ?>vh;
				left: 50vw;
				margin: 0px 0px <?php echo ($config['footerHeight'] + 20); ?>px -240px;
			}
			p#footer {
				position: fixed;
				bottom: 0px;
				left: 50vw;
				margin: 0px 0px 0px -240px;
				padding: 10px 0px;
				height: <?php echo $config['footerHeight']; ?>px;
				background-color: <?php echo $config['backgroundColor']; ?>;
				font-size: 12px;
				line-height: 16px;
			}
			a[href] {
				color: #CCCCFF;
				text-decoration: none;
			}
			a[href]:hover {
				color: #FFFFFF;
				text-decoration: underline;
			}
			a[href]:visited {
				color: #CC99CC;
			}
			a[href]:visited:hover {
				color: #FFCCFF;
			}
			a[href]:empty:before {
				content: attr(href);
			}
			.strike {
				text-decoration: line-through;
			}
		</style>
	</head>
	<body>
		<p id="headline"><?php echo $config['content']['headline']; ?></p>
		<p id="subheading"><?php echo $config['content']['subheading']; ?></p>
		<p id="footer"><?php echo $config['content']['footer']; ?></p>
	</body>
</html>
