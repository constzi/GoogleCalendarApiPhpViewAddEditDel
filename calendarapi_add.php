<?php

include("calendarapi_settings.php");

echo "<a href=calendarapi.php>back to calendar</a><p>";

$now = new DateTime;
$m = $now->format('m');
$d = $now->format('d');
$y = $now->format('Y');
$h = $now->format('H');
$i = $now->format('i');

if( isset($_POST['title']) ){

	//date difference check
	$date1 = strtotime($_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"]. " " . $_POST["hour"] . ":" . $_POST["minute"]);
	$date2 = strtotime($_POST["year2"] . "-" . $_POST["month2"] . "-" . $_POST["day2"]. " " . $_POST["hour2"] . ":" . $_POST["minute2"]);

	if ($date1 <= $date2) {
		// *** Creating Single Occurrence Events
		// Create a new event object using calendar services factory method.
		// We will then set different attributes of event in this object.
		$event= $service->newEventEntry();

		// Create a new title instance and set it in the event
		$event->title = $service->newTitle($_POST["title"]);
		// Where attribute can have multiple values and hence passing an array of where objects
		$event->where = array($service->newWhere($_POST["where"]));
		$event->content = $service->newContent($_POST["content"]);

		// Create an object of When and set start and end datetime for the event
		$when = $service->newWhen();
		// Set start and end times in RFC3339 (http://www.ietf.org/rfc/rfc3339.txt)
		//$when->startTime = "2012-08-31T16:30:00.000"; // aug 31 2012, 4:30 pm (+5:30 GMT)
		//$when->endTime = "2012-08-31T17:30:00.000"; // aug 31 2012, 5:30 pm (+5:30 GMT)
		$when->startTime = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"] . "T" . $_POST["hour"] . ":" . $_POST["minute"] . ":00.000";
		$when->endTime = $_POST["year2"] . "-" . $_POST["month2"] . "-" . $_POST["day2"] . "T" . $_POST["hour2"] . ":" . $_POST["minute2"] . ":00.000";
		// Set the when attribute for the event
		$event->when = array($when);

		// Create the event on google server
		$newEvent = $service->insertEvent($event);
		// URI of the new event which can be saved locally for later use
		$eventUri = $newEvent->id->text;

		Header("Location: calendarapi.php");
	} else
	{
		echo "<font color=red>Date from must be lesser than date to!</font>";
	}
}

?>

<form action="calendarapi_add.php" method="post">
	Title: <input type="text" name="title" />
	<br>Where: <input type="text" name="where" />
	<br>Description: <input type="text" name="content" />

	<br>Start Date:
	<select name="month">
	<?php
		for($month=1; $month <= 12; ++$month):
			if($month < 10) $month = "0".$month;
			$mSelected = ""; if ($month == $m) $mSelected = "selected";
			echo "<option value=". $month . " ". $mSelected . ">" . $month . "</option>";
		endfor;?>
	</select>
	<select name="day">
	<?php
		for($day=1; $day <= 31; ++$day):
			if($day < 10) $day = "0".$day;
			$dSelected = ""; if ($day == $d) $dSelected = "selected";
			echo "<option value=". $day . " ". $dSelected . ">" . $day . "</option>";
		endfor; ?>
	</select>
	<select name="year">
	<?php
		for($year=2012; $year <= 2020; ++$year):
			$ySelected = ""; if ($year == $y) $ySelected = "selected";
			echo "<option value=". $year . " ". $ySelected . ">" . $year . "</option>";
		endfor; ?>
	</select>
	Time:
	<select name="hour">
	<?php
		for($hour=0; $hour <= 23; ++$hour):
			if($hour < 10) $hour = "0".$hour;
			$hSelected = ""; if ($hour == $h) $hSelected = "selected";
			echo "<option value=". $hour . " ". $hSelected . ">" . $hour . "</option>";
		endfor;?>
	</select>
	:
	<select name="minute">
	<?php
		for($minute=0; $minute <= 59; $minute += 5):
			if($minute < 10) $minute = "0".$minute;
			echo "<option value=". $minute . ">" . $minute . "</option>";
		endfor;?>
	</select>

	<br>End Date:
	<select name="month2">
	<?php
		for($month2=1; $month2 <= 12; ++$month2):
			if($month2 < 10) $month2 = "0".$month2;
			$mSelected2 = ""; if ($month2 == $m) $mSelected2 = "selected";
			echo "<option value=". $month2 . " ". $mSelected2 . ">" . $month2 . "</option>";
		endfor;?>
	</select>
	<select name="day2">
	<?php
		for($day2=1; $day2 <= 31; ++$day2):
			if($day2 < 10) $day2 = "0".$day2;
			$dSelected2 = ""; if ($day2 == $d) $dSelected2 = "selected";
			echo "<option value=". $day2 . " ". $dSelected2 . ">" . $day2 . "</option>";
		endfor; ?>
	</select>
	<select name="year2">
	<?php
		for($year2=2012; $year2 <= 2020; ++$year2):
			$ySelected2 = ""; if ($year2 == $y) $ySelected2 = "selected";
			echo "<option value=". $year2 . " ". $ySelected2 . ">" . $year2 . "</option>";
		endfor; ?>
	</select>
	Time:
	<select name="hour2">
	<?php
		for($hour2=0; $hour2 <= 23; ++$hour2):
			$hSelected2 = ""; if ($hour2 == $h) $hSelected2 = "selected";
			echo "<option value=". $hour2 . " ". $hSelected2 . ">" . $hour2 . "</option>";
		endfor;?>
	</select>
	:
	<select name="minute2">
	<?php
		for($minute2=0; $minute2 <= 59; $minute2 += 5):
			if($minute2 < 10) $minute2 = "0".$minute2;
			echo "<option value=". $minute2 . ">" . $minute2 . "</option>";
		endfor;?>
	</select>
	<br><input type="submit" />
</form>