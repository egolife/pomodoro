<?php

namespace Models;

#Очень интересная мысль -
#Концепт разделения на команды и запросы 
# Command | Query separation
# Команда что-то делает ничего не возвращая
# Запрос ничего не далает и что-то возвращает
# Запросы - для получения информации
# Команды - для осуществления действий

interface TasksListGateway {
  public function persist(TasksList $tasksList);
  public function retrieve($id);
  public function getLastPersistId();
}