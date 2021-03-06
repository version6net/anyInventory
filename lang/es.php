<?php

define('PAGE_DIMENSIONS','Medidas de p�gina');
define('LABEL_DIMENSIONS','Medidas de etiqueta');
define('ROWS','filas');
define('COLUMNS','columnas');
define('LABEL_TEMPLATE','Plantilla');
define('LANGUAGE','Idioma');
define('ID_MATCH',AUTO_INC_FIELD_NAME.' Match');
define('NAME_MATCH',NAME_FIELD_NAME.' Match');
define('SWITCH_TO_TABLE','Cambie a la Rejilla');
define('SWITCH_TO_LIST','Cambie a la Lista');

// Dates (Fechas)
define('MONTH_1','Enero');
define('MONTH_2','Febrero');
define('MONTH_3','Marzo');
define('MONTH_4','Abril');
define('MONTH_5','Mayo');
define('MONTH_6','Junio');
define('MONTH_7','Julio');
define('MONTH_8','Agosto');
define('MONTH_9','Septiembre');
define('MONTH_10','Octubre');
define('MONTH_11','Noviembre');
define('MONTH_12','Diciembre');

// General (General)
define('APP_TITLE','anyInventory');
define('HOME','Inicio');
define('ADMINISTRATION','Administraci&oacute;n');
define('APPLIES_TO','Aplica para');
define('ACTIVE_WHEN','Activa(o) cuando');
define('FOOTER_TEXT_PRE','has inventariado');
define('ANYINVENTORY_LINK','<a href="http://anyinventory.sourceforge.net/">anyInventory, el mas completo y flexible sistema de inventarios para web</a>');
define('FOOTER_TEXT_POST','art&iacute;culos con '.ANYINVENTORY_LINK);
define('HELP','Ayuda');
define('EDIT','Editar');
define('_DELETE','Eliminar');
define('CANCEL','Cancelar');
define('SUBMIT','Enviar');
define('VALUE','Valor');
define('NAME','Nombre');
define('EDIT_LINK','editar');
define('DELETE_LINK','eliminar');
define('TYPE','Tipo');
define('SELECT_NONE','Ninguna selecci�n');
define('SUBMIT_REPORT','Tu puedes colaborar con el desarrollo de anyInventory al <a href="https://sourceforge.net/tracker/?func�d&amp;group_id.0239&amp;atide5777">enviar este error como un reporte de fallo</a>.');

// Buscar(Search)
define('SEARCH','Buscar');
define('SEARCH_RESULTS','Buscar dentro de los resultados');
define('IN','En');
define('NO_RESULTS','No hubo resultados');
define('NO_MATCHING_ITEMS','No hubo art&iacute;culos que coincidieran con la b&uacute;squeda.');

// Mensajes de error (Error messages)
define('ERROR','Error');
define('ACCESS_DENIED','Acceso denegado');
define('ERROR_DUPLICATE_FIELD',"Ya existe un campo con el nombre especificado.  Si deseas agregar un campo a varias categor&iacute;as, lo puedes realizar editando el campo y seleccionando varias categor&iacute;as (manteniendo presionada la tecla 'Ctrl').");
define('ERROR_BAD_DEFAULT_VALUE',"El valor por defecto para un campo de selecci&oacute;n o radio debe estar incluido en la lista de valores.");
define('ERROR_EMPTY_CATEGORY',"No hay art&iacute;culos en las categor&iacute;as especificadas; las categor&iacute;as debe contener art&iacute;culos para poder agregar una alerta.");
define('ERROR_NO_COMMON_FIELDS',"No hay campos comunes para las categor&iacute;as seleccionadas.");
define('ERROR_ALERT_NO_CATEGORIES','Una alerta debe ser aplicada al menos a una categor&iacute;a.');
define('ERROR_ALERT_NO_ITEMS','Una alerta debe ser aplicada al menos a un art&iacute;culo.');
define('ERROR_NO_TOP_LEVEL_EDIT','La categor&iacute;a '.TOP_LEVEL_CATEGORY.' no puede ser editada o eliminada.');
define('ERROR_NO_VALUES','Es necesario especificar una lista de valores para este campo.');
define('ERROR_PRIVELEGES','No tienes los permisos suficientes.');
define('ERROR_DELETE_OWN_ACCOUNT','No es posible eliminar la cuenta de usuario propia.');
define('ERROR_DUPLICATE_USER','Ya existe una cuenta con el mismo nombre de usuario.');

// Etiquetas (Labels)
define('LABEL','Etiqueta');
define('LABELS','Etiquetas');
define('LABEL_ERROR','No tienes instaladas las funciones necesarias para crear etiquetas.  Estas funciones son: <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, y <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  Unas o mas de estas no fueron encontradas.');
define('LABEL_CAT_INSTRUCTIONS','Selecciona las categor&iacute;as a las que pertenecen los art&iacute;culos para los cuales quieres generar las etiquetas.  Todas las categor&iacute;as que selecciones deben tener al menos un campo en com&uacute;n.');
define('LABEL_ITEM_INSTRUCTIONS','Selecciona el campo del cual quieres generar el c&oacute;digo de barras y los art&iacute;culos para los cuales quieres generar una etiqueta.');
define('GENERATE_LABELS','Generar etiquetas');
define('GENERATE_FROM','Generar desde');
define('GENERATE_FOR','Generar para');

// Campos (Fields)
define('FIELD','Campo');
define('FIELDS','Campos');
define('ADD_FIELD','Agregar campo');
define('DATA_TYPE','Tipo de dato');
define('TEXT','Campo de texto');
define('RADIO','Radio botones');
define('CHECKBOX','Casillas de verificaci&oacute;n');
define('SELECT_BOX','Opci&oacute;n m&uacute;ltiple');
define('MULTIPLE','Compuestos ('.TEXT.' + '.SELECT_BOX.')');
define('FILE','Archivo');
define('VALUES','Valores');
define('DEFAULT_VALUE','Valor por defecto');
define('VALUES_INFO',"Solamente para tipos de dato '".MULTIPLE."', '".SELECT_BOX."', '".CHECKBOX."', y '".RADIO.".'  Separados por comas.");
define('DEFAULT_VALUE_INFO',"Solamente para tipos de dato '".MULTIPLE."', '".SELECT_BOX."', '".TEXT."', y '".RADIO."'");
define('SIZE','Tama�o, en caracteres');
define('_SIZE','Tama�o');
define('SIZE_INFO',"Solamente para tipo de dato '".TEXT."'.");
define('HIGHLIGHT','Subrayar');
define('HIGHLIGHT_FIELD','Subrayar este campo');
define('DELETE_FIELD','Eliminar campo');
define('DELETE_FIELD_CONFIRM','�Realmente deseas eliminar este campo?');
define('NONE','Ninguno');
define('FIELD_CATS_PRE','Este campo est&aacute; en uso en');
define('AUTO_INCREMENT','auto-incrementar');
define('SHOW_AUTOINC_FIELD','Mostrar campo auto-incrementar');
define('DIVIDER','Separador');
define('ADD_DIVIDER','Agregar separador');
define('_FRONT_PAGE_TEXT','Texto de primera p&aacute;gina');
define('_NAME_FIELD_NAME','T&iacute;tulo del campo "Nombre"');
define('DOWN_LINK','abajo');
define('UP_LINK','arriba');
define('EDIT_AUTOINC_FIELD','Editar campo auto-incrementar');
define('EDIT_FRONT_PAGE_TEXT','Editar texto de primera p&aacute;gina');
define('EDIT_NAME_FIELD','Editar campo "Nombre"');
define('APPLY_FIELDS',"Aplicar los campos de esta categor&iacute;a a todas las sub-categor&iacute;as.");
define('EDIT_FIELD','Editar campo');

// Categorias (Categories)
define('CATEGORIES','Categor&iacute;as');
define('ADD_CATEGORY','Agregar categor&iacute;as');
define('TOP_LEVEL_CATEGORY','Tope');
define('INHERIT_FIELDS','Heredar campos de la categor&iacute;a superior (adem&aacute;s de las que selecciones a continuaci&oacute;n)');
define('ADD_CAT_HERE','Agregar una categor&iacute;a aqu&iacute;');
define('NO_SUBCATS','No hay sub-categor&iacute;as en esta categor&iacute;a.');
define('SUBCATS_IN','Sub-categor&iacute;as en');
define('PARENT_CATEGORY','Categor&iacute;a superior');
define('DELETE_CATEGORY','Eliminar categor&iacute;a');
define('DELETE_CATEGORY_CONFIRM','�Realmente deseas eliminar esta categor&iacute;a?');
define('NUM_ITEMS','N&uacute;mero de elementos');
define('NUM_ITEMS_R','N&uacute;mero de elementos total');
define('DELETE_ALL_ITEMS','Eliminar todos los elementos de esta categor&iacute;a');
define('MOVE_ITEMS_TO','Mover todos los elementos de esta categor&iacute;a a ');
define('NUM_SUBCATS','N&uacute;mero de categor&iacute;as');
define('DELETE_ALL_SUBCATS','Eliminar todas las sub-categor&iacute;as');
define('MOVE_SUBCATS_TO','Mover todas las sub-categor&iacute;as a');
define('NUM_ITEMS_TO','N&uacute;mero de elementos en esta<br /> categor&iacute;a y sub-categor&iacute;as');
define('UPDATE_CATEGORIES','Actualizar categor&iacute;as');
define('EDIT_CATEGORY','Editar categor&iacute;a');

// Articulos (Items)
define('ITEMS','Art&iacute;culos');
define('ADD_ITEM','Agregar art&iacute;culo');
define('ADD_ITEM_HERE','Agregar un art&iacute;culo aqu&iacute;');
define('ADD_ITEM_TO','Agregar art&iacute;culos a');
define('ITEMS_IN_CAT','Art&iacute;culos en esta categor&iacute;a');
define('NO_ITEMS_HERE','No hay art&iacute;culos en esta categor&iacute;a.');
define('MOVE','Mover');
define('MOVE_LINK','mover');
define('RELATED_ITEMS','Art&iacute;culos relacionados');
define('MORE_ITEMS',' mas...');
define('DELETE_ITEM','Eliminar art&iacute;culo');
define('DELETE_ITEM_CONFIRM','�Realmente deseas eliminar este art&iacute;culo?');
define('MOVE_ITEM','Mover art&iacute;culo');
define('MOVE_TO','Mover a');
define('EDIT_ITEM','Editar art&iacute;culo');

// Alertas (Alerts)
define('ALERT','Alerta');
define('ALERTS','Alertas');
define('EFFECTIVE_DATE','V&aacute;lida a partir de');
define('CONDITION','Condici&oacute;n');
define('ADD_ALERT','Agregar alerta');
define('ADD_ALERT_IN','Agregar una alerta para');
define('ALERT_TITLE','T&iacute;tulo de alerta');
define('TIMED_ONLY_LABEL','La alerta estar&aacute; <a href="../docs/alerts.php#time_based">basada en fecha</a>.');
define('TIMED_ONLY_EXPLANATION','Para alertas basadas en fecha, no es necesario llenar el campo, condici&oacute;n o valor.');
define('DELETE_ALERT','Eliminar Alarma');
define('DELETE_ALERT_CONFIRM','�Realmente deseas eliminar esta alerta?');
define('EDIT_ALERT','Editar Alerta');
define('EXPIRATION_DATE','Fecha de expiraci�n');
define('ALLOW_EXPIRATION','Permitir que expire la alerta');
define('EMAIL_ALERT_TO','Enviar correo de alerta a');
define('EMAIL_ALERT_INFO','Deja vac�o este campo si no deseas ser avisado por correo cuando esta alerta se active.');
define('ALERT_ACTIVATED_BY','Esta alerta fue activida inicialmente por este art�culo');

// Usuarios (Users)
define('USERS','Usuarios');
define('ADD_USER','Agregar usuario');
define('LOGIN','Iniciar sesi&oacute;n');
define('LOG_OUT','Terminar sesi&oacute;n');
define('USERNAME','Nombre de usuario');
define('PASSWORD','Contrase�a');
define('GIVE_VIEW_TO','Dar permisos de consulta a');
define('GIVE_ADMIN_TO','Dar permisos de administraci&oacute;n a');
define('CAN_VIEW','Puede consultar');
define('CAN_ADMIN','Puede administrar');
define('ALL','Todos');
define('USER_TYPE','Perfil de usuario');
define('DELETE_USER','Eliminar usuario');
define('DELETE_USER_CONFIRM','�Realmente deseas eliminar este usuario?');
define('EDIT_PASSWORD_INFO','Si no escribes una nueva contrase�a, la usada actualmente no ser&aacute; modificada.');
define('USER','Usuario');
define('ADMINISTRATOR','Administrador');
define('EDIT_USER','Editar Usuarios');

define('ON_SUBMIT','En Enviar');
define('ADD_ITEM_HERE','Agregar un articulo mas aqui');
define('RETURN_TO_ITEMS','Vueltar a la pagina de los articulos');

// Barcodes
define('BARCODE_I25', '<p>Interleaved 2 of 5 (Code 25)</p>
							<p>Interleaved 2 of 5 is a high density variable length numeric only symbology
							  that encodes digit pairs in an interleaved manner. The odd position digits
							  are encoded in the bars and the even position digits are encoded in the
							  spaces. Because of this, I 2 of 5 bar codes must consist of an even number
							  of digits. Also, because partial scans of I 2 of 5 bar codes have a slight
							  chance of being decoded as a valid (but shorter) bar code, readers are
							  usually set to read a fixed (even) number of digits when reading I 2 of
							  5 symbols. The number of digits are usually pre-defined for a particular
							  application and all readers used in the application are programmed to only
							  accept I 2 of 5 bar codes of the chosen length. Shorter data can be left
							  padded with zeros to fit the proper length. Interleaved 2 of 5 optionally
							  allows for a weighted modulo 10 check character for special situations
							  where data security is important. <br>
							  anyInventory will pad out your number
							  to even length using the pad char, but it will not add the check character
							automatically. </p> ');
define('BARCODE_C39', '<p>Code 39</p>
							<p>Code 39 is a variable length symbology that can encode the
							  following 44 characters: 1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ-. *$/+%.
							  Each Code 39 bar code is framed by a start/stop character represented by an asterisk
							  (*). The asterisk is reserved for this purpose and may not be used in the
							body of a message. <br>
							anyInventory will automatically add the asterisk to
							the start and stop. </p> ');
define('BARCODE_C128', '<p>Code 128 has 106 different printed barcode patterns. Each
								printed barcode can have one of three different meanings depending on
								which of the three character sets are used. Three different Code 128
								start characters are available to tell the scanner which character set
								is initially being used. Use Code 128 when you need alphanumeric or very
								compact numeric only barcodes.</p>');
define('BARCODE_C128A', '<p>Code 128A</p>
							<p>Character set A allows for uppercase characters, punctuation, numbers
							  and several special functions such as a return or tab.</p>');
define('BARCODE_C128B', '<p>Code 128B</p>
							<p>Character set B is the most common because it encodes everything from
							  ASCII 32 to ASCII 126. It allows for upper and lower case letters, punctuation,
							numbers and a few select functions.</p>');
define('BARCODE_C128C', '<p>Code 128C</p>
							<p> Character set C encodes only numbers and the FNC1 function. Because
							  the numbers are &quot;interleaved&quot; into pairs, two numbers are encoded
							  into every barcode character which makes it a very high density barcode.
							  If your number is not even, anyInventory will add the pad character to
							  even it out. </p>');
define('BARCODE_FOOTER', 'Check Digit Requirement - in Code 128, The modulo 103 Symbol Check Character
						is required and it is only encoded in the bar code. The check digit should never
						appear in human the readable interpretation below the bar code. anyInventory
							  will automatically add a check digit to your Code 128 barcodes.');

?>