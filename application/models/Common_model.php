<?php defined("BASEPATH") or exit("No Direct Access Allowed!");

class Common_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function getAll_or($table, $where = null, $keys = null, $whereor = null)
	{

		$this->db->distinct();

		if (!is_null($keys)) {
			$this->db->select($keys);
		}

		if (!is_null($whereor)) {
			foreach ($whereor as $key => $orrow) {
				if ($key == 0) {
					$this->db->or_group_start();
					$this->db->or_where($orrow['key'], $orrow['val']);
				} else if ($key == 1) {
					$this->db->where($orrow['key'], $orrow['val']);
					$this->db->group_end();
				} else if ($key == 2) {
					$this->db->or_group_start();
					$this->db->or_where($orrow['key'], $orrow['val']);
				} else if ($key == 3) {
					$this->db->where($orrow['key'], $orrow['val']);
					$this->db->group_end();
				} else if ($key == 4) {
					$this->db->or_group_start();
					$this->db->or_where($orrow['key'], $orrow['val']);
				} else if ($key == 5) {
					$this->db->where($orrow['key'], $orrow['val']);
					$this->db->group_end();
				} else if ($key == 6) {
					$this->db->or_group_start();
					$this->db->or_where($orrow['key'], $orrow['val']);
				} else if ($key == 7) {
					$this->db->where($orrow['key'], $orrow['val']);
					$this->db->group_end();
				}
			}
		}

		if (!is_null($where)) {
			$this->db->where($where);
		}

		return $this->db->get($table)->result_array();
	}


	public function getAll($table, $orderby = null, $where = null, $keys = null, $limit = null, $in_not_in = null)
	{
		if (!is_null($keys)) {
			$this->db->select($keys);
		}

		if (!is_null($limit)) {
			$this->db->limit($limit);
		}

		if (!is_null($in_not_in)) {
			foreach ($in_not_in as $nvalue) {
				if ($nvalue['type'] == 'in') {
					$this->db->where_in($nvalue['key'], $nvalue['inlist']);
				} else if ($nvalue['type'] == 'notin') {
					$this->db->where_not_in($nvalue['key'], $nvalue['inlist']);
				}
			}
		}


		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}

		if (!is_null($where)) {
			$this->db->where($where);
		}

		return $this->db->get($table)->result_array();
	}




	public function getSingle($table, $where = null, $keys = null, $orderby = null, $limit = null, $inkey = null, $invalue = null)
	{
		if (!is_null($keys)) {
			$keys = trim($keys);
		} else {
			$keys = '*';
		}
		$this->db->select($keys);

		if (!is_null($limit)) {
			$this->db->limit($limit);
		}
		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}
		if (!is_null($where)) {
			$this->db->where($where);
		}
		if (!is_null($inkey) && !is_null($invalue) && !empty($inkey) && !empty($invalue)) {
			$query = $this->db->where_in($inkey, (explode(',', $invalue)));
		}

		return $this->db->get($table)->row_array();
	}


	public function getRow($table, $where = null, $keys = null, $orderby = null, $limit = null, $inkey = null, $invalue = null)
	{
		if (!is_null($keys)) {
			$keys = trim($keys);
		} else {
			$keys = '*';
		}
		$this->db->select($keys);

		if (!is_null($limit)) {
			$this->db->limit($limit);
		}
		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}
		if (!is_null($where)) {
			$this->db->where($where);
		}
		if (!is_null($inkey) && !is_null($invalue) && !empty($inkey) && !empty($invalue)) {
			$query = $this->db->where_in($inkey, (explode(',', $invalue)));
		}

		if (strpos($keys, ',') !== false) {
			return $this->db->get($table)->row_array();
		} else if (strpos($keys, '*') !== false) {
			return $this->db->get($table)->row_array();
		} else {
			$rows = $this->db->get($table)->row_array();
			return $rows[$keys];
		}
	}



	public function delete($table, $where)
	{
		return $this->db->where($where)->delete($table);
	}

	/**
	 * Insert a new record into the specified table
	 * @param string $table Table name
	 * @param array $dataarray Data to insert
	 * @return int|bool Insert ID on success, false on failure
	 */
	public function insert($table, $dataarray)
	{
		$this->db->insert($table, $dataarray);
		return $this->db->insert_id();
	}

	/**
	 * Update existing records in the specified table
	 * @param string $table Table name
	 * @param array $dataarray Data to update
	 * @param array $where Where conditions
	 * @return bool True on success, false on failure
	 */
	public function update($table, $dataarray, $where)
	{
		return $this->db->where($where)->update($table, $dataarray);
	}


	public function saveupdate($table, $dataarray, $validation = null, $where = null, $id = null)
	{

		if (!is_null($where)) {
			$status = $this->db->where($where)->update($table, $dataarray);
			return !is_null($id) ? $id :  $status;
		} else {

			if (!is_null($validation)) {
				$this->db->where($validation);
			}

			if (!is_null($validation) && $this->db->get($table)->num_rows() > 0) {
				return false;
			} else {
				$this->db->insert($table, $dataarray);
				return $this->db->insert_id();
			}
		}
	}


	public function getfilter($tablename, $wherearray = null, $limit = null, $start = null, $orderby = null, $orderbykey = null, $whereor = null, $whereorkey = null, $like = null, $likekey = null,  $getorcount = null, $infield = null, $invalue = null, $keys = null, $groupby = null)
	{

		if (!is_null($keys)) {
			$this->db->select($keys);
		}
		if (!is_null($groupby)) {
			$this->db->group_by($groupby);
		}

		if (!is_null($limit) && !is_null($start) && $start > 0 && $limit > 0) {

			if (!is_null($orderby) && ($orderby == 'ASC' || $orderby == 'DESC')) {
				$query = $this->db->order_by($orderbykey, $orderby);
			}

			if (!is_null($likekey) && !is_null($like)) {
				$this->db->like($likekey, $like, 'both');
			}


			$query = $this->db->limit($limit, $start);
			if (!is_null($whereor) && !is_null($whereorkey)) {
				$query = $this->db->group_start();
				foreach ($whereor as $row) {
					$query = $this->db->or_where($whereorkey, $row);
				}
				$query = $this->db->group_end();
			}

			if (!is_null($whereor) && !is_null($whereorkey) && !empty($whereand)) {
				$query = $this->db->group_start();
				foreach ($whereand as $datet) {
					$query = $this->db->or_where($whereorkey, $datet);
				}
				$query = $this->db->group_end();
			}

			if (!is_null($infield) && !is_null($invalue) && !empty($infield) && !empty($invalue)) {
				$query = $this->db->where_in($infield, (explode(',', $invalue)));
			}
			$query = $this->db->where($wherearray);
			$query = $this->db->get($tablename);
		} else if (!is_null($limit) && $limit > 0) {

			if (!is_null($orderby) && ($orderby == 'ASC' || $orderby == 'DESC')) {
				$query = $this->db->order_by($orderbykey, $orderby);
			}

			if (!is_null($likekey) && !is_null($like)) {
				$this->db->like($likekey, $like, 'both');
			}
			$query = $this->db->limit($limit);
			if (!is_null($whereor) && !is_null($whereorkey)) {
				$query = $this->db->group_start();
				foreach ($whereor as $row) {
					$query = $this->db->or_where($whereorkey, $row);
				}
				$query = $this->db->group_end();
			}

			if (!is_null($infield) && !is_null($invalue) && !empty($infield) && !empty($invalue)) {
				$query = $this->db->where_in($infield, (explode(',', $invalue)));
			}
			$query = $this->db->where($wherearray);
			$query = $this->db->get($tablename);
		} else {
			if (!is_null($orderby) && ($orderby == 'ASC' || $orderby == 'DESC')) {
				$query = $this->db->order_by('id', $orderby);
			}

			if (!is_null($likekey) && !is_null($like)) {
				$this->db->like($likekey, $like, 'both');
			}

			if (!is_null($whereor) && !is_null($whereorkey)) {
				$query = $this->db->group_start();
				foreach ($whereor as $row) {
					$query = $this->db->or_where($whereorkey, $row);
				}
				$query = $this->db->group_end();
			}

			if (!is_null($infield) && !is_null($invalue) && !empty($infield) && !empty($invalue)) {
				$query = $this->db->where_in($infield, (explode(',', $invalue)));
			}
			$query = $this->db->where($wherearray);
			$query = $this->db->get($tablename);
		}



		$output = ($getorcount == 'count') && !is_null($getorcount) ? $query->num_rows() : $query->result_array();

		return  $output ? $output : '';
	}




	public function get_like($table, $where = null, $keys = null, $orderby = null, $like = null, $likekey = null, $likeaction = null)
	{
		if (!is_null($keys)) {
			$this->db->select($keys);
		}

		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}


		if (!is_null($like) && !is_null($likekey) && !is_null($likeaction)) {
			$this->db->like($likekey, $like, $likeaction);
		}

		if (!is_null($where)) {
			$this->db->where($where);
		}

		return $this->db->get($table)->result_array();
	}



	public function getAllwherein($table, $where = null, $keys = null, $orderby = null, $inkey = null, $inlistarray = null)
	{

		if (!is_null($keys)) {
			$this->db->select($keys);
		}

		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}


		if (!is_null($inkey) && !is_null($inlistarray)) {
			$this->db->where_in($inkey, $inlistarray);
		}

		if (!is_null($where)) {
			$this->db->where($where);
		}

		return $this->db->get($table)->result_array();
	}




	public function joindata($select, $where, $from, $joinarray = null, $groupby = null, $orderby = null, $limit = null, $in_not_in = null, $like = null, $likekey = null, $likeaction = null, $offset = null)
	{
		if (!is_null($select)) {
			$this->db->select($select);
		}
		if (!is_null($groupby)) {
			$this->db->group_by($groupby);
		}
		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}
		if (!empty($limit) && !empty($offset)) {
			$this->db->limit($limit, $offset);
		} else if (!empty($limit)) {
			$this->db->limit($limit);
		}
		if (!is_null($from)) {
			$this->db->from($from);
		}
		if (!is_null($joinarray)) {
			foreach ($joinarray as $value) {
				$this->db->join($value['table'], $value['on'], $value['key']);
			}
		}

		if (!is_null($in_not_in)) {
			foreach ($in_not_in as $nvalue) {
				if ($nvalue['type'] == 'in') {
					$this->db->where_in($nvalue['key'], $nvalue['inlist']);
				} else if ($nvalue['type'] == 'notin') {
					$this->db->where_not_in($nvalue['key'], $nvalue['inlist']);
				}
			}
		}

		if (!is_null($like) && !is_null($likekey) && !is_null($likeaction)) {
			$this->db->like($likekey, $like, $likeaction);
		}


		if (!is_null($where)) {
			$this->db->where($where);
		}
		return $this->db->get()->result_array();
	}


	public function countitem($table, $where = null, $whereor = null, $whereorkey = null, $keys = null)
	{

		if (!empty($keys)) {
			$this->db->select($keys);
		}
		if (!empty($where)) {
			$query = $this->db->where($where);
			if (!is_null($whereor)) {
				$query = $this->db->group_start();
				foreach ($whereor as $row) {
					$query = $this->db->or_where($whereorkey, $row);
				}
				$query = $this->db->group_end();
			}
			$query = $this->db->get($table);
		} else {
			$query = $this->db->get($table);
		}
		$count = $query->num_rows();
		return ($count > 0 ? $count : 0);
	}
}
