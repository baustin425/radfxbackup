<?php
echo '<html>';
    <head>
        <meta charset="utf-8" />
        <title>Calendar.js</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" user-scalable="no">
        <link rel="stylesheet" href="css/styles.css" />
        <link rel="stylesheet" href="src/calendarjs.css" />
        <script src="src/calendarjs.js"></script>
    </head>

    <body>
      
        <div class="contents">
            <div id="myCalendar" style="max-width: 800px;">
                <p>Some data that should be cleared.</p>
            </div>
            <br>
    
            <h2>Navigation:</h2>
            <button onclick="calendarInstance.moveToPreviousMonth();">Previous Month</button>
            <button onclick="calendarInstance.moveToNextMonth();">Next Month</button>
            <button onclick="calendarInstance.moveToPreviousYear();">Previous Year</button>
            <button onclick="calendarInstance.moveToNextYear();">Next Year</button>
            <button onclick="console.log( calendarInstance.getCurrentDisplayDate() );">Get Current Display Date</button>
            <button onclick="setCurrentDisplayDate();">Set Current Display Date</button>
            <br>
    
            <h2>Events:</h2>
            <button onclick="setEvents();">Set Events</button>
            <button onclick="removeEvent();">Remove Event</button>
            <button onclick="calendarInstance.clearEvents();">Clear Events</button>
            <button onclick="console.log( calendarInstance.getEvent( ''1234-5678-9'' ) );">Get Event</button>
            <br>

            <h2>Groups:</h2>
            <button onclick="console.log( calendarInstance.getAllGroups() );">Get All Groups</button>
            <button onclick="calendarInstance.clearAllGroups();">Clear All Groups</button>
            <button onclick="calendarInstance.removeGroup( ''Group 1'');">Remove Group</button>
            <br>

            <h2>Internal Clipboard:</h2>
            <button onclick="calendarInstance.setClipboardEvent( getCopiedEvent() );">Set Clipboard Event</button>
            <button onclick="console.log( calendarInstance.getClipboardEvent() );">Get Clipboard Event</button>
            <button onclick="calendarInstance.clearClipboard();">Clear Clipboard</button>
            <br>

            <h2>Additional Data:</h2>
            <button onclick="console.log( calendarInstance.getVersion() );">Get Version</button>
            <br>

            <h2>Options:</h2>
            <button onclick="setOptions();">Set Options</button>
            <button onclick="setSearchOptions();">Set Search Options</button>
            <button onclick="onlyDotsDisplay();">Set Options (only dots display)</button>
            <button onclick="turnOnEventNotifications();">Turn On Event Notifications</button>
            <button onclick="addNewHoliday();">Add New Holiday</button>
            <br />
    
            <h2>Main Controls:</h2>
            <button onclick="calendarInstance.turnOnFullScreen();">Turn On Full-Screen Mode</button>
            <button onclick="calendarInstance.turnOffFullScreen();">Turn Off Full-Screen Mode</button>
            <button onclick="console.log( calendarInstance.isFullScreenActivated() );">Is Full-Screen Activated</button>
            <button onclick="calendarInstance.startTheAutoRefreshTimer();">Start Auto-Refresh Timer</button>
            <button onclick="calendarInstance.stopTheAutoRefreshTimer();">Stop Auto-Refresh Timer</button>
            <button onclick="calendarInstance.destroy();">Destroy</button>
        </div>
    </body>

    <script>
        var calendarInstance = new calendarJs( "myCalendar", { 
            exportEventsEnabled: true, 
            manualEditingEnabled: true, 
            showTimesInMainCalendarEvents: false,
            minimumDayHeight: 0,
            manualEditingEnabled: true,
            organizerName: "Your Name",
            organizerEmailAddress: "your@email.address",
            visibleDays: [ 0, 1, 2, 3, 4, 5, 6 ]
        } );

        document.title += " v" + calendarInstance.getVersion();
        document.getElementById( "header" ).innerText += " v" + calendarInstance.getVersion();

        calendarInstance.addEvents( getEvents() );

        function turnOnEventNotifications() {
            calendarInstance.setOptions( {
                eventNotificationsEnabled: true
            } );
        }

        function setEvents() {
            calendarInstance.setEvents( getEvents() );
        }

        function removeEvent() {
            calendarInstance.removeEvent( new Date(), "Test Title 2" );
        }

        function daysInMonth( year, month ) {
            return new Date( year, month + 1, 0 ).getDate();
        }

        function setOptions() {
            calendarInstance.setOptions( {
                minimumDayHeight: 70,
                manualEditingEnabled: false,
                exportEventsEnabled: false,
                showDayNumberOrdinals: false,
                fullScreenModeEnabled: false,
                maximumEventsPerDayDisplay: 0,
                showTimelineArrowOnFullDayView: false,
                maximumEventTitleLength: 10,
                maximumEventDescriptionLength: 10,
                maximumEventLocationLength: 10,
                maximumEventGroupLength: 10,
                showDayNamesInMainDisplay: false,
                tooltipsEnabled: false,
                visibleDays: [ 0, 1, 2, 3, 4 ],
                allowEventScrollingOnMainDisplay: true,
                showExtraMainDisplayToolbarButtons: false,
                hideEventsWithoutGroupAssigned: true,
                showHolidays: false,
            } );
        }

        function setSearchOptions() {
            calendarInstance.setSearchOptions( {
                left: 10,
                top: 10
            } );
        }

        function onlyDotsDisplay() {
            calendarInstance.setOptions( {
                useOnlyDotEventsForMainDisplay: true
            } );
        }

        function setCurrentDisplayDate() {
            var newDate = new Date();
            newDate.setMonth( newDate.getMonth() + 3 );

            calendarInstance.setCurrentDisplayDate( newDate );
        }

        function getEvents() {
			
            var previousDay = new Date(),
                today9 = new Date(),
                today11 = new Date(),
                tomorrow = new Date(),
                firstDayInNextMonth = new Date(),
                lastDayInNextMonth = new Date(),
                today = new Date(),
                today3HoursAhead = new Date(),
                previousYear = new Date(),
                nextYear = new Date(),
                overlappingEvent1 = new Date(),
                overlappingEventTo1 = new Date(),
                overlappingEvent2 = new Date(),
                overlappingEventTo2 = new Date(),
                overlappingEvent3 = new Date(),
                overlappingEventTo3 = new Date(),
                overlappingEvent4 = new Date(),
                overlappingEventTo4 = new Date(),
                overlappingEvent5 = new Date(),
                overlappingEventTo5 = new Date();

            previousDay.setDate( previousDay.getDate() - 1 );
            today11.setHours( 11 );
            tomorrow.setDate( today11.getDate() + 1 );
            today9.setHours( 9 );

            firstDayInNextMonth.setDate( 1 );
            firstDayInNextMonth.setDate( firstDayInNextMonth.getDate() + daysInMonth( firstDayInNextMonth.getFullYear(), firstDayInNextMonth.getMonth() ) );

            lastDayInNextMonth.setDate( 1 );
            lastDayInNextMonth.setMonth( lastDayInNextMonth.getMonth() + 1 );
            lastDayInNextMonth.setDate( lastDayInNextMonth.getDate() + daysInMonth( lastDayInNextMonth.getFullYear(), lastDayInNextMonth.getMonth() ) - 1 );

            today.setHours( 21, 59, 0, 0 );
            today.setDate( today.getDate() + 3 );
            today3HoursAhead.setHours( 23, 59, 0, 0 );
            today3HoursAhead.setDate( today3HoursAhead.getDate() + 3 );

            previousYear.setFullYear( previousYear.getFullYear() - 1 );
            nextYear.setFullYear( nextYear.getFullYear() + 1 );

            overlappingEvent1.setDate( overlappingEvent1.getDate() - 3 );
            overlappingEventTo1.setDate( overlappingEventTo1.getDate() - 3 );
            overlappingEvent2.setDate( overlappingEvent2.getDate() - 3 );
            overlappingEventTo2.setDate( overlappingEventTo2.getDate() - 3 );
            overlappingEvent3.setDate( overlappingEvent3.getDate() - 3 );
            overlappingEventTo3.setDate( overlappingEventTo3.getDate() - 3 );
            overlappingEvent4.setDate( overlappingEvent4.getDate() - 3 );
            overlappingEventTo4.setDate( overlappingEventTo4.getDate() - 3 );
            overlappingEvent5.setDate( overlappingEvent5.getDate() - 3 );
            overlappingEventTo5.setDate( overlappingEventTo5.getDate() - 3 );
            overlappingEvent1.setHours( 0, 10, 0, 0 );
            overlappingEventTo1.setHours( 1, 10, 0, 0 );
            overlappingEvent2.setHours( 0, 35, 0, 0 );
            overlappingEventTo2.setHours( 1, 35, 0, 0 );
            overlappingEvent3.setHours( 1, 20, 0, 0 );
            overlappingEventTo3.setHours( 2, 20, 0, 0 );
            overlappingEvent4.setHours( 2, 0, 0, 0 );
            overlappingEventTo4.setHours( 3, 0, 0, 0 );
            overlappingEvent5.setHours( 3, 30, 0, 0 );
            overlappingEventTo5.setHours( 4, 40, 0, 0 );

            return [
                {
                    from: overlappingEvent1,
                    to: overlappingEventTo1,
                    title: "Overlapping Event 1",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    group: "Group 1"
                },
                {
                    from: overlappingEvent2,
                    to: overlappingEventTo2,
                    title: "Overlapping Event 2",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    group: "Group 1"
                },
                {
                    from: overlappingEvent3,
                    to: overlappingEventTo3,
                    title: "Overlapping Event 3",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    group: "Group 1"
                },
                {
                    from: overlappingEvent4,
                    to: overlappingEventTo4,
                    title: "Overlapping Event 4",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    group: "Group 1"
                },
                {
                    from: overlappingEvent5,
                    to: overlappingEventTo5,
                    title: "Overlapping Event 5",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    group: "Group 1"
                },
                {
                    from: previousYear,
                    to: previousYear,
                    title: "Previous Year",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    group: "Group 2"
                },
                {
                    from: nextYear,
                    to: nextYear,
                    title: "Next Year",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    group: "Group 2"
                },
                {
                    from: previousDay,
                    to: previousDay,
                    title: "Previous Day",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    color: "#FF0000",
                    colorText: "#FFFF00",
                    colorBorder: "#00FF00",
                    repeatEvery: 5,
                    id: "1234-5678-9",
                    group: "Group 1"
                },
                {
                    from: today11,
                    to: tomorrow,
                    title: "Title 1",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: false,
                    group: "group 1"
                },
                {
                    from: tomorrow,
                    to: today11,
                    title: "Title Bad (should not show)",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: false,
                    group: "group 1"
                },
                {
                    from: today9,
                    to: today9,
                    title: "Title 2",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    group: "Group 1",
                    url: "https://www.google.com/"
                },
                {
                    from: firstDayInNextMonth,
                    to: firstDayInNextMonth,
                    title: "First Day 1",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    color: "#00FF00",
                    colorText: "#FF0000",
                    repeatEvery: 4
                },
                {
                    from: firstDayInNextMonth,
                    to: firstDayInNextMonth,
                    title: "First Day 2",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    color: "#00FF00",
                    colorText: "#FF0000",
                    repeatEvery: 4
                },
                {
                    from: lastDayInNextMonth,
                    to: lastDayInNextMonth,
                    title: "Last Day 1",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    location: "Teams Meeting",
                    isAllDay: true,
                    color: "#0000FF",
                    repeatEvery: 2
                },
                {
                    from: today,
                    to: today3HoursAhead,
                    title: "Regular Event",
                    description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                    repeatEvery: 1,
                    repeatEveryExcludeDays: [ 6, 0 ],
                    repeatEnds: new Date( today.getFullYear() + 1, 0, 1 ),
                    group: "Group 1"
                }
            ];
			
        }

        function getCopiedEvent() {
            var today = new Date(),
                todayPlus1Hour = new Date();

            todayPlus1Hour.setHours( today.getHours() + 1 );

            return {
                from: today,
                to: todayPlus1Hour,
                title: "Copied Event",
                description: "This is a another description of the event that has been added, so it can be shown in the pop-up dialog.",
                group: "Group 1"
            }
        }

        function addNewHoliday() {
            var today = new Date();

            var holiday1 = {
                day: today.getDate(),
                month: today.getMonth() + 1,
                title: "Google Day",
                onClick: function() {
                    document.location = "https://www.google.com/";
                }
            };

            var holiday2 = {
                day: today.getDate(),
                month: today.getMonth() + 1,
                title: "Calendar.js Day",
                onClick: function() {
                    document.location = "https://github.com/williamtroup/Calendar.js";
                }
            };
            
            calendarInstance.addHolidays( [ holiday1, holiday2 ] );
        }
    </script>
</html>';
?>