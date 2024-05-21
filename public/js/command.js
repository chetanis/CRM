document.addEventListener("DOMContentLoaded", function() {
    const productSearchInput = document.getElementById('product-search');
    const quantityInput = document.getElementById('quantity-input');
    const addProductBtn = document.getElementById('add-product-btn');
    const selectedProductsList = document.getElementById('selected-products-list');
    const payment_method = document.getElementById('payment_method');
    payment_method.addEventListener('change', function() {
        calculateTotalPrice();
    });

    addProductBtn.addEventListener('click', function() {
        const productName = productSearchInput.value.trim();
        const quantity = parseInt(quantityInput.value);
        const selectedOption = document.querySelector(`#products option[value="${productName}"]`);

        if (!productName || isNaN(quantity) ||quantity <= 0 || !selectedOption) {
            alert('Veuillez sélectionner un produit et entrer une quantité valide.');
            return;
        }
        const productPrice = parseFloat(selectedOption.dataset
        .price); // Retrieve price from dataset
        const productId = selectedOption.dataset.id;

        // Check if the product is already selected
        const existingProduct = document.querySelector(
            `#selected-products-list li[data-name="${productName}"]`);
        if (existingProduct) {
            const existingQuantity = parseInt(existingProduct.dataset.quantity);
            existingProduct.dataset.quantity = existingQuantity + quantity;
            existingProduct.textContent =
                `${productName} - Quantité: ${existingProduct.dataset.quantity}`;
            // Create delete button
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Supprimer';
            deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'mx-5', );
            deleteButton.addEventListener('click', function() {
                existingProduct.remove();
                calculateTotalPrice()
            });

            // Append delete button to list item
            existingProduct.appendChild(deleteButton);

        } else {
            const listItem = document.createElement('li');
            listItem.dataset.name = productName;
            listItem.dataset.quantity = quantity;
            listItem.dataset.price = productPrice;
            listItem.dataset.id = productId;
            listItem.textContent = `${productName} - Quantité: ${quantity}`;
            selectedProductsList.appendChild(listItem);
            // Create delete button
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Supprimer';
            deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'mx-5', );
            deleteButton.addEventListener('click', function() {
                listItem.remove();
                calculateTotalPrice()
            });

            // Append delete button to list item
            listItem.appendChild(deleteButton);
            listItem.classList.add('mt-1');

            // Append list item to selected products list
            selectedProductsList.appendChild(listItem);
        }
        calculateTotalPrice();

        // Reset fields
        productSearchInput.value = '';
        quantityInput.value = '';
    });
    function calculateTotalPrice() {
            let totalPrice = 0;
            const selectedProducts = document.querySelectorAll('#selected-products-list li');
            selectedProducts.forEach(product => {
                const quantity = parseInt(product.dataset.quantity);
                const price = parseFloat(product.dataset.price);
                totalPrice += quantity * price;
            });
            let totalPriceTTC = totalPrice;
            let tva = totalPrice * 0.19;
            totalPriceTTC += tva;
            const payment_method = document.getElementById('payment_method').value;
            if (payment_method === 'Espèce') {
                totalPriceTTC = totalPriceTTC*1.01;
            }
            document.getElementById('total-price').textContent =
                `Prix HT : ${totalPrice.toFixed(2)} DA`;
            document.getElementById('total-price-ttc').textContent =
                `Prix TTC : ${totalPriceTTC.toFixed(2)} DA`;
    }
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.addEventListener('click', function() {
        const clientSearchInput = document.getElementById('client-search');
        const selectedOption = document.querySelector(`#clients option[value="${clientSearchInput.value}"]`);

        if (!selectedOption) {
            alert('Veuillez sélectionner un client.');
            return;
        }
        const client = selectedOption.dataset.id;
        const products = [];
        const selectedProducts = document.querySelectorAll('#selected-products-list li');
        if (selectedProducts.length === 0) {
            alert('Veuillez ajouter des produits.');
            return;
        }
        selectedProducts.forEach(product => {
            const productId = product.dataset.id;
            const quantity = parseInt(product.dataset.quantity);
            products.push({
                id: productId,
                quantity: quantity,
            });
        });
        const data = {
            client,
            products: products,
            payment_method: payment_method.value,
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/add-command', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, 
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
            if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});