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
        if (!is_logged('user_session')) {
            redirect('/');
        }
        // start paginated threads 
        $total_rows = Thread::countThreads();
        $page       = Pagination::pageValidator($total_rows, self::ROWS_PER_PAGE);
        $threads    = Thread::getAllThreads($page, self::ROWS_PER_PAGE);
        $paged      = new Pagination($total_rows, self::ROWS_PER_PAGE, $page);
        // end paginated threads        
        $this->set(get_defined_vars());
    }

    /**
     * View all comments with pagination
     * form for adding comments
     */
    public function view() 
    {
        if (!is_logged('user_session')) {
            redirect('/');;
        }

        $thread_id  = Param::get('thread_id');
        $thread     = Thread::getThread($thread_id);

        // start paginated comments 
        $session    = $_SESSION['user_session'];
        $username   = $session[0]['username'];        
        $total_rows = Thread::countComments($thread_id);
        $page       = Pagination::pageValidator($total_rows, self::ROWS_PER_PAGE);
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

    /**
     * Creating new thread
     */
    public function create() 
    {
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
        $err_msg = Param::get('error_msg');
        $this->set(get_defined_vars());
    }
}