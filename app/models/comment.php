<?php
class Comment extends AppModel
{
    public $validation = array(
        'body' => array(
            'length' => array(
                'is_between', 1, 500,
            ),
        ),
    );
}