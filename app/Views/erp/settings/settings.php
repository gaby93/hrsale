<?php
/*
* System Settings - Settings View
*/
?>
<?php
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
$LanguageModel = new LanguageModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$router = service('router');

$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$currency = $ConstantsModel->where('type','currency_type')->orderBy('constants_id', 'ASC')->findAll();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
$xin_system = $SystemModel->where('setting_id', 1)->first();
/////
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('settings1',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/system-settings');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-settings"></span>
      <?= lang('Main.left_settings');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_settings');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings2',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/system-constants');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-activity"></span>
      <?= lang('Main.left_constants');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_constants');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings3',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/email-templates');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-mail"></span>
      <?= lang('Main.left_email_templates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_email_templates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings4',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/all-languages');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-flag"></span>
      <?= lang('Main.xin_multi_language');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_multi_language');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('settings1',staff_role_resource()) || $user['user_type']== 'company') { ?>
<div class="row">
<!-- start -->
<div class="col-lg-3">
  <div class="card user-card user-card-1">
    <div class="card-body pb-0">
      <div class="media user-about-block align-items-center mt-0 mb-3">
        <div class="position-relative d-inline-block">
          <div class="certificated-badge"> <a href="javascript:void(0)" class="mb-3 nav-link"><span class="sw-icon fas fa-cog"></span></a> </div>
        </div>
        <div class="media-body ml-3">
          <h6 class="mb-1">
            <?= lang('Main.left_settings');?>
          </h6>
          <p class="mb-0 text-muted">
            <?= lang('Main.header_configuration');?>
          </p>
        </div>
      </div>
    </div>
    <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="account-settings-tab" data-toggle="pill" href="#account-settings" role="tab" aria-controls="account-settings" aria-selected="true"> <span class="f-w-500"><i class="feather icon-disc m-r-10 h5 "></i>
      <?= lang('Main.xin_system');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="account-system-logos-tab" data-toggle="pill" href="#account-system-logos" role="tab" aria-controls="account-system-logos" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
      <?= lang('Main.xin_system_logos');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="account-payment-tab" data-toggle="pill" href="#account-payment" role="tab" aria-controls="account-payment" aria-selected="false"> <span class="f-w-500"><i class="feather icon-credit-card m-r-10 h5 "></i>
      <?= lang('Main.xin_acc_payment_gateway');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="account-notification-tab" data-toggle="pill" href="#account-notification" role="tab" aria-controls="account-notification" aria-selected="false"> <span class="f-w-500"><i class="feather icon-crosshair m-r-10 h5 "></i>
      <?= lang('Main.xin_notification_position');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-set-email-tab" data-toggle="pill" href="#user-set-email" role="tab" aria-controls="user-set-email" aria-selected="false"> <span class="f-w-500"><i class="feather icon-mail m-r-10 h5 "></i>
      <?= lang('Main.xin_email_notifications');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> </div>
  </div>
</div>
<div class="col-lg-9">
  <div class="tab-content" id="user-set-tabContent">
    <div class="tab-pane fade show active" id="account-settings" role="tabpanel" aria-labelledby="account-settings-tab">
      <div class="card">
        <div class="card-header">
          <h5><i data-feather="disc" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_system');?>
            </span></h5>
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?= form_open('erp/settings/system_info', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_application_name');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_application_name');?>" name="application_name" type="text" value="<?= $xin_system['application_name'];?>" id="application_name">
                </div>
              </div>
            </div>
            
            <h6 class="mb-4"><?= lang('Main.xin_installed_ssl');?></h6>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_ssl_available" name="is_ssl_available" <?php if($xin_system['is_ssl_available']==1):?> checked="checked" <?php endif;?> value="1">
                <label class="custom-control-label" for="is_ssl_available"><?= lang('Main.xin_installed_ssl_details_text');?></label>
            </div>
            <hr>
            <h5 class="mt-5"><?= lang('Main.xin_auth_background');?></h5>
            <hr />
            <div class="row text-center">
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="2815767" value="2815767" <?php if($xin_system['auth_background']=='2815767'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="2815767"><a href="<?= base_url();?>/public/assets/images/auth/2815767.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/2815767.jpg" for="2815767" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4859202" value="4859202" <?php if($xin_system['auth_background']=='4859202'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4859202"><a href="<?= base_url();?>/public/assets/images/auth/4859202.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4859202.jpg" for="4859202" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4881040" value="4881040" <?php if($xin_system['auth_background']=='4881040'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4881040"><a href="<?= base_url();?>/public/assets/images/auth/4881040.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4881040.jpg" for="4881040" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4899203" value="4899203" <?php if($xin_system['auth_background']=='4899203'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4899203"><a href="<?= base_url();?>/public/assets/images/auth/4899203.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4899203.jpg" for="4899203" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4859203" value="4859203" <?php if($xin_system['auth_background']=='4859203'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4859203"><a href="<?= base_url();?>/public/assets/images/auth/4859203.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4859203.jpg" for="4859203" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4904579" value="4904579" <?php if($xin_system['auth_background']=='4904579'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4904579"><a href="<?= base_url();?>/public/assets/images/auth/4904579.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4904579.jpg" for="4904579" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4910284" value="4910284" <?php if($xin_system['auth_background']=='4910284'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4910284"><a href="<?= base_url();?>/public/assets/images/auth/4910284.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4910284.jpg" for="4910284" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4888301" value="4888301" <?php if($xin_system['auth_background']=='4888301'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4888301"><a href="<?= base_url();?>/public/assets/images/auth/4888301.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4888301.jpg" for="4888301" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4910910" value="4910910" <?php if($xin_system['auth_background']=='4910910'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4910910"><a href="<?= base_url();?>/public/assets/images/auth/4910910.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4910910.jpg" for="4910910" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4914544" value="4914544" <?php if($xin_system['auth_background']=='4914544'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4914544"><a href="<?= base_url();?>/public/assets/images/auth/4914544.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4914544.jpg" for="4914544" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4915973" value="4915973" <?php if($xin_system['auth_background']=='4915973'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4915973"><a href="<?= base_url();?>/public/assets/images/auth/4915973.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4915973.jpg" for="4915973" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="4931302" value="4931302" <?php if($xin_system['auth_background']=='4931302'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="4931302"><a href="<?= base_url();?>/public/assets/images/auth/4931302.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/4931302.jpg" for="4931302" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-4">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="auth_background" class="form-check-input" id="2456057" value="2456057" <?php if($xin_system['auth_background']=='2456057'):?> checked="checked" <?php endif;?>>
                        <label class="form-check-label" for="2456057"><a href="<?= base_url();?>/public/assets/images/auth/2456057.jpg" data-lightbox="roadtrip"><img src="<?= base_url();?>/public/assets/images/auth/2456057.jpg" for="2456057" class="img-fluid m-b-10 img-thumbnail bg-white" alt=""></a></label>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">
          <?= lang('Main.xin_save');?>
          </button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
    <div class="tab-pane fade" id="account-system-logos" role="tabpanel" aria-labelledby="account-system-logos-tab">
      <div class="card">
        <div class="card-header">
          <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_system_logos');?>
            </span></h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xl-12">
              <div class="nav-tabs-top mb-4">
                <ul class="nav nav-tabs">
                  <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#xin_system_logos">
                    <?= lang('Main.xin_system_logos');?>
                    </a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#xin_payslip_invoice_logo_title">
                    <?= lang('Main.xin_payslip_invoice_logo_title');?>
                    </a> </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="xin_system_logos">
                    <div class="card-body">
                      <div class="row  mb-4">
                        <div class="col-md-6">
                          <?php $attributes = array('name' => 'logo_info', 'id' => 'logo_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('company_logo' => 'UPDATE');?>
                          <?= form_open_multipart('erp/settings/add_logo', $attributes, $hidden);?>
                          <label for="logo">
                            <?= lang('Main.xin_system_logos');?>
                            <span class="text-danger">*</span> </label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="logo_file">
                            <label class="custom-file-label"><?= lang('Main.xin_choose_file');?></label>
                            <div class="mt-3">
                              <?php if($xin_system['logo']!='' && $xin_system['logo']!='no file') {?>
                              <img src="<?= base_url().'/public/uploads/logo/'.$xin_system['logo'];?>" width="70px" style="margin-left:30px;" id="u_file_1">
                              <?php } else {?>
                              <img src="<?= base_url().'/public/uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file_1">
                              <?php } ?>
                            </div>
                            <div class="mt-3"> <small>-
                              <?= lang('Main.xin_logo_files_only');?>
                              </small><br />
                              <small>-
                              <?= lang('Main.xin_best_main_logo_size');?>
                              </small><br />
                              <small>-
                              <?= lang('Main.xin_logo_whit_background_light_text');?>
                              </small></div>
                          </div>
                          <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                            <?= lang('Main.xin_save');?>
                            </button>
                          </div>
                          <?= form_close(); ?>
                        </div>
                        <div class="col-md-6 mb-4">
                          <?php $attributes = array('name' => 'logo_favicon', 'id' => 'logo_favicon', 'autocomplete' => 'off');?>
                          <?php $hidden = array('company_logo' => 'UPDATE');?>
                          <?= form_open_multipart('erp/settings/add_favicon', $attributes, $hidden);?>
                          <label for="logo">
                            <?= lang('Main.xin_favicon');?>
                            <span class="text-danger">*</span> </label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="favicon">
                            <label class="custom-file-label"><?= lang('Main.xin_choose_file');?></label>
                            <div class="mt-3">
                              <?php if($xin_system['favicon']!='' && $xin_system['favicon']!='no file') {?>
                              <img src="<?= base_url().'/public/uploads/logo/favicon/'.$xin_system['favicon'];?>" width="16px" style="margin-left:30px;" id="favicon1">
                              <?php } else {?>
                              <img src="<?= base_url().'/public/uploads/logo/no_logo.png';?>" width="16px" style="margin-left:30px;" id="favicon1">
                              <?php } ?>
                            </div>
                            <div class="mt-3"> <small>-
                              <?= lang('Main.xin_logo_files_only_favicon');?>
                              </small><br />
                              <small>-
                              <?= lang('Main.xin_best_logo_size_favicon');?>
                              </small></div>
                          </div>
                          <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                            <?= lang('Main.xin_save');?>
                            </button>
                          </div>
                          <?= form_close(); ?>
                        </div>
                      </div>
                      
                    </div>
                    
                  </div>
                  <div class="tab-pane fade" id="xin_payslip_invoice_logo_title">
                    
                      <?php $attributes = array('name' => 'iother_logo', 'id' => 'other_logo', 'autocomplete' => 'off');?>
                      <?php $hidden = array('company_logo' => 'UPDATE');?>
                      <?= form_open_multipart('erp/settings/add_other_logo', $attributes, $hidden);?>
                      <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <label for="logo">
                            <?= lang('Main.xin_logo');?>
                            <span class="text-danger">*</span> </label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="other_logo">
                            <label class="custom-file-label"><?= lang('Main.xin_choose_file');?></label>
                            <div class="mt-3">
                              <?php if($xin_system['other_logo']!='' && $xin_system['other_logo']!='no file') {?>
                              <img src="<?= base_url().'/public/uploads/logo/other/'.$xin_system['other_logo'];?>" width="70px" style="margin-left:30px;" id="u_file3">
                              <?php } else {?>
                              <img src="<?= base_url().'/public/uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file3">
                              <?php } ?>
                            </div>
                            <div class="mt-3"> <small>-
                              <?= lang('Main.xin_logo_dark_background_text');?>
                              </small></div>
                            <div> <small>-
                              <?= lang('Main.xin_logo_files_only');?>
                              </small></div>
                            <div> <small>-
                              <?= lang('Main.xin_best_signlogo_size');?>
                              </small></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">
                      <?= lang('Main.xin_save');?>
                      </button>
                    </div>
                    <?= form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="account-payment" role="tabpanel" aria-labelledby="account-payment-tab">
      <div class="card">
        <div class="card-header">
          <h5> <i data-feather="credit-card" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_acc_payment_gateway');?>
            </span> <small class="text-muted d-block m-l-25 m-t-5"><?= lang('Main.xin_change_payment_gateway_settings');?></small> </h5>
        </div>
          <?php $attributes = array('name' => 'payment_gateway', 'id' => 'payment_gateway', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_company_info' => 'UPDATE');?>
          <?= form_open('erp/settings/update_payment_gateway', $attributes, $hidden);?>
          <div class="card-body">
          <h5>
            <?= lang('Main.xin_acc_paypal_info');?>
          </h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">
                  <?= lang('Main.xin_acc_paypal_email');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_acc_paypal_email');?>" name="paypal_email" type="text" value="<?= $xin_system['paypal_email'];?>">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label class="form-label">
                      <?= lang('Main.xin_acc_paypal_sandbox_active');?>
                      <span class="text-danger">*</span> </label>
                    <select class="form-control" name="paypal_sandbox" data-plugin="xin_select" data-placeholder="<?= lang('Main.paypal_sandbox_active');?>">
                      <option value="">
                      <?= lang('Main.xin_select_one');?>
                      </option>
                      <option value="yes" <?php if($xin_system['paypal_sandbox'] =='yes'):?> selected="selected"<?php endif;?>>
                      <?= lang('Main.xin_yes');?>
                      </option>
                      <option value="no" <?php if($xin_system['paypal_sandbox'] =='no'):?> selected="selected"<?php endif;?>>
                      <?= lang('Main.xin_no');?>
                      </option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">
                      <?= lang('Main.xin_employees_active');?>
                      <span class="text-danger">*</span> </label>
                    <select class="form-control" name="paypal_active" data-plugin="xin_select" data-placeholder="<?= lang('Main.xin_employees_active');?>">
                      <option value="">
                      <?= lang('Main.xin_select_one');?>
                      </option>
                      <option value="yes" <?php if($xin_system['paypal_active'] =='yes'):?> selected="selected"<?php endif;?>>
                      <?= lang('Main.xin_yes');?>
                      </option>
                      <option value="no" <?php if($xin_system['paypal_active'] =='no'):?> selected="selected"<?php endif;?>>
                      <?= lang('Main.xin_no');?>
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <h5 class="pb-2">
            <?= lang('Main.xin_acc_stripe_info');?>
          </h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">
                  <?= lang('Main.xin_acc_stripe_secret_key');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_acc_stripe_secret_key');?>" name="stripe_secret_key" type="text" value="<?= $xin_system['stripe_secret_key'];?>">
              </div>
              <div class="form-group">
                <label class="form-label">
                  <?= lang('Main.xin_acc_stripe_publlished_key');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_acc_stripe_publlished_key');?>" name="stripe_publishable_key" type="text" value="<?= $xin_system['stripe_publishable_key'];?>">
              </div>
              <div class="form-group">
                <label class="form-label">
                  <?= lang('Main.xin_employees_active');?>
                  <span class="text-danger">*</span> </label>
                <select class="form-control" name="stripe_active" data-plugin="xin_select" data-placeholder="<?= lang('Main.xin_employees_active');?>">
                  <option value="">
                  <?= lang('Main.xin_select_one');?>
                  </option>
                  <option value="yes" <?php if($xin_system['stripe_active'] =='yes'):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_yes');?>
                  </option>
                  <option value="no" <?php if($xin_system['stripe_active'] =='no'):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_no');?>
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">
          <?= lang('Main.xin_save');?>
          </button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
    <div class="tab-pane fade" id="account-notification" role="tabpanel" aria-labelledby="account-notification-tab">
      <div class="card">
        <div class="card-header">
          <h5><i data-feather="crosshair" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_notification_position');?>
            </span></h5>
        </div>
        
          <?php $attributes = array('name' => 'notification_position_info', 'id' => 'notification_position_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('theme_info' => 'UPDATE');?>
          <?= form_open('erp/settings/notification_position_info', $attributes, $hidden);?>
          <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">
                  <?= lang('Main.dashboard_position');?>
                  <span class="text-danger">*</span> </label>
                <select class="form-control" name="notification_position" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_position');?>">
                  <option value="">
                  <?= lang('Main.xin_select_one');?>
                  </option>
                  <option value="toast-top-right" <?php if($xin_system['notification_position']=='toast-top-right'){?> selected <?php }?>>
                  <?= lang('Main.xin_top_right');?>
                  </option>
                  <option value="toast-bottom-right" <?php if($xin_system['notification_position']=='toast-bottom-right'){?> selected <?php }?>>
                  <?= lang('Main.xin_bottom_right');?>
                  </option>
                  <option value="toast-bottom-left" <?php if($xin_system['notification_position']=='toast-bottom-left'){?> selected <?php }?>>
                  <?= lang('Main.xin_bottom_left');?>
                  </option>
                  <option value="toast-top-left" <?php if($xin_system['notification_position']=='toast-top-left'){?> selected <?php }?>>
                  <?= lang('Main.xin_top_left');?>
                  </option>
                  <option value="toast-top-center" <?php if($xin_system['notification_position']=='toast-top-center'){?> selected <?php }?>>
                  <?= lang('Main.xin_top_center');?>
                  </option>
                </select>
                <br />
                <small class="text-muted"><i class="ft-arrow-up"></i>
                <?= lang('Main.xin_set_position_for_notifications');?>
                </small> </div>
            </div>
           </div>
           <hr class="pb-3">
            <h6 class="mb-4"><?= lang('Main.xin_close_button');?></h6>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="notification_close" name="notification_close" <?php if($xin_system['notification_close_btn']=='true'):?> checked="checked" <?php endif;?> value="true">
                <label class="custom-control-label" for="notification_close"><?= lang('Main.xin_enable_notification_close_btn');?></label>
            </div>
            <hr class="pb-3">
            <h6 class="mb-4"><?= lang('Main.xin_progress_bar');?></h6>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="notification_bar" name="notification_bar" <?php if($xin_system['notification_bar']=='true'):?> checked="checked" <?php endif;?> value="true">
                <label class="custom-control-label" for="notification_bar"><?= lang('Main.xin_enable_notification_bar');?></label>
            </div>          
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">
          <?= lang('Main.xin_save');?>
          </button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
    <div class="tab-pane fade" id="user-set-email" role="tabpanel" aria-labelledby="user-set-email-tab">
      <div class="card">
        <div class="card-header">
          <h5><i data-feather="mail" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_email_notifications');?>
            </span></h5>
        </div>
          <?php $attributes = array('name' => 'email_info', 'id' => 'email_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?= form_open('erp/settings/email_info', $attributes, $hidden);?>
          <div class="card-body">
          <div class="bg-white">
          <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_mail_type_config');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="email_type" id="email_type" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_mail_type_config');?>">
                    <option value="codeigniter" <?php if($xin_system['email_type'] == 'codeigniter'):?> selected="selected"<?php endif;?>>CodeIgniter v4 Mail()</option>
                    <option value="phpmail" <?php if($xin_system['email_type'] == 'phpmail'):?> selected="selected"<?php endif;?>>PHP Mail()</option>
                  </select>
                </div>
              </div>
            </div>
              <hr class="pb-3">
                <h6 class="mb-4"><?= lang('Main.xin_email_notification_enable');?></h6>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="email_notification" name="email_notification" <?php if($xin_system['enable_email_notification']==1):?> checked="checked" <?php endif;?> value="1">
                    <label class="custom-control-label" for="email_notification"><?= lang('Main.xin_enable_email_notification');?></label>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
          <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
