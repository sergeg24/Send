<?php
//���������� ������������ � ���� ������

//���� �� ����� � ������� ����� ���� � ����������� ��������
$dir = '/js/';

//��� ������������ �����, �� ��������� ���_������
$name_virtual_file = 'send.txt';

//����� ������ ����� ������ ����
$members = array(
	'Administrator',
);

$eventName = $modx->event->name;
  switch($eventName) {
	  case 'OnPageNotFound':
	    if ($modx->context->key == 'mgr') return;
		$file_name = str_replace(array('/'), '', $_SERVER['REQUEST_URI']);
		$SERVER_NAME = 	$name_virtual_file ? $name_virtual_file : $_SERVER['SERVER_NAME'];
		if($modx->user->isMember($members) && $file_name == $SERVER_NAME){
			$dir = $_SERVER['DOCUMENT_ROOT'].$dir.$_SERVER['SERVER_NAME'].'.send';
			if(file_exists($dir)){
				$file = file_get_contents($dir);
				$file = iconv('windows-1251', 'utf-8', $file);
				$file = htmlspecialchars($file);
				echo '<pre>'.$file.'</pre>';
				exit();
			}
		}
	  break;
  }