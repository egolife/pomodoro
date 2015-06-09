<?php 
$tasks = [
  '1' => new \Models\Task([
    'title' => 'Поиграть в Disciples',
    'tomatoes' => 5
  ]),

  '2' => new \Models\Task([
    'title' => 'Установить NetBeans',
    'tomatoes' => 2
  ]),

];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>test</title>
</head>
<body>
  <?php foreach($tasks as $key => $task): ?>
    <div class="task" id="<?= 'task' . $key ?>" style="border: 1px solid red">
      <h2><?= $task->title ?></h2>
      <p><?= $task->tomatoes ?></p>
    </div>
  <?php endforeach; ?>
</body>
</html>