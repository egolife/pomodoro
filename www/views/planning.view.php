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
					<th class="text-center">complete</th>
				</tr>
			</thead>
			<tbody>

				<form action="" role="form" id="newNode" method="post">
					<tr>
						<td class="l-type-col">

							<select form="newNode" type="text" class="form-control" id="typeInput" name="type" placeholder="Enter type">
								<option value="0">Тип задачи</option>
								<option value="1">epixx</option>
								<option value="2">webdev</option>
								<option value="3">work</option>
								<option value="4">family</option>
								<option value="5">operational</option>
								<option value="6">utility (for myself)</option>
							</select>
						</td>

						<td class="l-activity-col"><input form="newNode" required autofocus type="text" name="activity" class="form-control" id="activityInput" placeholder="Enter activity"></td>
						<td class="l-estimate-col"><input form="newNode" required type="number" name="estimate" class="form-control" id="estimateInput" placeholder="Enter estimate time"></td>
						<td class="text-center"><button form="newNode" type="submit" class="btn btn-success">Добавить</button></td>
						<td class="text-center">&nbsp;</td>
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
							<td class="task_text">
								<span class="inner_text"><?php echo $task['task']; ?></span>
								<a href="#" class="textUpdate"><span class="glyphicon glyphicon-pencil"></span></a>
								<a href="#" class="taskDelete"><span class="glyphicon glyphicon-remove"></span></a>
							</td>
							<td><?php echo $task['pomodoros']; ?></td>
							<td class="text-center">
								<input type="checkbox" value="<?php echo  "{$task['id']}";?>" id="<?php echo  "task{$task['id']}";?>" name="<?php echo  "task{$task['id']}";?>">
							</td>
							<td>
								<a class="freeze_toggle <?= $task['is_freezed'] ? 'freezed' : null ?>" href="#">
									<?= $task['is_freezed'] ? "restore" : "freeze" ?>
								</a>
							</td>
							<td class="text-center"><a data-toggle="modal" data-target="#done_modal" href="#">done</a></td>
						</tr>
					<?php endforeach; ?>
				</form>

				<tr>
					<td colspan="6" class="text-center">
						<button type="submit" form="selectionForm" class="btn btn-primary btn-lg">
							Составить план
						</button>
					</td>
				</tr>

			</tbody>
		</table>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="done_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">When task was completed?</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="/" role="form">
      	  <div class="form-group">
      	    <label for="done_date" class="col-sm-3 control-label">Done date</label>
      	    <div class="col-sm-9">
      	      <input class="datepicker form-control" type="text" placeholder="31.10.2014" name="done_date" id="done_date">
      	    </div>
      	  </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary done_earlier">Complete task</button>
      </div>
    </div>
  </div>
</div>

<?php require '/inc/footer.php'; ?>
