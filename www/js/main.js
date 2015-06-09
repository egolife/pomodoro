/**
* ---------------------------------------------------------------------------------------------------------------------------------------
* Main js functionality
* ---------------------------------------------------------------------------------------------------------------------------------------
*/
var task;
var onEvent = {

	/*  отправляет на сервер запрос на добавление задания в общий список */
	new_task : function(e){
		
		var that = $(this); //Cashed form
		e.preventDefault();
		var data = that.serialize();

		$.post("new_record.php", data, function(data){
			var data = $.parseJSON(data);
			flashMessage(data.status);
			empty_form(that);
			var newTask = generate_new_row(data.inserted_row[0]);
			$("#newNode").next("tr").after(newTask);
		});	
	},
	/* Оправляет на сервер список дел для составления плана на сегодня (сейчас на стр planning.php) */
	new_plan : function(e){

		e.preventDefault();
		var data = $( this ).serialize();
		if(data === "") {
			alert("Вы не выбрали ни одной задачи!");
		} else{
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
			tmp += "<tr data-taskid='" + data.id + "'>";
			tmp += "<td class='typeCell'>" + $("#typeInput").find("option[value='"+$("#typeInput").val()+"']").text() + "</td>";
			tmp += "<td class='taskCell'>" + $("#activityInput").val() + "</td>";
			tmp += "<td class='estimateCell'><img src='/img/tomato.png' alt='помидорка'> x " 
			+ $("#estimateInput").val() + "</td>";
			tmp += "<td class='realCell'><a class='addPomodoro' href>+</a></td>";
			tmp += "<td class='completeCell text-center'>"
			+ "<button class='completeBtn btn btn-xs btn-success' value='" +data.id+ "'>Complete</button></td>";
			tmp += "</tr>";

			$.post("db_updates.php", "extraTask="+data.id, function(data){

				if( $.trim(data) ){
					alert('Произошла непредвиденная ошибка, попробуй еще раз!');
					return;
				}

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
	},
	set_complete_date: function(e){
		e.preventDefault();
		var tmp = $(this).closest(".modal-content").find(".datepicker").datepicker("getDate");
		$.post("db_updates.php", {"complete" : task, "date" : +tmp / 1000}, function(data){
			if(!data){
				var row = $("table").find("tr[data-taskid=" + task + "]");
				var taskText = row.find(".task_text").text();
				row.remove();
				flashMessage("Задание № " + task + ": \"" + taskText + "\" отмечено как Выполненное!");
				$("#done_modal").modal("hide");
			}
		});
	},
	update_text: function(e){
		
		e.preventDefault();
		var that = $(this);

		task = that.closest("tr").data("taskid");
		var innerText = that.siblings(".inner_text").text();
		var td = that.closest("td");
		var width = td.width() - that.width() - 10;
		td.empty();

		$("<input/>").css("width", width).val(innerText).appendTo(td);
		$("<a href='#' class='textSend'> <span class='glyphicon glyphicon-ok'></span></a>").appendTo(td);

	},
	update_text_on_server: function(e){
		e.preventDefault();

		var text = $(this).closest("td").find("input").val();
		var td = $(this).closest("td");
		var str = '';
		$.post("db_updates.php", {"update_task":task, "text":text}, function(data){
			if(data) console.log(data);
			else{
				str += '<span class="inner_text">' + text + '</span> ';
				str += '<a href="#" class="textUpdate"><span class="glyphicon glyphicon-pencil"></span></a>';
				str += '<a href="#" class="taskDelete"> <span class="glyphicon glyphicon-remove"></span></a>';
				td.html(str);
				flashMessage("Текст задачи " + task + " успешно изменен");
			}

		});
	},
	delete_task: function(e){
		e.preventDefault();
		tr = $(this).closest("tr");
		task = tr.data("taskid");
		var confirmed = confirm("Точно удаляем запись №" + task + "?");
		if(!confirmed) return;

		$.post("db_updates.php", {"delete_task":task}, function(data){
			if(data) console.log(data);
			else{
				tr.remove();
				flashMessage("Задача №" + task + " успешно удалена!");
			}
		});
	},

	update_today_task: function(e){
		e.preventDefault();
		onEvent.restore_today_task_text();

		var $td = $(this).closest('td');
		var curr_text = $.trim($td.text());
		$td.data("saved_text", curr_text);
		var width = $td.width() - $(this).width() - 10;
		$td.empty();

		task = $td.closest("tr").data('taskid');

		$("<textarea/>").css("width", width).val(curr_text).appendTo($td);
		$("<a href='#' class='today_task_new_text'> <span class='glyphicon glyphicon-ok'></span></a>").appendTo($td);
	},

	save_today_task_new_text: function(e){
		e.preventDefault();

		var text = $(this).closest("td").find("textarea").val();
		task = $(this).closest('tr').data('taskid');

		$.post("db_updates.php", {"update_task":task, "text":text}, function(data){
			if(data) console.log(data);
			else{
				onEvent.restore_today_task_text(text);
				flashMessage("Текст задачи " + task + " успешно изменен");
			}

		});
	}, 
	restore_today_task_text: function(provided_text){

		var text;

		$(".taskCell").find("textarea").each(function(i, el){
			text = provided_text || $(this).closest('td').data('saved_text');
			$(this).closest('td').empty().html(text + " <a href='#' class='update-today-task'><i class='glyphicon glyphicon-pencil'></i></a>");
		});
	}

};


$(document).on("submit", "#newNode", onEvent.new_task); //#newNode - добавляет задачу со страницы planning.php
$(document).on("submit", "#selectionForm", onEvent.new_plan);  //#selectionForm находится на стр planning.php
$(document).on("click", ".addPomodoro", onEvent.move_progress);  //элемент на главной (time.dev), План на сегодня
$(document).on("click", ".completeBtn", onEvent.complete_task); //элемент на главной (time.dev), План на сегодня
$(document).on("submit", "#newTodayTask", onEvent.new_today_task); //элемент на главной (time.dev), План на сегодня
$(document).on("change", "#archive_tasks", onEvent.toggle_visibility_archived); //показть скрыть архивные задачи
$(document).on("click", ".freeze_toggle", onEvent.toggle_archive_property); //отправить в архив, вынуть из архива
$(document).on("click", ".done_earlier", onEvent.set_complete_date); //отметить как выполненное ранее
$(document).on("click", ".textUpdate", onEvent.update_text); //Преобразовать текст в Input val=text
$(document).on("click", ".taskDelete", onEvent.delete_task); //Удаляем задачу
$(document).on("click", ".textSend", onEvent.update_text_on_server); //Отправить изменения на сервер
$(document).on("show.bs.modal", "#done_modal", function(e){
	task = $(e.relatedTarget).closest("tr").data("taskid");
}); //отметить как выполненное ранее
$(document).on("click", ".update-today-task", onEvent.update_today_task); //Преобразовать текст в Input val=text
$(document).on("click", ".today_task_new_text", onEvent.save_today_task_new_text); //Преобразовать текст в Input val=text


$(document).ready(function(){
	var yesterday = new Date(new Date() - 1000 * 24 * 3600);
	$(".datepicker").datepicker($.datepicker.regional["ru"]);  // Датапикер сейчас используется только в today.php - не нужен
	var rowCount = $("table").find("tr").length - 3;
	$("<span/>").text(rowCount).addClass("label label-info pull-right").appendTo("h1");
	$("#done_date").val(formatDate(yesterday));
});

