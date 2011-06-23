<?php

/**
* ownCloud
*
* @author Frank Karlitschek
* @copyright 2010 Frank Karlitschek karlitschek@kde.org
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
header("Access-Control-Allow-Origin: *");

OC_UTIL::setUpFS(OC_UTIL::getUserFromUri(), 'files', false);
$server = new HTTP_WebDAV_Server_Filesystem();
$server->ServeRequest($CONFIG_DATADIRECTORY, true);

?>
