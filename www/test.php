<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Testing form clearing</title>
	<style>
		input, textarea, select, label {
			display: block;
			margin-bottom: 10px;
			margin-left: auto;
			margin-right: auto;
		}
		label > input{
			display: inline;
		}
		form{
			width: 400px;
			margin: 0 auto;
			margin-top: 50px;
			text-align: center;
		}
	</style>
</head>
<body>
	<form action="/">
		<input type="text" placeholder="Текстовое поле">
		<input type="tel" placeholder="Phone field">
		<input type="number" placeholder="Digital field">
		<input type="range" min=100 max=200 placeholder="Range field">
		<textarea name="" id="" cols="30" rows="10" placeholder="Long Happy Life"></textarea>
		<select name="" id="">
			<option value="">Default</option>
			<option value="">Option 1</option>
			<option value="">Option 2 Default</option>
			<option value="">Option 3</option>
		</select>
		<label for=""><input type="checkbox"> Просто Checkbox</label>
		<label for=""><input type="radio"> Just a radio button</label>
		<input type="submit" value="GO">
	</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="js/functions.js"></script>
<script>
	$("form").submit(function(e){
		e.preventDefault();
		console.log("Live in");
		empty_form($(this));
	});
</script>
</body>
</html>