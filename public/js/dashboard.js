
document.querySelectorAll('.sale-filter-option').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        const filter = event.target.getAttribute('data-filter');
        updateSalesCard(filter);
    });
});

document.querySelectorAll('.revenue-filter-option').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        const filter = event.target.getAttribute('data-filter');
        updateRevenueCard(filter);
    });
});

document.querySelectorAll('.client-filter-option').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        const filter = event.target.getAttribute('data-filter');
        updateClientCard(filter);
    });
});

function updateSalesCard(filter) {
    // Update the card title
    let filterText = '';
    switch (filter) {
        case 'today':
            filterText = 'Today';
            break;
        case 'month':
            filterText = 'This Month';
            break;
        case 'year':
            filterText = 'This Year';
            break;
    }
    document.querySelector('.sale-card-title-span').textContent = `| ${filterText}`;

    // Make an AJAX request to fetch filtered data
    fetch(`/sales-filter?filter=${filter}`)
        .then(response => response.json())
        .then(data => {

            const percentageDiffElement = document.querySelector('.sale-card-body-diff');
            const percentageDiffSideElement = document.querySelector('.sale-card-body-diff-side');
            const nbSalesElement = document.querySelector('.sale-card-body');

            nbSalesElement.textContent = data.nbSales;
            percentageDiffElement.textContent = `${data.percentageDiff}%`;

            if (data.percentageDiff >= 0) {
                percentageDiffElement.classList.remove('text-danger');
                percentageDiffElement.classList.add('text-success');

                percentageDiffSideElement.textContent = '+';
                percentageDiffSideElement.classList.remove('text-danger');
                percentageDiffSideElement.classList.add('text-success');

            } else {
                percentageDiffElement.classList.remove('text-success');
                percentageDiffElement.classList.add('text-danger');

                percentageDiffSideElement.textContent = '';
                percentageDiffSideElement.classList.remove('text-success');
                percentageDiffSideElement.classList.add('text-danger');
            }
        })
        .catch(error => console.error('Error fetching sales data:', error));
}

function updateRevenueCard(filter) {
    // Update the card title
    let filterText = '';
    switch (filter) {
        case 'today':
            filterText = 'Today';
            break;
        case 'month':
            filterText = 'This Month';
            break;
        case 'year':
            filterText = 'This Year';
            break;
    }
    document.querySelector('.revenue-card-title-span').textContent = `| ${filterText}`;

    // Make an AJAX request to fetch filtered data
    fetch(`/revenue-filter?filter=${filter}`)
        .then(response => response.json())
        .then(data => {
            const percentageDiffElement = document.querySelector('.revenue-card-body-diff');
            const percentageDiffSideElement = document.querySelector('.revenue-card-body-diff-side');
            const nbRevenuesElement = document.querySelector('.revenue-card-body');

            nbRevenuesElement.textContent = data.totalRevenue;
            percentageDiffElement.textContent = `${data.percentageDiff}%`;


            if (data.percentageDiff >= 0) {
                percentageDiffElement.classList.remove('text-danger');
                percentageDiffElement.classList.add('text-success');

                percentageDiffSideElement.textContent = '+';
                percentageDiffSideElement.classList.remove('text-danger');
                percentageDiffSideElement.classList.add('text-success');

            } else {
                percentageDiffElement.classList.remove('text-success');
                percentageDiffElement.classList.add('text-danger');

                percentageDiffSideElement.textContent = '';
                percentageDiffSideElement.classList.remove('text-success');
                percentageDiffSideElement.classList.add('text-danger');
            }
        })
        .catch(error => console.error('Error fetching revenue data:', error));
}

function updateClientCard(filter) {
    // Update the card title
    let filterText = '';
    switch (filter) {
        case 'today':
            filterText = 'Today';
            break;
        case 'month':
            filterText = 'This Month';
            break;
        case 'year':
            filterText = 'This Year';
            break;
    }
    document.querySelector('.client-card-title-span').textContent = `| ${filterText}`;

    // Make an AJAX request to fetch filtered data
    fetch(`/clients-filter?filter=${filter}`)
        .then(response => response.json())
        .then(data => {

            const percentageDiffElement = document.querySelector('.client-card-body-diff');
            const percentageDiffSideElement = document.querySelector('.client-card-body-diff-side');
            const nbClientsElement = document.querySelector('.client-card-body');

            nbClientsElement.textContent = data.nbClients;
            percentageDiffElement.textContent = `${data.percentageDiff}%`;

            if (data.percentageDiff >= 0) {
                percentageDiffElement.classList.remove('text-danger');
                percentageDiffElement.classList.add('text-success');

                percentageDiffSideElement.textContent = '+';
                percentageDiffSideElement.classList.remove('text-danger');
                percentageDiffSideElement.classList.add('text-success');

            } else {
                percentageDiffElement.classList.remove('text-success');
                percentageDiffElement.classList.add('text-danger');

                percentageDiffSideElement.classList.remove('text-success');
                percentageDiffSideElement.classList.add('text-danger');
            }
        })
        .catch(error => console.error('Error fetching clients data:', error));
}

