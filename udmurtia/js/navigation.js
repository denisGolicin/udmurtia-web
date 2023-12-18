const navigationUserButton = document.querySelector('.navigation-user-button');
const navigationUserItem = document.querySelectorAll('.navigation-user-item');

const navigationNewsButton = document.querySelector('.navigation-news-button');
const navigationNewsItem = document.querySelectorAll('.navigation-news-item');

const navigationEventsButton = document.querySelector('.navigation-events-button');
const navigationEventsItem = document.querySelectorAll('.navigation-events-item');

const navigationGamesButton = document.querySelector('.navigation-games-button');
const navigationGamesItem = document.querySelectorAll('.navigation-games-item');

const navigationMainButton = document.querySelector('.navigation-main-button');
const navigationNotificationsButton = document.querySelector('.navigation-notifications-button');
const navigationShopButton = document.querySelector('.navigation-shop-button');
const navigationTransactionButton = document.querySelector('.navigation-transaction-button');
const navigationPredictionsButton = document.querySelector('.navigation-prediction-button');
const navigationLevelsButton = document.querySelector('.navigation-levels-button');
const navigationMemesButton = document.querySelector('.navigation-memes-button');

const navigationToolsButton = document.querySelector('.navigation-tools-button');


let isActiveNavigation = {
    main: false,
    user: false,
    news: false,
    events: false,
    games: false,
    notification: false,
    shop: false,
    transaction: false,
    prediction: false, 
    levels: false,
    memes: false,


    tools: false
};

let showNavigationKey = 'main';
let showNavigationButton = navigationMainButton;
let showNavigationItem = [];

navigationMainButton.addEventListener('click', () => dropMenu(navigationMainButton, null, 'main'));
navigationUserButton.addEventListener('click', () => dropMenu(navigationUserButton, navigationUserItem, 'user'));
navigationNewsButton.addEventListener('click', () => dropMenu(navigationNewsButton, navigationNewsItem, 'news'));
navigationEventsButton.addEventListener('click', () => dropMenu(navigationEventsButton, navigationEventsItem, 'events'));
navigationGamesButton.addEventListener('click', () => dropMenu(navigationGamesButton, navigationGamesItem, 'games'));
navigationNotificationsButton.addEventListener('click', () => dropMenu(navigationNotificationsButton, null, 'notification'));
navigationShopButton.addEventListener('click', () => dropMenu(navigationShopButton, null, 'shop'));
navigationTransactionButton.addEventListener('click', () => dropMenu(navigationTransactionButton, null, 'transaction'));
navigationPredictionsButton.addEventListener('click', () => dropMenu(navigationPredictionsButton, null, 'prediction'));
navigationLevelsButton.addEventListener('click', () => dropMenu(navigationLevelsButton, null, 'levels'));
navigationMemesButton.addEventListener('click', () => dropMenu(navigationMemesButton, null, 'memes'));

navigationToolsButton.addEventListener('click', () => dropMenu(navigationToolsButton, null, 'tools'));


function dropMenu(button, dropItem, key){

    isActiveNavigation[key] = !isActiveNavigation[key];
    
    let text = button.querySelector('p');
    let arrow;

    if(dropItem != null){
        arrow = button.querySelector('.navigation-icon-arrow');
        arrow.style.transform = 'translate(-100%, -50%) ' + ((isActiveNavigation[key]) ? 'rotate(180deg)' : 'rotate(0deg)');
        dropItem.forEach(function(item, index) {
            item.style.height = (isActiveNavigation[key]) ? '5%' : '0';
        });
    }

    text.style.color = (isActiveNavigation[key]) ? '#781EB4' : 'black';
    button.style.backgroundColor = (isActiveNavigation[key]) ? '#F0F4FE' : '#ffffff00';

    if(showNavigationButton == button){
        showNavigationButton = null;
        showNavigationItem = null;
        showNavigationKey = null;
    } else if(showNavigationButton){

        if(showNavigationItem != null){
            arrow = showNavigationButton.querySelector('.navigation-icon-arrow');
            if(arrow) {
                arrow.style.transform = 'translate(-100%, -50%) rotate(0deg)';
                showNavigationItem.forEach(function(item, index) {
                    item.style.height = '0';
                });
            }
        }
        
        text = showNavigationButton.querySelector('p');
        showNavigationButton.style.backgroundColor = '#ffffff00';
        text.style.color = 'black';
        isActiveNavigation[showNavigationKey] = false;
    }

    showNavigationButton = button;
    showNavigationItem = dropItem;
    showNavigationKey = key;

    const newUrl = window.location.href.split('?')[0] + "?page=" + key;
    history.pushState({}, '', newUrl);
};


const windowMain = document.querySelector('.window-main');
const windowUsers = document.querySelector('.window-users');
const windowNews = document.querySelector('.window-news');
const windowEvents = document.querySelector('.window-events');
const windowGames = document.querySelector('.window-games');
const windowNotifications = document.querySelector('.window-notifications');
const windowShop = document.querySelector('.window-shop');
const windowTransaction = document.querySelector('.window-transaction');
const windowPredictions = document.querySelector('.window-predictions');
const windowLevels = document.querySelector('.window-levels');
const windowMemes = document.querySelector('.window-memes');

const windowTools = document.querySelector('.window-tools');

navigationMainButton.addEventListener('click', () => openWindow(windowMain));
navigationUserButton.addEventListener('click', () => openWindow(windowUsers));
navigationNewsButton.addEventListener('click', () => openWindow(windowNews));
navigationEventsButton.addEventListener('click', () => openWindow(windowEvents));
navigationGamesButton.addEventListener('click', () => openWindow(windowGames));
navigationNotificationsButton.addEventListener('click', () => openWindow(windowNotifications));
navigationShopButton.addEventListener('click', () => openWindow(windowShop));
navigationTransactionButton.addEventListener('click', () => openWindow(windowTransaction));
navigationPredictionsButton.addEventListener('click', () => openWindow(windowPredictions));
navigationLevelsButton.addEventListener('click', () => openWindow(windowLevels));
navigationMemesButton.addEventListener('click', () => openWindow(windowMemes));

navigationToolsButton.addEventListener('click', () => openWindow(windowTools));

let activeWindow = windowMain;
windowMain.style.display = 'flex';


function openWindow(window){
    if(activeWindow == window) return;

    activeWindow.style.display = 'none';
    window.style.display = 'flex';

    activeWindow = window;
    
}

let url = new URL(window.location.href);
let params = new URLSearchParams(url.search);
let paramPage = params.get('page');
const pageActions = {
    'main': [navigationMainButton, null, windowMain],
    'user': [navigationUserButton, navigationUserItem, windowUsers],
    'news': [navigationNewsButton, navigationNewsItem, windowNews],
    'events': [navigationEventsButton, navigationEventsItem, windowEvents],
    'games': [navigationGamesButton, navigationGamesItem, windowGames],
    'notification': [navigationNotificationsButton, null, windowNotifications],
    'shop': [navigationShopButton, null, windowShop],
    'transaction': [navigationTransactionButton, null, windowTransaction],
    'prediction': [navigationPredictionsButton, null, windowPredictions],
    'levels': [navigationLevelsButton, null, windowLevels],
    'memes': [navigationMemesButton, null, windowMemes],
    'tools': [navigationToolsButton, null, windowTools]
};

if (paramPage && pageActions[paramPage]) {
    const [button, dropItem, window] = pageActions[paramPage];
    dropMenu(button, dropItem, paramPage);
    openWindow(window);
} else {
    dropMenu(navigationMainButton, null, 'main');
    openWindow(windowMain);
}


const windowButtons = {
    news: document.querySelector('.events-button-news'),
    published: document.querySelector('.events-button-published'),
    hidden: document.querySelector('.events-button-hidden'),
    completed: document.querySelector('.events-button-completed'),
    category: document.querySelector('.events-button-category'),
    district: document.querySelector('.events-button-district')
};

const innerWindows = {
    news: document.querySelector('.events-news'),
    published: document.querySelector('.events-published'),
    hidden: document.querySelector('.events-hidden'),
    completed: document.querySelector('.events-completed'),
    category: document.querySelector('.events-category'),
    district: document.querySelector('.events-district'),
};

let activeWindowChild = innerWindows.news;

activeWindowChild.style.display = 'flex';

for (const type in windowButtons) {
    if (windowButtons.hasOwnProperty(type)) {
        windowButtons[type].addEventListener('click', () => openWindowChild(type));
    }
}

function openWindowChild(type) {
    if (!type || !innerWindows[type]) return;

    if (activeWindowChild === innerWindows[type]) return;

    activeWindowChild.style.display = 'none';
    innerWindows[type].style.display = 'flex';

    activeWindowChild = innerWindows[type];
}

