<?php

/**
 * Blank PHP Google App for simple demonstration and deployment test.
 *
 * Original package from: http://php-apps.appspot.com/
 *
 * File: index.php
 *
 * @author Marko Manninen <mmstud@gmail.com>
 * @copyright Copyright (c) 2010 Marko Manninen
 */

$title = 'Blank PHP Google App';

?>
<html>
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>
th {text-align: left;}
</style>
</head>
<body>
<h1><?=$title?></h1>
<p>Source: <a href="http://php-apps.appspot.com/">PHP on Google App Engine</a></p>
	
<?php

ob_start();
phpinfo();
$c = ob_get_contents();
ob_end_clean();

# phpinfo gives html head and body tags, get only content after h1
$p1 = strpos($c, '</h1>')+strlen('</h1>');
$p2 = strpos($c, '</body>');
echo substr($c, $p1, $p2-$p1);

?>

</body>
</html>