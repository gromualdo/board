<?php

class ThreadController extends AppController{
    public function index()
    {

    }

    public function threads()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $threads = Thread::getAll();
        //TODO: Get all threads
        $this->set(get_defined_vars());
        $session = $_SESSION['user'];
        // print("<pre>");
        // print_r($session);
        // print("</pre>");


    }
    public function view()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];
        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments();

        $username = $session[0]['username'];

        // print("<pre>");
        // print_r($comments);
        // print("</pre>");


        $this->set(get_defined_vars());
    }
    public function write()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];

        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');

        switch($page){
            case 'write';
                break;
            case 'write_end';
                $comment->username = Param::get('username');
                $comment->body = Param::get('body');
                try{
                    $thread->write($comment);
                } catch(ValidationException $e) {
                    $page = 'write';
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
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];

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
            } catch (ValidationException $e){
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

}