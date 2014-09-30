<?php require '/inc/header.php'; ?>


<section class="container l-main">

<h1>Records</h1>

	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="records">
			<thead>
				<tr>
					<th>Numerator</th>
					<th>Date</th>
					<th>Type</th>
					<th>Activity</th>
					<th>Estimate</th>
					<th>Real</th>
					<th>Differ</th>
				</tr>
			</thead>
			<tbody>
				<form action="/" role="form" id="newNode" method="post">
					<tr>
						<td class="text-center">0</td>
						<td class="l-date-col"><input type="text" class="form-control datepicker" id="dateInput" placeholder="Enter date"></td>
						<td class="l-type-col">
							<select type="text" class="form-control" id="typeInput" placeholder="Enter type">
								<option value="epixx">epixx</option>
								<option value="imperial">imperial</option>
								<option value="home">home</option>
								<option value="webdev">webdev</option>
								<option value="family">family</option>
								<option value="utility">utility</option>

							</select>
						</td>
						<td class="l-activity-col"><input autofocus type="text" class="form-control" id="activityInput" placeholder="Enter activity"></td>
						<td class="l-estimate-col"><input type="number" class="form-control" id="estimateInput" placeholder="Enter estimate time"></td>
						<td cass="l-real-col"><input type="number" class="form-control" id="realInput" placeholder="Enter real time"></td>
						<td><button type="submit" class="btn btn-primary">Добавить</button></td>
					</tr>
				</form>


				<?php 
				$i = 0;
				foreach($tasks as $task) : 
				$i++;
				?>
					<tr>
						<td class="text-center"><?php echo $i; ?></td>
						<td><?php echo $task['set_date']; ?></td>
						<td><?php echo $task['name']; ?></td>
						<td><?php echo $task['task']; ?></td>
						<td><?php echo $task['pomodoros']." pomodoros";?></td>
						<td></td>
						<td></td>
					</tr>

				<?php endforeach; ?>


<!-- 				<tr>
					<td>21.05.2014</td>
					<td>epixx</td>
					<td>Добавил на newbie.epixx custom select</td>
					<td>3</td>
					<td>5</td>
					<td>-2</td>
				</tr>
				<tr>
					<td>22.05.2014</td>
					<td>imperial</td>
					<td>Подготовка workspace для разработки посадки Испании</td>
					<td>2</td>
					<td>3</td>
					<td>-1</td>
				</tr>
				<tr>
					<td>22.05.2014</td>
					<td>imperial</td>
					<td>Нарезка картинок из psd Испании</td>
					<td>1</td>
					<td>2</td>
					<td>-1</td>
				</tr> -->
			</tbody>
		</table>
	</div>

</section>



<?php require '/inc/footer.php'; ?>








