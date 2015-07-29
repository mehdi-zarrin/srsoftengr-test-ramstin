<?php


namespace Application\src;

use Resque;

class LeadCollector
{
    public $db;
    public $resque;
    private function getAuthToken($input)
    {
        $arg = json_encode($input);

        return `./token $arg`;
    }

    public function setDatabase(Database $db)
    {
        $this->db = $db;
    }

    public function setResque($resque)
    {
        $this->resque = $resque;
    }

    public function save($stackContents)
    {
        if (!is_array($stackContents) || count($stackContents) == 0) {
            return false;
        }

        $this->db->query('INSERT INTO
                `imoney` (name, mobno, email, auth_token, created_at)
                 VALUES (:name, :mobno, :email, :auth_token, NOW())'
            );
        $this->db->beginTransaction();
        foreach ($stackContents as $item) {
            echo 'generating auth token !'.PHP_EOL;
            $auth_token = $this->getAuthToken($stackContents);
            $this->db->bind(':name', $item['name']);
            $this->db->bind(':mobno', $item['mobno']);
            $this->db->bind(':email', $item['email']);
            $this->db->bind(':auth_token', $auth_token);
            $this->db->execute();
        }
        $this->db->endTransaction();

        echo 'A new job stack has been inserted into database '.PHP_EOL;
    }

    /**
     * creating an extra queue in redis is much more efficent than
     * inserting into mysql for every single request
     * this function pack data and use batch insert to minimize
     * database connection.
     *
     * @param  [array] $queueContents [description]
     *
     * @return [boolean]
     */
    public function createJobStack($input, $queue = null)
    {
        if (!is_array($input)) {
            throw new \InvalidArgumentException();
        }

        // create job stack in redis with "current queue name"
        // to avoid name collision with possible future job stack

        $stack = $queue.'-jobstack';
        $size = $this->resque->size($stack);
        if ($size < Config::$minQueueSize) {

            // check incoming content and if they are buggy
            // don't let them pass !
            if (!Validator::validate($input, Config::$validKeys)) {
                echo 'buggy content'.PHP_EOL;
                return false;
            }

            $this->resque->push($stack, $input);
            echo 'new item has been added to '.$stack.PHP_EOL;
            echo 'current stack size is : '.$size.PHP_EOL;
        } else {
            $stackContents = [];
            for ($i = 1; $i <= Config::$minQueueSize; ++$i) {
                array_push($stackContents, $this->resque->pop($stack));
            }

            echo 'calling save method !'.PHP_EOL;
            // save the stack into database
            $this->save($stackContents);
        }

        return true;
    }

    public function setUp()
    {
        $this->setDatabase((new Database()));
        $this->setResque((new Resque()));
    }
    public function perform()
    {
        $this->createJobStack($this->args, $this->queue);
    }
}
