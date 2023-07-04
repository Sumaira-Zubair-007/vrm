<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model
{


    public function doAuth($data, $type = 2)
    {
        if (!empty($data['email']) && !empty($data['password'])) {
            // return type ...
            if($type == 1)
                return $this->db->where($data)->select('*')->get(ADMINS)->row();
            else if($type == 3)
                return $this->db->where($data)->select('*')->get(STAFFS)->row();
            else if($type == 4)
                return $this->db->where($data)->select('*')->get(OWNERS)->row();
            else
                return $this->db->where($data)->select('*')->get(VENDORS)->row();

        } else
            return false;
    }


    public function ForgotPassword($email, $type = 2) {
        
        $data['email'] = $email;

        if (!empty($data['email']) ) {
            // return type ...
            if($type == 1)
                return $this->db->where($data)->select('*')->get(ADMINS)->row();
            else if($type == 3)
                return $this->db->where($data)->select('*')->get(STAFFS)->row();
            else if($type == 4)
                return $this->db->where($data)->select('*')->get(OWNERS)->row();
            else
                return $this->db->where($data)->select('*')->get(VENDORS)->row();

        }
        else{
            return false;
        }
    }


    public function sendpassword($datas, $type = 2) {

        $email          = $datas->email;
        $res            = '';
        $db_table       = '';
        $data['id']     = $datas->id;
        $data['email']  = $datas->email;

        if($type == 1) {
            $db_table = ADMINS;
            $res = $this->db->where($data)->select('*')->get(ADMINS)->row();
        }else if($type == 3) {
            $db_table = STAFFS;
            $res = $this->db->where($data)->select('*')->get(STAFFS)->row();
        }else if($type == 4) {
            $db_table = OWNERS;
            $res = $this->db->where($data)->select('*')->get(OWNERS)->row();
        }else {
            $db_table = VENDORS;
            $res = $this->db->where($data)->select('*')->get(VENDORS)->row();
        }
            
        if (!empty($res)) { 
              
            $passwordplain          = "";
            $passwordplain          = rand(999999999,9999999999);
            $data['password']       = md5($passwordplain);
              
            $this->db->where('email', $email)->update($db_table, $data);

            // send E-mail 
            $email_data['email']    = $email;
            $email_data['password'] = $passwordplain;
            //
            $message = $this->load->view('site/emailresetpassword',$email_data, TRUE);
            $subject = "Password Reset - VRMBIM";
            $cc      = "fersen@newgents.com";
            

            if (sendMail($subject, $message, $email_data['email'], NULL, $cc)) {
                return 'sent';
            } else {
                return 'failed';                
            }
        }
    }
 
}
