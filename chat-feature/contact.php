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
                <li class="contact-item" onclick="openChat('<?= htmlspecialchars($contact['CONTACT_NICKNAME']) ?>')">
                    <img src="../img/user profile icon.png" alt="other user profile" class="profile-pic" />
                    <span class="contact-nickname"><?= htmlspecialchars($contact['CONTACT_NICKNAME']) ?></span>
                    <span class="contact-email"><?= htmlspecialchars($contact['CONTACT_EMAIL']) ?></span>
                    <button class="delete-contact-btn" onclick="deleteContact('<?= htmlspecialchars($contact['CONTACT_EMAIL']) ?>')">X</button>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li id="no-contacts-message">No contacts found.</li>
        <?php endif; ?>
    </ul>
    <button class="add-contact-btn" onclick="addNewContact()">+ Add Contact</button>

</div>