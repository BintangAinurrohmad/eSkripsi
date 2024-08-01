<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function check_npm_email_exists($npm, $email)
    {
        $this->db->where('npm', $npm);
        $this->db->or_where('email', $email);
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    public function register_user($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_user_by_npm_or_email($npm_or_email)
    {
        $this->db->where('npm', $npm_or_email);
        $this->db->or_where('email', $npm_or_email);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function check_password($user_id, $password)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table);
        $user = $query->row();

        if ($user) {
            return password_verify($password, $user->password);
        }

    return false;
    }

    public function getMahasiswa()
    {
        $this->db->where('group_id', 1);
        $this->db->order_by('npm', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getDosen()
    {
        $this->db->where('group_id', 2);
        $this->db->order_by('npm', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getKoordinator()
    {
        $this->db->where('group_id', 3);
        $this->db->order_by('npm', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getAdmin()
    {
        $this->db->where('group_id', 4);
        $this->db->order_by('npm', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getRole()
    {
        return $this->db->get('group')->result_array();
    }

	public function get_profile($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get('users');
		return $query->row();
	}

	public function update_profile($user_id, $data)
	{
		$this->db->where('id', $user_id);
		$this->db->update('users', $data);
		return $this->db->affected_rows();
	}

	public function get_user_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		return $query->row();
	}

	public function update_password($id, $new_password)
	{
		$this->db->where('id', $id);
		$this->db->update('users', array('password' => password_hash($new_password, PASSWORD_DEFAULT)));
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('users');
	}

    public function editUser($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }
}
