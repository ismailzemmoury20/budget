function setType(type){
    document.getElementById('type').value = type;

    document.getElementById('btn-revenu').classList.remove('active');
    document.getElementById('btn-depense').classList.remove('active');

    document.getElementById('btn-' + type).classList.add('active');
}