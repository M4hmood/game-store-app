document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector('.store-search input');
    const checkboxList = document.querySelector('.checkbox-list');
    const gameCards = document.querySelectorAll('.game-card');
    
    // Dynamically generate genre checkboxes based on what's currently rendered
    if (checkboxList && gameCards.length > 0) {
        const genres = new Set();
        gameCards.forEach(card => {
            const desc = card.querySelector('.game-card-desc');
            if (desc) genres.add(desc.textContent.trim());
        });

        // Clear the hardcoded boxes
        checkboxList.innerHTML = '';
        
        genres.forEach(genre => {
            const label = document.createElement('label');
            label.className = 'checkbox-item';
            label.style.display = 'block';
            label.style.marginBottom = '5px';
            label.style.color = 'var(--text-secondary)';
            label.style.cursor = 'pointer';
            
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.value = genre;
            input.className = 'genre-filter';
            input.style.marginRight = '8px';
            
            label.appendChild(input);
            label.appendChild(document.createTextNode(genre));
            
            checkboxList.appendChild(label);
        });
    }

    // Filter Logic
    const filterGames = () => {
        let searchTerm = '';
        if (searchInput) {
            searchTerm = searchInput.value.toLowerCase();
        }

        const checkedCheckboxes = document.querySelectorAll('.genre-filter:checked');
        const checkedGenres = Array.from(checkedCheckboxes).map(cb => cb.value);

        let gamesVisible = 0;

        gameCards.forEach(card => {
            const titleEl = card.querySelector('.game-card-title');
            const descEl = card.querySelector('.game-card-desc');
            
            if (!titleEl || !descEl) return;

            const title = titleEl.textContent.toLowerCase();
            const desc = descEl.textContent;

            const matchesSearch = title.includes(searchTerm);
            const matchesGenre = checkedGenres.length === 0 || checkedGenres.includes(desc);

            if (matchesSearch && matchesGenre) {
                card.style.display = 'block';
                gamesVisible++;
            } else {
                card.style.display = 'none';
            }
        });

        // Optional: show a message if zero games found
        let noResultsMsg = document.getElementById('no-results');
        if (gamesVisible === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('p');
                noResultsMsg.id = 'no-results';
                noResultsMsg.style.color = 'white';
                noResultsMsg.style.gridColumn = '1 / -1';
                noResultsMsg.textContent = 'No games match your search parameters.';
                document.querySelector('.games-grid').appendChild(noResultsMsg);
            } else {
                noResultsMsg.style.display = 'block';
            }
        } else if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
        }
    };

    if (searchInput) {
        searchInput.addEventListener('input', filterGames);
    }
    
    // Use event delegation for dynamic checkboxes
    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('genre-filter')) {
            filterGames();
        }
    });
});
