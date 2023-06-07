<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the TimeHRM License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.timehrm.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to timehrm.official@gmail.com so we can send you a copy immediately.
 *
 * @author   TimeHRM
 * @author-email  timehrm.official@gmail.com
 * @copyright  Copyright © timehrm.com All Rights Reserved
 */
namespace App\Controllers\Erp;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\ConstantsModel;

class Assets extends BaseController {

	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('asset1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_assets').' | '.$xin_system['application_name'];
		$data['path_url'] = 'assets';
		$data['breadcrumbs'] = lang('Dashboard.xin_assets');

		$data['subview'] = view('erp/assets/assets_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function asset_view()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();		
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $AssetsModel->where('assets_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('asset1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Asset.xin_view_asset').' | '.$xin_system['application_name'];
		$data['path_url'] = 'asset_details';
		$data['breadcrumbs'] = lang('Asset.xin_view_asset');

		$data['subview'] = view('erp/assets/asset_view', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_asset() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'asset_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_asset_name_field')
					]
				],
				'category_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_category_field')
					]
				],
				'brand_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_brand_field')
					]
				],
				'asset_image' => [
					'rules'  => 'uploaded[asset_image]|mime_in[asset_image,image/jpg,image/jpeg,image/gif,image/png]|max_size[asset_image,3072]',
					'errors' => [
						'uploaded' => lang('Asset.xin_error_asset_image_field'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "asset_name" => $validation->getError('asset_name'),
					"category_id" => $validation->getError('category_id'),
					"brand_id" => $validation->getError('brand_id'),
					"asset_image" => $validation->getError('asset_image')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$asset_image = $this->request->getFile('asset_image');
				$file_name = $asset_image->getName();
				$asset_image->move('public/uploads/asset_image/');
				
				$asset_name = $this->request->getPost('asset_name',FILTER_SANITIZE_STRING);
				$category_id = $this->request->getPost('category_id',FILTER_SANITIZE_STRING);
				$brand_id = $this->request->getPost('brand_id',FILTER_SANITIZE_STRING);
				$company_asset_code = $this->request->getPost('company_asset_code',FILTER_SANITIZE_STRING);
				$is_working = $this->request->getPost('is_working',FILTER_SANITIZE_STRING);
				$purchase_date = $this->request->getPost('purchase_date',FILTER_SANITIZE_STRING);
				$invoice_number = $this->request->getPost('invoice_number',FILTER_SANITIZE_STRING);
				$manufacturer = $this->request->getPost('manufacturer',FILTER_SANITIZE_STRING);
				$serial_number = $this->request->getPost('serial_number',FILTER_SANITIZE_STRING);
				$warranty_end_date = $this->request->getPost('warranty_end_date',FILTER_SANITIZE_STRING);
				$asset_note = $this->request->getPost('asset_note',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'name' => $asset_name,
					'assets_category_id'  => $category_id,
					'brand_id'  => $brand_id,
					'company_asset_code'  => $company_asset_code,
					'company_id'  => $company_id,
					'employee_id'  => $staff_id,
					'purchase_date'  => $purchase_date,
					'invoice_number'  => $invoice_number,
					'manufacturer'  => $manufacturer,
					'serial_number'  => $serial_number,
					'warranty_end_date'  => $warranty_end_date,
					'asset_note'  => $asset_note,
					'asset_image'  => $file_name,
					'is_working'  => $is_working,
					'created_at' => date('d-m-Y h:i:s')
				];
				$AssetsModel = new AssetsModel();
				$result = $AssetsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Asset.xin_success_asset_added');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}			
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	public function update_asset() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();	
		if ($this->request->getPost('type') === 'edit_record') {
			
			// set rules
			$rules = [
				'asset_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_asset_name_field')
					]
				],
				'category_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_category_field')
					]
				],
				'brand_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_brand_field')
					]
				],
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "asset_name" => $validation->getError('asset_name'),
					"category_id" => $validation->getError('category_id'),
					"brand_id" => $validation->getError('brand_id'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
			   $validated = $this->validate([
					'asset_image' => [
						'rules'  => 'uploaded[asset_image]|mime_in[asset_image,image/jpg,image/jpeg,image/gif,image/png]|max_size[asset_image,3072]',
						'errors' => [
							'uploaded' => lang('Asset.xin_error_asset_image_field'),
							'mime_in' => 'wrong size'
						]
					],
				]);
				if ($validated) {
					$asset_image = $this->request->getFile('asset_image');
					$file_name = $asset_image->getName();
					$asset_image->move('public/uploads/asset_image/');
				}
				$asset_name = $this->request->getPost('asset_name',FILTER_SANITIZE_STRING);
				$category_id = $this->request->getPost('category_id',FILTER_SANITIZE_STRING);
				$brand_id = $this->request->getPost('brand_id',FILTER_SANITIZE_STRING);
				$company_asset_code = $this->request->getPost('company_asset_code',FILTER_SANITIZE_STRING);
				$is_working = $this->request->getPost('is_working',FILTER_SANITIZE_STRING);
				$purchase_date = $this->request->getPost('purchase_date',FILTER_SANITIZE_STRING);
				$invoice_number = $this->request->getPost('invoice_number',FILTER_SANITIZE_STRING);
				$manufacturer = $this->request->getPost('manufacturer',FILTER_SANITIZE_STRING);
				$serial_number = $this->request->getPost('serial_number',FILTER_SANITIZE_STRING);
				$warranty_end_date = $this->request->getPost('warranty_end_date',FILTER_SANITIZE_STRING);
				$asset_note = $this->request->getPost('asset_note',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				if ($validated) {
					$data = [
						'name' => $asset_name,
						'assets_category_id'  => $category_id,
						'brand_id'  => $brand_id,
						'company_asset_code'  => $company_asset_code,
						'employee_id'  => $staff_id,
						'purchase_date'  => $purchase_date,
						'invoice_number'  => $invoice_number,
						'manufacturer'  => $manufacturer,
						'serial_number'  => $serial_number,
						'warranty_end_date'  => $warranty_end_date,
						'asset_note'  => $asset_note,
						'asset_image'  => $file_name,
						'is_working'  => $is_working,
					];
				} else {
						$data = [
						'name' => $asset_name,
						'assets_category_id'  => $category_id,
						'brand_id'  => $brand_id,
						'company_asset_code'  => $company_asset_code,
						'employee_id'  => $staff_id,
						'purchase_date'  => $purchase_date,
						'invoice_number'  => $invoice_number,
						'manufacturer'  => $manufacturer,
						'serial_number'  => $serial_number,
						'warranty_end_date'  => $warranty_end_date,
						'asset_note'  => $asset_note,
						'is_working'  => $is_working,
					];	
				}
				$AssetsModel = new AssetsModel();
				$result = $AssetsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Asset.xin_success_asset_updated');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}			
	}
	// read record
	public function read_asset()
	{
		$session = \Config\Services::session($config);
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/assets/dialog_asset', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// record list
	public function assets_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AssetsModel = new AssetsModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$assets = $AssetsModel->where('employee_id',$user_info['user_id'])->orderBy('assets_id', 'ASC')->findAll();
		} else {
			$assets = $AssetsModel->where('company_id',$usession['sup_user_id'])->orderBy('assets_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($assets as $r) {						
		  			
				//working?
				if($r['is_working']==1){
					$working = lang('Main.xin_yes');
				} else {
					$working = lang('Main.xin_no');
				}
				if(in_array('asset4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn btn-sm btn-light-danger delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['assets_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}
				//$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn btn-sm btn-icon btn-light-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['assets_id']) . '"><i class="feather icon-eye"></span></button></i>';
			
			$created_at = set_date_format($r['created_at']);
			$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
			$category_info = $ConstantsModel->where('constants_id', $r['assets_category_id'])->first();
			$brand_info = $ConstantsModel->where('constants_id', $r['brand_id'])->first();
			
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/asset-view/'.uencode($r['assets_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			$combhr = $view.$delete;
			$cname2= '<div class="media align-items-center"><img class="ui-w-30 d-block" src="'.base_url().'/public/uploads/asset_image/'.$r['asset_image'].'" alt=""><span class="media-body d-block text-body ml-3">'.$r['name'].'</span></div>';	

			$cname = $r['name'];
			$icname = '
				'.$cname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$icname,
				$category_info['category_name'],
				$brand_info['category_name'],
				$r['company_asset_code'],
				$working,
				$iuser_info['first_name'].' '.$iuser_info['last_name'],
				$created_at
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// delete record
	public function delete_asset() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session($config);
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$AssetsModel = new AssetsModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $AssetsModel->where('assets_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Asset.xin_success_asset_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
