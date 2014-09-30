/**
* ---------------------------------------------------------------------------------------------------------------------------------------
* Все то, что уже ничего не делает, но все еще болтается в программе
* ---------------------------------------------------------------------------------------------------------------------------------------
*/



var cf = {

};
var tmp_process = function(e){

		e.preventDefault();

		var data = $( this ).serialize();

		alert("Engadged!");
		return;

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
	}