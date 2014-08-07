<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
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
				margin: 0px auto;
				padding: 0px;
				background-color: <?php
					$colors = array('#CC0000', '#CC6600', '#CCCC00', '#00CC00', '#0000CC', '#6600CC');
					echo $colors[array_rand($colors)];
				?>;
				color: #FFFFFF;
				font-family: 'Vollkorn', serif;
				font-size: 12px;
				line-height: 16px;
				font-weight: 400;
				text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.9);
			}
			p {
				position: absolute;
				left: 50%;
				margin: 0px 0px 0px -240px;
				padding: 0px;
				width: 480px;
				height: 16px;
				text-align: center;
			}
			p#headline {
				top: 50%;
				margin-top: -27px;
				height: 30px;
				font-size: 26px;
				line-height: 30px;
			}
			p#subheading {
				top: 50%;
				margin-top: 4px;
				height: 20px;
				font-size: 16px;
				line-height: 20px;
			}
			p#footer {
				bottom: 10px;
			}
			a[href] {
				color: #CCCCFF;
				text-decoration: none;
			}
			a[href]:hover {
				text-decoration: underline;
			}
			a[href]:visited {
				color: #CC99FF;
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
		<p id="headline">
			Hello, I'm Blastyr
		</p>
		<p id="subheading">
			<?php if ((include '/subheading.php') === false) echo 'There is nothing here yet. ;)'; ?>
		</p>
		<p id="footer">
			Visual page design <span class="strike">blatantly stolen</span> lovingly borrowed from <a href="http://nekinie.com/" target="_blank">nekinie.com</a>.
		</p>
	</body>
</html>
