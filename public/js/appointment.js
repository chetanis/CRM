document.addEventListener("DOMContentLoaded", function() {
    const createAppointmentButton = document.getElementById("submit-btn");
    const dateAndTimeInput = document.getElementById("date_and_time");
    const detailsInput = document.getElementById("details");

    createAppointmentButton.addEventListener('click', function () {
        const clientSearchInput = document.getElementById('client-search');
        const selectedOption = document.querySelector(`#clients option[value="${clientSearchInput.value}"]`);
        const dateAndTime = dateAndTimeInput.value;
        const details = detailsInput.value;

        if (!selectedOption) {
            alert('Veuillez sélectionner un client.');
            return;
        }

        if (!dateAndTime) {
            alert("Veuillez sélectionner une date.");
            return;
        }

        
        // Verifie if the date is correct 
        var currentDate = new Date();
        var selectedDate = new Date(dateAndTime);
        if (selectedDate < currentDate) {
            alert('Veuillez sélectionner une date valide.');
            return;
        }
        if (!details) {
            alert('Veuillez saisir les détails du rendez-vous.');
            return;
        }
        const clientId = selectedOption.dataset.id;
        const data = {
            client : clientId,
            date : selectedDate,
            purpose : details,
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/add-appointment', {
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
