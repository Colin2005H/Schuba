<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @include('header')
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            <span class="font-medium"> {{session('success')}} </span>
        </div>
    @endif
    <div class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
        
        <h3 class="text-xl font-semibold text-center mb-6">Créer un compte utilisateur</h3>
        
        <form method="POST" action="" style="margin-bottom: 10px;">
            @csrf
            <div class="mb-4">
                <label class="flex items-center gap-2 text-gray-700">
                    <input type="text" id="uti_nom" name="uti_nom" value="" placeholder="Nom" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </label>
                @error("uti_nom")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-2 text-gray-700">
                    <input type="text" id="uti_prenom" name="uti_prenom" value="" placeholder="Prénom" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </label>
                @error("uti_prenom")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-2 text-gray-700">
                    <input type="text" id="uti_code_postal" name="uti_code_postal" value="" placeholder="Code Postal" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </label>
                @error("uti_code_postal")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror

                <label class="flex items-center gap-2 text-gray-700">
                    <input type="text" id="uti_adresse" name="uti_adresse" value="" placeholder="Adresse" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </label>
                @error("uti_adresse")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror

                <label class="flex items-center gap-2 text-gray-700">
                    <input type="text" id="uti_ville" name="uti_ville" value="" placeholder="Ville" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </label>
                @error("uti_ville")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-2 text-gray-700">
                    <input type="text" id="uti_mail" name="uti_mail" value="" placeholder="Adresse email" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </label>
                @error("uti_mail")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="clu_id">Club :</label>
                <input type="text" id="clu_id" name="clu_id" value="{{$clubDirector[0]->clu_nom}}" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>

                @error("clu_id")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <select name="uti_niveau" id="niveauUser" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Niveau de plongée</option>
                    <option value="0">Pas de niveau</option>
                    <option value="1">N1</option>
                    <option value="2">N2</option>
                    <option value="3">N3</option>
                    <option value="4">MF1</option>
                    <option value="4">MF2</option>
                </select>
                @error("uti_niveau")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="uti_date_naissance">Date de naissance : </label>
                <input id="uti_date_naissance" type="date" name="uti_date_naissance" value="1950-01-01" min="1950-01-01" max="{{today()}}" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                @error("uti_date_naissance")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="uti_date_certificat">Date du certificat de santé : </label>
                <input id="uti_date_certificat" type="date" name="uti_date_certificat" value="1950-01-01" min="1950-01-01" max="2025-" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                @error("uti_date_certificat")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-4" id="userTypeDiv">
                <div class="form-check" id="eleveDiv">
                    <input type="radio" id="userType1" name="userType" value="eleve" disabled/>
                    <label for="userType1">Eleve</label>
                </div>

                <div id="initiateurBtnRadio" class="form-check">
                    <input type="radio" id="userType2" name="userType" value="initiateur" disabled/>
                    <label for="userType2">Initiateur</label>
                </div>

                @error("userType")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>

            <button class="flex items-center justify-center text-white hover:bg-blue-500 p-4 rounded-md" style="background-color: rgba(23, 34, 49, 1);">Enregistrer</button>
        </form>
    </div>

    <script>
        var niveau = document.getElementById("niveauUser");
        var student = document.getElementById("userType1");
        var initiateur = document.getElementById("userType2");
        var studentDiv = document.getElementById("eleveDiv");
        var changeStudentRadioBtn = 0;
        document.getElementById("uti_date_naissance").max = new Date().toLocaleDateString('fr-ca');
        document.getElementById("uti_date_certificat").max = new Date().toLocaleDateString('fr-ca')

        student.addEventListener('click', function() {
            if(student.checked && changeStudentRadioBtn === 0){
                var studentFormation = document.createElement('p');
                var valueFormation = parseInt(niveau.value)+ 1
                studentFormation.textContent = 'Formation de niveau ' + valueFormation + ' pour cette année';
                studentFormation.id = 'studentFormation';
                studentDiv.appendChild(studentFormation);
                changeStudentRadioBtn++;
            }
        });

        initiateur.addEventListener('click', function() {
            if(document.getElementById('studentFormation')){
                var studentFormation = document.getElementById('studentFormation');
                studentDiv.removeChild(studentFormation);
                changeStudentRadioBtn = 0;
            }
        });

        niveau.addEventListener('change', function () {
            if(niveau.value == ""){
                initiateur.disabled = true;
                initiateur.checked = false;
                student.disabled = true;
                student.checked = false;
                if(document.getElementById('studentFormation')){
                    var studentFormation = document.getElementById('studentFormation');
                    studentDiv.removeChild(studentFormation);
                    changeStudentRadioBtn = 0;
                }
                return;
            }
            if(student.checked){
                var valueFormation = parseInt(niveau.value)+ 1
                document.getElementById("studentFormation").textContent = 'Formation de niveau ' + valueFormation + ' pour cette année';
            }
            if(parseInt(niveau.value) < 2){
                initiateur.disabled = true;
                initiateur.checked = false;
                student.disabled = false;
            }
            if(parseInt(niveau.value) == 2){
                initiateur.disabled = false;
                student.disabled = false;
            }
            if(parseInt(niveau.value) >= 3){
                initiateur.disabled = false;
                student.disabled = true;
                student.checked = false;
                if(document.getElementById('studentFormation')){
                    var studentFormation = document.getElementById('studentFormation');
                    studentDiv.removeChild(studentFormation);
                    changeStudentRadioBtn = 0;
                }
            }
        });
    </script>
</body>
</html>