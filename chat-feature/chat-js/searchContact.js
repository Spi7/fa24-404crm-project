const searchInput = document.getElementById('searchInput');
const contactList = document.getElementById('contact-list');
let contacts = Array.from(contactList.getElementsByClassName('contact-item'));
const contactsListEl = document.querySelector("#search-results-contacts-list")
const messageListEl = document.querySelector("#search-results-messages-list")

// Function to filter contacts based on search input
function search() {
    const searchTerm = searchInput.value;
    if (searchTerm != "") {
        //hide contacts show search results
        document.querySelector("#contact-list").classList.add("hide")
        document.querySelector("#contact-search-results").classList.remove("hide")
        fetch(`search.php?q=${searchTerm}`)
            .then(res => res.json())
            .then(json => {
                console.log(json)
                if (json.contacts) {
                    contactsListEl.innerHTML = ``
                    json.contacts.forEach(contact => {
                        contactsListEl.innerHTML += `<li class="contact-item" onclick="openChat('${contact.CONTACT_NICKNAME}', '${contact.CONTACT_USER_ID}','${contact.CONTACT_EMAIL}')">
                    <img src="../img/user profile icon.png" alt="other user profile" class="profile-pic" />
                    <div>
                    <span class="contact-nickname">${contact.CONTACT_NICKNAME}</span><br>
                    <span class="contact-email">${contact.CONTACT_EMAIL}</span>
                    </div>
                    <button class="delete-contact-btn" onclick="deleteContact(event,'${contact.CONTACT_EMAIL}')">X</button>
                    </li>`
                    });
                }
                if (json.messages) {
                    messageListEl.innerHTML = ``
                    //figure out the blank fields in open chat tommorow
                    json.messages.forEach(message => {
                        //if our id is the sender of the message the open id should be set to the recipient
                        if(json.CurrUserID == message.CURRENT_USER_ID ){
                            chatOpenId = message.CHAT_USER_ID
                            chatDir="you to "+message.NICKNAME
                        } else {
                        //if our id is the recipient of the message the open id should be set to the sender
                            chatOpenId = message.CURRENT_USER_ID
                            chatDir=message.NICKNAME+" to you"
                        }
                        messageListEl.innerHTML += `<li class="message-item" onclick="openChat('${message.NICKNAME}', '${chatOpenId}','${message.EMAIL}')">
                        <img src="../img/user profile icon.png" alt="other user profile" class="profile-pic" />
                    <div>
                    <span class="message-nickname">${chatDir}</span><br>
                    <span class="message-search-content">${message.CONTENT}</span>
                    </div>
                    </li>`
                    });
                }
            })

    } else {
        document.querySelector("#contact-list").classList.remove("hide")
        document.querySelector("#contact-search-results").classList.add("hide")
    }
}

// Add event listener to the search input
searchInput.addEventListener('input', search);
