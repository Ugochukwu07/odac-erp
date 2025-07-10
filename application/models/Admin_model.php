<?php defined("BASEPATH") or exit("No Direct Access Allowed!");

class Admin_model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
	}



	public function getAll($table, $orderby = null, $where = null, $keys = null)
	{
		if (!is_null($keys)) {
			$this->db->select($keys);
		}

		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}

		if (!is_null($where)) {
			$this->db->where($where);
		}

		return $this->db->get($table)->result_array();
	}




	public function getSingle($table, $where, $keys = null, $orderby = null, $limit = null)
	{
		if (!is_null($limit)) {
			$this->db->limit($limit);
		}
		if (!is_null($keys)) {
			$this->db->select($keys);
		}
		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}

		return $this->db->where($where)->get($table)->row_array();
	}




	public function delete($table, $where)
	{
		return $this->db->where($where)->delete($table);
	}



	public function countitem($table, $where = null, $whereor = null, $whereorkey = null)
	{

		if (!is_null($where)) {

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


	public function getfilter($tablename, $wherearray = null, $limit = null, $start = null, $orderby = null, $orderbykey = null, $whereor = null, $whereorkey = null, $like = null, $likekey = null,  $getorcount = null)
	{

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
			$query = $this->db->where($wherearray);
			$query = $this->db->get($tablename);
		}



		$output = ($getorcount == 'count') && !is_null($getorcount) ? $query->num_rows() : $query->result_array();;

		return  $output ? $output : '';
	}




	public function getAlllike($table, $where = null, $keys = null, $orderby = null, $like = null, $likekey = null, $likeaction = null)
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



	public function getAllwherein($table, $where = null, $keys = null, $orderby = null, $inkey = null, $inlistarray = null, $intype = null, $limit = null)
	{


		if (!is_null($limit)) {
			$this->db->limit($limit);
		}

		if (!is_null($keys)) {
			$this->db->select($keys);
		}

		if (!is_null($orderby)) {
			$this->db->order_by($orderby);
		}


		if (!is_null($inkey) && !is_null($inlistarray)) {
			if (!is_null($intype)) {
				$this->db->where_not_in($inkey, $inlistarray);
			} else {
				$this->db->where_in($inkey, $inlistarray);
			}
		}

		if (!is_null($where)) {
			$this->db->where($where);
		}

		return $this->db->get($table)->result_array();
	}

	public function broadCastlist($enquerynumber)
	{
		$this->db->select('bidlist.uniqueid, bidlist.bidclosedate, brdcast.bidopendatetime');
		$this->db->from('corpo_brdcastbooking as brdcast');
		$this->db->join('bid_broadcastlist as bidlist', 'bidlist.enquerynumber = brdcast.querynumber', 'inner');
		$this->db->where(array('brdcast.bidclosestatus' => 'no', 'brdcast.querynumber' => trim($enquerynumber)));

		return $this->db->get()->result_array();
	}
}
