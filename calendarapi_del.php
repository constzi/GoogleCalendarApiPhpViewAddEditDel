<?php

include("calendarapi_settings.php");

if( isset($_REQUEST['id']) ){

	// *** Deleting an event
	// Get the event
	$event = $service->getCalendarEventEntry($_REQUEST['id']);
	// Delete the event
	$event->delete();

	Header("Location: calendarapi.php");
}

?>

