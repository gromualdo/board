<?php
/**
 * Class Controller
 */
class ThreadController extends AppController 
{
    const ROWS_PER_PAGE = 5;
    

    /**
     * Display all threads with pagination
     */
    public function threads() 
    {
        $title = "Threads";
        if (!is_logged('user_session')) {
            redirect('/');
        }
        // $session = $_SESSION['user_session'];
        // start paginated threads 
        $total_rows = Thread::countThreads();
        $page       = pagination::pagevalidator($total_rows, self::ROWS_PER_PAGE);
        $threads    = Thread::getAllThreads($page, self::ROWS_PER_PAGE);
        $paged      = new pagination($total_rows, self::ROWS_PER_PAGE, $page);
        // end paginated threads        
        $this->set(get_defined_vars());
    }

    /**
     * View all comments with pagination
     * form for adding comments
     */
    public function view() 
    {
        $title = "Comments";
        if (!is_logged('user_session')) {
            redirect('/');;
        }
        $thread_id  = Param::get('thread_id');
        $thread     = Thread::getThread($thread_id);

        //redirect to 404 page if thread id is not found
        if (!$thread) {
            throw new DCException("Cannot find Thread_ID $thread_id");
        }

        // start paginated comments 
        $session    = $_SESSION['user_session'];
        $username   = $session[0]['username'];        
        $total_rows = Thread::countComments($thread_id);
        $page       = Pagination::pagevalidator($total_rows, self::ROWS_PER_PAGE);
        $comments   = Thread::getComments($page, self::ROWS_PER_PAGE, $thread_id);
        $paged      = new Pagination($total_rows, self::ROWS_PER_PAGE, $page, 
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
                $page = 'view?whut';
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

    /**
     * Creating new thread
     */
    public function create() 
    {
        $title = "Create Thread";
        if (!is_logged('user_session')) {
            redirect('/');
        }
        $session    = $_SESSION['user_session'];
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
                $thread->createThread($comment);
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

    /**
     * Catch page when user types in invalid URL
     */
    public function pageNotFound() 
    {
        $title = "404";
        $err_msg = Param::get('error_msg');
        $this->set(get_defined_vars());
    }
}