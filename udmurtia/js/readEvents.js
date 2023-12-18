async function readEvents(page = 1) {
    setLoader(true, `Загрузка мероприятий, страница: №${page}`);
    try {
        const response = await fetch(`${domain}/api/events/read.php?page=${page}&apiKey=${apiKey}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`Произошла ошибка при запросе. Статус: ${response.status}, Подробности: ${response.statusText}`);
        }
        
        const json = await response.json();
        viewEvents(json);
        return true;

    } catch (error) {
        console.log("Ошибка чтения мероприятий:", error);
        return false;
    }
}

const eventsActual = document.querySelector('.events-actual');
const eventsNews = document.querySelector('.events-news');
const eventsPublished = document.querySelector('.events-published');
const eventsHidden = document.querySelector('.events-hidden');
const eventsCompleted = document.querySelector('.events-completed');

function viewEvents(json) {
    json.events.forEach((event, index) => {
        const imagesHtml = event.images.map((image) => {
            return `<img src="/udmurtia/${image}" alt="">`;
        }).join('');

        const buttonsHtml = getButtonsHtml(event);

        const string = `
        <div class="events-item">
            <div class="events-item-img"><img src="/udmurtia/${event.images[0]}"></div>
            <div class="events-item-info-wrapper">
                <div class="events-item-title">${event.title}</div>
                <div class="events-item-info">${event.category_name} | ${formatDate(event.start_date)}, ${event.start_time}</div>
                <div class="events-item-buttons-wrapper">
                    ${buttonsHtml}
                </div>
            </div>
        </div>`;

        // if (index < 3) eventsActual.insertAdjacentHTML("beforeend", string);

        switch (event.status) {
            case 'new':
                eventsNews.insertAdjacentHTML("afterbegin", string);
                break;
            case 'published':
                eventsPublished.insertAdjacentHTML("afterbegin", string);
                break;
            case 'hidden':
                eventsHidden.insertAdjacentHTML("afterbegin", string);
                break;
            case 'completed':
                eventsCompleted.insertAdjacentHTML("afterbegin", string);
                break;
            default:
                break;
        }
    });
}

function getButtonsHtml(event) {
    let buttonsHtml = '';
    
    switch (event.status) {
        case 'new':
            buttonsHtml = `
                <div class="events-item-button button-event-edit">Редактировать</div>
                <div class="events-item-button button-event-hide">Скрыть</div>
                <div class="events-item-button button-event-delete">Удалить</div>
                <div class="events-item-button button-event-send">Опубликовать</div>`;
            break;
        case 'published':
            buttonsHtml = `
                <div class="events-item-button button-event-edit">Редактировать</div>
                <div class="events-item-button button-event-hide">Скрыть</div>
                <div class="events-item-button button-event-delete">Удалить</div>
                `;
            break;
        case 'hidden':
            buttonsHtml = `
                <div class="events-item-button button-event-edit">Редактировать</div>
                <div class="events-item-button button-event-show">Показать</div>
                <div class="events-item-button button-event-delete">Удалить</div>`;
            break;
        case 'completed':
            buttonsHtml = 
                `
                <div class="events-item-button button-event-edit">Редактировать</div>
                <div class="events-item-button button-event-show">Показать</div>
                <div class="events-item-button button-event-delete">Удалить</div>
                `;
            break;
        default:
            break;
    }

    return buttonsHtml;
}
