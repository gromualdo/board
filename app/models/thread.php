<?php 
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 30,
                ),
            ),
        );

    public static function get($id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        return new self($row);
    }
    public static function getAll()
    {
        $threads = array();

        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM thread');
        foreach ($rows as $row)
        {
            $threads[] = new Thread($row);
        }

        return $threads;
    }
    public function getComments()
    {
        $comments = array();
        $rowsperpage = 4;
        $db = DB::conn();

        $sqlrowcount = $db->row(
            "SELECT COUNT(*) as num FROM comment"
            );
        $numrows = $sqlrowcount['num'];

        $lowerlimit = ($_GET['currentpage'] - 1) * $rowsperpage;

        $limitrows= $db->rows(
            "SELECT * FROM comment ORDER BY id DESC LIMIT $lowerlimit, $rowsperpage"
            );
        foreach($limitrows as $limitrow)
        {
            $comments[] = new Thread($limitrow);
        }
        $showpages = pagination($numrows, $rowsperpage);
        $comments[] = $showpages;
        return $comments;
        

       
    }

    public function write(Comment $comment)
    {
        if(!$comment->validate()){
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->query("INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()", array($this->id, $comment->username, $comment->body)
            );
    }

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }

        $db = DB::conn();
        $db->begin();

        $db->query('INSERT INTO thread SET title = ?, created = NOW()', array($this->title));
        $this->id = $db->lastInsertId();

        // write first comment at the same time
        $this->write($comment);
        
        $db->commit();
    }



}