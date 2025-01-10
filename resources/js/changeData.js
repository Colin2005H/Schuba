var pageValue = document.getElementById('changeDataValue');
if(pageValue.textContent == "email"){
    document.getElementById('editEmail').classList.remove('hidden');
    document.getElementById('editPassword').classList.add('hidden');
}
if(pageValue.textContent == "password"){
    document.getElementById('editPassword').classList.remove('hidden');
    document.getElementById('editEmail').classList.add('hidden');
}