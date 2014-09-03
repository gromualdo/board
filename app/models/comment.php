<?php
class Comment extends AppModel
{
    public $validation = array(
        'body' => array(
            'length' => array(
                'validateBetween', 1, 500,
            ),
        ),
    );
}