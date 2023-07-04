<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();

        // THEME MODEL
        $this->load->model('site_model', 'm');

        $this->load->model('admin/buildings_model','b');

        $this->load->model('admin/vendors_model','v');

        $this->load->model('admin/invoices_model','i');

        // Helpers
        $this->load->helper('common');


    }
    // AUTH METHODS
    public function admin()
    {

        if ($this->session->userdata('id'))
            return $this->redirectRole();
        
        // admin type ...
        $data['type']                   = "1";
        $data['total_buildings']        = count($this->b->index_m());
        $data['total_vendors']          = count($this->v->index_m());
        $data['total_invoices_amount']  = $this->i->get_total_payment_m();
        
        $this->load->view('site/login', $data);
    }

    // AUTH METHODS

    public function vendor()
    {

        if ($this->session->userdata('id'))
            return $this->redirectRole();
        
        // vendor type ...
        $data['type']                   = "2";
        $data['total_buildings']        = count($this->b->index_m());
        $data['total_vendors']          = count($this->v->index_m());
        $data['total_invoices_amount']  = $this->i->get_total_payment_m();
        $this->load->view('site/login', $data);
    }

     // AUTH METHODS

    public function staff()
    {

        if ($this->session->userdata('id'))
            return $this->redirectRole();
        
        // vendor type ...
        $data['type']                   = "3";
        $data['total_buildings']        = count($this->b->index_m());
        $data['total_vendors']          = count($this->v->index_m());
        $data['total_invoices_amount']  = $this->i->get_total_payment_m();
        $this->load->view('site/login', $data);
    }

     // AUTH METHODS

    public function owner()
    {

        if ($this->session->userdata('id'))
            return $this->redirectRole();
        
        // vendor type ...
        $data['type']                   = "4";
        $data['total_buildings']        = count($this->b->index_m());
        $data['total_vendors']          = count($this->v->index_m());
        $data['total_invoices_amount']  = $this->i->get_total_payment_m();
        $this->load->view('site/login', $data);
    }

    //FORGOT FUNCTION
    public function forgotpassword() {
         
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $load = $this->input->post("load");
            $type = $this->input->post("type");

            if ($load == 'view') {
                $data['type'] = $type;
                $this->load->view('site/forgotpassword', $data);    
            }
        } else {
            
            // vendor type ...
            $data['type']                   = "4";
            $data['total_buildings']        = count($this->b->index_m());
            $data['total_vendors']          = count($this->v->index_m());
            $data['total_invoices_amount']  = $this->i->get_total_payment_m();
            return redirect('site/login');
        }
    }

    //Reet Function
    public function resetpassword() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $type       = $this->input->post("type");
            $email      = $this->input->post('email');    
            $this->session->set_userdata('type', $type);  
            $data['type'] = $type;

            // In case of passing validation
            if ($this->form_validation->run() == true) {

                $findemail  = $this->m->ForgotPassword($email, $type);  
                $this->session->set_userdata('type', $type);
                 
                if ($findemail) {
                    $response = $this->m->sendpassword($findemail, $type);        
    
                    if ($response == 'sent') {
                        $this->session->set_flashdata('msg','Password sent to your email!');
                    }else if ($response == 'failed') {
                        $this->session->set_flashdata('msg','Failed to send password, please try again!');
                    }
                    $this->load->view('site/login',$data);
                }else{
                    
                    $this->session->set_flashdata('msg',' Email not found!');
                    $this->load->view('site/login',$data);
                }
            } else {
                $this->session->set_flashdata('msg', lang('all_fields_required'));

                
                $this->load->view('site/forgotpassword', $data); 
            } 
        }
    }



    // LOGIN FUNCTION
    public function auth()
    {

        // Detecting request method for security purposes

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
            // In case of passing validation
            if ($this->form_validation->run() == true) {
                $data['email']    = $this->input->post('email');
                $data['password'] = md5($this->input->post('password'));
                $type   = ( $this->input->post("type") == 4 ? 4 : ( $this->input->post("type") == 3 ? 3 : ( $this->input->post("type") == 1 ? 1 : 2)));


                if ($user = $this->m->doAuth($data, $type)) {

                    // is disabled (only applied to clients ) ??
                    if(isset($user->status) && $user->status != 1){
                        $this->session->set_flashdata('msg',lang('client_status_disabled'));
                        return redirect('vendor');
                    }


                    $this->session->set_userdata('id', $user->id);
                    $this->session->set_userdata('name', $user->name);
                    $this->session->set_userdata('type', $type);
                    $this->session->set_userdata('picture', $user->picture);
                    $this->session->set_userdata('created_at', $user->created_at);


                    $this->redirectRole();

                } else {
                    $this->session->set_flashdata('msg', lang('invalid_username_password'));
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('msg', lang('all_fields_required'));
                return redirect($_SERVER['HTTP_REFERER']);
            }

        } else {
            $this->session->set_flashdata('msg',lang('unauthorize_request'));
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }

    // end to login function
    
     // redirect as per role
    private function redirectRole()
    {   
        // admin
        if ($this->session->userdata('type')     == 1)
            redirect('admin/dashboard');

        // vendor
        elseif ($this->session->userdata('type') == 2)
            redirect('vendor/dashboard');

        // staff
        elseif ($this->session->userdata('type') == 3)
            redirect('staff/dashboard');

        // owner
        elseif ($this->session->userdata('type') == 4)
            redirect('owner/dashboard');
        else
            redirect('login');
    }
}
