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