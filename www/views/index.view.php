<?php require '/inc/header.php'; ?>


<section class="container l-main">

<h1>План на сегодня <?php echo date('d-m-Y'); ?></h1>

	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="records">
			<thead>
				<tr>
					<th>Type</th>
					<th>Activity</th>
					<th>Estimated time</th>
					<th class="text-center" style="width: 20%">Spent pomodoros</th>
					<th class="text-center">Complete</th>
				</tr>
			</thead>
			<tbody>
				
				<!-- <form action="create_today_plan.php" role="form" id="selectionForm" method="post"> -->
					<?php foreach($today_tasks as $task) : ?>
						<tr class="<?php if ($task['complete_date']) echo 'success';?>" >
							<td class="typeCell"><?php echo $task['name']; ?></td>
							<td class="taskCell" id="task<?php echo $task['id']; ?>">
								<?php echo $task['task']; ?>
							</td>
							<td class="estimateCell">
								<img src='/img/tomato.png' alt='помидорка'> x <?php echo $task['pomodoros'];?>
							</td>
							<td class="realCell">
								<?php for($i =0; $i < $task['progress']; $i++) : ?>
								<img src='/img/tomato.png' alt='помидорка'>
								<?php endfor; ?>
								<?php if (!$task['complete_date']) :?>
								<a class="addPomodoro" href="">+</a>
								<?php endif; ?>
							</td>
							<td class="completeCell text-center">
								<button class="completeBtn btn btn-xs btn-success
								<?php if ($task['complete_date']) echo 'disabled';?>" 
								value="<?php echo $task['id']; ?>">
									<?php if (!$task['complete_date']) echo 'Complete'; else echo 'Done';?>
								</button>
							</td>
						</tr>
					
					<?php endforeach; ?>

				<!-- </form> -->

				<form action="/" role="form" id="newTodayTask" method="post">
						<tr>
							<td class="l-type-col">

								<select type="text" class="form-control" id="typeInput" name="type" placeholder="Enter type">
									<option value="1">epixx</option>
									<option value="3">work</option>
									<option value="5">operational</option>
									<option value="2">webdev</option>
									<option value="4">family</option>
									<option value="6">utility (for myself)</option>
								</select>
							</td>

							<td class="l-activity-col"><input required autofocus type="text" name="activity" class="form-control" id="activityInput" placeholder="Введите описание срочной задачи"></td>
							<td class="l-estimate-col"><input required type="number" name="estimate" class="form-control" id="estimateInput" placeholder="Помидоры"></td>
							<td colspan=2 class="text-center">
								<button type="submit" class="btn btn-info">Добавить задачу</button>
							</td>
						</tr>
					</form>

			</tbody>
		</table>
	</div>

</section>

<?php require '/inc/footer.php'; ?>








