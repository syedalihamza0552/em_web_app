document.addEventListener("DOMContentLoaded", () => {
    console.log("Home js loaded");
})


async function deleteEvent(id) {
    console.log(id)
    await fetch(`../../app/controllers/eventController.php/?action=delete_event`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ id: id })
    })

    location.reload()
}

async function filterEvents(category, search) {
    const data = {
        category: category || "",
        search: search || ""
    }
    await fetch(`../../app/controllers/eventController.php/?action=fetch_filtered`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
}