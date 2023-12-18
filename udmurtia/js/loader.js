const loader = document.querySelector('.loader-wrapper');
const loaderText = document.querySelector('.loader-text');

function setLoader(open = true, text = 'Загрузка...'){
    loader.style.display = open == true ? 'flex':'none';
    loaderText.innerHTML = text;
};