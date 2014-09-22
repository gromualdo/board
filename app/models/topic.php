<?php 
class Topic extends AppModel
{
    public static $has_results = false;
    public $validation = array(
        'topic_name' => array(
            'length' => array(
                'is_between', 1, 50,
                ),
            'valid_topic' => array(
                'has_space_at_beginning'
                ),
            ),
        'question' => array(
            'length' => array(
                'is_between', 1, 1000,
                ),
            'valid_question' => array(
                'has_space_at_beginning'
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
        $topic_id = Param::get('topic_id');
        $db = DB::conn();
        $row = $db->row("SELECT topic_id, topics.user_id, topic_name, 
            topics.grade_level, created, question, subject_category, 
            users.username FROM topics, users 
            WHERE topic_id = ? AND topics.user_id = users.user_id", 
            array($id)
            );
        if (!$row) {
            //will be redirected to pagenotfound if $row=0
            throw new pagenotfoundException("Cannot find Topic_ID $topic_id");           
        }
        return new self($row);
    }

    /**
     * Displays all topics with Limit and Offsets
     * in descending order
     * @param $currentpage
     * @param ROWS_PER_PAGE
     * @return $topics array
     */
    public static function getAll($currentpage)
    {
        $topics = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * ROWS_PER_PAGE;
        $limit = "LIMIT $lowerlimit,".ROWS_PER_PAGE;

        $rows = $db->rows("SELECT topic_id, topics.user_id, topic_name, 
            topics.grade_level, created, question, subject_category, 
            users.username
            FROM topics, users
            WHERE topics.user_id = users.user_id
            GROUP BY topics.topic_id
            ORDER BY topics.topic_id DESC   
            $limit"
            );

        foreach ($rows as $row) {
            $topics[] = new Topic($row);
        }
        return $topics;
    }

    /**
     * Create new Thread
     * @param $reply Object
     */
    public function create()
    {
        $this->validate();
        if (!$this->validate()) {
            throw new ValidationException('invalid topic or reply');
        }

        $db = DB::conn();
        $params = array(
            'user_id' => $this->user_id,
            'topic_name' => $this->topic_name,
            'grade_level' => $this->grade_level,
            'question' => $this->question,
            'subject_category' => $this->subject_category
            );
        $db->insert("topics", $params);
        $this->topic_id = $db->lastInsertId();
    }

    /**
     * Returns the number of rows
     * of topics table
     * @return $numrows
     */
    public static function count()
    {
        $db = DB::conn();
        return (int) $db->value("SELECT COUNT(*) FROM topics");
    }

    /**
     * Search topic
     * @param $currentpage
     * @param $string
     * @return $searchresult
     */
    public function search($currentpage, $string)
    {
        $searchresult = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * ROWS_PER_PAGE;
        $limit = "$lowerlimit,".ROWS_PER_PAGE;
        $results = $db->search("topics", "topic_name LIKE ?", 
            array("%$string%"), "topic_id DESC", "$limit"
            );
        if($results) {
            self::$has_results = true;
            foreach($results as $result) {
                $searchresult[] = new Topic($result);
            }
            return $searchresult;
        } else {
            return false;
        }
    }

    /**
     * Count the number of rows
     * of search results
     * @param $string
     * @return $result_count
     */
    public function countSearchResults($string)
    {
        $db = DB::conn();
        $result_count = (int) $db->value("SELECT COUNT(*) FROM topics 
            WHERE topic_name LIKE ?", 
            array("%$string%")
            );
        return $result_count;
    }


    /**
     * Delete the topic and its replies
     * @param $string
     */
    public function delete($string, $string2)
    {
        $db = DB::conn();
        try {
            $db->begin();
            $db->query("DELETE FROM topics 
                WHERE topic_id = ? AND user_id = ?",
                array($string, $string2)
                );
            $db->query("DELETE FROM replies 
                WHERE topic_id = ? AND user_id = ?",
                array($string, $string2)
                );
            $db->commit();
        } catch(ValidationException $e) {
            throw $e;
        }

    }
}