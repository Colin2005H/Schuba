<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <style>
        .fc-event-time {
            font-size: 0.9rem !important;
            font-family: 'figtree', sans-serif; 
        }

        /* Media query for mobile devices */
        @media screen and (max-width: 768px) {
            #calendar {
                font-size: 0.8rem;
            }

            .fc-event-time {
            font-size: 1rem !important;
        }
        }
        .fc{
            font-family: 'figtree', sans-serif; 
        }

        #calendar {
            margin: 0 auto;
        }

        .calendar {
            font-family: 'figtree', sans-serif;
            font-size: 1.2rem;
            margin: 0 auto;
            padding: 20px;

        }

        .fc .fc-toolbar{
            flex-wrap: wrap;
            gap: 20px;
        }

    </style>
    <div class="calendar">
        <h1>Calendrier des séances</h1>
        <div id='calendar'>
            <script>
                // Déclaration globale de la variable calendar
                var calendar;

                var isMobile = window.matchMedia("(max-width: 768px)").matches;

                async function getSession(start, end) {
                    const response = await fetch(`/api/session?start=${start.toISOString()}&end=${end.toISOString()}`);
                    return response.json();
                }

                // Définition des options et configurations du calendrier
                var calendarTem = {
                    initialView: isMobile ? 'timeGridDay' : 'timeGridWeek', // Afficher la vue jour sur mobile
                    locale: 'fr',
                    height: "auto",
                    nowIndicator: true,
                    handleWindowResize: true,
                    firstDay: 1,
                    navLinks: true,
                    businessHours: {
                        daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                        startTime: '8:00',
                        endTime: '20:00',
                    },
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today,dayGridMonth,timeGridWeek,timeGridDay' // Permet à l'utilisateur de changer de vue
                    },
                    buttonText: {
                        today: 'Aujourd\'hui',
                        month: 'Mois',
                        week: 'Semaine',
                        day: 'Jour',
                        list: 'Liste'
                    },
                    eventSources: [
                        {
                            startParam: 'BEGIN',
                            endParam: 'END',
                            color: 'blue',
                            textColor: 'white',
                            timeZoneParam: 'EU/PARIS',
                        }
                    ],
                    slotMinTime: "06:00:00",
                    slotMaxTime: "22:00:00",
                    windowResize: function(arg) {
                        resizeCaldendar();
                    },
                    events: async function(info, successCallback, failureCallback) {
                        try {
                            // Await the sessions response
                            const sessions = await getSession(info.start, info.end);
                            
                            const result = [];
                            
                            // We will use Promise.all to ensure all location fetches complete before continuing
                            const locationPromises = sessions.map(async (session) => {
                                try {
                                    // Fetch location data
                                    const response = await fetch(`/api/location?id=${session.LOCATION_ID}`);

                                    const locationData = await response.json();
                                    
                                    // Check if location data is available
                                    if (locationData && locationData.length > 0) {
                                        const location = locationData[0];
                                        return {
                                            title: `${location.NAME}`, 
                                            start: session.START,
                                            end: session.END,
                                            id : session.ID
                                        };
                                    } else {
                                        throw new Error('Location not found');
                                    }
                                } catch (error) {
                                    console.error('Error fetching location data:', error);
                                }
                            });

                            // Await all location fetch promises and store the results in result
                            const locationEvents = await Promise.all(locationPromises);

                            // Fill result with valid location data (non-null items)
                            result.push(...locationEvents.filter(event => event !== undefined));

                            console.log(result);

                            // Pass the final result to successCallback
                            successCallback(result);
                        } catch (error) {
                            console.error('Error fetching session data:', error);
                            failureCallback(error);
                        }
                    },

                    eventClick: function(info) {
                        var identifier = document.getElementById('identifier');
                        var popup = document.getElementById("popup");
                        var location = document.getElementById('location');
                        var beginningHour = document.getElementById('beginning-hour');
                        var endingHour = document.getElementById('ending-hour');
                        identifier.textContent = info.event.id;
                        location.textContent = info.event.title;
                        beginningHour.textContent = "Début : " + info.event.start.toLocaleTimeString();
                        endingHour.textContent = "Fin : " + info.event.end.toLocaleTimeString();
                        popup.style.display = "block";
                    }
              };

                function resizeCaldendar() {
                    // Vérifier si l'on est en mode mobile
                    isMobile = window.matchMedia("(max-width: 768px)").matches;
                    if (calendarTem.initialView != (isMobile ? 'timeGridDay' : 'timeGridWeek')) {

                        calendarTem.initialView = isMobile ? 'timeGridDay' : 'timeGridWeek';

                        calendar.destroy(); // Détruire le calendrier existant
                        calendar = new FullCalendar.Calendar(document.getElementById('calendar'), calendarTem); // Recréer le calendrier avec les nouvelles options
                        calendar.render(); // Redessiner le calendrier
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Sélectionner le conteneur du calendrier
                    var calendarEl = document.getElementById('calendar');

                    // Initialiser le calendrier avec les options définies
                    calendar = new FullCalendar.Calendar(calendarEl, calendarTem);
                    calendar.render();

                    // Appeler resizeCaldendar après l'initialisation du calendrier
                    resizeCaldendar();
                });
            </script>
        </div>
    </div>
</head>
<body>
    <div id='calendar'></div>
    <popup style = "display: none;" id="popup">
        <p id="identifier" style="display: none;"></p>
        <p id="location"></p>
        <p id="beginning-hour"></p>
        <p id="ending-hour"></p>
        @foreach 

        @endforeach
        

        <button id="close">Fermer</button>
        
        
        
    </popup>
</body>
</html>
