<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tasks extends Common_Back_Controller {

    public $data = "";

    function __construct() {
        parent::__construct();
        $this->check_admin_user_session();
    }
    public function index(){
     
        $data['title']      = "Tasks";
         
        $count              = $this->common_model->get_total_count('tasks');
        $count              = number_format_short($count);
        $link               = base_url().'admin/tasks/add';
        $data['recordSet']  = array('<li class="sparks-info"><h5>Task<span class="txt-color-blue"><a href="'.$link.'" class="anchor-btn"><i class="fa fa-plus-square"></i></a></span></h5></li>','<li class="sparks-info"><h5>Total Tasks <span class="txt-color-darken" id="totalCust"><i class="fa fa-lg fa-fw fa fa-tags"></i>&nbsp;'.$count.'</span></h5></li>');
           $data['front_scripts']  = array('backend_assets/custom/js/common_datatable.js',
            'backend_assets/custom/js/task.js');
        $this->load->admin_render('tasks/index', $data, '');
    } //End function
        public function add() { 
        
        $data['title']              = 'Add Task';
        $data['front_scripts'] = array('backend_assets/custom/js/task.js');
        $this->load->admin_render('tasks/add', $data);
    } //End Function
  
}//End Class