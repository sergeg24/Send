Version 1.6.4 (совместим с 1.6.*)

1.6.4 
- Добавлено событие "send", с помощью него можно контролировать выполнение скрипта, пример:

	<script>
		$(document).on( 'send', function( event, param ) {
			console.log( param );
		});
	</script>		

- добавлена возможность изменять путь к обработчику у формы, достаточно его прописать в action у формы. 
- добавлена возможность использовать вместо тега form любой другой тег (div, p и т.д.). 
- добавлена возможность скрывать форму после успешной отправки. На блок с фомой нужно повесить класc: hide_*. (* - id формы) 
- добавлена возможность выводить своё сообщение об успешной отправки, вместо единички нужно отправить json данные, пример:
	<?php
		echo json_encode(
			array(
				'good' => 'Сообщение успешно отправлено!'
			)
		);
	?>		
1.6.3 - исправлено: при многочисленном нажатии на кнопку отправки не корректно отображались сообщения об ошибках

1.6.2 - добавлена возможность передачи файлов + мелкие доработки

1.6.1 - добавлена возможность передачи данных из select

Код HTML:

<!doctype html>
<html>
    <head>
    <title>send</title>
    <meta charset='utf-8' />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="/js/send.1.6.4.js"></script>
</head>
<body>

	<form id="form_1" class="hide_1">
	<input type="text" id="name_1"  class="required" placeholder="Имя" title='Имя'><br/>
	<input type="text" id="email_1" class="required" placeholder="E-mail" title='E-mail'><br/>
	<input type="text" id="phone_1" title='Телефон' placeholder="+7(___)___-__-__"><br/>
	<select id="select_1" class="required" title='Доп. поле'>
		<option value=''>-</option>
		<option value='1'>Один</option>
		<option value='2'>Два</option>
	</select><br/>
	<input type="file" id="file_1" title="Документ" class="required"><br/>
	1)Тут можно выбрать checkbox: <input type="checkbox" id="checkbox_1" class="required" title='checkbox' value=""><br/>
	2)Тут можно выбрать checkbox: <input type="checkbox" id="checkbox2_1" title='checkbox' value=""><br/>
	1)Тут можно выбрать radio:<input type="radio" id="radio1_1" name="radio" title='radio' value=""><br/>
	2)Тут можно выбрать radio:<input type="radio" id="radio2_1" name="radio" title='radio' value=""><br/>
	<textarea maxlength="500" id="message_1" class="" placeholder="Интересующая техника, оборудование или запчасти."></textarea><br/>
	<input type="submit" value="Отправить вопрос"> 
	<div id="result_1"></div>
	</form>
  
</body>
</html>	
