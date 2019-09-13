<?php

class User_Model extends CI_Model
{
    protected $UserTable = 'user';
    protected $MahasiswaTable = 'mahasiswa';
    protected $UserinRoleTable = 'userinrole';
    protected $RoleTable = 'role';
    protected $PegawaiTable = 'pegawai';
    protected $UserinRole = 'userinrole';
    public function insert_user(array $UserData)
    {
        $this->db->insert($this->UserTable, $UserData);
        return $this->db->insert_id();
    }

    public function CekData()
    {
        $DataUser = $this->db->query("SELECT * FROM User");
        return $DataUser->num_rows();
    }

    public function insert_role($role)
    {
        $this->db->insert($this->UserinRole, $role);
        return $this->db->insert_id();
    }

    public function ChangesPassword($data, $Id)
    {
        $this->db->where('Id', $Id);
        $this->db->where('Password', md5($data['OldPassword']));
        $resultCek = $this->db->get('user');
        if ($resultCek->num_rows()) {
            $this->db->set('Password', md5($data['NewPassword']));
            $this->db->where('Id', $Id);
            $result = $this->db->update('user');
            return true;
        } else {
            return false;
        }
    }

    public function ChangesUsername($data, $Id)
    {
        $this->db->set('Username', $data['Username']);
        $this->db->where('Id', $Id);
        $result = $this->db->update('user');
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function fetch_all_users()
    {
        $query = $this->db->get('user');
        foreach ($query->result() as $row) {
            $user_data[] = [
                'Username' => $row->Username,
                'Email' => $row->Email,
                'Insert' => $row->Insert,
                'Update' => $row->Update,
            ];
        }
        return $user_data;
    }

    public function user_login($Username, $Password)
    {
        $Pass = md5($Password);
        $Data = $this->db->query("
            SELECT
                *
            FROM
                `user`
                LEFT JOIN `userinrole` ON `userinrole`.`IdUser` = `user`.`IdUser`
                RIGHT JOIN `role` ON `userinrole`.`Idrole` = `role`.`Idrole` 
            WHERE Username = '$Username' AND Password = '$Pass'"
        );
        if ($Data->num_rows()) {
            return $Data->result_object();
        } else {
            return false;
        }
    }
}
