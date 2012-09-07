<?php

include("calendarapi_settings.php");

echo "<a href=calendarapi.php>back to calendar</a><p>";

if( isset($_REQUEST['id']) ){

	// *** Retrieving individual events
	$eventURL = $_REQUEST['id'];
	try {
		$event = $service->getCalendarEventEntry($eventURL);
		$title = $event->title;
		$where = $event->where[0];
		$content = $event->content;

		$when = $event->when[0];
		$format  = 'd/m/Y H:i'; // $when->startTime is a string like "2011-05-10T20:00:00.000+01:00"
		$y = date_create($when->startTime)->format('Y');
		$m = date_create($when->startTime)->format('m');
		$d = date_create($when->startTime)->format('d');
		$h = date_create($when->startTime)->format('H');
		$i = date_create($when->startTime)->format('i');

		$y2 = date_create($when->endTime)->format('Y');
		$m2 = date_create($when->endTime)->format('m');
		$d2 = date_create($when->endTime)->format('d');
		$h2 = date_create($when->endTime)->format('H');
		$i2 = date_create($when->endTime)->format('i');

		//$event->when[0]
	} catch (Zend_Gdata_App_Exception $e) {
		echo "Error: " . $e->getMessage();
	}
}

?>

<form action="calendarapi_update.php" method="post">
	<input type="hidden" name="id" value="<?php echo $eventURL ?>" />
	Title: <input type="text" name="title" value="<?php echo $title ?>" />
	<br>Where: <input type="text" name="where" value="<?php echo $where ?>" />
	<br>Description: <input type="text" name="content" value="<?php echo $content ?>" />

	<br>Start Date:
	<select name="month">
	<?php
		for($month=1; $month <= 12; ++$month):
			if($month < 10) $month = "0".$month;
			$mSelected = ""; if ($month == $m) $mSelected = "selected";
			echo "<option value=". $month . " ". $mSelected  .">" . $month . "</option>";
		endfor;?>
	</select>
	<select name="day">
	<?php
		for($day=1; $day <= 31; ++$day):
			if($day < 10) $day = "0".$day;
			$dSelected = ""; if ($day == $d) $dSelected = "selected";
			echo "<option value=". $day . " ". $dSelected  .">" . $day . "</option>";
		endfor; ?>
	</select>
	<select name="year">
	<?php
		for($year=2012; $year <= 2020; ++$year):
			$ySelected = ""; if ($year == $y) $ySelected = "selected";
			echo "<option value=". $year . " ". $ySelected  .">" . $year . "</option>";
		endfor; ?>
	</select>
	Time:
	<select name="hour">
	<?php
		for($hour=0; $hour <= 23; ++$hour):
			if($hour < 10) $hour = "0".$hour;
			$hSelected = ""; if ($hour == $h) $hSelected = "selected";
			echo "<option value=". $hour . " ". $hSelected  .">" . $hour . "</option>";
		endfor;?>
	</select>
	:
	<select name="minute">
	<?php
		for($minute=0; $minute <= 59; $minute += 5):
			if($minute < 10) $minute = "0".$minute;
			$iSelected = ""; if ($minute == $i) $iSelected = "selected";
			echo "<option value=". $minute . " ". $iSelected  .">" . $minute . "</option>";
		endfor;?>
	</select>

	<br>End Date:
	<select name="month2">
	<?php
		for($month2=1; $month2 <= 12; ++$month2):
			if($month2 < 10) $month2 = "0".$month2;
			$mSelected2 = ""; if ($month2 == $m2) $mSelected2 = "selected";
			echo "<option value=". $month2 . " ". $mSelected2  .">" . $month2 . "</option>";
		endfor;?>
	</select>
	<select name="day2">
	<?php
		for($day2=1; $day2 <= 31; ++$day2):
			if($day2 < 10) $day2 = "0".$day2;
			$dSelected2 = ""; if ($day2 == $d2) $dSelected = "selected";
			echo "<option value=". $day2 . " ". $dSelected2  .">" . $day2 . "</option>";
		endfor; ?>
	</select>
	<select name="year2">
	<?php
		for($year2=2012; $year2 <= 2020; ++$year2):
			$ySelected2 = ""; if ($year2 == $y2) $ySelected2 = "selected";
			echo "<option value=". $year2 . " ". $ySelected2  .">" . $year2 . "</option>";
		endfor; ?>
	</select>
	Time:
	<select name="hour2">
	<?php
		for($hour2=0; $hour2 <= 23; ++$hour2):
			if($hour2 < 10) $hour2 = "0".$hour2;
			$hSelected2 = ""; if ($hour2 == $h2) $hSelected2 = "selected";
			echo "<option value=". $hour2 . " ". $hSelected2  .">" . $hour2 . "</option>";
		endfor;?>
	</select>
	:
	<select name="minute2">
	<?php
		for($minute2=0; $minute2 <= 59; $minute2 += 5):
			if($minute2 < 10) $minute2 = "0".$minute2;
			$iSelected2 = ""; if ($minute2 == $i2) $iSelected2 = "selected";
			echo "<option value=". $minute2 . " ". $iSelected2  .">" . $minute2 . "</option>";
		endfor;?>
	</select>
<input type="submit" />
</form>