<?php

error_reporting(E_ALL ^ E_NOTICE);

class file_object{
	var $id;			// The id of this file, matches up with the id field in anyInventory_files
	var $item_id;		// The id of the item that owns this file, matches up with the id field in anyInventory_items
	
	var $file_name;		// The name of this file.
	var $file_type;		// The mime type of this file.
	var $file_size;		// The size of this file, in bytes
	
	var $web_path;		// The path to this file on the Web.
	var $server_path;	// The path to this file on the server.
	
	function file_object($id){
		global $files_dir;		// The absolute path to the directory where files are stored
		global $DIR_PREFIX;		// The depth of the current directory we are in.
		
		// Set the id of this file.
		$this->id = $id;
		
		// Get the information about this file.
		$query = "SELECT * FROM `anyInventory_files` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		// Set the id of the item that owns this file.
		$this->item_id = $row["key"];
		
		// Set the file information.
		$this->file_name = $row["file_name"];
		$this->file_size = $row["file_size"];
		$this->file_type = $row["file_type"];
		
		// Set the Web and server path.
		$this->web_path = $DIR_PREFIX."item_files/".$this->file_name;
		$this->server_path = $files_dir.$this->file_name;
	}
	
	// This function returns a link to the file that contains the file name, file type, and file size.
	
	function get_download_link(){
		$link = '<a href="'.$this->web_path.'">'.$this->file_name.' ('.$this->file_type.', '.round($this->file_size / 1000).' KB)</a>';
		
		return $link;
	}
	
	// This function returns true ifthe file is an image, false otherwise.
	
	function is_image(){
		if (stristr($this->file_type, "image/") !== false){
			return true;
		}
		else{
			return false;
		}
	}
	
	// This function determines whether a thumbnail can be created for this file.
	
	function has_thumbnail(){
		// The only supported types currently are jpeg and png.
		if ((stristr($this->file_type, "/jpg") !== false) || (stristr($this->file_type, "/png") !== false) || (stristr($this->file_type, "/jpeg") !== false)){
			// Make sure the necessary functions exist.
			if (function_exists('getimagesize') && 
			    function_exists('imagecreate') && 
				function_exists('imagecreatefromjpeg') && 
				function_exists('imagecopyresized') && 
				function_exists('imagedestroy') && 
				function_exists('imagecreatefrompng') && 
				function_exists('imagejpeg')){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	// This function outputs a thumbnail of the file (if it is an image) directly to the browser.
	
	function output_thumbnail(){
		global $files_dir;
		
		// The maximum width and height for the thumnbail.
		$thumb_width = 120;
		$thumb_height = 120;
		
		// Get the information about the image.
		$image_info = getimagesize($this->server_path);
		
		$image_width = $image_info[0];
		$image_height = $image_info[1];
		
		// A thumbnail only needs to be created if the image is bigger than the max width or height.
		if (($image_width > $thumb_width) || ($image_height > $thumb_height)){
			// Set the ratio from the largest side.
			if (($image_width / $thumb_width) > ($image_height > $thumb_width)){
				$ratio = $thumb_height / $image_height;
			}
			else{
				$ratio = $thumb_width / $image_width;
			}
			
			// Set the dimension of the thumbnail
			$new_image_width = round($ratio * $image_width);
			$new_image_height = round($ratio * $image_height);
			
			// Create the thumbnail based on the image type.
			switch($image_info[2]){
				case 2:
					// JPG
					$thumb = imagecreate($new_image_width, $new_image_height);
					$image = imagecreatefromjpeg($this->server_path);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $image_width, $image_height);
					imagedestroy($image);
					break;
				case 3:
					// PNG
					$thumb = imagecreate($new_image_width, $new_image_height);
					$image = imagecreatefrompng($this->server_path);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $image_width, $image_height);
					imagedestroy($image);
					break;
			}
		}
		else{
			switch($image_info[2]){
				case 2:
					// JPG
					$thumb = imagecreatefromjpeg($this->server_path);
					break;
				case 3:
					// PNG
					$thumb = imagecreatefrompng($this->server_path);
					break;
			}
		}
		
		// Output the new image.
		header("Content-type: image/jpeg");
		imagejpeg($thumb, '', 100);
		
		// Destroy the new image.
		imagedestroy($thumb);
		exit;
	}
}

?>