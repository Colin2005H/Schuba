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
    @include('header')
    <div class="calendar">
        <h1>Calendrier des séances</h1>
        <div id='calendar'>
            <script>
                // Déclaration globale de la variable calendar
                var calendar;

                var isMobile = window.matchMedia("(max-width: 768px)").matches;

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
                            url: 'http://localhost:8000/api/seance', // use the `url` property
                            title: 'Séance',
                            color: 'blue',
                            textColor: 'white',
                            timeZoneParam: 'EU/PARIS'
                        }
                    ],
                    slotMinTime: "06:00:00",
                    slotMaxTime: "22:00:00",
                    windowResize: function(arg) {
                        resizeCaldendar(); // Appeler resizeCaldendar lors du redimensionnement de la fenêtre
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
</body>
</html>
