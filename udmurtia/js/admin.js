let newsData = '';

const exitButton = document.querySelector('#exitButton');
exitButton.addEventListener('click', function(){
    deleteCookie("AUTH_TOKEN");
    window.location.reload();
});

function deleteCookie(cookieName) {
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
function getCookie(cookieName) {
  let name = cookieName + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let cookieArray = decodedCookie.split(';');

  for (let i = 0; i < cookieArray.length; i++) {
    let cookie = cookieArray[i].trim();
    if (cookie.indexOf(name) === 0) {
      return cookie.substring(name.length, cookie.length);
    }
  }

  return null;
}

let authToken = getCookie("AUTH_TOKEN");


const maxLengthCharNewsDescription = 150;
const newsDescription = [] = document.querySelectorAll('.news-description');
for(let i = 0; i < newsDescription.length; i++){
    originalText = newsDescription[i].textContent;
  if (newsDescription[i].textContent.length > maxLengthCharNewsDescription) {
    newsDescription[i].textContent = originalText.slice(0, maxLengthCharNewsDescription) + "...";
  }
}

const newsWrapper = document.querySelector('.news-page');

function createNews(json){

  newsData = json;
  json.news.reverse();

  for(let i = 0; i < json.news.length; i++){
    let text = null;
    let image = null;
    for(let d = 0; d < json.news[i].description.length; d++){
      if(json.news[i].description[d].type == 'text'){
        if(text == null){
          text = json.news[i].description[d].content; 
        }
      }
      if(json.news[i].description[d].type == 'image'){
        if(image == null){
          image = json.news[i].description[d].src; 
        }
      }
    }
    newsWrapper.insertAdjacentHTML('afterbegin', `
      <div class="news-item">
        <div class="preview-news">
            <img src="${domain}/db/news/${image}" alt="">
        </div>
        <p class="news-description">${text}</p>

        <img class="button-edit" src="src/icons/edit_4mw0jaq74bvt.svg" alt="">
        <img class="button-delete" src="src/icons/delete_18aqyvqiawhe.svg" alt="">
      </div>
  `);
  }

  setLoader(false);
}

const addNewsButton = document.querySelector('.news-add');
addNewsButton.addEventListener('click', sendAddNews);
function addNews(){

  let currentDate = new Date();
  let currentDay = currentDate.getDate();
  let currentMonth = currentDate.getMonth() + 1; 
  let currentYear = currentDate.getFullYear();

  let newNews = {
    "title": "Пустая новость",
    "date": currentDay + "." + currentMonth + "." + currentYear,
    "description": [
      {
        "type": "text",
        "content": "Это описание новой новости."
      },
      {
        "type": "image",
        "src": "media/prikazz.jpg"
      }
    ]
  };

  console.log(sendAddNews())
  if(!sendAddNews()) { return false; } else { newsData.news.push(newNews); }

  newsWrapper.insertAdjacentHTML('afterbegin', `
      <div class="news-item">
        <div class="preview-news">
            <img src="${domain}/db/news/media/prikazz.jpg" alt="">
        </div>
        <p class="news-description">Это описание новой новости.</p>

        <img class="button-edit" src="src/icons/edit_4mw0jaq74bvt.svg" alt="">
        <img class="button-delete" src="src/icons/delete_18aqyvqiawhe.svg" alt="">
      </div>
  `);

}


sendGetNews();
function sendGetNews() {
  setLoader(true);

  const xhr = new XMLHttpRequest();
  let formData = new FormData();
  xhr.open('POST', `${domain}/api/news.php`, true);
  formData.append('AUTH_TOKEN', authToken);
  formData.append('NEWS', 'GET');
  xhr.send(formData);

  xhr.onload = function() {
      if (xhr.status === 200) {

          const json = JSON.parse(xhr.responseText);
          if (json.hasOwnProperty("success")) {
              
              if(json.success){
                alert(json.message);
              } else {
                alert(json.message);
              }
              
              return;
          } else {
            console.log(json.news);
            createNews(json);
          }
          return;
          
      } else {

          alert('Сервер временно не доступен! Подробнее: info@example.ru');
      }

  }

  xhr.onerror = function() {
      if (xhr.status === 0) {
          alert('Сервер временно не доступен! Подробнее: info@example.ru');
      } else {
          alert('Произошла ошибка при запросе. Статус: ' + xhr.status + ', Подробности: ' + xhr.statusText);
      }
  };
};

function sendAddNews(){

  setLoader(true);

  let currentDate = new Date();
  let currentDay = currentDate.getDate();
  let currentMonth = currentDate.getMonth() + 1; 
  let currentYear = currentDate.getFullYear();

  let newNews = {
    "title": "Пустая новость",
    "date": currentDay + "." + currentMonth + "." + currentYear,
    "description": [
      {
        "type": "text",
        "content": "Это описание новой новости."
      },
      {
        "type": "image",
        "src": "media/prikazz.jpg"
      }
    ]
  };

  newsData.news.push(newNews);

  const xhr = new XMLHttpRequest();
  let formData = new FormData();
  xhr.open('POST', `${domain}/api/news.php`, true);
  formData.append('AUTH_TOKEN', authToken);
  formData.append('NEWS', 'ADD');
  formData.append('DATA', JSON.stringify(newsData));
  xhr.send(formData);

  xhr.onload = function() {
      if (xhr.status === 200) {
          setLoader(false);
          const json = JSON.parse(xhr.responseText);     

          if (json.hasOwnProperty("success") && json.success) {
            newsWrapper.insertAdjacentHTML('afterbegin', `

                <div class="news-item">
                  <div class="preview-news">
                      <img src="${domain}/db/news/media/prikazz.jpg" alt="">
                  </div>
                  <p class="news-description">Это описание новой новости.</p>

                  <img class="button-edit" src="src/icons/edit_4mw0jaq74bvt.svg" alt="">
                  <img class="button-delete" src="src/icons/delete_18aqyvqiawhe.svg" alt="">
                </div>
            `);

            return true;

          } else {

            alert(json.message);
            return false;

          }
          
      } else {
          alert('Сервер временно не доступен! Подробнее: info@example.ru');
      }

  }

  xhr.onerror = function() {
      if (xhr.status === 0) {
          alert('Сервер временно не доступен! Подробнее: info@example.ru');
      } else {
          alert('Произошла ошибка при запросе. Статус: ' + xhr.status + ', Подробности: ' + xhr.statusText);
      }
  };
}

  