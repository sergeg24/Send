<?php
$to = "";
$site = $_SERVER['SERVER_NAME'];

function save(){
	$file = $_SERVER['SERVER_NAME'].".txt";
	$today = date("F j, Y, g:i a");
	$htmlspecialchars = '['.$today.'] '; 
	foreach($_POST as $name => $value){
		if($value!='undefined' && $value!=''){
			$htmlspecialchars .= $name.":".$value."|";
		}
	}
	$htmlspecialchars = substr($htmlspecialchars,0,-1)."\n";
	if($fopen = fopen($file, "a+")){
		fwrite($fopen, iconv("UTF-8", "WINDOWS-1251", $htmlspecialchars));
		}
	fclose($fopen);
}


if($_POST["form"] == "1"){

	$name  =  $_POST['name'];
	$phone = $_POST['phone'];
	
	$titles = "������ � ����� (�������� ������) � ����� ".$site;
	
	$mess  = "<body><b>".$titles."</b><br />";
	$mess .= "<br />";
	$mess .= "<b>���������� ������:</b><br />";
	$mess .= "���: <br />" . $name . "<br />";
	$mess .= "�������: <br />" ."+".$phone . "<br />";

	$header="Content-type: text/html; charset=\"utf-8\"\n";
	$header .="From: ". $site . "<".$site.">\n";
	$header .="Subject: " . $titles . "\n";

	if(empty($phone)){
		echo "������� ����� ��������!";
	}elseif(!preg_match('/^[0-9\(\)\-\+]+$/',$phone)){
		echo "������� ���������� ����� ��������!";
	}else{
		if(mail($to, $titles, $mess, $header)){
				echo "1";
		}else{
			echo "�� ������� ��������� ���������!";
		}
	}
}