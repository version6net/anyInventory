<?php

include("globals.php");

$title = 'anyInventory: Categories';
$breadcrumbs = 'Administration > Categories';

$rows = get_category_array();

if (count($rows) > 0){
	foreach($rows as $row){
		$temp = new category($row["id"]);
		
		$table_rows .= '
			<tr>
				<td align="center" style="width: 15ex; white-space: nowrap;">
					<nobr>
						[<a href="edit_category.php?id='.$row["id"].'">edit</a>]
						[<a href="delete_category.php?id='.$row["id"].'">delete</a>]
					</nobr>
				</td>
				<td style="white-space: nowrap;">'.$row["name"].' ('.$temp->num_items_r().')</td>
			</tr>';
	}
	
	$table_rows = '<table>'.$table_rows.'</table>';
}
else{
	$table_rows = 'There are no categories to display.';
}

$output .= '
	<table class="standardTable" cellspacing="0" cellpadding="3">
		<tr class="tableHeader">
			<td>
				Categories (<a href="add_category.php">Add a category</a>)
			</td>
			<td style="text-align: right;">
				[<a href="../docs/categories.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>