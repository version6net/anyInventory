<?php

include("globals.php");

$title = "anyInventory: Delete Category";

$category = new category($_REQUEST["id"]);

$output .= '
	<form method="post" action="category_processor.php">
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<input type="hidden" name="action" value="do_delete" />
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>Delete a Category</td>
				<td style="text-align: right;">[<a href="../docs/deleting_categories.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<table>
						<tr>
							<td class="form_label">Name:</td>
							<td>'.$category->breadcrumb_names.'</td>
						</tr>
						<tr>
							<td class="form_label">Fields:</td>
							<td>';

if(is_array($category->field_names)){
	foreach($category->field_names as $field){
		$output .= $field.', ';
	}
	$output = substr($output, 0, strlen($output) - 2);
}
else{
	$output .= 'None';
}

$output .= '</td>
						</tr>
						<tr>
							<td class="form_label">Number of items:</td>
							<td>'.$category->num_items().'</td>
						</tr>';

if ($category->num_items() > 0){
	$output .= '		<tr>
							<td class="form_label"><input type="radio" name="item_action" value="delete" /></td>
							<td>Delete all items in this category</td>
						</tr>
						<tr>
							<td class="form_label"><input type="radio" name="item_action" value="move" /></td>
							<td>Move all items in this category to <select name="move_items_to" id="move_items_to">'.get_category_options($category->parent_id, false).'</select></td>
						</tr>';
}

$output .= '
						<tr>
							<td class="form_label">Number of subcategories:</td>
							<td>'.$category->num_children.'</td>
						</tr>';

if ($category->num_children > 0){
	$output .= '
		<tr>
			<td class="form_label"><input type="radio" name="subcat_action" value="delete" /></td>
			<td>Delete all sub-categories</td>
		</tr>
		<tr>
			<td class="form_label"><input type="radio" name="subcat_action" value="move" /></td>
			<td>Move all sub-categories to <select name="move_subcats_to" id="move_subcats_to">'.get_category_options($category->parent_id, false).'</select></td>
		</tr>
		<tr>
			<td class="form_label">Number of items in this category and its subcategories:</td>
			<td>'.$category->num_items_r().'</td>
		</tr>';
}

$output .= '<tr>
							<td class="form_label">&nbsp;</td>
							<td style="text-align: center;"><input type="submit" name="delete" value="Delete" class="submitButton" /> <input type="submit" name="cancel" value="Cancel" class="submitButton" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>