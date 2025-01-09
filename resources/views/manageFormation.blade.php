@extends('head')
<script>

            let selectedN1="";
            let selectedN2="";
            let selectedN3="";

            //disable the preselected option for the other forms
            document.addEventListener("DOMContentLoaded", function() {
                @foreach($optionsManager as $option)
                    @if ($n1Exist===1 && $n1ExistManager->first()->UTI_ID==$option->UTI_ID)
                        loadManagersN1({{ $option->UTI_ID }});
                    @endif
                    @if ($n2Exist===1 && $n2ExistManager->first()->UTI_ID==$option->UTI_ID)
                        loadManagersN2({{ $option->UTI_ID }});
                    @endif
                    @if ($n3Exist===1 && $n3ExistManager->first()->UTI_ID==$option->UTI_ID)
                        loadManagersN3({{ $option->UTI_ID }});
                    @endif
                @endforeach
            });

            //disable or enable option according the the selection change for the form N1
            function loadManagersN1(id){

                if (id==""){
                    selectedN1="";
                    document.querySelectorAll("form #manager-select option").forEach(function(elt) { elt.disabled=false; })
                    if (selectedN2!=""){
                        loadManagersN2(selectedN2);
                    }
                    if (selectedN3!=""){
                        loadManagersN3(selectedN3);
                    }
                }

                else{
                    selectedN1=id;
                    document.querySelectorAll("form #manager-select option").forEach(function(elt) { elt.disabled=false; })
                    if (selectedN2!=""){
                        document.querySelector("#n1_"+selectedN2).disabled = true;
                        document.querySelector("#n3_"+selectedN2).disabled = true;
                    }
                    if (selectedN3!=""){
                        document.querySelector("#n1_"+selectedN3).disabled = true;
                        document.querySelector("#n2_"+selectedN3).disabled = true;
                    }
                    document.querySelector("#n2_"+id).disabled = true;
                    document.querySelector("#n3_"+id).disabled = true;
                }

            }

            //disable or enable option according the the selection change for the form N2
            function loadManagersN2(id){
                if (id==""){
                    selectedN2="";
                    document.querySelectorAll("form #manager-select option").forEach(function(elt) { elt.disabled=false; })
                    if (selectedN1!=""){
                        loadManagersN1(selectedN1);
                    }
                    if (selectedN3!=""){
                        loadManagersN3(selectedN3);
                    }
                }
                else{
                    selectedN2=id;
                    document.querySelectorAll("form #manager-select option").forEach(function(elt) { elt.disabled=false; })
                    if (selectedN1!=""){
                        document.querySelector("#n2_"+selectedN1).disabled = true;
                        document.querySelector("#n3_"+selectedN1).disabled = true;
                    }
                    if (selectedN3!=""){
                        document.querySelector("#n1_"+selectedN3).disabled = true;
                        document.querySelector("#n2_"+selectedN3).disabled = true;
                    }
                    document.querySelector("#n1_"+id).disabled = true;
                    document.querySelector("#n3_"+id).disabled = true;
                }
            }

            //disable or enable option according the the selection change for the form N3
            function loadManagersN3(id){
                if (id==""){
                    selectedN3="";
                    document.querySelectorAll("form #manager-select option").forEach(function(elt) { elt.disabled=false; })
                    if (selectedN1!=""){
                        loadManagersN1(selectedN1);
                    }
                    if (selectedN2!=""){
                        loadManagersN2(selectedN2);
                    }
                }
                else{
                    selectedN3=id;
                    document.querySelectorAll("form #manager-select option").forEach(function(elt) { elt.disabled=false; })
                    if (selectedN1!=""){
                        document.querySelector("#n2_"+selectedN1).disabled = true;
                        document.querySelector("#n3_"+selectedN1).disabled = true;
                    }
                    if (selectedN2!=""){
                        document.querySelector("#n1_"+selectedN2).disabled = true;
                        document.querySelector("#n3_"+selectedN2).disabled = true;
                    }
                    document.querySelector("#n1_"+id).disabled = true;
                    document.querySelector("#n2_"+id).disabled = true;
                }
            }

        </script>

@section('title','Formation')

@section('content')
    <div class="bg-[rgb(255,255,255,1)] px-16 py-10 m-10 justify-items-center rounded">
        <h1 class="font-bold text-[#004B85] text-center text-2xl m-4">Création de formation</h1>

       <!-- FORM N1 -->
    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->
        <div class="flex">
            <form action="/formations" method="post" class="mx-4 my-6 max-w-96 flex flex-col border-2 border-[#004B85] rounded">
                @csrf

                <div class="flex m-3">
                    <label for="category-select" class="font-bold mr-6 text-xl">Niveau&nbsp;:&nbsp;N1</label>
                    <select name="category" id="category-select" class="rounded max-w-64 drop-shadow-lg hidden" required>
                        <option value="1">N1</option>
                    </select>
                </div>

                <div class="flex m-3">
                    <label for="manager-select" class="font-bold mr-6">Responsable&nbsp;:&nbsp;</label>
                    <select name="manager" id="manager-select" class="rounded max-w-64 drop-shadow-lg" required onchange="loadManagersN1(this.selectedOptions[0].value)">
                        <option value="">-- Sélectionnez une option --</option>
                        @foreach($optionsManager as $option)
                            <option @if ($n1Exist===1 && $n1ExistManager->first()->UTI_ID==$option->UTI_ID)
                                selected
                            @endif id="n1_{{ $option->UTI_ID}}" value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex m-3">
                    <label for="initiator-select" class="font-bold content-center mr-6">Initiateurs&nbsp;:&nbsp;</label>
                    <select name="initiator[]" id="initiator-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                        @php
                            $existingInitiatorIdsN1 = collect($n1ExistInitiators)->pluck('UTI_ID')->toArray();
                        @endphp
                        @foreach($optionsInitiatorsN1N2 as $option)

                            <option @if ($n1Exist===1 &&  in_array($option->UTI_ID, $existingInitiatorIdsN1) )
                                selected
                            @endif value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>

                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>

                <div class="flex m-3">
                    <label for="student-select" class="font-bold content-center mr-6">Élèves&nbsp;:&nbsp;</label>
                    <select name="student[]" id="student-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                        @php
                            $existingStudentIdsN1 = collect($n1ExistStudents)->pluck('UTI_ID')->toArray();
                        @endphp
                        @foreach($optionsStudentN1 as $option)
                            <option @if ($n1Exist===1 &&  in_array($option->UTI_ID, $existingStudentIdsN1) )
                                selected
                            @endif value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>


                    @if ($n1Exist===0)
                        <div class="text-center m-4">
                            <input type="submit" value="Créer" id="btnCreateN1" class="bg-[#000000] py-2 px-4 rounded text-white" />
                        </div>
                    @else
                        <div class="text-center m-4">
                            <input type="submit" value="Modifier" id="btnModifyN1" class="bg-[#000000] py-2 px-4 rounded text-white" />
                        </div>
                    @endif

                    @if ($n1NbSessions === 0 && $n1Exist===1)
                        <input type="submit" name="action" value="Supprimer" class="bg-[#000000] py-2 px-3 mb-4 self-center rounded text-white " />
                    @endif



                @if (session('success1'))
                    <div class="text-center"> {{ session('success1') }} </div>
                @endif

            </form>

            <!-- FORM N2 -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

            <form action="/formations" method="post" class="mx-4 my-6 max-w-96 flex flex-col border-2 border-[#004B85] rounded">
                @csrf

                <div class="flex m-3">
                    <label for="category-select" class="font-bold mr-6 text-xl">Niveau&nbsp;:&nbsp;N2</label>
                    <select name="category" id="category-select" class="rounded max-w-64 drop-shadow-lg hidden" required>
                        <option value="2">N2</option>
                    </select>
                </div>

                <div class="flex m-3">
                    <label for="manager-select" class="font-bold mr-6">Responsable&nbsp;:&nbsp;</label>
                    <select name="manager" id="manager-select" class="rounded max-w-64 drop-shadow-lg" required onchange="loadManagersN2(this.selectedOptions[0].value)">
                        <option value="">-- Sélectionnez une option --</option>
                        @foreach($optionsManager as $option)
                            <option @if ($n2Exist===1 && $n2ExistManager->first()->UTI_ID==$option->UTI_ID)
                                selected
                            @endif value="{{ $option->UTI_ID }}" id="n2_{{ $option->UTI_ID}}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex m-3">
                    <label for="initiator-select" class="font-bold content-center mr-6">Initiateurs&nbsp;:&nbsp;</label>
                    <select name="initiator[]" id="initiator-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                        @php
                            $existingInitiatorIdsN2 = collect($n2ExistInitiators)->pluck('UTI_ID')->toArray();
                        @endphp
                        @foreach($optionsInitiatorsN1N2 as $option)
                            <option @if ($n2Exist===1 &&  in_array($option->UTI_ID, $existingInitiatorIdsN2) )
                                selected
                            @endif value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>

                <div class="flex m-3">
                    <label for="student-select" class="font-bold content-center mr-6">Élèves&nbsp;:&nbsp;</label>
                    <select name="student[]" id="student-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                        @php
                            $existingStudentIdsN2 = collect($n2ExistStudents)->pluck('UTI_ID')->toArray();
                        @endphp
                        @foreach($optionsStudentN2 as $option)
                            <option @if ($n2Exist===1 &&  in_array($option->UTI_ID, $existingStudentIdsN2) )
                                selected
                            @endif value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>


                @if ($n2Exist===0)
                    <div class="text-center m-4">
                        <input type="submit" value="Créer" id="btnCreateN2" onclick="createdN2()" class="bg-[#000000] py-2 px-4 rounded text-white" />
                    </div>
                @else
                    <div class="text-center m-4">
                        <input type="submit" value="Modifier" id="btnModifyN2" class="bg-[#000000] py-2 px-4 rounded text-white" />
                    </div>
                @endif

                @if ($n2NbSessions === 0 && $n2Exist===1)
                        <input type="submit" name="action" value="Supprimer" class="bg-[#000000] py-2 px-3 mb-4 self-center rounded text-white" />
                @endif

                @if (session('success2'))
                    <div class="text-center"> {{ session('success2') }} </div>
                @endif

            </form>

            <!-- FORM N3 -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

            <form action="/formations" method="post" class="mx-4 my-6 max-w-96 flex flex-col border-2 border-[#004B85] rounded">
                @csrf

                <div class="flex m-3">
                    <label for="category-select" class="font-bold mr-6 text-xl">Niveau&nbsp;:&nbsp;N3</label>
                    <select name="category" id="category-select" class="rounded max-w-64 drop-shadow-lg hidden" required>
                        <option value="3">N3</option>
                    </select>
                </div>

                <div class="flex m-3">
                    <label for="manager-select" class="font-bold mr-6">Responsable&nbsp;:&nbsp;</label>
                    <select name="manager" id="manager-select" class="rounded max-w-64 drop-shadow-lg" required onchange="loadManagersN3(this.selectedOptions[0].value)">
                        <option value="">-- Sélectionnez une option --</option>
                        @foreach($optionsManager as $option)
                            <option @if ($n3Exist===1 && $n3ExistManager->first()->UTI_ID==$option->UTI_ID)
                                selected
                            @endif id="n3_{{ $option->UTI_ID}}" value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex m-3">
                    <label for="initiator-select" class="font-bold content-center mr-6">Initiateurs&nbsp;:&nbsp;</label>
                    <select name="initiator[]" id="initiator-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                        @php
                            $existingInitiatorIdsN3 = collect($n3ExistInitiators)->pluck('UTI_ID')->toArray();
                        @endphp
                        @foreach($optionsInitiatorsN3 as $option)
                            <option @if ($n3Exist===1 &&  in_array($option->UTI_ID, $existingInitiatorIdsN3) )
                                selected
                            @endif value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>

                <div class="flex m-3">
                    <label for="student-select" class="font-bold content-center mr-6">Élèves&nbsp;:&nbsp;</label>
                    <select name="student[]" id="student-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                        @php
                            $existingStudentIdsN3 = collect($n3ExistStudents)->pluck('UTI_ID')->toArray();
                        @endphp
                        @foreach($optionsStudentN3 as $option)
                            <option @if ($n3Exist===1 &&  in_array($option->UTI_ID, $existingStudentIdsN3) )
                                selected
                            @endif value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>

                @if ($n3Exist===0)
                    <div class="text-center m-4">
                        <input type="submit" value="Créer" id="btnCreateN3" onclick="createdN3()" class="bg-[#000000] py-2 px-4 rounded text-white" />
                    </div>
                @else
                    <div class="text-center m-4">
                        <input type="submit" value="Modifier" id="btnModifyN3" class="bg-[#000000] py-2 px-4 rounded text-white" />
                    </div>
                @endif

                @if ($n3NbSessions === 0 && $n3Exist===1)
                        <input type="submit" name="action" value="Supprimer" class="bg-[#000000] py-2 px-3 mb-4 self-center rounded text-white" />
                @endif

                @if (session('success3'))
                    <div class="text-center"> {{ session('success3') }} </div>
                @endif

            </form>
        </div>

    <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <div>



@endsection




