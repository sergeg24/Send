<?php
//Отображает отправленные с форм заявки

//Путь до папки в которой лежит файл с сохранеными заявками
$dir = '/js/';

//Имя виртуального файла, по умолчанию имя_домена
$name_virtual_file = 'send.txt';

//Какие группы могут видеть файл
$members = array(
	'Administrator',
);

function file_get_contents_utf8($fn) {
	$content = file_get_contents($fn);
	return mb_convert_encoding($content, 'UTF-8',
			mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

$eventName = $modx->event->name;
  switch($eventName) {
	  case 'OnPageNotFound':
	    if ($modx->context->key == 'mgr') return;
		$file_name = str_replace(array('/'), '', $_SERVER['REQUEST_URI']);
		$SERVER_NAME = 	$name_virtual_file ? $name_virtual_file : $_SERVER['SERVER_NAME'];
		if($modx->user->isMember($members) && $file_name == $SERVER_NAME){
			$dir = $_SERVER['DOCUMENT_ROOT'].$dir.$_SERVER['SERVER_NAME'].'.send';
			if(file_exists($dir)){
				$file = file_get_contents_utf8($dir);
				$file = htmlspecialchars($file);
				echo '<pre>'.$file.'</pre>';
				exit();
			}
		}
	  break;
  }