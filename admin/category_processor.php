<?php

include("globals.php");

if ($_POST["action"] == "do_add"){
	if (!$admin_user->can_admin($_POST["parent"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	else{
		// Add a category.
		$query_data = array("id"=>get_unique_id('anyInventory_categories'),
							"name"=>stripslashes($_POST["name"]),
							"parent"=>$_POST["parent"],
							"auto_inc_field"=>intval(($_POST["auto_inc"] == "yes")));
		$result = $db->autoExecute('anyInventory_categories',$query_data,DB_AUTOQUERY_INSERT);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		$this_id = get_unique_id('anyInventory_categories') - 1;
		
		if ($_POST["inherit_fields"] == "yes"){
			// Add the fields from the parent category
			$parent = new category($_POST["parent"]);
			
			if(is_array($parent->field_ids)){
				foreach($parent->field_ids as $field_id){
					$field = new field($field_id);
					$field->add_category($this_id);
				}
			}
		}
		
		// Add the checked fields
		if (is_array($_POST["fields"])){
			foreach($_POST["fields"] as $key => $value){
				$field = new field($key);
				$field->add_category($this_id);
			}
		}
		
		if (is_array($_POST["view_users"])){
			foreach($_POST["view_users"] as $user_id){
				$temp_user = new user($user_id);
				$temp_user->add_category_view($this_id);
			}
		}
		
		if (is_array($_POST["admin_users"])){
			foreach($_POST["admin_users"] as $user_id){
				$temp_user = new user($user_id);
				$temp_user->add_category_admin($this_id);
			}
		}
	}
}
elseif($_POST["action"] == "do_edit"){
	if (!$admin_user->can_admin($_POST["parent"]) || (!$admin_user->can_admin($_POST["id"]))){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Make an object from the unchanged category
	$old_category = new category($_POST["id"]);
	
	// Change the category information
	$query = "UPDATE `anyInventory_categories` SET 
				`name`='".$_POST["name"]."',
				`parent`='".$_POST["parent"]."',
				`auto_inc_field`='".((int) (($_POST["auto_inc"] == "yes") / 1))."'
				WHERE `id`='".$_POST["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	// Remove the category from all of the fields
	if (is_array($old_category->field_ids)){
		foreach($old_category->field_ids as $field_id){
			$temp_field = new field($field_id);
			$temp_field->remove_category($old_category->id);
		}
	}
	
	if ($_POST["inherit_fields"] == "yes"){
		// Add the fields from the parent category
		$parent = new category($_POST["parent"]);
		
		if(is_array($parent->field_ids)){
			foreach($parent->field_ids as $field_id){
				$field = new field($field_id);
				$field->add_category($_POST["id"]);
			}
		}
	}
	
	// Add the checked fields
	if (is_array($_POST["fields"])){
		foreach($_POST["fields"] as $key => $value){
			$temp_field2 = new field($key);
			$temp_field2->add_category($_POST["id"]);
		}
	}
	
	if ($_POST["apply_fields"] == "yes"){
		// Apply the fields of this category to all of the children
		$category = new category($_POST["id"]);
		
		$children = get_category_array($category->id);
		
		if (is_array($children)){
			foreach($children as $child){
				remove_from_fields($child["id"]);
				
				if (is_array($category->field_ids)){
					foreach($category->field_ids as $field_id){
						$field = new field($field_id);
						$field->add_category($child["id"]);
					}
				}
			}
		}
	}
	
	$query = "SELECT `id` FROM `anyInventory_users` WHERE `usertype` != 'Administrator'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	if (PP_ADMIN || PP_VIEW){
		while ($row = $result->fetchRow()){
			$temp_user = new user($row["id"]);
			if (PP_ADMIN) $temp_user->remove_category_admin($_POST["id"]);
			if (PP_VIEW) $temp_user->remove_category_view($_POST["id"]);
		}
		
		if (PP_VIEW){
			if (is_array($_POST["view_users"])){
				foreach($_POST["view_users"] as $user_id){
					$temp_user = new user($user_id);
					$temp_user->add_category_view($_POST["id"]);
				}
			}
		}
		
		if (PP_ADMIN){
			if (is_array($_POST["admin_users"])){
				foreach($_POST["admin_users"] as $user_id){
					$temp_user = new user($user_id);
					$temp_user->add_category_admin($_POST["id"]);
				}
			}
		}
	}
}
elseif($_POST["action"] == "do_delete"){
	// Make sure the user clicked "Delete" and not "Cancel"
	if ($_POST["delete"] == "Delete"){
		if (!$admin_user->can_admin($_POST["id"])){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		else{
			// Create an object from the category
			$category = new category($_POST["id"]);
			
			// Delete the category
			$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$_POST["id"]."'"; 
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
			
			if ($_POST["item_action"] == "delete"){
				$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
				$result = $db->query($query);
				if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
				
				while ($row = $result->fetchRow()){
					$newquery = "SELECT `id` FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$row["id"]."\"%'";
					$newresult = $db->query($newquery);
					if (DB::isError($newresult)) die($newresult->getMessage().': line '.__LINE__.'<br /><br />'.$newresult->userinfo);
					
					while ($newrow = $newresult->fetchRow()){
						$alert = new alert($newrow["id"]);
						
						$alert->remove_item($row["id"]);
						
						if (count($alert->item_ids) == 0){
							$newerquery = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$alert->id."'";
							$newerresult = $db->query($newerquery);
							if (DB::isError($newerresult)) die($newerresult->getMessage().': line '.__LINE__.'<br /><br />'.$newerresult->userinfo);
						}
					}
					
					$newquery = "DELETE FROM `anyInventory_fields` WHERE `item_id`='".$row["id"]."'";
					$newresult = $db->query($newquery);
					if (DB::isError($newresult)) die($newresult->getMessage().': line '.__LINE__.'<br /><br />'.$newresult->userinfo);
				}
				
				// Delete all of the items in the category
				$query = "DELETE FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
				$result = $db->query($query);
				if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
			}
			elseif($_POST["item_action"] == "move"){
				$newcategory = new category($_POST["move_items_to"]);
				
				$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
				$result = $db->query($query);
				if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
				
				while($row = $result->fetchRow()){
					$newquery = "SELECT `id` FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$row["id"]."\"%'";
					$newresult = $db->query($newquery);
					if (DB::isError($newresult)) die($newresult->getMessage().': line '.__LINE__.'<br /><br />'.$newresult->userinfo);
					
					while ($newrow = $newresult->fetchRow()){
						$alert = new alert($newrow["id"]);
						
						if (!in_array($alert->field_id, $newcategory->field_ids)){
							$alert->remove_item($row["id"]);
							
							if (count($alert->item_ids) == 0){
								$newerquery = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$alert->id."'";
								$newerresult = $db->query($newerquery);
								if (DB::isError($newerresult)) die($newerresult->getMessage().': line '.__LINE__.'<br /><br />'.$newerresult->userinfo);
							}
						}
					}
				}
				
				// Move the items to a different category
				
				$query = "UPDATE `anyInventory_items` SET `item_category`='".$newcategory->id."' WHERE `item_category`='".$category->id."'";
				$result = $db->query($query);
				if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
			}
			
			if ($_POST["subcat_action"] == "delete"){
				// Delete the subcategories
				delete_subcategories($category);
			}
			elseif($_POST["subcat_action"] == "move"){
				// Move the subcategories
				$query = "UPDATE `anyInventory_categories` SET `parent`='".$_POST["move_subcats_to"]."' WHERE `parent`='".$category->id."'";
				$result = $db->query($query);
				if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
			}
			
			// Remove all of the fields from this category.
			remove_from_fields($category->id);
		}
	}
}

header("Location: categories.php");

?>
