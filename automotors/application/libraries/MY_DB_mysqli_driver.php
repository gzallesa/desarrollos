<?php
class MY_DB_mysqli_driver extends CI_DB_mysqli_driver {

    function __construct($params){
        parent::__construct($params);
        //log_message('debug', 'Extended DB driver class instantiated!');
    }

    /**
     * Execute the query
     *
     * @param  string $sql   an SQL query
     * @return mixed
     */

    protected function _execute($sql)
    {
        // free results from previous query
        $this->free_results();

        $sql = $this->_prep_query($sql);

        // get a result code of query (), can be used for test is the query ok
        $retval = @mysqli_multi_query($this->conn_id, $sql);

        // get a first resultset
        $firstResult = @mysqli_store_result($this->conn_id);

        // test is the error occur or not
        if (!$firstResult && !@mysqli_errno($this->conn_id)) {
            return true;
        }

        return $firstResult;
    }

    /**
     * Read the next result
     *
     * @return  null
     */
    function next_result()
    {
        $result = null;
        if (is_object($this->conn_id))
        {
            $result = mysqli_next_result($this->conn_id);
        } else {
            $result = FALSE;
        }
        return $result;
    }

    function free_result(){
        // free resultset
        $result = null;
        if(is_object($this->conn_id)){
            $result = @mysqli_free_result(@mysqli_store_result($this->conn_id));
        }
        return $result;
    }

    function free_results(){
        // free other resultsets
        while (is_object($this->conn_id) && @mysqli_next_result($this->conn_id)) {
            $this->free_result();
        }
    }
}