<?php

/**
* ownCloud
*
* Original:
* @author Frank Karlitschek
* @copyright 2010 Frank Karlitschek karlitschek@kde.org
* 
* Adapted:
* @author Michiel de Jong, 2011
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


require_once('../lib/base.php');
require_once('HTTP/WebDAV/Server/Filesystem.php');


ini_set('default_charset', 'UTF-8');
#ini_set('error_reporting', '');
@ob_clean();

//allow use as unhosted storage for other websites
if(isset($_SERVER['HTTP_ORIGIN'])) {
  $allowOrigin = $_SERVER['HTTP_ORIGIN'];
  header('Access-Control-Max-Age: 3600');
} else {
  $allowOrigin = '*';
}
header('Access-Control-Allow-Origin: '.$allowOrigin);

$path = substr($_SERVER["REQUEST_URI"], strlen($_SERVER["SCRIPT_NAME"]));
$pathParts =  explode('/', $path);
if(count($pathParts) < 4)) {
	die('access denied');
}
$ownCloudUser = $pathParts[1];//this will be replaced by '/public' when mapping to the user's storage. 
			//so data will be under /public/unhosted/webdav/userDomain/userName/dataScope/...
if($pathParts[2] == 'unhosted') {
	if($pathParts[3] == 'webdav') {
		if(count($pathParts) < 7) {
			die('access denied');
		}
		//check if authed with a token:
		if(($_SERVER['PHP_AUTH_USER'] == $pathParts[5].'@'.$pathParts[4])
				&& (in_array(sha1($_SERVER['PHP_AUTH_PW']), $validTokens[$ownCloudUser][$pathParts[6]]))) {
			OC_UTIL::setUpFS($user, 'files', true);
			$server = new HTTP_WebDAV_Server_Filesystem();
			$server->ServeRequest($CONFIG_DATADIRECTORY);
		}else{//read-only
			OC_UTIL::setUpFS(OC_UTIL::getUserFromUri(), 'files', false);
			$server = new HTTP_WebDAV_Server_Filesystem();
			$server->ServeRequest($CONFIG_DATADIRECTORY, true);
		}
	} else if($pathParts[3] == 'oauth') {
		die('show oauth dialog.');
	} else {
		die('access denied');
	}
} else {
	die('access denied');
}

