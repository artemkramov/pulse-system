#!/usr/bin/env php
<?php

define('BASEPATH', 1);
require_once 'websockets.php';
$db = require_once '../../../common/config/main-local.php';

/**
 * Class echoServer
 */
class echoServer extends WebSocketServer
{
    /**
     * @var PDO
     */
    private $DBH;

    /**
     * echoServer constructor.
     * @param $add
     * @param $port
     * @param int $bufferLength
     */
    public function __construct($add, $port, $bufferLength = 2048)
    {
        parent::__construct($add, $port, $bufferLength);
        global $db;
        $dbDefault = $db['components']['db'];
        $this->DBH = new PDO($dbDefault['dsn'], $dbDefault['username'], $dbDefault['password']);
    }

    /**
     * @param $user
     * @param $message
     */
    protected function process($user, $message)
    {
        $msg = json_decode($message);
        if (is_object($msg)) {
            $method = $msg->method;
            if (method_exists($this, $method)) {
                $this->$method($user, $msg);
            }
        }
    }

    /**
     * @param $userID
     * @return mixed
     */
    private function getUser($userID)
    {
        $query = "select * from user where id = '" . $userID . "'";
        $STH = $this->DBH->query($query);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        return $STH->fetch();
    }

    /**
     * @param $user
     * @param stdClass $msg
     */
    public function confirm($user, $msg)
    {
        $this->stderr('Confirm with user hash: ' . $msg->userID);
        $row = $this->getUser($msg->userID);
        if (!empty($row)) {
            $user->row_id = $msg->userID;
            $this->users[$user->id] = $user;
        } else {
            $this->disconnect($user->socket);
        }
    }

    /**
     * @param $sender
     * @param $msg
     */
    public function pushNotification($sender, $msg)
    {
        foreach ($this->users as $user) {
            if ($user->row_id == $msg->data->userID) {
                unset($msg->data->userID);
                $json = array(
                    'data' => $msg->data,
                    'type' => 'notice'
                );
                $this->send($user, json_encode($json));
                $this->disconnect($user);
            }
        }
    }

    /**
     * @param $user
     */
    protected function connected($user)
    {
        // Do nothing: This is just an echo server, there's no need to track the user.
        // However, if we did care about the users, we would probably have a cookie to
        // parse at this step, would be looking them up in permanent storage, etc.
    }

    /**
     * @param $user
     */
    protected function closed($user)
    {
        // Do nothing: This is where cleanup would go, in case the user had any sort of
        // open files or other objects associated with them.  This runs after the socket
        // has been closed, so there is no need to clean up the socket itself here.
        $this->stderr('Disconnected: ' . $user->id);
    }
}

$echo = new echoServer("0.0.0.0", "9000", "128000");

try {
    set_time_limit(0);
    $echo->run();
} catch (Exception $e) {
    $echo->stdout($e->getMessage());
}
