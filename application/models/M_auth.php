<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function validate_user($user, $passwd) 
    {
        $this->db->where('kode_surveyor', $user);
        $this->db->where('password_surveyor', md5($passwd));
        $data = $this->db->get('surveyor');
        return $data;
    }


}
