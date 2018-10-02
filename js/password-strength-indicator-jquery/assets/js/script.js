$(function(){
	
	var pass1 = $('#password1'),
		pass2 = $('#password2'),
		email = $('#email'),
		form = $('#main form'),
		arrow = $('#main .arrow');

	// Опустошаем поле при загрузке
	$('#main .row input').val('');

	// Обрабатывае мотправку формы
	form.on('submit',function(e){
		
		// Все введено корректно?
		if($('#main .row.success').length == $('#main .row').length){
			
			// Да!
			alert("Спасибо за внимание!");
			e.preventDefault(); // Удалить для реальной отправки данных
			
		}
		else{
			
			// Нет. Останавливаем отправку формы
			e.preventDefault();
			
		}
	});
	
	// Проверка адреса e-mail
	email.on('blur',function(){
		
		// оченьт простая процедура проверки
		if (!/^\S+@\S+\.\S+$/.test(email.val())){
			email.parent().addClass('error').removeClass('success');
		}
		else{
			email.parent().removeClass('error').addClass('success');
		}
		
	});

	// Используем плагин complexify на первом поле ввода пароля
	pass1.complexify({minimumChars:6, strengthScaleFactor:0.7}, function(valid, complexity){
		
		if(valid){
			pass2.removeAttr('disabled');
			
			pass1.parent()
					.removeClass('error')
					.addClass('success');
		}
		else{
			pass2.attr('disabled','true');
			
			pass1.parent()
					.removeClass('success')
					.addClass('error');
		}
		
		var calculated = (complexity/100)*268 - 134;
		var prop = 'rotate('+(calculated)+'deg)';
		
		// Вращаем стрелку
		arrow.css({
			'-moz-transform':prop,
			'-webkit-transform':prop,
			'-o-transform':prop,
			'-ms-transform':prop,
			'transform':prop
		});
	});
	
	// Проверяем второе поле ввода пароля
	pass2.on('keydown input',function(){
		
		// Нужно убедиться, что эначения первого и второго полей ввода пароля одинаковы
		if(pass2.val() == pass1.val()){
			
			pass2.parent()
					.removeClass('error')
					.addClass('success');
		}
		else{
			pass2.parent()
					.removeClass('success')
					.addClass('error');
		} 
	});
	
});
