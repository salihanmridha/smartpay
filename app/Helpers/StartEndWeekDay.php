<?php

function startEndWeekDay(string $date): array
{
  $arr = [];
  $dayofweek = date('w', strtotime($date));

  $firstDayOfWeek    = date('Y-m-d', strtotime((1 - $dayofweek).' day', strtotime($date)));
  $lastDayOfWeek    = date('Y-m-d', strtotime((7 - $dayofweek).' day', strtotime($date)));

  $arr["week_first_day"] = $firstDayOfWeek;
  $arr["week_last_day"] = $lastDayOfWeek;

  return $arr;
}
