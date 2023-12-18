function formatDate(inputDate) {
    const months = [
        'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
        'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
    ];

    const dateParts = inputDate.split('-');
    const year = dateParts[0];
    const month = parseInt(dateParts[1], 10);
    const day = parseInt(dateParts[2], 10);

    const monthName = months[month - 1];

    return `${day} ${monthName} ${year}`;
}


const formattedDate = formatDate('2023-04-15');
console.log(formattedDate); 