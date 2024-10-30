<div class="contacts">
    <div class="mobile-back-btn">
        <button type="button" onclick="window.history.back()">← Back</button>
    </div>

    <h3>
        Contacts
        <input type="text" placeholder="Search" id="searchInput">
    </h3>
    <ul id="contact-list">
        <?php if (isset($contacts) && $contacts->num_rows > 0): ?>
            <?php while ($contact = $contacts->fetch_assoc()): ?>
            <!-- Pass in both the coontact's nickname and email for display and chat history -->
                <li class="contact-item" onclick="openChat('<?= htmlspecialchars($contact['CONTACT_NICKNAME']) ?>', '<?= htmlspecialchars($contact['CONTACT_USER_ID']) ?>','<?= htmlspecialchars($contact['CONTACT_EMAIL']) ?>')">
                    <img src="../img/user profile icon.png" alt="other user profile" class="profile-pic" />
                    <div>
                    <span class="contact-nickname"><?= htmlspecialchars($contact['CONTACT_NICKNAME']) ?></span><br>
                    <span class="contact-email"><?= htmlspecialchars($contact['CONTACT_EMAIL']) ?></span>
                    </div>
                    <button class="delete-contact-btn" onclick="deleteContact(event,'<?= htmlspecialchars($contact['CONTACT_EMAIL']) ?>')">X</button>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li id="no-contacts-message">No contacts found.</li>
        <?php endif; ?>
    </ul>
    <div id="addContactInput" class="hide">
        <input id="addContactEmail" type="email" placeholder="enter contact email">
        <button id="cancelAddContact" onclick="cancelAddNewContactInput()">cancel</button>
    </div>
    <button class="add-contact-btn" onclick="addNewContact()">+ Add Contact</button>

</div>