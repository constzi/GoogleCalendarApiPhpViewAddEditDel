<?php

include("calendarapi_settings.php");

if( isset($_POST['id']) ){

	//date difference check
	$date1 = strtotime($_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"]. " " . $_POST["hour"] . ":" . $_POST["minute"]);
	$date2 = strtotime($_POST["year2"] . "-" . $_POST["month2"] . "-" . $_POST["day2"]. " " . $_POST["hour2"] . ":" . $_POST["minute2"]);

	if ($date1 <= $date2) {

		// *** Updating an event
		// URI of the event which we got after creating it.
		$eventUri = $_POST['id'];
		// Get the event
		$event = $service->getCalendarEventEntry($eventUri);
		// Change the title
		$event->title = $service->newTitle($_POST["title"]);
		$event->where = array($service->newWhere($_POST["where"]));
		$event->content = $service->newContent($_POST["content"]);
		$when = $service->newWhen();
		$when->startTime = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"] . "T" . $_POST["hour"] . ":" . $_POST["minute"] . ":00.000";
		$when->endTime = $_POST["year2"] . "-" . $_POST["month2"] . "-" . $_POST["day2"] . "T" . $_POST["hour2"] . ":" . $_POST["minute2"] . ":00.000";
		$event->when = array($when);

		// Save the event
		$event->save();

		Header("Location: calendarapi.php");
	}else{
		echo "<font color=red>Date from must be lesser than date to!</font> - go back and fix";
	}
}

?>