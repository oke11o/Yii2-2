<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use console\components\SocketServer;

class SocketController extends Controller {
    public function actionStartSocket($port = 8080) {
        $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new SocketServer()
            )
        ), $port);

        $server->run();
    }
}