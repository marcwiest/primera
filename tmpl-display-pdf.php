<?php /*
Template Name: Blank Page
Template Post Type: page

https://developer.wordpress.org/themes/template-files-section/

This template is helpful if you'd like to use a nicer URL to point to a PDF.

NOTE: Use "Content-Disposition: attachment;" to force the download.
*/

$file_name    = 'document.pdf';
$file_content = file_get_contents( get_template_directory_uri()."/$file_name" );

header( 'Content-Type: application/pdf' );
header( "Content-Disposition: inline; filename=$file_name" );
header( 'Content-Description: File Transfer' );
header( 'Content-Transfer-Encoding: binary' );
header( 'Pragma: public' );
header( 'Content-Length: '.strlen($file_content) );
nocache_headers();

echo $file_content;
