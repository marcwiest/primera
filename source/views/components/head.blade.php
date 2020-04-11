<!DOCTYPE html>
<html class="no-js {{ $html_class_names }}" {!! get_language_attributes() !!}>
<head>
	<meta charset="{!! get_bloginfo('charset') !!}">
	@php wp_head(); @endphp
</head>
<body @php body_class(); @endphp>

@php
	wp_body_open() ;
	do_action('get_header');
@endphp
