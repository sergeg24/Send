//version 1.6.3
//manual: http://ima-pr.ru/js/archives/send/
//onclick="formSend(id);return false;";
function formSend(id){
	var inputVal,fieldName='',countCheck,type,typeInp='',button,max_upload_file,c,name,checked_obj,default_message,objectElement,url,input,label,fNameA,emptyElement,formTegId,test,
	idInp,good,one,fieldNameA,nameArray,requestRequired,checked,val,classErr,classValid,patternID = /_[^|]*$/i,ElementShift,idResult,fd,file_data,
	classResult,send_request_always,elementId,countElement,request,patternEmail = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
	/*~~~OPTION~~~*/
	url = "/js/archives/send/send-test.php";//путь до файла отправки почты	
	max_upload_file = 2;//максимально допустимый размер загружаемого файла (Мб)
	formTegId = "#form_"+id;//id на тег <form>	
	idResult = "#result_"+id;//вывод результата в блок	
	classResult = "result";//доп. класс. Вставляется на блок "idResult"	
	send_request_always = true;//(true) всегда отправляет запрос к обработчику, даже если заполнены не все обязательные поля		
	one = "1";//то что толжен вернуть обработчик в случае успешной проверки формы (echo "1";)	
	classErr = "f_err";//класс пустого поля		
	classValid = "f_valid";//класс заполненного поля		
	default_message = ["Укажите id формы!","<div class='good'><span>Сообщение успешно отправлено!</span></div>",]
	/*~~~OPTION~~~*/
	good = default_message[1];
	if($.type(id) === 'undefined' || id == ''){
		alert(default_message[0]);
		return false;
	}
	fd = new FormData($(formTegId)[0]);
	fd.append("form", id);
	countElement = 0;
	test = [];
	requestRequired = [];
	request = [];
	button = $(formTegId + ' input[type="submit"],'+formTegId+' button');
	//Собираем все поля в два массива, все поля и обязательные поля
	$(formTegId + " *").each(function(){
		objectElement = $(this);
		elementId = objectElement.attr("id");
		if($.type(elementId) !== 'undefined'){
			if($(this).hasClass( "required" )){
				requestRequired.push("#"+elementId);
			}
			type = $(this)[0].type;
			if($.type(type) !== 'undefined'){
				typeInp = "|" + $(this)[0].type;
			}else{
				typeInp = '';
			}
			request.push(elementId + typeInp);
		}				
	});	
	//подгатавливаем ВСЕ запросы
	for (var i = 0; i < request.length; i++){
		fieldNameA = request[i];
		nameArray = fieldNameA.split("|");
		name = nameArray[0].replace(patternID,'');
		type = nameArray[1];
		countCheck = nameArray.length;
		if(type == 'checkbox'){
			checked_obj = $("#"+nameArray[0]+":checkbox:checked");	
			c = 1;
		}else if(type == 'radio'){
			checked_obj = $("#"+nameArray[0]+":radio:checked");
			c = 1;
		}else{
			val = $("#"+nameArray[0]).val();
			c = 0;
		}	
		if(c){
			checked = checked_obj.length;
			if(checked == 1){
				$("#"+nameArray[0]).val(1);
			}else{
				$("#"+nameArray[0]).val('');
			}
			val = checked;
		}	
		if(type == 'file'){
			file_data = $("#"+nameArray[0]).prop('files')[0];
			if($.type(file_data) !== 'undefined'){
				if(max_upload_file * 1000000 < file_data.size){
					$("#"+nameArray[0]).val('');
				}
				fd.append(name, file_data);
			}	
		}
		if(countCheck == 1) continue;
		fd.append(name, val);
	}
	//производим проверку обязательных полей
	for (var i = 0; i < requestRequired.length; i++){
		countElement++;
		idInp = requestRequired[i];
		input = $(idInp);
		inputVal = input.val();	
		fNameA = idInp.replace(patternID,'');				
	if(inputVal==""){
		test.unshift(idInp);
		input.addClass(classErr).removeClass(classValid);						
		$(idInp + " + label").remove();
	}else if(fNameA == "#email" || fNameA == "#mail"){
		if(!patternEmail.test($(idInp).val())){
			test.unshift(idInp);
			input.addClass(classErr).removeClass(classValid);						
			$(idInp + " + label").remove();
		}else{
			input.addClass(classValid).removeClass(classErr);						
			$(idInp + " + label").remove();
		}	
	}else{
			input.addClass(classValid).removeClass(classErr);
			$(idInp + " + label").remove();
		}
	} 
	emptyElement = test.reverse();
	ElementShift = emptyElement.shift();//id		
	if($.type(ElementShift) != 'undefined'){
		if($.type($(ElementShift).attr('title')) != 'undefined'){
			label = "<label class='messageLabel'>Заполните поле: <span>" + $(ElementShift).attr('title') + "!</span></label>";
		}
		$(ElementShift).focus().after(label);
		if(send_request_always == false){
			return false;
		}
	}
	$.ajax({	
		type: "POST",
		url: url,
		data: fd,
		contentType: false,
		processData: false,
		dataType: "html",	
		success: function(html){
		$(idResult).empty();
			if(html == one){
				button.prop('disabled', true);
				$(formTegId).trigger('reset');
				input.removeClass(classValid);
				$(idResult).append(good);
				$(idResult+" .good").fadeIn().delay(2000).fadeOut();
				$(idResult).fadeIn().delay(2000).fadeOut('show', function(){
					button.prop('disabled', false);
				});
			}else{
				button.prop('disabled', true);
				$(idResult).fadeIn().append(html).delay(2000).fadeOut('show', function(){
					button.prop('disabled', false);
				});	
			}
		}
	});
}