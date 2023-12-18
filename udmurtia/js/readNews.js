
async function readNews(page = 1) {
    setLoader(true, `Загрузка новостей, страница: №${page}`);
    try {
        const response = await fetch(`${domain}/api/news/read.php?page=${page}&apiKey=${apiKey}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`Произошла ошибка при запросе. Статус: ${response.status}, Подробности: ${response.statusText}`);
        }
        
        const json = await response.json();
        viewNews(JSON.stringify(json));
        return true;

    } catch (error) {
        console.log("Ошибка чтения новостей:", error);
        return false;
    }
}

function viewNews(json){
    console.log(json);
}