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

$version = "1.0.1";

$panel = "<div id='panel'><a href='?download'>download</a></a>";

$eventName = $modx->event->name;
  switch($eventName) {
	  case 'OnPageNotFound':
	    if ($modx->context->key == 'mgr') return;
		$file_name = preg_replace(array("/\?(.*)/", "/\//"), '', $_SERVER['REQUEST_URI']);
		$SERVER_NAME = 	$name_virtual_file ? $name_virtual_file : $_SERVER['SERVER_NAME'];
		if($modx->user->isMember($members) && $file_name == $SERVER_NAME){
			$dir = $_SERVER['DOCUMENT_ROOT'].$dir.$_SERVER['SERVER_NAME'].'.send';
			if(isset($_GET['download'])){
				file_force_download($dir);
			}
			if(file_exists($dir)){
				$file = file_get_contents($dir); 	
				$file = iconv('windows-1251', 'utf-8', $file);
				echo "<em>version ".$version."</em>";
				echo $panel;
				echo '<pre>'.$file.'</pre>';
				exit();
			}
		}
	  break;
  }

function file_force_download($file) {
  if (file_exists($file)) { 
    if (ob_get_level()) { 
      ob_end_clean(); 
    } 
    header('Content-Description: File Transfer'); 
    header('Content-Type: application/octet-stream'); 
    header('Content-Disposition: attachment; filename=' . basename($file.'.txt')); 
    header('Content-Transfer-Encoding: binary'); 
    header('Expires: 0'); 
    header('Cache-Control: must-revalidate'); 
    header('Pragma: public'); 
    header('Content-Length: ' . filesize($file)); 
    readfile($file); 
  } 
}