document.addEventListener("DOMContentLoaded", () => {
    console.log("Home js loaded");
    const form = document.getElementById('filter-form');
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const search = document.getElementById('search').value;
        const category = document.getElementById('category').value;
        const data = {
            category: category,
            search: search
        };
        console.log(data);
        fetch(`../../app/controllers/eventController.php/?action=fetch_filtered`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                updateEventCards(data.events);
            })
            .catch(error => {
                console.error('Error fetching filtered events:', error);
            });
    });
});

function updateEventCards(events) {
    const container = document.querySelector('.container-fluid');

    const existingCards = document.querySelectorAll('.card');
    existingCards.forEach(card => {
        if (!card.closest('form')) {
            card.remove();
        }
    });

    if (events.length === 0) {
        const noEventsCard = document.createElement('div');
        noEventsCard.className = 'card';
        noEventsCard.innerHTML = `
        <div class="card-body">
          <p class="card-text">No events match your search criteria.</p>
        </div>
      `;
        container.appendChild(noEventsCard);
        return;
    }

    events.forEach(event => {
        const card = document.createElement('div');
        card.className = 'card';

        const isLoggedIn = document.querySelector('.action-btns') !== null;

        const actionButtons = isLoggedIn ? `
        <div class="action-btns position-absolute top-0 end-0 m-2">
          <button type="button" class="btn btn-sm btn-danger me-1" id="delete" 
            onclick="deleteEvent(${event.id})">Delete</button>
          <a href="./editEvent.php?id=${event.id}&title=${encodeURIComponent(event.title)}&location=${encodeURIComponent(event.location)}&date=${encodeURIComponent(event.date)}&category=${encodeURIComponent(event.category)}&description=${encodeURIComponent(event.description)}" 
            class="btn btn-sm btn-primary">Edit</a>
        </div>
      ` : '';

        card.innerHTML = `
        <div class="card-body">
          <h5 class="card-title">${event.title}</h5>
          <div class="event-date mb-2">
            ${new Date(event.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}
          </div>
          <div class="event-category mb-2">
            ${event.category}
          </div>
          <div class="event-location">
            ${event.location}
          </div>
          <p class="card-text">${event.description}</p>
          ${actionButtons}
        </div>
      `;

        container.appendChild(card);
    });
}

async function deleteEvent(id) {
    console.log(id);
    await fetch(`../../app/controllers/eventController.php/?action=delete_event`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ id: id })
    });
    location.reload();
}

const filterForm = document.getElementById('filter-form');
function clearFilters() {
    document.getElementById('search').value = '';
    document.getElementById('category').value = '';
    document.getElementById('filter-form').dispatchEvent(new Event('submit'));
}

if (filterForm) {
    const clearButton = document.createElement('button');
    clearButton.type = 'button';
    clearButton.textContent = 'Clear Filters';
    clearButton.className = 'btn btn-sm btn-secondary ms-2';
    clearButton.addEventListener('click', clearFilters);
    filterForm.appendChild(clearButton);
}