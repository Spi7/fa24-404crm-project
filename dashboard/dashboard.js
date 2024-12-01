function expandCard(card) {
    // Disable clicking to expand the card again
    card.style.pointerEvents = 'none'; // Disable further clicks on the card

    // Create an overlay element
    const overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    const buttons = card.querySelectorAll('.actions button');
    buttons.forEach(button => button.style.display = 'none'); // Hide buttons when expanding

    // Create a new expanded card
    const expandedCard = document.createElement('div');
    expandedCard.classList.add('expanded-card');

    // Clone the contents of the clicked card into the expanded card
    const clonedContent = card.cloneNode(true);
    clonedContent.querySelector('.expanded-content').style.display = 'block';
    expandedCard.appendChild(clonedContent);

    // Add a close button to the expanded card
    const closeBtn = document.createElement('button');
    closeBtn.classList.add('close-btn');
    closeBtn.textContent = 'X';
    closeBtn.onclick = () => closeCard(expandedCard, overlay, card);
    expandedCard.appendChild(closeBtn);

    // Append the expanded card to the body
    document.body.appendChild(expandedCard);
}

function closeCard(expandedCard, overlay, originalCard) {
    // Re-enable clicking on the original card
    originalCard.style.pointerEvents = 'auto'; // Allow the card to be clicked again

    // Show the buttons again
    const buttons = originalCard.querySelectorAll('.actions button');
    buttons.forEach(button => button.style.display = 'inline-block');

    // Remove the expanded card and overlay
    expandedCard.remove();
    overlay.remove();
}

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.actions button');
    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent card expansion when clicking buttons
        });
    });
});
