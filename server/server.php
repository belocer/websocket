<?php
use Workerman\Worker;

require_once __DIR__ . '/../vendor/autoload.php';

$wsWorker = new Worker('websocket://0.0.0.0:2346');
$wsWorker->count = 4; // Количество подключений от клиента

// Колбэк на подключение пользователя
$wsWorker->onConnect = function ($connection) {
    echo "Client up \n";
};

// Колбэк реагирования на сообщение
$wsWorker->onMessage = function ($connection, $data) use ($wsWorker) {
    foreach ($wsWorker->connections as $clientConnection) {
        $clientConnection->send($data);
    }
};

// Колбэк на отключение пользователя
$wsWorker->onClose = function ($connection) {
    echo "Client down \n";
};

// Запускаем воркер
Worker::runAll();