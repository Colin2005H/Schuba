const groupContainer = document.getElementById("groupGlobalContainer");

const initiators = document.getElementById("initiateur1"); //changer le nom
const student1 = document.getElementById("eleve1_1"); //changer le nom
const student2 = document.getElementById("eleve2_1"); //changer le nom;

let selectedIds = {};
let groupNb = 1;

/**
 * ajoute une ligne Initiateur/Eleve 1/Eleve 2 au formulaire
 */
function addGroupInput() {
    groupNb++;

    let newContainer = document.createElement("div");
    newContainer.setAttribute("class", "mb-4 border p-4 rounded-md bg-gray-50");

    newContainer.id = "groupContainer" + groupNb;

    let labelInit = document.createElement("label");
    labelInit.setAttribute("for", "initiateur" + groupNb);
    labelInit.appendChild(
        document.createTextNode("Initiateur " + groupNb + " : ")
    );

    let newInitiator = initiators.cloneNode(true);
    newInitiator.id = "initiateur" + groupNb;
    newInitiator.setAttribute("name", "group[" + groupNb + "][initiateur]");
    newInitiator.setAttribute("onchange", `onInitiatorSelect(${groupNb})`);

    let labelStu1 = document.createElement("label");
    labelStu1.setAttribute("for", "eleve1_" + groupNb);
    labelStu1.appendChild(document.createTextNode("Eleve 1 : "));

    let newStudent1 = student1.cloneNode(true);
    newStudent1.id = "eleve1_" + groupNb;
    newStudent1.setAttribute("name", "group[" + groupNb + "][eleve1]");
    newStudent1.setAttribute("onchange", `onStudentSelect(${groupNb}, 1)`);

    let labelStu2 = document.createElement("label");
    labelStu2.setAttribute("for", "eleve2_" + groupNb);
    labelStu2.appendChild(document.createTextNode("Eleve 2 : "));

    let newStudent2 = student2.cloneNode(true);
    newStudent2.id = "eleve2_" + groupNb;
    newStudent2.setAttribute("name", "group[" + groupNb + "][eleve2]");
    newStudent2.setAttribute("onchange", `onStudentSelect(${groupNb}, 2)`);

    newContainer.appendChild(labelInit);
    newContainer.appendChild(newInitiator);

    newContainer.appendChild(labelStu1);
    newContainer.appendChild(newStudent1);

    newContainer.appendChild(labelStu2);
    newContainer.appendChild(newStudent2);

    groupContainer.appendChild(newContainer);

    selectUpdate();
}

/**
 * retire une ligne Initiateur/Eleve 1/Eleve 2 du formulaire
 * ne fait rien s'il n'y a qu'une seule ligne
 */
function removeGroupInput() {
    if (groupNb > 1) {
        const elt = document.getElementById("groupContainer" + groupNb);
        elt.remove();
        groupNb--;

        //retire les valeurs du dict des valeurs selectionnées (elles n'existent plus)
        delete selectedIds["initiateur"+groupNb];
        delete selectedIds["eleve1_"+groupNb];
        delete selectedIds["eleve2_"+groupNb];

        selectUpdate();
    } else {
        window.alert("Impossible de créer une séance sans groupe");
    }
}

/**
 * activé lors du changement dans la valeur d'un selecteur d'initiateur
 * @param {number} groupId numero du groupe dont fait parti le selecteur concerné
 */
function onInitiatorSelect(groupId) {
    console.log("init" + groupId);
    const id = "initiateur" + groupId;

    const selector = document.getElementById(id);

    disableId = selector.value;

    selectedIds[id] = disableId;

    selectUpdate();
}

/**
 * activé lors du changement dans la valeur d'un selecteur d'eleve
 * @param {number} groupId numero du groupe dont fait parti le selecteur concerné
 * @param {number} studentNb 1 ou 2, permet d'identifier le selecteur
 */
function onStudentSelect(groupId, studentNb) {
    console.log("stu" + groupId + " WIP");
    const id = "eleve" + studentNb + "_" + groupId;

    const selector = document.getElementById(id);

    disableId = selector.value;

    selectedIds[id] = disableId;

    selectUpdate();
}

function selectUpdate() {
    for (i = 1; i <= groupNb; i++) {
        //pour tout containeur

        let currentSelector = document.getElementById("initiateur" + i);

        optionsUpdate(currentSelector.children, "initiateur" + i);

        currentSelector = document.getElementById("eleve1_" + i);

        optionsUpdate(currentSelector.children, "eleve1_" + i);

        currentSelector = document.getElementById("eleve2_" + i);

        optionsUpdate(currentSelector.children, "eleve2_" + i);
    }
}

/**
 * 
 * @param {HTMLCollection} options collection de balises <option>
 * @param {string} selectorId id du selecteur, permet d'éviter de desactiver la valeur qu'il selectionne actuellement
 */
function optionsUpdate(options, selectorId) {
    for (opt of options) {
        if (Object.values(selectedIds).includes(opt.value) && opt.value != "null") {
            //la valeur de l'option est selectionnée et l'option n'est pas "AUCUN"
            console.log("oui");

            if (selectedIds[selectorId] != opt.value) {
                //l'option n'est pas selectionnée
                opt.disabled = true; //on la desactive
            } else {
                //par sécurité
                opt.disabled = false;
            }
        } else {
            //rien
            opt.disabled = false;
        }
    }
}
