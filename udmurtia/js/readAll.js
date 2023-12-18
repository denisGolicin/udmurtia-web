readNews().then(result => {
    if (!result) alert(`Произошла ошибка при обновление новостей! Обратитесь в поддержку: ${supportEmail}`);
    setLoader(false);
});
readEvents().then(result => {
    if (!result) alert(`Произошла ошибка при обновление мероприятий! Обратитесь в поддержку: ${supportEmail}`);
    setLoader(false);
});