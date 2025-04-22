<!-- Chatbot Button -->
<button id="chatbot-btn">
        <img src="{{ asset('assets/img/whitelogo.png') }}" alt="Chatbot Logo">
    </button>

    <!-- Chatbot Window -->
    <div id="chatbot-container">
        <div id="chatbot-header">ARKILA Support Agent</div>
        <div id="chatbot-messages"></div>
        <div id="chatbot-input">
            <input type="text" id="chatbot-text" placeholder="Type a message...">
            <button id="chatbot-send">Send</button>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------------- -->

    @include('partials.chatbot')