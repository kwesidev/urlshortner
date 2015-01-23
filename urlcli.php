<?php
include_once "UrlShortner.php";
include_once "database.php";

$urlshort = new UrlShortner($_SERVER['argv'][1],time());
print $urlshort->generateNewUrl()."\n";
