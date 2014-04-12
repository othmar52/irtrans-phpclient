<?php

require_once('./class.remotecontrol.php');

$remotecontrol = new remotecontrol();

switch($_REQUEST['type']) {
	case 'ir':
		$remotecontrol->fire($_REQUEST['remote'], $_REQUEST['cmd']);
		break;
	case 'ezcontrol':
		$remotecontrol->funky($_REQUEST['remote'], $_REQUEST['cmd']);
		break;
	default:
		break;
}

#echo "<pre>" . print_r($_REQUEST,1);

?>