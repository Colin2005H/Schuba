const groupContainer = document.getElementById("groupGlobalContainer");

const initiators = document.getElementById("initiateur"); //changer le nom
const student1 = document.getElementById("eleve1"); //changer le nom
const student2 = document.getElementById("eleve2"); //changer le nom;


let groupNb = 1;

/**
 * ajoute une ligne Initiateur/Eleve 1/Eleve 2 au formulaire
 */
function addGroupInput(){
    groupNb ++;

    let newContainer = document.createElement("div");

    newContainer.id = "groupContainer" + groupNb;

    let labelInit = document.createElement("label");
    labelInit.setAttribute("for", "initiateur" + groupNb);
    labelInit.appendChild(document.createTextNode("Initiateur " + groupNb + " : "));

    let newInitiator = initiators.cloneNode(true);
    newInitiator.id = "initiateur" + groupNb;
    newInitiator.setAttribute("name", 'group['+groupNb+'][initiateur]');

    let labelStu1 = document.createElement("label");
    labelStu1.setAttribute("for", "eleve1_" + groupNb);
    labelStu1.appendChild(document.createTextNode("Eleve 1 : "));

    let newStudent1 = student1.cloneNode(true);
    newStudent1.id = "eleve1_" + groupNb;
    newStudent1.setAttribute("name", 'group['+groupNb+'][eleve1]');

    let labelStu2 = document.createElement("label");
    labelStu2.setAttribute("for", "eleve2_" + groupNb);
    labelStu2.appendChild(document.createTextNode("Eleve 2 : "));

    let newStudent2 = student2.cloneNode(true);
    newStudent2.id = "eleve2_" + groupNb;
    newStudent2.setAttribute("name", 'group['+groupNb+'][eleve2]');

    

    newContainer.appendChild(labelInit);
    newContainer.appendChild(newInitiator);

    newContainer.appendChild(labelStu1);
    newContainer.appendChild(newStudent1);

    newContainer.appendChild(labelStu2);
    newContainer.appendChild(newStudent2);

    groupContainer.appendChild(newContainer);
    
    console.log("+");
}

/**
 * retire une ligne Initiateur/Eleve 1/Eleve 2 du formulaire
 * ne fait rien s'il n'y a qu'une seule ligne
 */
function removeGroupInput(){
    if(groupNb > 1){
        const elt = document.getElementById("groupContainer"+groupNb);
        elt.remove();
        groupNb --;
    } else {
        window.alert("Impossible de créer une séance sans groupe");
    }
}

