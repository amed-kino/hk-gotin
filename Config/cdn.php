<?php
/* This is the file where you specify the CDNs for Hunerakurdi.com
 *
 *
 * Define the following constant to ignore the default configuration file.
 */
$config=array();

$bootstrapCssFile = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css';
$bootstrapJsFile = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js';
$jqueryJsFile = 'https://code.jquery.com/jquery-latest.min.js';






Configure::write('HK.cdn.bootstrapCss',$bootstrapCssFile);
Configure::write('HK.cdn.bootstrapJs',$bootstrapJsFile);
Configure::write('HK.cdn.jqueryJs',$jqueryJsFile);
