const searchInput = document.getElementById('searchInput');
const contactList = document.getElementById('contact-list');
let contacts = Array.from(contactList.getElementsByClassName('contact-item'));

// Function to filter contacts based on search input
function filterContacts() {
    const searchTerm = searchInput.value.toLowerCase(); // Get the input value

    // Show all contacts if the search term is empty
    if (!searchTerm) {
        contacts.forEach(contact => {
            contact.style.display = 'flex'; // Show all contacts
        });
        return; // Exit the function
    }

    // Filter contacts based on the search term
    let foundMatch = false; // Flag to check if any contact matches
    contacts.forEach(contact => {
        const contactName = contact.querySelector('.contact-nickname').textContent.toLowerCase(); // Get contact name
        const contactEmail = contact.querySelector('.contact-email').textContent.toLowerCase(); // Get contact email

        // Show contact if the name or email matches the search term
        if (contactName.includes(searchTerm) || contactEmail.includes(searchTerm)) {
            contact.style.display = 'flex'; // Show matching contact
            foundMatch = true;
        } else {
            contact.style.display = 'none'; // Hide non-matching contact
        }
    });
}

// Add event listener to the search input
searchInput.addEventListener('input', filterContacts);