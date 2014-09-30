/**
* ---------------------------------------------------------------------------------------------------------------------------------------
* Main js functionality
* ---------------------------------------------------------------------------------------------------------------------------------------
*/

var onEvent = {

	/*  отправляет на сервер запрос на добавление задания в общий список */
	new_task : function(e){

		e.preventDefault();

		var data = $( this ).serialize();

		$.post("new_record.php", data, function(data){

			var data = $.parseJSON(data);

			var message = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>";
			message += "&times;</button>";
			message += "<strong>Все ок! </strong>";
			message += data.status;

			$("body").prepend("<div class='alert alert-success alert-dismissable'></div>")
			.find(".alert-dismissable").hide().append(message).slideDown(400).delay(4000).slideUp(400, function(){
				$(this).remove();
			});



			var tmp = "";
			tmp += "<tr>";
			tmp += "<td>" + $("#typeInput").find("option[value='"+$("#typeInput").val()+"']").text() + "</td>";
			tmp += "<td>" + $("#activityInput").val() + "</td>";
			tmp += "<td>" + $("#estimateInput").val() + "</td>";
			tmp += "<td class='text-center'><input type='checkbox' checked value='" + data.id + "' form='selectionForm' id='task";
			tmp += data.id +"' name='task" + data.id + "'></td>";
			tmp += "</tr>";
			$("#newNode").before(tmp);

		});	
	},
	/* Оправляет на сервер список дел для составления плана на сегодня (сейчас на стр planning.php) */
	new_plan : function(e){

		e.preventDefault();

		var data = $( this ).serialize();

		if(data === "") alert("Вы не выбрали ни одной задачи!");

		else{
			$.post("create_today_plan.php", data, function(data){
				alert(data);
				document.location = "/";
			});
		}
	},

	/* Отправляет на сервер запрос по добавлению одного помидора к выбранной задаче */
	move_progress: function(e){
		e.preventDefault();

		var elem = $(this);
		var id = elem.closest("td").next("td").find(".completeBtn").val();
		var data = "progress=" + id;
		
		$.post("db_updates.php", data, function(data){
			if(data) {
				alert(data);
				return;
			}
			elem.before("<img src='/img/tomato.png' alt='помидорка'> ");
		});
	},

	/* Отправляет на сервер запрос на завершение задания */
	complete_task: function(e){
		e.preventDefault();

		if(!confirm("Подтвердите выполнение задания")){
			return;
		}
		var elem = $(this);
		var data = "complete=" + elem.val();

		$.post("db_updates.php", data, function(data){
			if(data){
				alert(data);
				return;
			}
		elem.addClass("disabled").text("Done").closest("tr").addClass("success")
		.find(".addPomodoro").remove().prev();
		});
	},

	/* Отправляет на сервер запрос на добавление нового задания на сегодня и в общий список */
	new_today_task: function(e){
		
		e.preventDefault();
		var data = $(this).serialize();

		$.post("new_record.php", data, function(data){

			data = $.parseJSON(data);

			var message = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>";
			message += "&times;</button>";
			message += "<strong>Success! </strong>";
			message += data.status;

			var tmp = "";
			tmp += "<tr>";
			tmp += "<td class='typeCell'>" + $("#typeInput").find("option[value='"+$("#typeInput").val()+"']").text() + "</td>";
			tmp += "<td class='taskCell'>" + $("#activityInput").val() + "</td>";
			tmp += "<td class='estimateCell'><img src='/img/tomato.png' alt='помидорка'> x " 
			+ $("#estimateInput").val() + "</td>";
			tmp += "<td class='realCell'><a class='addPomodoro' href>+</a></td>";
			tmp += "<td class='completeCell text-center'>"
			+ "<button class='completeBtn btn btn-xs btn-success' value='" +data.id+ "'>Complete</button></td>";
			tmp += "</tr>";

			$.post("db_updates.php", "extraTask="+data.id, function(data){

				$("#newTodayTask").before(tmp);

				$("body").prepend("<div class='alert alert-success alert-dismissable'></div>")
				.find(".alert-dismissable").hide().append(message).slideDown(400).delay(4000).slideUp(400, function(){
					$(this).remove();
				});
			});
		});
	},

	toggle_visibility_archived: function(e){
		if( $(this).prop("checked") ) {
			window.location = "planning.php?archive=true";
		} else{
			window.location = "planning.php";
		}
	},

	toggle_archive_property: function(e){
		e.preventDefault();

		var confirmed = confirm("Подтвердите отправку задачи в архив / восстановление из архива");
		if(!confirmed) return;
		
		var el = $(this);
		var task_id = el.closest("tr").data("taskid");

		if( $(this).hasClass("freezed") ){
			$.post("db_updates.php", {"unfreeze_task":task_id}, function(data){
				if(data){
					alert(data);
					return;
				} else{
					el.removeClass("freezed");
					el.text("freeze");
					el.closest("tr").find("td").first().find("span").remove();
				}
			});
		}
		else{
			$.post("db_updates.php", {"freeze_task":task_id}, function(data){
				if(data){
					alert(data);
					return;
				} else{
					el.addClass("freezed");
					el.text("restore");
					el.closest("tr").find("td").first().append("<span class='label label-info'>FREEZED</span>");
				}
			});
		}
	}
};


$(document).on("submit", "#newNode", onEvent.new_task); //#newNode - добавляет задачу со страницы planning.php
$(document).on("submit", "#selectionForm", onEvent.new_plan);  //#selectionForm находится на стр planning.php
$(document).on("click", ".addPomodoro", onEvent.move_progress);  //элемент на главной (time.dev), План на сегодня
$(document).on("click", ".completeBtn", onEvent.complete_task); //элемент на главной (time.dev), План на сегодня
$(document).on("submit", "#newTodayTask", onEvent.new_today_task); //элемент на главной (time.dev), План на сегодня
$(document).on("change", "#archive_tasks", onEvent.toggle_visibility_archived); //показть скрыть архивные задачи
$(document).on("click", ".freeze_toggle", onEvent.toggle_archive_property); //отправить в архив, вынуть из архива


$(document).ready(function(){

	$(".datepicker").datepicker($.datepicker.regional["ru"]);  // Датапикер сейчас используется только в today.php - не нужен

});