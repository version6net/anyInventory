<?php

include("globals.php");

if ($_REQUEST["action"] == "add_field"){
	$sized_input_types = array("text","multiple");
	
	if (($_REQUEST["size"] == '') && (in_array($_REQUEST["input_type"], $sized_input_types))){
		$_REQUEST["size"] = 255;
	}
	
	$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["input_type"]."','".$_REQUEST["values"]."','".$_REQUEST["default_value"]."','".$_REQUEST["size"]."','0')";
	$result = query($query);
	
	$query = "ALTER TABLE `anyInventory_items` ADD `".$_REQUEST["name"]."`";
	
	switch($_REQUEST["input_type"]){
		case 'text':
		case 'multiple':
			if ($_REQUEST["size"] < 256){
				$query .= " VARCHAR(".$_REQUEST["size"].") DEFAULT '".$_REQUEST["default_value"]."' ";
			}
			else{
				$query .= " TEXT ";
			}
			break;
		case 'radio':
		case 'checkbox':
		case 'select':
			$query .= " ENUM(";
			
			$enums = explode(",",$_REQUEST["values"]);
			
			foreach($enums as $enum){
				$query .= $enum.",";
			}
			
			$query = substr($query, 0, strlen($query) - 1);
			
			$query .= ") DEFAULT '".$_REQUEST["default_value"]."' ";
			break;
	}
	
	$query .= " NOT NULL";
	$result = query($query);
	
	header("Location: ".$_SERVER["PHP_SELF"]);
}
elseif($_REQUEST["action"] == "delete_field"){
	$field = new field($_REQUEST["id"]);
	
	$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
	$result = query($query);
	
	header("Location: ".$_SERVER["PHP_SELF"]);
}

$title = 'anyInventory Fields';
$page_key = "fields";
$links = array(array("url"=>$_SERVER["PHP_SELF"]."?action=add","name"=>"Add a Field"));

if ($_REQUEST["action"] == "add"){
	$output = '
			<form method="post" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">
				<h2>Add Field</h2>
				<input type="hidden" name="action" value="add_field" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="name">Data type:</label></td>
						<td class="form_input">
							<select name="input_type" id="input_type"">
								<option value="text">Text</option>
								<option value="select">Select Box</option>
								<option value="multiple">Multiple (Select + Text)</option>
								<option value="checkbox">Checkboxes</option>
								<option value="radio">Radio Buttons</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="form_label"><label for="values">Values:</label><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
						<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="default_value">Default value:</label></td>
						<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="size">Size, in characters:</label><br /><small>Only for data types \'Multiple\' and \'Text\'.</small></td>
						<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
					</tr>
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
}
else{
	$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?action=add">Add a field.</a></p>';
	
	$query = "SELECT *,'' as `nosortcol_`,`name` as `sortcol_Name`,`input_type` as `nosortcol_Type`,`values` as `nosortcol_Values`,`default_value` as `nosortcol_Default Value`,`size` as `nosortcol_Size` FROM `anyInventory_fields`";
	$data_obj = new dataset_library("Fields", $query, $_REQUEST, "mysql");
	$result = $data_obj->get_result_resource();
	$rows = $data_obj->get_result_set();
	
	if (mysql_num_rows($result) > 0){
		$i = 0;
		
		while($row = mysql_fetch_assoc($result)){
			$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
			$table_set .= '<tr class="'.$color_code.'">';
			$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;"><a href="'.$_SERVER["PHP_SELF"].'?action=edit_field&amp;id='.$row["id"].'">[edit]</a> <a href="'.$_SERVER["PHP_SELF"].'?action=delete_field&amp;id='.$row["id"].'">[delete]</a></td>';
			$table_set .= '<td>'.$row["name"].'</td>';
			$table_set .= '<td>'.$row["input_type"].'</td>';
			$table_set .= '<td>'.$row["values"].'</td>';
			$table_set .= '<td>'.$row["default_value"].'</td>';
			$table_set .= '<td>'.$row["size"].'</td>';
			$table_set .= '</tr>';
			$i++;
		}
	}
	else{
		$table_set .= '<tr class="row_off"><td>There are no fields to display.</td></tr>';
	}
	
	$table_set = $data_obj->get_sort_interface() . $table_set . $data_obj->get_paging_interface();
	
	$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';
}

include("header.php");
echo $output;
include("footer.php");

exit;

?>