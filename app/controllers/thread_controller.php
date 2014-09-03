<?php
/**
 * Class Controller
 */
class ThreadController extends AppController 
{
    const ROWS_PER_PAGE = 5;

    public function threads() 
    {
        $title = "Threads";
        if (!is_logged('user')) {
            redirect('/');
        }
        $session = $_SESSION['user'];
        // start paginated threads 
        $totalrows  = Thread::threadsrows();
        $page       = pagination::pagevalidator($totalrows, self::ROWS_PER_PAGE);
        $threads    = Thread::getAll($page, self::ROWS_PER_PAGE);
        $paged      = new pagination($totalrows, self::ROWS_PER_PAGE, $page);
        // end paginated threads        
        $this->set(get_defined_vars());
    }

    public function view() 
    {
        $title = "Comments";
        if (!is_logged('user')) {
            redirect('/');;
        }
        $thread_id  = Param::get('thread_id');
        $thread     = Thread::get($thread_id);

        //redirect to 404 page if thread id is not found
        if (!$thread) {
            redirect("/thread/pagenotfound");
        }

        // start paginated comments 
        $session    = $_SESSION['user'];
        $username   = $session[0]['username'];        
        $totalrows  = Thread::commentsrows($thread_id);
        $page       = pagination::pagevalidator($totalrows, self::ROWS_PER_PAGE);
        $comments   = Thread::getComments($page, self::ROWS_PER_PAGE, $thread_id);
        $paged      = new pagination($totalrows, self::ROWS_PER_PAGE, $page, 
            array("thread_id=$thread_id"));
        // end paginated comments  

        $comment = new Comment;
        $page = Param::get('page_next', 'view');

        switch($page) {
        case 'view';
            break;
        case 'write_end';
            $comment->username = Param::get('username');
            $comment->body = Param::get('body');
            try {
                $thread->write($comment);
            } catch (ValidationException $e) {
                $page = 'view';
            }
            break;
            $thread->write($comment);
            break;
        default:
            throw new NotFoundException("{$page} is not found");
            break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function create() 
    {
        $title = "Create Thread";
        if (!is_logged('user')) {
            redirect('/');
        }
        $session    = $_SESSION['user'];
        $username   = $session[0]['username'];

        $thread     = new Thread;
        $comment    = new Comment;
        $page       = Param::get('page_next', 'create');

        switch ($page) {
        case 'create':
            break;
        case 'create_end':
            $thread->title      = Param::get('title');
            $comment->username  = Param::get('username');
            $comment->body      = Param::get('body');
            try {
                $thread->create($comment);
            } catch (ValidationException $e) {
                $page = 'create';
            }
            break;
        default:
            throw new NotFoundException("{$page} is not found");
            break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function pagenotfound() 
    {
        $title = "404";
    }
}