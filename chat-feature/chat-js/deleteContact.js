function deleteContact(contactEmail) {
    let noContactsMessage = document.getElementById('no-contacts-message');
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
                //when last contact is removed from the list, no contacts found would appear in the list again
                if (contactList.children.length === 1 && noContactsMessage) {
                    noContactsMessage.style.display = 'block';
                }
                disableChat();
                
                //at this point the contact should already be removed from the contactlist
            } else {
                alert('Error deleting contact: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function disableChat() {
    if (window.innerWidth <= 768) {
        document.querySelector('.contacts').style.display = 'block';
        document.querySelector('.chat-interface').style.display = 'none';
    }
    // Disable message input
    const messageInput = document.getElementById('message-input');
    if (messageInput) {
        messageInput.value = "";
        messageInput.disabled = true;
    }

    // Disable send button
    const sendButton = document.querySelector('.send-btn');
    if (sendButton) {
        sendButton.disabled = true;
    }

    // Update chat header to reflect disabled state
    const chatHeaderText = document.getElementById('chat-header-text');
    if (chatHeaderText) {
        chatHeaderText.textContent = "Select a contact to start chatting";
    }
}