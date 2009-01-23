#!/usr/bin/env php
<?php

/**
 * Screaming Twitter Script
 * A script that posts to twitter with screaming profanity.
 * Originally developed for @fuckbot.
 *
 * Usage: ./screambot.php username password
 * 
 * For added lulz, set it on a cron. You'll probably want to pipe
 * the output to /dev/null so it doesn't email you every minute.
 **/

// Add some sayings and whatnot in this array.
$longs = array(
	""
);

// put random expletives here to fill out the tweets.
$shorts = array(
	"cock",
	"twat",
	"dick",
	"bitch",
	"bastard",
	"ass",
);

$s = $longs[rand(0,count($longs)-1)];
while (strlen($s) < 140) {
	$f = $shorts[rand(0,count($shorts)-1)];
	if (rand(0,1) === 1) {
		$f = strtoupper($f);
		if (substr($f,-1) === ".") $f = substr($f, 0, -1);
		for ($i = 0, $l = rand(0,3); $i < $l; $i ++) $f .= "!";
	}
	if ( strlen("$s $f") < 140 ) {
		$s = rand(0,3)===1 ? "$f $s" : "$s $f";
	} else break;
}
echo "Screaming: $s\n";
$s = rawurlencode(trim($s));

array_shift($argv);
list($u, $p) = array_map('rawurlencode', $argv);

echo `curl -i -d status=$s http://$u:$p@twitter.com/statuses/update.json`;

