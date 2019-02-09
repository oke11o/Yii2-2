<?php
namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use common\models\tables\Chat;

class SocketServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
        echo "Server started\n";
    }

    function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection: {$conn->resourceId}\n";
    }

    function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "user {$conn->resourceId} disconnect\n";
    }

    function onError(ConnectionInterface $conn, \Exception $e) {
        echo "\nconnection {$conn->resourceId} close with error\n";
        $conn->close();
        $this->clients->detach($conn);
    }

    function onMessage(ConnectionInterface $from, $msg) {
        echo "{$from->resourceId}: {$msg}\n";
        foreach($this->clients as $client) {
            $client->send($msg);
        }

        $msgChat = json_decode($msg);
        $chatMessage = new Chat([
            'task_id' => $msgChat->task_id,
            'user_id' => $msgChat->user_id,
            'msg' => $msgChat->message
        ]);
        $chatMessage->save();
    }
}