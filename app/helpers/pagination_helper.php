<?php
/**
 * Class Pagination
 */
class pagination 
{
    public $row_count;
    public $rows_per_page;
    public $current_page;
    public $page_count;
    public $query_string;
    const PAGE_RANGE = 2;

    /**
     * Class Constructor
     * Assigns parameter to public variables if not null
     * Performs the run() function
     * @param $row_count
     * @param $rows_per_page
     * @param $current_page
     * @param $get_vars
     */
    public function __construct ($row_count = null, $rows_per_page = null, 
        $current_page = null, array $get_vars = null)
    {
        if (!is_null($row_count) && !is_null($rows_per_page) && !is_null($current_page)) {
            $this->row_count     = $row_count;
            $this->rowsperpage  = $rows_per_page;
            $this->current_page  = $current_page;
            $this->get_vars = $get_vars;
            $this->run();
        }
    }

    /**
     * Checks the number of pages
     * Validates the value of $current_page variable
     */
    public function run()
    {
        $this->page_count    = ceil($this->row_count / $this->rowsperpage);
        $this->current_page  = max($this->current_page, 1);
        $this->current_page  = min($this->current_page, $this->page_count);
    }

    /**
     * Validates the user input via GET method
     * @param $totalrows
     * @param $rows_per_page
     * @return $pages
     */
    public static function pageValidator($totalrows, $rows_per_page)
    {
        $totalpages = ceil($totalrows/$rows_per_page);
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $current_page = (int) $_GET['page'];
        } else {
            $current_page = 1;
        }

        if ($current_page > $totalpages) {
            $current_page = $totalpages;
        }

        if ($current_page < 1) {
            $current_page = 1;
        }

        $pages = $current_page;
        return $pages;
    }

    //
    /**
     * Outputs the pagination control buttons
     * @return $page_btn
     */
    public function __toString()
    {
        $query_string = "";       //additional get_var
        foreach((array) $this->get_vars as $get_var) {
            $query_string .= "&{$get_var}";
        }
        $page_btn = "<div class='pagination pagination-centered'><ul>";
        if ($this->current_page > 1) {
            $page_btn .= "<li><a href='?page=1{$query_string}' class='btn '> << </a></li>";
            $prev_page  = $this->current_page - 1;
            $page_btn .= "<li><a href='?page=$prev_page{$query_string}' class='btn '> < </a></li> "; 
        }
 
        for($i = ($this->current_page - self::PAGE_RANGE); $i <= ($this->current_page + self::PAGE_RANGE); $i++) {
            if (($i > 0) && ($i <= $this->page_count)) {
                if ($i == $this->current_page) {
                    $page_btn .= "<li class='disabled'><a class='btn '>$i</a></li>";
                } else {
                    $page_btn .= "<li><a href='?page=$i{$query_string}' class='btn '>$i</a></li> ";
                }
            }       
        }
        if ($this->current_page != $this->page_count) {
            $next_page = $this->current_page + 1;
            $page_btn .= "<li><a href='?page=$next_page{$query_string}' class='btn '> > </a></li>";
            $page_btn .= "<li><a href='?page=$this->page_count{$query_string}' class='btn '> >> </a></li>";
        }
    $page_btn .="</ul></div>";
    return $page_btn;
    }
}