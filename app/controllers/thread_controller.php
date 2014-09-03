<?php
class ThreadController extends AppController 
{
    public function threads() 
    {
    	$title = "Threads";
    	if (!is_logged('user')) {
            header("location: /");
        }
        $session = $_SESSION['user'];
        // start paginated threads 
        $rowsperpage= 5;
        $totalrows 	= Thread::threadsrows();
        $page = pagination::pagevalidator($totalrows, $rowsperpage);
        $threads = Thread::getAll($page, $rowsperpage);
		$paged = new pagination($totalrows, $rowsperpage, $page);
		// end paginated threads  		
		$this->set(get_defined_vars());
    }

    public function view() 
    {
    	$title = "Comments";
        if (!is_logged('user')) {
            header("location: /");
        }
        $thread_id 	= Param::get('thread_id');
        $thread 	= Thread::get($thread_id);

        //redirect to 404 page if thread id is not found
        if (!$thread) {
        	header("location: /thread/pagenotfound");
        }

        // start paginated comments 
        $rowsperpage= 5;
        $session 	= $_SESSION['user'];
        $username	= $session[0]['username'];        
        $totalrows 	= Thread::commentsrows($thread_id);
        $page 		= pagination::pagevalidator($totalrows, $rowsperpage);
        $comments 	= Thread::getComments($page, $rowsperpage, $thread_id);
        $paged 		= new pagination($totalrows, $rowsperpage, $page, 
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
            header("location: /");
        }
        $session = $_SESSION['user'];
        $username = $session[0]['username'];

        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');

        switch ($page) {
        case 'create':
            break;
        case 'create_end':
            $thread->title = Param::get('title');
            $comment->username = Param::get('username');
            $comment->body = Param::get('body');
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