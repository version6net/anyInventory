<?php

include("globals.php");

$replace = array('"','&',"\\",':',';','`','[',']');

if ($_REQUEST["action"] == "do_edit_auto_inc_field"){
	$_REQUEST["name"] = stripslashes($_REQUEST["name"]);
	$_REQUEST["name"] = str_replace($replace,"",$_REQUEST["name"]);
	$_REQUEST["name"] = trim(addslashes($_REQUEST["name"]));
	
	$query = "UPDATE `anyInventory_config` SET `value`='".$_REQUEST["name"]."' WHERE `key`='AUTO_INC_FIELD_NAME'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$query = "UPDATE `anyInventory_categories` SET `auto_inc_field`='0'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Add any categories that were selected.
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
			$query = "UPDATE `anyInventory_categories` SET `auto_inc_field`='1' WHERE `id`='".$cat_id."'";
			$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		}
	}
	
	header("Location: fields.php");
	exit;
}

?>