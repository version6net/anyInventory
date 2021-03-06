<?php

error_reporting(E_ALL ^ E_NOTICE);

class item {
	var $id;					// The id of the item, matches up with id field in anyInventory_items
	
	var $category;				// A category object of the category to which this item belongs.
	
	var $name;					// The name of this item.
	var $fields = array();		// An associative array, keyed by the field name, consisting of the field values.
	var $files;		// An array of file objects that belong to this item.
	
	function item($item_id){
        global $db;
		
		// Set the item id.
		$this->id = $item_id;
		
		// Get the information about this item.
		$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('id') . " = '".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);                    
		 
		$row = $result->fetchRow();
		
		// Set the item name.
		$this->name = $row["name"];
		
		// Create the category object.
		$this->category = new category($row["item_category"]);
		
		$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_values') . " WHERE " . $db->quoteIdentifier('item_id') . "='".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		while($row = $result->fetchRow()){
			$field = new field($row["field_id"]);
			
			if ($field->input_type == 'file'){
				$this->fields[$field->name] = array("is_file"=>true,"file_id"=>$row["value"]);
			}
			elseif($field->input_type == 'item'){
				$this->fields[$field->name] = unserialize($row["value"]);
			}
			elseif($field->input_type == 'divider'){
				$this->fields[$field->name] = array("is_divider"=>true);
			}
			elseif ($field->input_type != "checkbox"){
				$this->fields[$field->name] = $row["value"];
			}
			else{
				if (strstr($row["value"],",") !== false){
					$this->fields[$field->name] = explode(",",$row["value"]);
					if (is_array($this->fields[$field->name])){
						foreach($this->fields[$field->name] as $key => $value){
							$this->fields[$field->name][$key] = trim($value);
						}
					}
				}
				elseif ($row["value"] != '') {
					$this->fields[$field->name][0] = trim($row["value"]);
				}
			}
		}
		
		// Get each of this item's files and add it to the array.
		$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('key') . " = '".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);                    
		
		while ($row = $result->fetchRow()){
			$this->files[] = new file_object($row["id"]);
		}
	}
	
	// This function returns a "teaser" or short description and link for the item.
	function export_teaser(){
		global $DIR_PREFIX;
		
		$output = '<a href="'.$DIR_PREFIX.'index.php?c='.$this->category->id.'&amp;id='.$this->id.'" style="text-decoration: none;"><b>'.$this->name.'</b></a>';
		
		return $output;
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $db;
		global $DIR_PREFIX;
		global $admin_user;
		
		// Create the header with the name.
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.$this->name;
		
		if($admin_user->can_admin($this->category->id)){
			$output .= ' ( <a href="'.$DIR_PREFIX.'admin/move_item.php?id='.$this->id.'">'.MOVE.'</a> | <a href="'.$DIR_PREFIX.'admin/edit_item.php?id='.$this->id.'">'.EDIT.'</a> | <a href="'.$DIR_PREFIX.'admin/delete_item.php?id='.$this->id.'">'._DELETE.'</a> )';
		}
		
		$output .= '		
					</td>
				</tr>
				<tr>
					<td class="tableData">
						<table cellspacing="0" cellpadding="3">';
		
		if ($this->category->auto_inc_field){
			$output .= '
				<tr class="highlighted_field">
					<td style="width: 5%;">
						<a href="./label_processor.php?i='.$this->id.'&amp;bar='.BARCODE.'&amp;f=0" style="color: #000000;">PNG</a>&nbsp;<a href="./pdf.php?i='.$this->id.'&amp;bar='.BARCODE.'&amp;template='.BAR_TEMPLATE.'&amp;f=0" style="color: #000000;">PDF</a>
					</td>
					<td style="text-align: right; width: 10%; white-space: nowrap;"><nobr><b>'.AUTO_INC_FIELD_NAME.':</b></nobr></td>
					<td style="width: 85%;"></b> '.$this->id.'</td>
				</tr>';
		}
		
		// Output each field with its value.
		if (is_array($this->category->field_ids)){
			foreach($this->category->field_ids as $field_id){
				$field = new field($field_id);
				
				if ($field->input_type == "file"){
					if ($this->fields[$field->name]["file_id"] > 0){
						$output .= '
							<tr';
						
						if ($field->highlight){
							$output .= ' class="highlighted_field"';
						}
						
						$output .= '>
								<td>&nbsp;</td>
								<td style="white-space: nowrap; text-align: right;"><b>'.$field->name.':</b></td>
								<td>';
						
						$file = new file_object($this->fields[$field->name]["file_id"]);
						
						if ($file->is_image()){
							$output .= '<a href="'.$file->web_path.'"><img src="';
							if ($file->has_thumbnail()) $output .= $DIR_PREFIX.'thumbnail.php?id='.$file->id;
							else $output .= $DIR_PREFIX."images/no_thumb.gif";
							
							$output .= '" class="thumbnail" /></a>';
						}
						else{
							$output .= $file->get_download_link();
						}
						
						$output .= '
								</td>
							</tr>';
					}
					
					$last_divider = false;
				}
				elseif($field->input_type == 'item'){
					if (is_array($this->fields[$field->name]) && (count($this->fields[$field->name]) > 0)){
						$output .= '
							<tr';
						
						if ($field->highlight){
							$output .= ' class="highlighted_field"';
						}
						
						$output .= '>
							<td>&nbsp;</td>
							<td style="white-space: nowrap; text-align: right;"><b>'.$field->name.':</b></td>
							<td>';
						
						foreach($this->fields[$field->name] as $item_id){
							$item = new item($item_id);
							$output .= $item->export_teaser() . '<br />';
						}
						
						$output .= '
								</td>
							</tr>';
						
						$last_divider = false;
					}
				}
				elseif($field->input_type == 'divider'){
					if (!$last_divider)	$output .= '<tr><td colspan="3"><hr /></td></tr>';
					$last_divider = true;
				}
				elseif(is_array($this->fields[$field->name]) && (count($this->fields[$field->name]) > 0)){
					$output .= '<tr';
					
					if ($field->highlight){
						$output .= ' class="highlighted_field"';
					}
					
					$output .= '><td>&nbsp;</td><td style="text-align: right;"><b>'.$field->name.':</b></td><td> ';
					
					foreach($this->fields[$field->name] as $val){
						$output .= $val.", ";
					}
					
					$output = substr($output, 0, strlen($output) - 2) . '</td></tr>';
					
					$last_divider = false;
				}
				elseif (trim(strip_tags($this->fields[$field->name])) != ""){
					$output .= '
						<tr';
					
					if ($field->highlight){
						$output .= ' class="highlighted_field"';
					}
					
					$output .= '>
							<td style="width: 8%;">
								<a href="'.$DIR_PREFIX.'label_processor.php?i='.$this->id.'&amp;bar='.BARCODE.'&amp;f='.$field->id.'" style="color: #000000;">PNG</a>&nbsp;<a href="'.$DIR_PREFIX.'pdf.php?i='.$this->id.'&amp;bar='.BARCODE.'&amp;template=6&amp;f='.$field->id.'" style="color: #000000;">PDF</a>
							</td>
							<td style="text-align: right; width: 10%; white-space: nowrap;"><nobr><b>'.$field->name.'</b>:</nobr></td>
							<td style="width: 85%;">'.$this->fields[$field->name].'</td>
						</tr>';
					
					$last_divider = false;
				}
			}
			
			$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE " . $db->quoteIdentifier('input_type') . " = 'item'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);                    
			
			while ($row = $result->fetchRow()){
				$query2 = "SELECT " . $db->quoteIdentifier('item_id') . " FROM " . $db->quoteIdentifier('anyInventory_values') . " WHERE " . $db->quoteIdentifier('value') . " LIKE '%\"".$this->id."\"%' GROUP BY " . $db->quoteIdentifier('item_id') . "";
				$result2 = $db->query($query2);
				if(DB::isError($result2)) die($result2->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query2);
				
				while ($row2 = $result2->fetchRow()){
					$backlinks[] = $row2["item_id"];
				}
			}
			
			if (is_array($backlinks)){
				$backlinks = array_unique($backlinks);
				
				if (!$last_divider){
					$output .= '<tr><td colspan="3"><hr /></td></tr>';
					$last_divider = true;
				}
				
				$output .= '
					<tr>
						<td>&nbsp;</td>
						<td style="text-align: right; width: 10%; white-space: nowrap;"><nobr><b>'.RELATED_ITEMS.':</b></nobr></td>
						<td>';
				
				foreach($backlinks as $item_id){
					$item = new item($item_id);
					
					$output .= $item->export_teaser().'<br />';
				}
				
				$output .= '</td>
						</tr>';
			}
			
			$output .= '
							</table>
						</td>
					</tr>
				</table>';
		}
		
		return $output;
	}
	
	function export_table_row(){
		$output .= '<tr>';
		
		if ($this->category->auto_inc_field){
			$output .= '<td style="white-space: nowrap; border-width: 0px 1px 0px 0px; border-color: #aaaaaa; border-style: solid;"><nobr>'.$this->id.'</nobr></td>';
		}
		
		$output .= '<td style="white-space: nowrap; border-width: 0px 1px 0px 0px; border-color: #aaaaaa; border-style: solid;"><nobr><a href="'.$DIR_PREFIX.'index.php?c='.$this->category->id.'&amp;id='.$this->id.'">'.$this->name.'</a></nobr></td>';
		
		if (is_array($this->category->field_ids)){
			foreach($this->category->field_ids as $fid){
				$field = new field($fid);
				
				if (($field->input_type != 'divider') && ($field->input_type != 'file') && ($field->input_type != 'item')){
					$output .= '<td style="white-space: nowrap; border-width: 0px 1px 0px 0px; border-color: #aaaaaa; border-style: solid;"><nobr>'.$this->fields[$field->name].'</nobr></td>';
				}
			}
		}
		
		$output .= '</tr>';
		
		return $output;
	}
	
	function export_assoc_array(){
		$array = array();
		
		$array["id"] = $this->id;
		
		$array["name"] = $this->name;
		
		if (is_array($this->category->field_ids)){
			foreach($this->category->field_ids as $fid){
				$field = new field($fid);
				
				if (($field->input_type != 'divider') && ($field->input_type != 'file') && ($field->input_type != 'item')){
					$array["field_".$fid] = $this->fields[$field->name];
				}
			}
		}
		
		return $array;
	}
	
	function delete_self(){
		global $admin_user,$db;
		
		if (!$admin_user->can_admin($item->category->id)){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		if (is_array($this->files)){
			foreach($this->files as $file){
				$file->delete_self();
			}
		}
		
		// Remove this item from any alerts
		$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('item_ids') . " LIKE '%\"".$this->id."\"%'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);                    
		
		while ($row = $result->fetchRow()){
			$alert = new alert($row["id"]);
			
			$alert->remove_item($this->id);
		}
		
		$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);                    
		
		$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_values') . " WHERE " . $db->quoteIdentifier('item_id') . "='".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);                    
		
		return;
	}
}

?>
