<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Calendrier</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <style>

        body{
            font-family: 'figtree', sans-serif;
        }
        
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

        h1 {
            font-size: 3rem;
            
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
                        var identifier = document.getElementById('idSeance');
                        var popup = document.getElementById("popup");
                        var location = document.getElementById('location');
                        var beginningHour = document.getElementById('beginning-hour');
                        var endingHour = document.getElementById('ending-hour');
                        identifier.value = info.event.id;
                        identifier.setAttribute("value", info.event.id);
                        location.textContent = info.event.title;
                        beginningHour.textContent = "Début : " + info.event.start.toLocaleTimeString();
                        endingHour.textContent = "Fin : " + info.event.end.toLocaleTimeString();
                        popup.style.display = "block";

                        async function loadTable() {
                            try {
                                // Requête AJAX pour récupérer le HTML généré par PHP
                                const response = await fetch(`/calendar/${info.event.id}`);

                                // Vérifiez si la requête a réussi
                                if (!response.ok) {
                                    throw new Error('Échec de la récupération des données');
                                }

                                // Récupérer le HTML de la réponse
                                const tableHTML = await response.text();

                                document.getElementById('bodyTable').innerHTML = tableHTML;

                            } catch (error) {
                                console.error('Erreur lors de la récupération de la table:', error);
                            }
                        }
                        loadTable();

                        //document.cookie = "identifier=".info.event.id;

                        // const idInput = document.getElementById('idSeance');
                        // idInput.value = session.ID;
                        // console.log(idInput.value);

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
    <p id="hiddenValue" class="hidden"></p>
    <div class="hidden fixed inset-0 z-10 bg-opacity-75 bg-gray-500 flex items-center justify-center place-content-center place-items-center align-content-center min-h-screen w-full" id="popup">
        <div class="bg-white rounded-lg p-6 w-full max-w-md text-center">
            <form action="" method="POST">
                @csrf
            <input id="idSeance" name="identifier" class="hidden" value="">
            <p id="location" class="text-lg font-semibold mb-2"></p>
            <p id="beginning-hour" class="mb-2"></p>
            <p id="ending-hour" class="mb-4"></p>
            <table class="min-w-full bg-white border border-gray-200">
                <thead id="test">
                    <tr>
                        <th scope="col" class="px-4 py-2 border-b border-gray-200 text-center">Initiateurs</th>
                        <th scope="col" class="px-4 py-2 border-b border-gray-200 text-center">Elèves</th>
                        <th scope="col" class="px-4 py-2 border-b border-gray-200 text-center">Aptitudes</th>
                    </tr>
                </thead>
                <tbody id="bodyTable">

                <tbody>
                    <?php
                    use App\Http\Controllers\CalendarController;
                    use App\Http\Controllers\RoleController;
                    use Illuminate\Support\Facades\Auth;

                    $roleController = new RoleController();
                    $role = $roleController->getRole(session('user'));
                    ?>
                </tbody>
            </table>
            <button id="close" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded mx-auto" onclick="document.getElementById('popup').style.display = 'none';" type="button">Fermer</button>
            <?php
                //$seance_id = $_COOKIE['identifier'];
                //$url = route('bilan.showForm', ['seance_id' => $seance_id]);
            
            ?>
            <?php if($role === 'initiateur'): ?>
            
                <button id="evaluate" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded mx-auto" 
                        >
                    Evaluer
                </button>
                <?php endif; ?>
                <?php if($role === 'responsable'): ?>
            
            <button id="modif" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded mx-auto" 
                    >
                    Modifier
            </button>    
            <?php endif; ?>
            
            @if($role === 'eleve')
            <button id="bilan" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded mx-auto" 
                    >
                    bilan
            </button>   
            @endif
            
            </form>
    
        </div>
    </div>
</body>
</html>