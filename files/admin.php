<?php

/**
* ownCloud - ajax frontend
*
* @author Robin Appelman
* @copyright 2010 Robin Appelman icewind1991@gmail.com
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/


// Init owncloud
require_once('../lib/base.php');
require( 'template.php' );


// Check if we are a user
if( !OC_USER::isLoggedIn() || !OC_GROUP::inGroup( OC_USER::getUser(), 'admin' )){
	header( "Location: ".OC_HELPER::linkTo( "index.php" ));
	exit();
}

$htaccessWorking=(getenv('htaccessWorking')=='true');
if(isset($_POST['maxUploadSize'])){
	$maxUploadFilesize=$_POST['maxUploadSize'];
	OC_FILES::setUploadLimit(OC_HELPER::computerFileSize($maxUploadFilesize));
}else{
	$maxUploadFilesize = ini_get('upload_max_filesize').'B';
}

if(isset($_POST['publicfoldername'])) {
	$path = $_POST['publicfoldername'];
	if(strlen($path) && (strpos($path, '..') === false)) {
		if($path[0] != '/') {
			$path = '/'.$path;
		}
		OC_PREFERENCES::setValue(OC_USER::getUser(), 'core', 'publicfoldername', $path);
	}
}

OC_APP::setActiveNavigationEntry( "files_administration" );
// return template
$tmpl = new OC_TEMPLATE( "files", "admin", "admin" );
$tmpl->assign( 'htaccessWorking', $htaccessWorking );
$tmpl->assign( 'uploadMaxFilesize', $maxUploadFilesize);
$tmpl->assign( 'publicFolders', 'on');
$tmpl->assign( 'sharingaim', 'inwebdav');
$tmpl->assign( 'publicfoldername', OC_PREFERENCES::getValue(OC_USER::getUser(), 'core', 'publicfoldername', '/public'));
$tmpl->printPage();

?>
