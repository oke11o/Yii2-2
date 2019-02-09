if (!window.WebSocket) {
    alert("Ваш браузер не поддерживает веб-соккеты!");
}

var taskId = document.getElementById("taskId").innerHTML;
var addrSite = "ws://test:8080/";
var webSocket = new WebSocket(addrSite);
var chatForm = document.getElementById("chat_form_btn");
if (chatForm) {
    chatForm.addEventListener('click', function(event) {
            var textMessage = {
                "message": document.getElementById("chat-msg").value,
                "user": document.getElementById("chat_username").value,
                "task_id": document.getElementById("chat-task_id").value,
                "user_id": document.getElementById("chat-user_id").value,
            };
            webSocket.send(JSON.stringify(textMessage));
            event.preventDefault();
            return false;
        });
}

webSocket.onmessage = function(event) {
    var data = JSON.parse(event.data);
    if (data.task_id == taskId) {
        var messageContainer = document.createElement('p');
        messageContainer.innerHTML = data.user + "<br>" + data.message + "<br>";
        document.getElementById("root_chat").appendChild(messageContainer);
    }
}