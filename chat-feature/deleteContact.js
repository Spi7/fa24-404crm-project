function deleteContact(contactEmail) {
    if (confirm('Are you sure you want to delete this contact?')) {
        fetch('delete_contact_backend.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: contactEmail })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the contact from the display
                const contactList = document.getElementById('contact-list');
                const contactItem = Array.from(contactList.children).find(item => 
                    item.textContent.includes(contactEmail) // Match based on email
                );
                if (contactItem) {
                    contactItem.remove(); // Remove the contact item from the list
                }
                // alert('Contact deleted successfully.');
            } else {
                alert('Error deleting contact: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}