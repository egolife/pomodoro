/**
 * Создает строку вида dd.mm.yyyy с ведущими нулями (если нужно)
 * @param  {Date} date Дата из которой создаем строку
 * @return {string}      Строка формата dd.mm.yyyy
 */
function formatDate(date){
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();

	return addLeadZero(day) + "." + addLeadZero(month) + "." + year;
}

/**
 * Создает из числа строку с ведущими нулями
 * @param {number} num число для преобразования
 * @param {number} strLength итоговая длина строки | по умолчанию 2
 */
function addLeadZero(num, strLength){
	var desiredLength = strLength || 2;
	var currentLength = String(num).length;
	var diff = desiredLength - currentLength;
	var leadZero = "";
	if(diff <= 0){
		return String(num);
	}

	for (var i = 0; i < diff; i++) {
		leadZero += "0";
	}

	return leadZero + num;
}

/**
 * Нужно переделывать - на данный момент созадет html-код для сообщения, показывает его и скрывает
 * @param  {string} str Текст сообщения
 */
function flashMessage(str){
	$("body").prepend("<div class='alert alert-success alert-dismissable'></div>")
	.find(".alert-dismissable").hide().append(str).slideDown(400).delay(4000).slideUp(400, function(){
		$(this).remove();
	});
}

/**
 * Создает отображение задачи - строку таблицы из объекта
 * @param  {object} obj {id, name, task, pomodoros [, ...]}
 * @return {string}     Строка для вставки в таблицу
 */
function generate_new_row(obj){

	var str = "<tr " + "data-taskid='" + obj.id + "'>";
	str += "<td>" + obj.name + "&nbsp;</td>";
	str += "<td>" + obj.task + "</td>";
	str += "<td>" + obj.pomodoros + "</td>";
	str += "<td class='text-center'>" + "<input type='checkbox' checked value='" + obj.id + "' form='selectionForm' id='task";
	str += obj.id + "' name='task" + obj.id + "'>" + "</td>";
	str += "<td class='text-center'>" + "<a class='freeze_toggle' href='#'>freeze</a>" + "</td>";
	str += "<td class='text-center'>";
	str += "<a data-toggle=\"modal\" data-target=\"#done_modal\" href='#'>done</a>";
	str += "</td>";
	str += "</tr>";

	return $(str);
}

/**
 * Незаконченная функция - должна приводить любую форму в исходное состояние
 * (сейчас только input и textarea)
 * @param  {jQuery} $form коллекция (объект) jQuery с формой
 */
function empty_form($form){
	$form.find("input, textarea").not("[type=submit]").val("").end().find("select").unset();
}