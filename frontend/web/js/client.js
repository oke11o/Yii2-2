if (!window.WebSocket) {
    alert("Ваш браузер не поддерживает веб-соккеты!");
}

var addrSite = "ws://task.local:8080?channel=" + channel;
var webSocket = new WebSocket(addrSite);
var chatForm = document.getElementById("chat_form_btn");
if (chatForm) {
    chatForm.addEventListener('click', function(event) {
            var textMessage = {
                message: document.getElementById("chat-msg").value,
                user: document.getElementById("chat_username").value,
                channel: document.getElementById("chat-channel").value,
                user_id: document.getElementById("chat-user_id").value,
            };
            console.log(textMessage);
            webSocket.send(JSON.stringify(textMessage));
            event.preventDefault();
            return false;
        });
}

webSocket.onmessage = function(event) {
    var data = JSON.parse(event.data);
    var messageContainer = document.createElement('p');
    messageContainer.innerHTML = data.user + "<br>" + data.message + "<br>";
    document.getElementById("root_chat").appendChild(messageContainer);
}