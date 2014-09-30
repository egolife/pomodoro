<?php require '/inc/header.php'; ?>


<section class="container l-main">

	<h1>Составление плана на сегодня <?php echo date('d-m-Y'); ?></h1>

	<p class="small">
		<label><input type="checkbox" id="archive_tasks" <?= $archive ? "checked" : null ?> > Показать невыполненные задачи из архива</label>
	</p>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="records">
			<thead>
				<tr>
					<th>Type</th>
					<th>Activity</th>
					<th>Estimated time</th>
					<th class="text-center">Add to plan</th>
					<th class="text-center">freeze</th>
				</tr>
			</thead>
			<tbody>

				<form action="" role="form" id="newNode" method="post">
					<tr>
						<td class="l-type-col">

							<select type="text" class="form-control" id="typeInput" name="type" placeholder="Enter type">
								<option value="1">epixx</option>
								<option value="2">webdev</option>
								<option value="3">work</option>
								<option value="4">family</option>
								<option value="5">operational</option>
								<option value="6">utility (for myself)</option>
							</select>
						</td>

						<td class="l-activity-col"><input required autofocus type="text" name="activity" class="form-control" id="activityInput" placeholder="Enter activity"></td>
						<td class="l-estimate-col"><input required type="number" name="estimate" class="form-control" id="estimateInput" placeholder="Enter estimate time"></td>
						<td class="text-center"><button type="submit" class="btn btn-success">Добавить</button></td>
						<td class="text-center">&nbsp;</td>
					</tr>
				</form>

				<form action="create_today_plan.php" role="form" id="selectionForm" method="post">
					<?php foreach($tasks as $task) : ?>
						<tr <?= "data-taskid='".$task['id']."'" ?>>
							<td>
								<?php echo $task['name'] . "&nbsp;" ?>
								<?= $task['is_freezed'] ? "<span class='label label-info'>FREEZED</span>" : null ?>

							</td>
							<td><?php echo $task['task']; ?></td>
							<td><?php echo $task['pomodoros']; ?></td>
							<td class="text-center">
								<input type="checkbox" value="<?php echo  "{$task['id']}";?>" id="<?php echo  "task{$task['id']}";?>" name="<?php echo  "task{$task['id']}";?>">
							</td>
							<td>
								<a class="freeze_toggle <?= $task['is_freezed'] ? 'freezed' : null ?>" href="#">
									<?= $task['is_freezed'] ? "restore" : "freeze" ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</form>

				<tr>
					<td colspan="5" class="text-center">
						<button type="submit" form="selectionForm" class="btn btn-primary btn-lg">
							Составить план
						</button>
					</td>
				</tr>

			</tbody>
		</table>
	</div>
</section>

<?php require '/inc/footer.php'; ?>
