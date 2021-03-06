<?php

// Init owncloud
require_once('../../lib/base.php');

// We send json data
header( "Content-Type: application/jsonrequest" );

// Check if we are a user
if( !OC_USER::isLoggedIn() || !OC_GROUP::inGroup( OC_USER::getUser(), 'admin' )){
	echo json_encode( array( "status" => "error", "data" => array( "message" => "Authentication error" )));
	exit();
}

$groups = array();
if( isset( $_POST["groups"] )){
	$groups = $_POST["groups"];
}
$username = $_POST["username"];
$password = $_POST["password"];

// Does the group exist?
if( in_array( $username, OC_USER::getUsers())){
	echo json_encode( array( "status" => "error", "data" => array( "message" => "User already exists" )));
	exit();
}

// Return Success story
if( OC_USER::createUser( $username, $password )){
	foreach( $groups as $i ){
		OC_GROUP::addToGroup( $username, $i );
	}
	echo json_encode( array( "status" => "success", "data" => array( "username" => $username, "groups" => implode( ", ", OC_GROUP::getUserGroups( $username )))));
}
else{
	echo json_encode( array( "status" => "error", "data" => array( "message" => "Unable to add user" )));
}

?>
