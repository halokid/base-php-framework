<?php
/**
 * model base class
 */
class Model_Base{
	protected $_tb_name;
	protected $_conn;
	
	public function __construct($conn, $tb_name) {
		$this->_conn = $conn;
		$this->_tb_name = $tb_name;
	}
	
	public function get_row($columns = '*', $where = '', $order = '' ){
//		$sql =  ($order == '' && $where == '') ? "select $columns from $this->_tb_name " : "select $columns from $this->_tb_name where=$where order by $order";
//		$sql = "select * from news";
//		$this->_conn->exec($sql);
//		$this->_conn->query($sql);
//		return $rows;
	}
}