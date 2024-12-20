<div class="chat-interface">
    <div class="chat-header">
        <div class="mobile-back-btn">
            <button type="button" onclick="goBack()">← Back</button>
        </div>
        <h3 id="chat-header-text">Select a contact to start chatting</h3>
    </div>
    <div class="chat-messages" id="chat-messages">
        <!-- Chat messages will appear here dynamically -->
    </div>
    <div class="chat-input">
        <input type="text" id="message-input" placeholder="Type a message" disabled>
        <input type="file" id="file-input" style="display:none;" accept="*">
        <button class="attach-btn" id="attach-btn" disabled onclick="document.getElementById('file-input').click();">
            <img src="../img/attachment.png" alt="Attach" class="attach-icon">
        </button>
        <button id="send-button" class="send-btn" disabled>Send</button>
    </div>
</div>