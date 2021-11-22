export function uppercaseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export function paginate(currentPage, lastPage, perEnd = 2) {
    let pages = [];

    let minPage = currentPage - perEnd;
    while (minPage <= 1) {
        minPage++;
    }
    let maxPage = minPage + 2 * perEnd;
    while (maxPage >= lastPage) {
        maxPage--;
        if (minPage - 1 > 1) {
            minPage--;
        }
    }

    // Special cases
    if (minPage === 2 && maxPage < lastPage - 1) {
        maxPage++;
    }
    if (minPage === 3) {
        minPage--;
    }
    if (maxPage === lastPage - 1 && minPage > 2) {
        minPage--;
    }
    if (maxPage === lastPage - 2) {
        maxPage++;
    }
    for (let page = minPage; page <= maxPage; page++) {
        pages.push(page);
    }

    return {
        pages,
        nextPage: currentPage < lastPage ? currentPage + 1 : null,
        previousPage: currentPage > 1 ? currentPage - 1 : null,
    };
}
