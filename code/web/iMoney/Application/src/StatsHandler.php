<?php



namespace Application\src;

class StatsHandler
{
    private $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function leadCount()
    {
        $sql = 'SELECT SQL_NO_CACHE COUNT(*) AS cnt
        				FROM `imoney`
        				WHERE `created_at` > NOW() - INTERVAL 15 MINUTE';

        $query = $this->db->query($sql);
        $result = $this->db->single();

        return $result;

    }

    public function timeSpan()
    {
        $sql = 'SELECT SQL_NO_CACHE min(`created_at`) AS min_date, max(`created_at`) max_date FROM
        				(SELECT `created_at` FROM `imoney` ORDER BY `id` DESC LIMIT 10000) AS tbl ';

        $this->db->query($sql);
        $result = $this->db->resultset();

        return $result;
    }
}
