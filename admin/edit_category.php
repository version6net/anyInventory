<?php

include("globals.php");

if ($_REQUEST["id"] == '0'){
	header("Location: ../error_handler.php?eid=7");
	exit;
}
else{
	$title = "anyInventory: Edit Category";
	$breadcrumbs = 'Administration > <a href="categories.php">Categories</a> > Edit Category';
	
	$category = new category($_REQUEST["id"]);
	
	$checked = ($category->auto_inc_field) ? ' checked="checked"' : '';
	
	$exclude = $category->all_children_ids;
	$exclude[] = $category->id;
	
	$output = '
		<form method="post" action="category_processor.php">
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$category->id.'" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Edit a Category: '.$category->get_breadcrumb_admin_links().'</td>
					<td style="text-align: right;">[<a href="../docs/editing_categories.php">Help</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
					<table>
						<tr>
							<td class="form_label"><label for="name">Name:</label></td>
							<td class="form_input"><input type="text" name="name" id="name" value="'.$category->name.'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="parent">Parent Category:</label></td>
							<td class="form_input">
								<select name="parent" id="parent">
									<option value="0">Top Level</option>
									'.get_category_options($category->parent_id, false, $exclude).'
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label">Fields:</td>
							<td class="form_input">
								<input type="checkbox" name="auto_inc" id="auto_inc" value="yes" '.$checked.' /> Show auto-increment field<br /><br />';
	
	if($category->id != 0){
		$output .= '<input type="checkbox" name="inherit_fields" id="inherit_fields" value="yes" checked="checked" /> Inherit fields from this category\'s parent.<br />';
	}
	
	if($category->num_children > 0){
		$output .= '<input type="checkbox" name="apply_fields" id="apply_fields" value="yes" checked="checked" /> Apply this category\'s fields to all subcategories.<br />';
	}
	
	$output .= '<br />'.get_fields_checkbox_area($category->field_ids).'
							</td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</form>';
	
	display($output);
}

?>