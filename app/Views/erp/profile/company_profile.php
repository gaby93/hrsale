<?php
/*
* Profile View
*/
use CodeIgniter\I18n\Time;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;

$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$MembershipModel = new MembershipModel();
$CompanymembershipModel = new CompanymembershipModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$result = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$membership_plans = $MembershipModel->orderBy('membership_id', 'ASC')->findAll();
$company_membership = $CompanymembershipModel->where('company_id', $usession['sup_user_id'])->first();
$status = '<span class="badge badge-light-success"><em class="icon ni ni-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
$status_label = '<i class="fas fa-certificate text-success bg-icon"></i><i class="fas fa-check front-icon text-white"></i>';

$currency = $ConstantsModel->where('type','currency_type')->orderBy('constants_id', 'ASC')->findAll();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
$xin_system = erp_company_settings();
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="float-right">
          <?= $status;?>
        </div>
        <div class="media user-about-block align-items-center mt-0 mb-3">
          <div class="position-relative d-inline-block">
            <img src="<?= staff_profile_photo($result['user_id']);?>" alt="" class="d-block img-radius img-fluid wid-80">
            <div class="certificated-badge">
              <?= $status_label;?>
            </div>
          </div>
          <div class="media-body ml-3">
            <h6 class="mb-1">
              <?= $result['first_name'].' '.$result['last_name'];?>
            </h6>
            <p class="mb-0 text-muted">@
              <?= $result['username'];?>
            </p>
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-mail m-r-10"></i>
          <?= lang('Main.xin_email');?>
          </span> <a href="mailto:<?= $result['email'];?>" class="float-right text-body">
          <?= $result['email'];?>
          </a> </li>
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-phone-call m-r-10"></i>
          <?= lang('Main.xin_phone');?>
          </span> <a href="#" class="float-right text-body">
          <?= $result['contact_number'];?>
          </a> </li>
      </ul>
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="account-settings-tab" data-toggle="pill" href="#account-settings" role="tab" aria-controls="account-settings" aria-selected="true"> <span class="f-w-500"><i class="feather icon-disc m-r-10 h5 "></i>
      <?= lang('Main.xin_account_settings');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-edit-account-tab" data-toggle="pill" href="#user-edit-account" role="tab" aria-controls="user-edit-account" aria-selected="true"> <span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i>
        <?= lang('Main.xin_personal_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-profile-logo-tab" data-toggle="pill" href="#user-profile-logo" role="tab" aria-controls="user-profile-logo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
        <?= lang('Main.xin_e_details_profile_picture');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-companyinfo-tab" data-toggle="pill" href="#user-companyinfo" role="tab" aria-controls="user-companyinfo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-text m-r-10 h5 "></i>
        <?= lang('Main.xin_company_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-password-tab" data-toggle="pill" href="#user-password" role="tab" aria-controls="user-password" aria-selected="false"> <span class="f-w-500"><i class="feather icon-shield m-r-10 h5 "></i>
        <?= lang('Main.header_change_password');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="card tab-content">
      <div class="tab-pane fade active show" id="account-settings" role="tabpanel" aria-labelledby="account-settings-tab">
        <div class="card-header">
          <h5><i data-feather="disc" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_account_settings');?>
            </span></h5>
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
          <?= form_open('erp/profile/system_info', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_ci_default_language');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="default_language" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_ci_default_language');?>">
                    <?php foreach($language as $lang):?>
                    <option value="<?= $lang['language_code'];?>" <?php if($xin_system['default_language']==$lang['language_code']){?> selected <?php }?>>
                    <?= $lang['language_name'];?>
                    </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_date_format');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_date_format');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <option value="Y-m-d" <?php if($xin_system['date_format_xi']=='Y-m-d'){?> selected <?php }?>>Format: <?= date('Y-m-d');?></option>
                    <option value="Y-d-m" <?php if($xin_system['date_format_xi']=='Y-d-m'){?> selected <?php }?>>Format: <?= date('Y-d-m');?></option>
                    <option value="d-m-Y" <?php if($xin_system['date_format_xi']=='d-m-Y'){?> selected <?php }?>>Format: <?= date('d-m-Y');?></option>
                    <option value="m-d-Y" <?php if($xin_system['date_format_xi']=='m-d-Y'){?> selected <?php }?>>Format: <?= date('m-d-Y');?></option>
                    <option value="Y/m/d" <?php if($xin_system['date_format_xi']=='Y/m/d'){?> selected <?php }?>>Format: <?= date('Y/m/d');?></option>
                    <option value="Y/d/m" <?php if($xin_system['date_format_xi']=='Y/d/m'){?> selected <?php }?>>Format: <?= date('Y/d/m');?></option>
                    <option value="d/m/Y" <?php if($xin_system['date_format_xi']=='d/m/Y'){?> selected <?php }?>>Format: <?= date('d/m/Y');?></option>
                    <option value="m/d/Y" <?php if($xin_system['date_format_xi']=='m/d/Y'){?> selected <?php }?>>Format: <?= date('m/d/Y');?></option>
                    <option value="Y.m.d" <?php if($xin_system['date_format_xi']=='Y.m.d'){?> selected <?php }?>>Format: <?= date('Y.m.d');?></option>
                    <option value="Y.d.m" <?php if($xin_system['date_format_xi']=='Y.d.m'){?> selected <?php }?>>Format: <?= date('Y.d.m');?></option>
                    <option value="d.m.Y" <?php if($xin_system['date_format_xi']=='d.m.Y'){?> selected <?php }?>>Format: <?= date('d.m.Y');?></option>
                    <option value="m.d.Y" <?php if($xin_system['date_format_xi']=='m.d.Y'){?> selected <?php }?>>Format: <?= date('m.d.Y');?></option>
                    <option value="F j, Y" <?php if($xin_system['date_format_xi']=='F j, Y'){?> selected <?php }?>>Format: <?= date('F j, Y');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_default_currency');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="default_currency" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_default_currency');?>">
   				<option value="USD" <?php if($xin_system['default_currency']=='USD'):?> selected="selected"<?php endif;?>>United States Dollars</option>
                <option value="EUR" <?php if($xin_system['default_currency']=='EUR'):?> selected="selected"<?php endif;?>>Euro</option>
                <option value="GBP" <?php if($xin_system['default_currency']=='GBP'):?> selected="selected"<?php endif;?>>United Kingdom Pounds</option>
                <option value="CNY" <?php if($xin_system['default_currency']=='CNY'):?> selected="selected"<?php endif;?>>China Yuan Renmimbi</option>
                <option value="AUD" <?php if($xin_system['default_currency']=='AUD'):?> selected="selected"<?php endif;?>>Australia Dollars</option>
                <option value="DZD" <?php if($xin_system['default_currency']=='DZD'):?> selected="selected"<?php endif;?>>Algeria Dinars</option>
                <option value="ARP" <?php if($xin_system['default_currency']=='ARP'):?> selected="selected"<?php endif;?>>Argentina Pesos</option>
                <option value="ATS" <?php if($xin_system['default_currency']=='ATS'):?> selected="selected"<?php endif;?>>Austria Schillings</option>
                <option value="BSD" <?php if($xin_system['default_currency']=='BSD'):?> selected="selected"<?php endif;?>>Bahamas Dollars</option>
                <option value="BBD" <?php if($xin_system['default_currency']=='BBD'):?> selected="selected"<?php endif;?>>Barbados Dollars</option>
                <option value="BEF" <?php if($xin_system['default_currency']=='BEF'):?> selected="selected"<?php endif;?>>Belgium Francs</option>
                <option value="BMD" <?php if($xin_system['default_currency']=='BMD'):?> selected="selected"<?php endif;?>>Bermuda Dollars</option>
                <option value="BRR" <?php if($xin_system['default_currency']=='BRR'):?> selected="selected"<?php endif;?>>Brazil Real</option>
                <option value="BGL" <?php if($xin_system['default_currency']=='BGL'):?> selected="selected"<?php endif;?>>Bulgaria Lev</option>
                <option value="CAD" <?php if($xin_system['default_currency']=='CAD'):?> selected="selected"<?php endif;?>>Canada Dollars</option>
                <option value="CLP" <?php if($xin_system['default_currency']=='CLP'):?> selected="selected"<?php endif;?>>Chile Pesos</option>
                
                <option value="CYP" <?php if($xin_system['default_currency']=='CYP'):?> selected="selected"<?php endif;?>>Cyprus Pounds</option>
                <option value="CSK" <?php if($xin_system['default_currency']=='CSK'):?> selected="selected"<?php endif;?>>Czech Republic Koruna</option>
                <option value="DKK" <?php if($xin_system['default_currency']=='DKK'):?> selected="selected"<?php endif;?>>Denmark Kroner</option>
                <option value="NLG" <?php if($xin_system['default_currency']=='NLG'):?> selected="selected"<?php endif;?>>Dutch Guilders</option>
                <option value="XCD" <?php if($xin_system['default_currency']=='XCD'):?> selected="selected"<?php endif;?>>Eastern Caribbean Dollars</option>
                <option value="EGP" <?php if($xin_system['default_currency']=='EGP'):?> selected="selected"<?php endif;?>>Egypt Pounds</option>
                <option value="FJD" <?php if($xin_system['default_currency']=='FJD'):?> selected="selected"<?php endif;?>>Fiji Dollars</option>
                <option value="FIM" <?php if($xin_system['default_currency']=='FIM'):?> selected="selected"<?php endif;?>>Finland Markka</option>
                <option value="FRF" <?php if($xin_system['default_currency']=='FRF'):?> selected="selected"<?php endif;?>>France Francs</option>
                <option value="DEM" <?php if($xin_system['default_currency']=='DEM'):?> selected="selected"<?php endif;?>>Germany Deutsche Marks</option>
                <option value="XAU" <?php if($xin_system['default_currency']=='XAU'):?> selected="selected"<?php endif;?>>Gold Ounces</option>
                <option value="GRD" <?php if($xin_system['default_currency']=='GRD'):?> selected="selected"<?php endif;?>>Greece Drachmas</option>
                <option value="HKD" <?php if($xin_system['default_currency']=='HKD'):?> selected="selected"<?php endif;?>>Hong Kong Dollars</option>
                <option value="HUF" <?php if($xin_system['default_currency']=='HUF'):?> selected="selected"<?php endif;?>>Hungary Forint</option>
                <option value="ISK" <?php if($xin_system['default_currency']=='ISK'):?> selected="selected"<?php endif;?>>Iceland Krona</option>
                <option value="INR" <?php if($xin_system['default_currency']=='INR'):?> selected="selected"<?php endif;?>>India Rupees</option>
                <option value="IDR" <?php if($xin_system['default_currency']=='IDR'):?> selected="selected"<?php endif;?>>Indonesia Rupiah</option>
                <option value="IEP" <?php if($xin_system['default_currency']=='IEP'):?> selected="selected"<?php endif;?>>Ireland Punt</option>
                <option value="ILS" <?php if($xin_system['default_currency']=='ILS'):?> selected="selected"<?php endif;?>>Israel New Shekels</option>
                <option value="ITL" <?php if($xin_system['default_currency']=='ITL'):?> selected="selected"<?php endif;?>>Italy Lira</option>
                <option value="JMD" <?php if($xin_system['default_currency']=='JMD'):?> selected="selected"<?php endif;?>>Jamaica Dollars</option>
                <option value="JPY" <?php if($xin_system['default_currency']=='JPY'):?> selected="selected"<?php endif;?>>Japan Yen</option>
                <option value="JOD" <?php if($xin_system['default_currency']=='JOD'):?> selected="selected"<?php endif;?>>Jordan Dinar</option>
                <option value="KRW" <?php if($xin_system['default_currency']=='KRW'):?> selected="selected"<?php endif;?>>Korea (South) Won</option>
                <option value="LBP" <?php if($xin_system['default_currency']=='LBP'):?> selected="selected"<?php endif;?>>Lebanon Pounds</option>
                <option value="LUF" <?php if($xin_system['default_currency']=='LUF'):?> selected="selected"<?php endif;?>>Luxembourg Francs</option>
                <option value="MYR" <?php if($xin_system['default_currency']=='MYR'):?> selected="selected"<?php endif;?>>Malaysia Ringgit</option>
                <option value="MXP" <?php if($xin_system['default_currency']=='MXP'):?> selected="selected"<?php endif;?>>Mexico Pesos</option>
                <option value="NLG" <?php if($xin_system['default_currency']=='NLG'):?> selected="selected"<?php endif;?>>Netherlands Guilders</option>
                <option value="NZD" <?php if($xin_system['default_currency']=='NZD'):?> selected="selected"<?php endif;?>>New Zealand Dollars</option>
                <option value="NOK" <?php if($xin_system['default_currency']=='NOK'):?> selected="selected"<?php endif;?>>Norway Kroner</option>
                <option value="PKR" <?php if($xin_system['default_currency']=='PKR'):?> selected="selected"<?php endif;?>>Pakistan Rupees</option>
                <option value="XPD" <?php if($xin_system['default_currency']=='XPD'):?> selected="selected"<?php endif;?>>Palladium Ounces</option>
                <option value="PHP" <?php if($xin_system['default_currency']=='PHP'):?> selected="selected"<?php endif;?>>Philippines Pesos</option>
                <option value="XPT" <?php if($xin_system['default_currency']=='XPT'):?> selected="selected"<?php endif;?>>Platinum Ounces</option>
                <option value="PLZ" <?php if($xin_system['default_currency']=='PLZ'):?> selected="selected"<?php endif;?>>Poland Zloty</option>
                <option value="PTE" <?php if($xin_system['default_currency']=='PTE'):?> selected="selected"<?php endif;?>>Portugal Escudo</option>
                <option value="ROL" <?php if($xin_system['default_currency']=='ROL'):?> selected="selected"<?php endif;?>>Romania Leu</option>
                <option value="RUR" <?php if($xin_system['default_currency']=='RUR'):?> selected="selected"<?php endif;?>>Russia Rubles</option>
                <option value="SAR" <?php if($xin_system['default_currency']=='SAR'):?> selected="selected"<?php endif;?>>Saudi Arabia Riyal</option>
                <option value="XAG" <?php if($xin_system['default_currency']=='XAG'):?> selected="selected"<?php endif;?>>Silver Ounces</option>
                <option value="SGD" <?php if($xin_system['default_currency']=='SGD'):?> selected="selected"<?php endif;?>>Singapore Dollars</option>
                <option value="SKK" <?php if($xin_system['default_currency']=='SKK'):?> selected="selected"<?php endif;?>>Slovakia Koruna</option>
                <option value="ZAR" <?php if($xin_system['default_currency']=='ZAR'):?> selected="selected"<?php endif;?>>South Africa Rand</option>
                <option value="KRW" <?php if($xin_system['default_currency']=='KRW'):?> selected="selected"<?php endif;?>>South Korea Won</option>
                <option value="ESP" <?php if($xin_system['default_currency']=='ESP'):?> selected="selected"<?php endif;?>>Spain Pesetas</option>
                <option value="XDR" <?php if($xin_system['default_currency']=='XDR'):?> selected="selected"<?php endif;?>>Special Drawing Right (IMF)</option>
                <option value="SDD" <?php if($xin_system['default_currency']=='SDD'):?> selected="selected"<?php endif;?>>Sudan Dinar</option>
                <option value="SEK" <?php if($xin_system['default_currency']=='SEK'):?> selected="selected"<?php endif;?>>Sweden Krona</option>
                <option value="CHF" <?php if($xin_system['default_currency']=='CHF'):?> selected="selected"<?php endif;?>>Switzerland Francs</option>
                <option value="TWD" <?php if($xin_system['default_currency']=='TWD'):?> selected="selected"<?php endif;?>>Taiwan Dollars</option>
                <option value="THB" <?php if($xin_system['default_currency']=='THB'):?> selected="selected"<?php endif;?>>Thailand Baht</option>
                <option value="TTD" <?php if($xin_system['default_currency']=='TTD'):?> selected="selected"<?php endif;?>>Trinidad and Tobago Dollars</option>
                <option value="TRL" <?php if($xin_system['default_currency']=='TRL'):?> selected="selected"<?php endif;?>>Turkey Lira</option>
                <option value="VEB" <?php if($xin_system['default_currency']=='VEB'):?> selected="selected"<?php endif;?>>Venezuela Bolivar</option>
                <option value="ZMK" <?php if($xin_system['default_currency']=='ZMK'):?> selected="selected"<?php endif;?>>Zambia Kwacha</option>
                <option value="XCD" <?php if($xin_system['default_currency']=='XCD'):?> selected="selected"<?php endif;?>>Eastern Caribbean Dollars</option>
                <option value="XDR" <?php if($xin_system['default_currency']=='XDR'):?> selected="selected"<?php endif;?>>Special Drawing Right (IMF)</option>
                <option value="XAG" <?php if($xin_system['default_currency']=='XAG'):?> selected="selected"<?php endif;?>>Silver Ounces</option>
                <option value="XAU" <?php if($xin_system['default_currency']=='XAU'):?> selected="selected"<?php endif;?>>Gold Ounces</option>
                <option value="XPD" <?php if($xin_system['default_currency']=='XPD'):?> selected="selected"<?php endif;?>>Palladium Ounces</option>
                <option value="XPT" <?php if($xin_system['default_currency']=='XPT'):?> selected="selected"<?php endif;?>>Platinum Ounces</option>
                </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_setting_timezone');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_setting_timezone');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <?php foreach(generate_timezone_list() as $tval=>$labels):?>
                    <option value="<?= $tval;?>" <?php if($xin_system['system_timezone']==$tval){?> selected <?php }?>>
                    <?= $labels;?>
                    </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_invoice_terms_condition');?>
                    <span class="text-danger">*</span> </label>
                  <textarea class="form-control" name="invoice_terms_condition" rows="3"><?= $xin_system['invoice_terms_condition'];?>
</textarea>
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
    <div class="tab-pane fade" id="user-edit-account">
      <div class="card-header">
          <h5><i data-feather="user" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_personal_info');?>
            </span></h5>
        </div>
        <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_user', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
        <?= form_open('erp/profile/update_profile', $attributes, $hidden);?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Main.xin_employee_first_name');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="<?= $result['first_name'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="last_name" class="control-label">
                  <?= lang('Main.xin_employee_last_name');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="<?= $result['last_name'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">
                  <?= lang('Main.xin_email');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="email" value="<?= $result['email'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">
                  <?= lang('Main.dashboard_username');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text" value="<?= $result['username'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="contact_number">
                  <?= lang('Main.xin_contact_number');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="gender" class="control-label">
                  <?= lang('Main.xin_employee_gender');?>
                </label>
                <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                  <option value="1" <?php if('1'==$result['gender']):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_gender_male');?>
                  </option>
                  <option value="2"<?php if('2'==$result['gender']):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_gender_female');?>
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="country">
                  <?= lang('Main.xin_country');?>
                  <span class="text-danger">*</span> </label>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                  <option value="">
                  <?= lang('Main.xin_select_one');?>
                  </option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?= $country['country_id'];?>" <?php if($country['country_id']==$result['country']):?> selected="selected"<?php endif;?>>
                  <?= $country['country_name'];?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address_1">
                  <?= lang('Main.xin_address');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address_1" type="text" value="<?= $result['address_1'];?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address_2"> &nbsp;</label>
                <input class="form-control" placeholder="<?= lang('Main.xin_address_2');?>" name="address_2" type="text" value="<?= $result['address_2'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="city">
                  <?= lang('Main.xin_city');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="state">
                  <?= lang('Main.xin_state');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="zipcode">
                  <?= lang('Main.xin_zipcode');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-profile-logo">
      <div class="card-header">
          <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_e_details_profile_picture');?>
            </span></h5>
        </div>
        <?php $attributes = array('name' => 'edit_user_photo', 'id' => 'edit_user_photo', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
        <?= form_open('erp/profile/update_profile_photo', $attributes, $hidden);?>
        <div class="card-body pb-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Company.xin_company_logo');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file">
                  <label class="custom-file-label">
                    <?= lang('Main.xin_choose_file');?>
                  </label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-password" role="tabpanel" aria-labelledby="user-password-tab">
        <div class="alert alert-warning" role="alert">
          <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i><?= lang('Main.xin_alert');?></h5>
          <p><?= lang('Main.xin_dont_share_password');?></p>
        </div>
        <div class="card-header">
          <h5><i data-feather="shield" class="icon-svg-primary wid-20"></i><span class="p-l-5"><?= lang('Main.header_change_password');?></span></h5>
        </div>
        <?php $attributes = array('name' => 'change_password', 'id' => 'change_password', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
        <?= form_open('erp/profile/update_password', $attributes, $hidden);?>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>
                  <?= lang('Main.xin_current_password');?>
                </label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                  <input type="password" readonly="readonly" class="form-control" name="pass" placeholder="<?= lang('Main.xin_current_password');?>" value="********">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>
                  <?= lang('Main.xin_new_password');?>
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                  <input type="password" class="form-control" name="new_password" placeholder="<?= lang('Main.xin_new_password');?>">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>
                  <?= lang('Main.xin_repeat_new_password');?>
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                  <input type="password" class="form-control" name="confirm_password" placeholder="<?= lang('Main.xin_repeat_new_password');?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-danger"><?= lang('Main.header_change_password');?></button>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-companyinfo">
      <div class="card-header">
          <h5><i data-feather="file-text" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_company_info');?>
            </span></h5>
        </div>
        <div class="card-body pb-2">
          <?php $attributes = array('name' => 'company_info', 'id' => 'company_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
          <?= form_open('erp/profile/update_company_info', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Company.xin_company_name');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_company_name');?>" name="company_name" type="text" value="<?= $user_info['company_name'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Company.xin_company_type');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="company_type" data-plugin="select_hrm" data-placeholder="<?= lang('Company.xin_company_type');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <?php foreach($company_types as $ctype) {?>
                    <option value="<?= $ctype['constants_id'];?>" <?php if($user_info['company_type_id']==$ctype['constants_id']){?> selected="selected" <?php } ?>>
                    <?= $ctype['category_name'];?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="trading_name">
                    <?= lang('Company.xin_company_trading');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_company_trading');?>" name="trading_name" type="text" value="<?= $user_info['trading_name'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="xin_gtax">
                    <?= lang('Company.xin_gtax');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_gtax');?>" name="xin_gtax" type="text" value="<?= $user_info['government_tax'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="registration_no">
                    <?= lang('Company.xin_company_registration');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_company_registration');?>" name="registration_no" type="text" value="<?= $user_info['registration_no'];?>">
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
