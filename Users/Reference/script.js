document.addEventListener('DOMContentLoaded', () => {
    const rowsPerPage = 10;
    let currentPage = 1;
    let data = [];
    let defaultData = [];

    const tableBody = document.querySelector('#dataTable tbody');
    const pageNumber = document.getElementById('pageNumber');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const addForm = document.getElementById('addForm');

    const sortNameBtn = document.getElementById('sortName');
    const sortAgeBtn = document.getElementById('sortAge');
    const sortDefaultBtn = document.getElementById('sortDefault');

    function displayPage(page) {
        tableBody.innerHTML = '';
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = data.slice(start, end);

        for (let row of pageData) {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${row.id}</td><td>${row.name}</td><td>${row.age}</td>`;
            tableBody.appendChild(tr);
        }

        pageNumber.textContent = page;
    }

    function updatePagination() {
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === Math.ceil(data.length / rowsPerPage);
    }

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayPage(currentPage);
            updatePagination();
        }
    });

    nextPageBtn.addEventListener('click', () => {
        if (currentPage < Math.ceil(data.length / rowsPerPage)) {
            currentPage++;
            displayPage(currentPage);
            updatePagination();
        }
    });

    addForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const age = document.getElementById('age').value;

        const id = data.length + 1;
        const newRow = { id, name, age };
        data.push(newRow);
        defaultData.push(newRow);

        addForm.reset();
        currentPage = Math.ceil(data.length / rowsPerPage);
        displayPage(currentPage);
        updatePagination();
    });

    sortNameBtn.addEventListener('click', () => {
        data.sort((a, b) => a.name.localeCompare(b.name));
        currentPage = 1;
        displayPage(currentPage);
        updatePagination();
    });

    sortAgeBtn.addEventListener('click', () => {
        data.sort((a, b) => a.age - b.age);
        currentPage = 1;
        displayPage(currentPage);
        updatePagination();
    });

    sortDefaultBtn.addEventListener('click', () => {
        data = [...defaultData];
        currentPage = 1;
        displayPage(currentPage);
        updatePagination();
    });

    // Initial load
    displayPage(currentPage);
    updatePagination();
});
