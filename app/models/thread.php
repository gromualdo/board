<?php 
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'is_between', 1, 30,
                ),
            ),
        );

    /**
     * Displays the Thread selected by the 
     * SQL query
     * @param $id
     * @return new obj
     */
    public static function get($id)
    {
        $thread_id = Param::get('thread_id');
        $db = DB::conn();
        $row = $db->row("SELECT * FROM thread 
            WHERE id = ?", 
            array($id)
            );
        if (!$row) {
            throw new PageNotFoundException("Cannot find Thread_ID $thread_id");           //will be redirected to pagenotfound if $row=0
        }
        return new self($row);
    }

    /**
     * Displays all threads with Limit and Offsets
     * in descending order
     * @param $currentpage
     * @param $rowsperpage
     * @return $threads array
     */
    public static function getAll($currentpage, $rowsperpage)
    {
        $threads = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * $rowsperpage;
        $rows = $db->rows("SELECT * FROM thread 
            ORDER BY id DESC 
            LIMIT $lowerlimit, $rowsperpage"
            );
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        return $threads;
    }

    /**
     * Create new Thread
     * @param $comment Object
     */
    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if (!$this->validate() || !$comment->validate()) {
            throw new ValidationException('invalid thread or comment');
        }
        $db = DB::conn();
        $db->begin();
        $params = array(
            'title' => $this->title
            );
        $db->insert("thread", $params);
        $this->id = $db->lastInsertId();
        $comment->write($this->id);     
        $db->commit();
    }

    /**
     * Returns the number of rows
     * of thread table
     * @return $numrows
     */
    public static function count()
    {
        $db = DB::conn();
        return (int) $db->value("SELECT COUNT(*) FROM thread");
    }
}