<?php
// Configuration defaults
$defaultConfig = array(
	'pageTitle' => $_SERVER['SERVER_NAME'],
	'favicon' => '',
	'googleFont' => array(
		'enabled' => true,
		'name' => 'Vollkorn',
		'css' => 'http://fonts.googleapis.com/css?family=Vollkorn'
	),
	'fontFamily' => 'serif',
	'customStyle' => '',
	'content' => array(
		'headline' => 'Hello. This is my page.',
		'subheading' => array('There is nothing here yet.'),
		'footer' => array(
			'The code for this page is on <a href="https://github.com/blandin/spdl" target="_blank">GitHub</a>.',
			'This page uses valid <a href="http://validator.w3.org/check?uri=referer" target="_blank">HTML5</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">CSS3</a>.'
		)
	),
	'backgroundColor' => call_user_func(function () {
		$colors = array('#CC0000', '#CC6600', '#CCCC00', '#00CC00', '#0000CC', '#6600CC');
		return $colors[array_rand($colors)];
	}),
	'headlinePosition' => 50,
	'allowCache' => true,
	'gzip' => array(
		'enabled' => false,
		'level' => 9,
		'footer' => 'Gzip compression enabled.'
	)
);

// Start output buffering
ob_start();

// Load configuration, if it exists
if (file_exists('./config.php')) include './config.php';
if (isset($config)) $config = array_replace_recursive($defaultConfig, $config);
else $config = $defaultConfig;

// Gzip compression handler
function gzipHandler($buffer, $mode) {
	chdir(dirname(__FILE__));
	global $config;
	$gzlevel = (int)$config['gzip']['level'];
	// Validate configured compression level
	if ($gzlevel >= 1 && $gzlevel <= 9) $mode = $gzlevel;
	return ob_gzhandler(trim($buffer), $mode);
}

// Validate that fontFamily is an array, and prepend Google font if configured
$config['fontFamily'] = (array)$config['fontFamily'];
if ($config['googleFont']['enabled']) {
	array_unshift($config['fontFamily'], "'" . $config['googleFont']['name'] . "'");
}

// Validate and calculate headline position
$config['subheadingPosition'] = $config['headlinePosition'];
$config['subheadingPosition'] = max(10, min(90, (int)$config['subheadingPosition']));
$config['headlinePosition'] = (100 - $config['subheadingPosition']);

// Validate that subheading is an array
$config['content']['subheading'] = (array)$config['content']['subheading'];

// Validate that the footer is an array
$config['content']['footer'] = (array)$config['content']['footer'];

// If gzip is enabled, append to the footer if configured
if ($config['gzip']['enabled'] && $config['gzip']['footer'])
	$config['content']['footer'][] = (string)$config['gzip']['footer'];

// Calculate footer height
$config['footerHeight'] = (count($config['content']['footer']) * 16);

// If configured to prevent caching, send headers
if (!$config['allowCache']) {
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
}

// Discard any extaneous output
ob_end_clean();

// If gzip is enabled, start output buffering with compression handler
if ($config['gzip']['enabled']) ob_start("gzipHandler");

?><!doctype html>
<!--
	Simple PHP domain landing page
	Project at	https://github.com/blandin/spdl
-->
<html lang="en">
	<head>
		<title><?php echo $config['pageTitle']; ?></title>
		<meta charset="utf-8"/><?php
		if (!empty($config['favicon'])) echo '<link href="' . $config['favicon'] . '" rel="icon"/>' . PHP_EOL;
		if ($config['googleFont']['enabled'])
			echo '<link href="' . $config['googleFont']['css'] . '" rel="stylesheet" type="text/css"/>'; ?>
		<style type="text/css">
			body {
				margin: 0px;
				padding: 0px;
				background-color: <?php echo $config['backgroundColor']; ?>;
				color: #FFFFFF;
				font-family: <?php echo implode(', ', $config['fontFamily']); ?>;
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
<?php echo $config['customStyle']; ?>
		</style>
	</head>
	<body>
		<p id="headline"><?php echo $config['content']['headline']; ?></p>
		<p id="subheading"><?php echo implode('<br/>', $config['content']['subheading']); ?></p>
		<?php
		if (!empty($config['content']['footer'])) {
			echo '<p id="footer">' . implode('<br/>', $config['content']['footer']) . '</p>' . PHP_EOL;
		}
		?>
	</body>
</html><?php

// If gzip is enabled, flush compressed output to client
if ($config['gzip']['enabled']) ob_end_flush();
