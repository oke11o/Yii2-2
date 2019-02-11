<?php
namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use common\models\tables\Chat;

class SocketServer implements MessageComponentInterface {
    protected $clients = [];

    public function __construct() {
        echo "Server started\n";
    }

    private function getChannel($conn){
        $queryString = $conn->httpRequest->getUri()->getQuery();
        return explode("=", $queryString)[1];
    }

    function onOpen(ConnectionInterface $conn) {
        $channel = $this->getChannel($conn);
        $this->clients[$channel][$conn->resourceId] = $conn;
        echo "New connection: {$conn->resourceId}\n";
    }

    function onClose(ConnectionInterface $conn) {
        $channel = $this->getChannel($conn);
        unset($this->clients[$channel][$conn->resourceId]);
        echo "user {$conn->resourceId} disconnect\n";
    }

    function onError(ConnectionInterface $conn, \Exception $e) {
        echo "\nconnection {$conn->resourceId} close with error\n";
        $conn->close();
        $channel = $this->getChannel($conn);
        unset($this->clients[$channel][$conn->resourceId]);
    }

    function onMessage(ConnectionInterface $from, $msg) {
        echo "{$from->resourceId}: {$msg}\n";

        $msgChat = json_decode($msg);
        (new Chat([
            'channel' => $msgChat->channel,
            'user_id' => $msgChat->user_id,
            'msg' => $msgChat->message
        ]))->save();

        $channel = $msgChat->channel;
        foreach($this->clients[$channel] as $client) {
            $client->send($msg);
        }
    }
}