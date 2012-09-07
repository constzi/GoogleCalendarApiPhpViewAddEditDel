<?php
include("calendarapi_settings.php");

echo "<a href=calendarapi_add.php>add event</a>";

// *** Retrieve all events
$query = $service->newEventQuery();
// Set different query parameters
$query->setUser('default');
$query->setVisibility('private');
$query->setProjection('full');
$query->setOrderby('starttime');
$query->setSortOrder('a'); //ascending

$now = new DateTime;
$m = $now->format('m');
$d = $now->format('d');
$y = $now->format('Y');

if( isset($_POST['year']) ){
	// Start date from where to get the events
		$query->setStartMin($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day']);
}

// Get the event list
try {
    $eventFeed = $service->getCalendarEventFeed($query); //for all: $service->getCalendarListFeed();
} catch (Zend_Gdata_App_Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "<ul>";
foreach ($eventFeed as $event) {
	$when = $event->when[0];
	$format  = 'm/d H:i'; // $when->startTime is a string like "2011-05-10T20:00:00.000+01:00"
	$start = date_create($when->startTime)->format($format);
	$end = date_create($when->endTime)->format($format);

    echo "<li>" . $start . " - " . $end . " - " .
		"what: " . $event->title . " - " . "where: " . $event->where[0] . " - " . "description: " . $event->content .
    	" <a href=calendarapi_edit.php?id=" . $event->id .">edit</a>" .
    	" <a href=calendarapi_del.php?id=" . $event->id .">del</a></li><br>";
}
echo "</ul>";

?>

<form action="calendarapi.php" method="post">
	Events starting
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
	<input type="submit" />
</form>