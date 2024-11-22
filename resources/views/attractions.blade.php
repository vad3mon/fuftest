<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions</title>
</head>
<body>
<h1>Attractions</h1>
<button onclick="document.getElementById('createForm').style.display='block'">Add Attraction</button>

<div id="createForm" style="display:none;">
    <h2>Add New Attraction</h2>
    <form id="attractionForm">
        <input type="text" id="name" placeholder="Name" required>
        <input type="text" id="description" placeholder="Description">
        <input type="text" id="location" placeholder="Location" required>
        <button type="submit">Create</button>
    </form>
</div>

<h2>List of Attractions</h2>
<ul id="attractionList"></ul>

<script>
    const token = localStorage.getItem('token');

    // Fetch attractions
    async function fetchAttractions() {
        const response = await fetch('/api/attractions', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        const attractions = await response.json();
        const list = document.getElementById('attractionList');
        list.innerHTML = '';
        attractions.forEach(attraction => {
            const li = document.createElement('li');
            li.textContent = `${attraction.name} - ${attraction.location}`;
            list.appendChild(li);
        });
    }

    // Create new attraction
    document.getElementById('attractionForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const description = document.getElementById('description').value;
        const location = document.getElementById('location').value;

        await fetch('/api/attractions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ name, description, location })
        });

        fetchAttractions();
        document.getElementById('createForm').style.display = 'none';
    });

    // Initial fetch
    fetchAttractions();
</script>
</body>
</html>
