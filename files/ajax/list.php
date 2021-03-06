<?php

// Init owncloud
require_once('../../lib/base.php');
require_once('../../lib/template.php');

// We send json data
header( "Content-Type: application/jsonrequest" );

// Check if we are a user
if( !OC_USER::isLoggedIn()){
	echo json_encode( array( "status" => "error", "data" => array( "message" => "Authentication error" )));
	exit();
}

// Load the files
$dir = isset( $_GET['dir'] ) ? $_GET['dir'] : '';
$doBreadcrumb = isset( $_GET['breadcrumb'] ) ? true : false;
$data = array();

// Make breadcrumb
if($doBreadcrumb){
	$breadcrumb = array();
	$pathtohere = "/";
	foreach( explode( "/", $dir ) as $i ){
		if( $i != "" ){
			$pathtohere .= "$i/";
			$breadcrumb[] = array( "dir" => $pathtohere, "name" => $i );
		}
	}
	
	$breadcrumbNav = new OC_TEMPLATE( "files", "part.breadcrumb", "" );
	$breadcrumbNav->assign( "breadcrumb", $breadcrumb );
	
	$data['breadcrumb'] = $breadcrumbNav->fetchPage();
}

// make filelist
$files = array();
foreach( OC_FILES::getdirectorycontent( $dir ) as $i ){
	$i["date"] = OC_UTIL::formatDate($i["mtime"] );
	$files[] = $i;
}

$list = new OC_TEMPLATE( "files", "part.list", "" );
$list->assign( "files", $files );
$data = array('files' => $list->fetchPage());

echo json_encode( array( "status" => "success", "data" => $data));

?>
