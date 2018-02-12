<?php
ini_set('session.cookie_domain', '.winwinlabs.com');
session_start();
//echo session_id();
if($_REQUEST['val'])
{
    $_SESSION['userSession'] = $_REQUEST['val'];
}
 
?>