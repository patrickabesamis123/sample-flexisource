@extends('layouts.home')

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>
<div class="container-fluid">
   <div class="row">      
    
    <div class="col-md-12 employerregister" id="Register_employer">
        <div class="row ng-scope" ng-controller="RegisterController">
            <div class="content-container col-md-12">
                <div class="formContainer formStepsHolder">
                    <div class="carousel slide" data-ride="carousel" id="carousel-example-generic" ng-init="">
                        <div class="control ng-hide" ng-hide="true">
                            <div class="left triggerPrev item text-center ng-isolate-scope" data-slide="prev" href="/register/employer/#carousel-example-generic" ng-class="{ 'active': leaving || (active &amp;&amp; !entering), 'prev': (next || active) &amp;&amp; direction=='prev', 'next': (next || active) &amp;&amp; direction=='next', 'right': direction=='prev', 'left': direction=='next' }" ng-transclude="" role="button">
                                <span class="ng-scope">Previous</span>
                            </div>
                            <div class="right triggerNext item text-center ng-isolate-scope" data-slide="next" href="/register/employer/#carousel-example-generic" ng-class="{ 'active': leaving || (active &amp;&amp; !entering), 'prev': (next || active) &amp;&amp; direction=='prev', 'next': (next || active) &amp;&amp; direction=='next', 'right': direction=='prev', 'left': direction=='next' }" ng-transclude="" role="button">
                                <span class="ng-scope">Next</span>
                            </div>
                            <ul>
                                <li class="triggerLast" data-slide-to="4" data-target="#carousel-example-generic">Last</li>
                            </ul>
                        </div><!-- Wrapper for slides -->
                        <div class="carousel-inner step-container" role="listbox">
                            <div class="item active">
                                <div id="FormStep1">
                                    <div class="register-form-container">
                                        <div class="loadme ng-hide" ng-hide="preload"><img src="https://staging.previewmedev.co//themes/bbt/images/preloader.gif"></div>
                                        <h3>Personal Information</h3>
                                        <ul class="errmsg ng-binding">
                                            <!-- ngRepeat: (key, val) in ErrorMsgs -->
                                        </ul>
                                        <form class="ng-pristine ng-invalid ng-invalid-required" id="Step1Form" name="Step1Form" ng-submit="SubmitEmployerStep1()">
                                            <fieldset>
                                                <hr class="divider">
                                                <h4>General Details</h4>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-valid ng-empty ng-touched" id="Form_nickname" name="nickname" ng-model="nickname" placeholder="Nickname" type="text">
                                                </div>
                                                <hr class="divider">
                                                <h4>Contact Information</h4>
                                                <div class="field text nolabel inline-field">
                                                    <input class="text nolabel left required ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_phone_number" name="phone_number" ng-keypress="numbersOnly()" ng-model="phone_number" placeholder="Phone Number" required="required" type="text"> <span class="asterisk s1_phone">*</span> <input class="text nolabel right ng-pristine ng-untouched ng-valid ng-empty" id="Form_phone_extension" name="phone_extension" ng-keypress="numbersOnly()" ng-model="phone_extension" placeholder="Extension" type="text">
                                                </div>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel required ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_mobile_number" name="mobile_number" ng-keypress="numbersOnly()" ng-model="mobile_number" placeholder="Mobile Number" required="required" type="text"> <span class="asterisk s1_mobile">*</span>
                                                </div>
                                                <hr class="divider">
                                                <h4>Work Information</h4>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_work_title" name="work_title" ng-model="work_title" placeholder="Title" type="text">
                                                </div>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_work_dept" name="work_dept" ng-model="work_dept" placeholder="Department" type="text">
                                                </div>
                                                <hr class="divider">
                                                <h4 id="profile_picture_label">Your Profile Picture</h4><i class="pvm-blue">Max size 2MB</i>
                                                <div class="field profile_picture_url text nolabel">
                                                    <div class="custom-file-upload">
                                                        <div class="file-upload-wrapper">
                                                            <input class="file inputfile inputfile-6 custom-file-upload-hidden" id="profileImage" placeholder="Profile Image" style="position: absolute; left: -9999px;" tabindex="-1" type="file"><input class="file-upload-input" ng-show="true" placeholder="Upload profile image" type="text"><button class="file-upload-button" data-docfiletype="image" ng-click="open_file_modal($event)" tabindex="-1" type="button">Browse</button>
                                                        </div>
                                                    </div>
                                                    <div id="profileImageMessage"></div>
                                                    <div animate="true" class="progress-striped active ng-hide progress ng-isolate-scope" id="profileImageProgress" max="100" type="success" value="progressResumeValue">
                                                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="" aria-valuetext="%" class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" ng-style="{width: percent + '%'}" ng-transclude="" role="progressbar"></div>
                                                    </div><input class="ng-pristine ng-untouched ng-valid ng-empty ng-hide" name="profile_picture_url" ng-hide="true" ng-model="image_url" type="text" val="">
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr class="divider">
                                            </fieldset>
                                            <div class="Actions">
                                                <input class="action submitblue submit pull-right" id="Form_action_doNothing" name="action_doNothing" type="submit" value="Continue"> <!-- <a href="/register/employer/#carousel-example-generic" role="button" class="btn submityellow" data-slide="next">Skip <span class="glyphicon glyphicon-arrow-right"></span>  </a>-->
                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div id="FormStep2">
                                    <div class="register-form-container">
                                        <div class="loadme ng-hide" ng-hide="preload"><img src="https://staging.previewmedev.co//themes/bbt/images/preloader.gif"></div>
                                        <h3>Company Information</h3>
                                        <div class="divider"></div>
                                        <ul class="errmsg">
                                            <!-- ngRepeat: (key, val) in ErrorMsgs -->
                                        </ul>
                                        <form class="ng-pristine ng-invalid ng-invalid-required" id="Step2Form" name="Step2Form" ng-submit="SubmitEmployerStep2()">
                                            <hr class="divider">
                                            <h4>General Details</h4>
                                            <fieldset>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel required ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_company_name" name="company_name" ng-model="company_name" placeholder="Company Name" required="required" type="text"> <span class="asterisk s2_cname">*</span>
                                                </div>
                                                <div class="field text nolabel">
                                                    <select name="num_of_employees" required="required">
                                                        <option selected="selected" value="">
                                                            Company Size
                                                        </option><!-- ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="1 - 5">
                                                            1 - 5
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="6 - 19">
                                                            6 - 19
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="20 - 49">
                                                            20 - 49
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="50 - 99">
                                                            50 - 99
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="100 - 499">
                                                            100 - 499
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="500 - 999">
                                                            500 - 999
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="1000 - 2999">
                                                            1000 - 2999
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="3000 - 4999">
                                                            3000 - 4999
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value=" 5000 - 9999">
                                                            5000 - 9999
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                        <option class="ng-binding ng-scope" ng-repeat="item in number_of_employees" value="10000 +">
                                                            10000 +
                                                        </option><!-- end ngRepeat: item in number_of_employees -->
                                                    </select> <span class="asterisk s2_nemp">*</span>
                                                </div>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_company_phone" name="company_phone" ng-keypress="numbersOnly($event)" ng-model="company_phone" placeholder="Company Phone" type="text">
                                                </div>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_company_fax" name="company_fax" ng-keypress="numbersOnly($event)" ng-model="company_fax" placeholder="Company Fax" type="text">
                                                </div>
                                                <div class="field text nolabel">
                                                    <select class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="industry_step2" ng-model="industries_step2" ng-options="s.id as s.display_name for s in industries track by s.id" required="required">
                                                        <option class="" selected="selected" value="">
                                                            Select Classification
                                                        </option>
                                                        <option label="Accounting" value="20">
                                                            Accounting
                                                        </option>
                                                        <option label="Administration &amp; Office Support" value="21">
                                                            Administration &amp; Office Support
                                                        </option>
                                                        <option label="Advertising, Arts &amp; Media" value="22">
                                                            Advertising, Arts &amp; Media
                                                        </option>
                                                        <option label="Banking &amp; Financial Services" value="23">
                                                            Banking &amp; Financial Services
                                                        </option>
                                                        <option label="Call Centre &amp; Customer Service" value="24">
                                                            Call Centre &amp; Customer Service
                                                        </option>
                                                        <option label="CEO &amp; General Management" value="25">
                                                            CEO &amp; General Management
                                                        </option>
                                                        <option label="Community Services &amp; Development" value="26">
                                                            Community Services &amp; Development
                                                        </option>
                                                        <option label="Construction" value="27">
                                                            Construction
                                                        </option>
                                                        <option label="Consulting &amp; Strategy" value="28">
                                                            Consulting &amp; Strategy
                                                        </option>
                                                        <option label="Design &amp; Architecture" value="29">
                                                            Design &amp; Architecture
                                                        </option>
                                                        <option label="Education &amp; Training" value="30">
                                                            Education &amp; Training
                                                        </option>
                                                        <option label="Engineering" value="31">
                                                            Engineering
                                                        </option>
                                                        <option label="Farming, Animals &amp; Conservation" value="32">
                                                            Farming, Animals &amp; Conservation
                                                        </option>
                                                        <option label="Government &amp; Defence" value="33">
                                                            Government &amp; Defence
                                                        </option>
                                                        <option label="Healthcare &amp; Medical" value="34">
                                                            Healthcare &amp; Medical
                                                        </option>
                                                        <option label="Hospitality &amp; Tourism" value="35">
                                                            Hospitality &amp; Tourism
                                                        </option>
                                                        <option label="Human Resources &amp; Recruitment" value="36">
                                                            Human Resources &amp; Recruitment
                                                        </option>
                                                        <option label="Information &amp; Communication Technology" value="37">
                                                            Information &amp; Communication Technology
                                                        </option>
                                                        <option label="Insurance &amp; Superannuation" value="38">
                                                            Insurance &amp; Superannuation
                                                        </option>
                                                        <option label="Legal" value="58">
                                                            Legal
                                                        </option>
                                                        <option label="Manufacturing, Transport &amp; Logistics" value="59">
                                                            Manufacturing, Transport &amp; Logistics
                                                        </option>
                                                        <option label="Marketing &amp; Communications" value="60">
                                                            Marketing &amp; Communications
                                                        </option>
                                                        <option label="Mining, Resources &amp; Energy" value="61">
                                                            Mining, Resources &amp; Energy
                                                        </option>
                                                        <option label="Real Estate &amp; Property" value="62">
                                                            Real Estate &amp; Property
                                                        </option>
                                                        <option label="Retail &amp; Consumer Products" value="63">
                                                            Retail &amp; Consumer Products
                                                        </option>
                                                        <option label="Sales" value="64">
                                                            Sales
                                                        </option>
                                                        <option label="Science &amp; Technology" value="65">
                                                            Science &amp; Technology
                                                        </option>
                                                        <option label="Self Employment" value="66">
                                                            Self Employment
                                                        </option>
                                                        <option label="Sport &amp; Recreation" value="67">
                                                            Sport &amp; Recreation
                                                        </option>
                                                        <option label="Trades &amp; Services" value="68">
                                                            Trades &amp; Services
                                                        </option>
                                                    </select> <span class="asterisk s2_ind">*</span>
                                                </div>
                                                <div class="field text nolabel">
                                                    <div class="text-center ng-hide" ng-hide="subIndustryLoader">
                                                        <img src="https://staging.previewmedev.co//themes/bbt/images/preloader.gif" width="15"><br>
                                                        Loading Sub Classification
                                                    </div><select class="ng-pristine ng-untouched ng-valid ng-empty ng-hide" name="subindustry_step2" ng-hide="subIndustryEl" ng-model="subindustry_step2" ng-options="s.id as s.display_name for s in subIndustries track by s.id">
                                                        <option class="" selected="selected" value="">
                                                            Select Sub-Classification
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_website_url" name="website_url" ng-model="website_url" placeholder="Website (http://www.website.com)" type="text">
                                                </div>
                                                <hr class="divider">
                                                <h4>Company Address</h4>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_street_address" name="street_address" ng-model="street_address" placeholder="Address Line 1" type="text">
                                                </div>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_street_address_2" name="street_address_2" ng-model="street_address_2" placeholder="Address Line 2" type="text">
                                                </div>
                                                <div class="field text nolabel">
                                                    <div class="text-center ng-hide" ng-show="hidecounty">
                                                        <img src="https://staging.previewmedev.co//themes/bbt/images/preloader.gif" width="15"><br>
                                                        Loading Countries
                                                    </div><select class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="country" ng-hide="hidecounty" ng-model="country" ng-options=" item as item.display_name for item in countries track by item.id" required="required">
                                                        <option class="" selected="selected" value="">
                                                            Select Country
                                                        </option>
                                                        <option label="Afghanistan" value="1">
                                                            Afghanistan
                                                        </option>
                                                        <option label="Albania" value="2">
                                                            Albania
                                                        </option>
                                                        <option label="Algeria" value="3">
                                                            Algeria
                                                        </option>
                                                        <option label="American Samoa" value="4">
                                                            American Samoa
                                                        </option>
                                                        <option label="Andorra" value="5">
                                                            Andorra
                                                        </option>
                                                        <option label="Angola" value="6">
                                                            Angola
                                                        </option>
                                                        <option label="Anguilla" value="7">
                                                            Anguilla
                                                        </option>
                                                        <option label="Antarctica" value="8">
                                                            Antarctica
                                                        </option>
                                                        <option label="Antigua And Barbuda" value="9">
                                                            Antigua And Barbuda
                                                        </option>
                                                        <option label="Argentina" value="10">
                                                            Argentina
                                                        </option>
                                                        <option label="Armenia" value="11">
                                                            Armenia
                                                        </option>
                                                        <option label="Aruba" value="12">
                                                            Aruba
                                                        </option>
                                                        <option label="Australia" value="13">
                                                            Australia
                                                        </option>
                                                        <option label="Austria" value="14">
                                                            Austria
                                                        </option>
                                                        <option label="Azerbaijan" value="15">
                                                            Azerbaijan
                                                        </option>
                                                        <option label="Bahamas" value="16">
                                                            Bahamas
                                                        </option>
                                                        <option label="Bahrain" value="17">
                                                            Bahrain
                                                        </option>
                                                        <option label="Bangladesh" value="18">
                                                            Bangladesh
                                                        </option>
                                                        <option label="Barbados" value="19">
                                                            Barbados
                                                        </option>
                                                        <option label="Belarus" value="20">
                                                            Belarus
                                                        </option>
                                                        <option label="Belgium" value="21">
                                                            Belgium
                                                        </option>
                                                        <option label="Belize" value="22">
                                                            Belize
                                                        </option>
                                                        <option label="Benin" value="23">
                                                            Benin
                                                        </option>
                                                        <option label="Bermuda" value="24">
                                                            Bermuda
                                                        </option>
                                                        <option label="Bhutan" value="25">
                                                            Bhutan
                                                        </option>
                                                        <option label="Bolivia" value="26">
                                                            Bolivia
                                                        </option>
                                                        <option label="Bosnia And Herzegovina" value="27">
                                                            Bosnia And Herzegovina
                                                        </option>
                                                        <option label="Botswana" value="28">
                                                            Botswana
                                                        </option>
                                                        <option label="Bouvet Island" value="29">
                                                            Bouvet Island
                                                        </option>
                                                        <option label="Brazil" value="30">
                                                            Brazil
                                                        </option>
                                                        <option label="British Indian Ocean Territory" value="31">
                                                            British Indian Ocean Territory
                                                        </option>
                                                        <option label="Brunei Darussalam" value="32">
                                                            Brunei Darussalam
                                                        </option>
                                                        <option label="Bulgaria" value="33">
                                                            Bulgaria
                                                        </option>
                                                        <option label="Burkina Faso" value="34">
                                                            Burkina Faso
                                                        </option>
                                                        <option label="Burundi" value="35">
                                                            Burundi
                                                        </option>
                                                        <option label="Cambodia" value="36">
                                                            Cambodia
                                                        </option>
                                                        <option label="Cameroon" value="37">
                                                            Cameroon
                                                        </option>
                                                        <option label="Canada" value="38">
                                                            Canada
                                                        </option>
                                                        <option label="Cape Verde" value="39">
                                                            Cape Verde
                                                        </option>
                                                        <option label="Cayman Islands" value="40">
                                                            Cayman Islands
                                                        </option>
                                                        <option label="Central African Republic" value="41">
                                                            Central African Republic
                                                        </option>
                                                        <option label="Chad" value="42">
                                                            Chad
                                                        </option>
                                                        <option label="Chile" value="43">
                                                            Chile
                                                        </option>
                                                        <option label="China" value="44">
                                                            China
                                                        </option>
                                                        <option label="Christmas Island" value="45">
                                                            Christmas Island
                                                        </option>
                                                        <option label="Cocos (keeling) Islands" value="46">
                                                            Cocos (keeling) Islands
                                                        </option>
                                                        <option label="Colombia" value="47">
                                                            Colombia
                                                        </option>
                                                        <option label="Comoros" value="48">
                                                            Comoros
                                                        </option>
                                                        <option label="Congo" value="49">
                                                            Congo
                                                        </option>
                                                        <option label="Congo, The Democratic Republic Of The" value="50">
                                                            Congo, The Democratic Republic Of The
                                                        </option>
                                                        <option label="Cook Islands" value="51">
                                                            Cook Islands
                                                        </option>
                                                        <option label="Costa Rica" value="52">
                                                            Costa Rica
                                                        </option>
                                                        <option label="Cote D'ivoire" value="53">
                                                            Cote D'ivoire
                                                        </option>
                                                        <option label="Croatia" value="54">
                                                            Croatia
                                                        </option>
                                                        <option label="Cuba" value="55">
                                                            Cuba
                                                        </option>
                                                        <option label="Cyprus" value="56">
                                                            Cyprus
                                                        </option>
                                                        <option label="Czech Republic" value="57">
                                                            Czech Republic
                                                        </option>
                                                        <option label="Denmark" value="58">
                                                            Denmark
                                                        </option>
                                                        <option label="Djibouti" value="59">
                                                            Djibouti
                                                        </option>
                                                        <option label="Dominica" value="60">
                                                            Dominica
                                                        </option>
                                                        <option label="Dominican Republic" value="61">
                                                            Dominican Republic
                                                        </option>
                                                        <option label="East Timor" value="62">
                                                            East Timor
                                                        </option>
                                                        <option label="Ecuador" value="63">
                                                            Ecuador
                                                        </option>
                                                        <option label="Egypt" value="64">
                                                            Egypt
                                                        </option>
                                                        <option label="El Salvador" value="65">
                                                            El Salvador
                                                        </option>
                                                        <option label="Equatorial Guinea" value="66">
                                                            Equatorial Guinea
                                                        </option>
                                                        <option label="Eritrea" value="67">
                                                            Eritrea
                                                        </option>
                                                        <option label="Estonia" value="68">
                                                            Estonia
                                                        </option>
                                                        <option label="Ethiopia" value="69">
                                                            Ethiopia
                                                        </option>
                                                        <option label="Falkland Islands (malvinas)" value="70">
                                                            Falkland Islands (malvinas)
                                                        </option>
                                                        <option label="Faroe Islands" value="71">
                                                            Faroe Islands
                                                        </option>
                                                        <option label="Fiji" value="72">
                                                            Fiji
                                                        </option>
                                                        <option label="Finland" value="73">
                                                            Finland
                                                        </option>
                                                        <option label="France" value="74">
                                                            France
                                                        </option>
                                                        <option label="French Guiana" value="75">
                                                            French Guiana
                                                        </option>
                                                        <option label="French Polynesia" value="76">
                                                            French Polynesia
                                                        </option>
                                                        <option label="French Southern Territories" value="77">
                                                            French Southern Territories
                                                        </option>
                                                        <option label="Gabon" value="78">
                                                            Gabon
                                                        </option>
                                                        <option label="Gambia" value="79">
                                                            Gambia
                                                        </option>
                                                        <option label="Georgia" value="80">
                                                            Georgia
                                                        </option>
                                                        <option label="Germany" value="81">
                                                            Germany
                                                        </option>
                                                        <option label="Ghana" value="82">
                                                            Ghana
                                                        </option>
                                                        <option label="Gibraltar" value="83">
                                                            Gibraltar
                                                        </option>
                                                        <option label="Greece" value="84">
                                                            Greece
                                                        </option>
                                                        <option label="Greenland" value="85">
                                                            Greenland
                                                        </option>
                                                        <option label="Grenada" value="86">
                                                            Grenada
                                                        </option>
                                                        <option label="Guadeloupe" value="87">
                                                            Guadeloupe
                                                        </option>
                                                        <option label="Guam" value="88">
                                                            Guam
                                                        </option>
                                                        <option label="Guatemala" value="89">
                                                            Guatemala
                                                        </option>
                                                        <option label="Guinea" value="90">
                                                            Guinea
                                                        </option>
                                                        <option label="Guinea-bissau" value="91">
                                                            Guinea-bissau
                                                        </option>
                                                        <option label="Guyana" value="92">
                                                            Guyana
                                                        </option>
                                                        <option label="Haiti" value="93">
                                                            Haiti
                                                        </option>
                                                        <option label="Heard Island And Mcdonald Islands" value="94">
                                                            Heard Island And Mcdonald Islands
                                                        </option>
                                                        <option label="Holy See (vatican City State)" value="95">
                                                            Holy See (vatican City State)
                                                        </option>
                                                        <option label="Honduras" value="96">
                                                            Honduras
                                                        </option>
                                                        <option label="Hong Kong" value="97">
                                                            Hong Kong
                                                        </option>
                                                        <option label="Hungary" value="98">
                                                            Hungary
                                                        </option>
                                                        <option label="Iceland" value="99">
                                                            Iceland
                                                        </option>
                                                        <option label="India" value="100">
                                                            India
                                                        </option>
                                                        <option label="Indonesia" value="101">
                                                            Indonesia
                                                        </option>
                                                        <option label="Iran, Islamic Republic Of" value="102">
                                                            Iran, Islamic Republic Of
                                                        </option>
                                                        <option label="Iraq" value="103">
                                                            Iraq
                                                        </option>
                                                        <option label="Ireland" value="104">
                                                            Ireland
                                                        </option>
                                                        <option label="Israel" value="105">
                                                            Israel
                                                        </option>
                                                        <option label="Italy" value="106">
                                                            Italy
                                                        </option>
                                                        <option label="Jamaica" value="107">
                                                            Jamaica
                                                        </option>
                                                        <option label="Japan" value="108">
                                                            Japan
                                                        </option>
                                                        <option label="Jordan" value="109">
                                                            Jordan
                                                        </option>
                                                        <option label="Kazakstan" value="110">
                                                            Kazakstan
                                                        </option>
                                                        <option label="Kenya" value="111">
                                                            Kenya
                                                        </option>
                                                        <option label="Kiribati" value="112">
                                                            Kiribati
                                                        </option>
                                                        <option label="Korea, Democratic People's Republic Of" value="113">
                                                            Korea, Democratic People's Republic Of
                                                        </option>
                                                        <option label="Korea, Republic Of" value="114">
                                                            Korea, Republic Of
                                                        </option>
                                                        <option label="Kosovo" value="115">
                                                            Kosovo
                                                        </option>
                                                        <option label="Kuwait" value="116">
                                                            Kuwait
                                                        </option>
                                                        <option label="Kyrgyzstan" value="117">
                                                            Kyrgyzstan
                                                        </option>
                                                        <option label="Lao People's Democratic Republic" value="118">
                                                            Lao People's Democratic Republic
                                                        </option>
                                                        <option label="Latvia" value="119">
                                                            Latvia
                                                        </option>
                                                        <option label="Lebanon" value="120">
                                                            Lebanon
                                                        </option>
                                                        <option label="Lesotho" value="121">
                                                            Lesotho
                                                        </option>
                                                        <option label="Liberia" value="122">
                                                            Liberia
                                                        </option>
                                                        <option label="Libyan Arab Jamahiriya" value="123">
                                                            Libyan Arab Jamahiriya
                                                        </option>
                                                        <option label="Liechtenstein" value="124">
                                                            Liechtenstein
                                                        </option>
                                                        <option label="Lithuania" value="125">
                                                            Lithuania
                                                        </option>
                                                        <option label="Luxembourg" value="126">
                                                            Luxembourg
                                                        </option>
                                                        <option label="Macau" value="127">
                                                            Macau
                                                        </option>
                                                        <option label="Macedonia, The Former Yugoslav Republic Of" value="128">
                                                            Macedonia, The Former Yugoslav Republic Of
                                                        </option>
                                                        <option label="Madagascar" value="129">
                                                            Madagascar
                                                        </option>
                                                        <option label="Malawi" value="130">
                                                            Malawi
                                                        </option>
                                                        <option label="Malaysia" value="131">
                                                            Malaysia
                                                        </option>
                                                        <option label="Maldives" value="132">
                                                            Maldives
                                                        </option>
                                                        <option label="Mali" value="133">
                                                            Mali
                                                        </option>
                                                        <option label="Malta" value="134">
                                                            Malta
                                                        </option>
                                                        <option label="Marshall Islands" value="135">
                                                            Marshall Islands
                                                        </option>
                                                        <option label="Martinique" value="136">
                                                            Martinique
                                                        </option>
                                                        <option label="Mauritania" value="137">
                                                            Mauritania
                                                        </option>
                                                        <option label="Mauritius" value="138">
                                                            Mauritius
                                                        </option>
                                                        <option label="Mayotte" value="139">
                                                            Mayotte
                                                        </option>
                                                        <option label="Mexico" value="140">
                                                            Mexico
                                                        </option>
                                                        <option label="Micronesia, Federated States Of" value="141">
                                                            Micronesia, Federated States Of
                                                        </option>
                                                        <option label="Moldova, Republic Of" value="142">
                                                            Moldova, Republic Of
                                                        </option>
                                                        <option label="Monaco" value="143">
                                                            Monaco
                                                        </option>
                                                        <option label="Mongolia" value="144">
                                                            Mongolia
                                                        </option>
                                                        <option label="Montserrat" value="145">
                                                            Montserrat
                                                        </option>
                                                        <option label="Montenegro" value="146">
                                                            Montenegro
                                                        </option>
                                                        <option label="Morocco" value="147">
                                                            Morocco
                                                        </option>
                                                        <option label="Mozambique" value="148">
                                                            Mozambique
                                                        </option>
                                                        <option label="Myanmar" value="149">
                                                            Myanmar
                                                        </option>
                                                        <option label="Namibia" value="150">
                                                            Namibia
                                                        </option>
                                                        <option label="Nauru" value="151">
                                                            Nauru
                                                        </option>
                                                        <option label="Nepal" value="152">
                                                            Nepal
                                                        </option>
                                                        <option label="Netherlands" value="153">
                                                            Netherlands
                                                        </option>
                                                        <option label="Netherlands Antilles" value="154">
                                                            Netherlands Antilles
                                                        </option>
                                                        <option label="New Caledonia" value="155">
                                                            New Caledonia
                                                        </option>
                                                        <option label="New Zealand" value="156">
                                                            New Zealand
                                                        </option>
                                                        <option label="Nicaragua" value="157">
                                                            Nicaragua
                                                        </option>
                                                        <option label="Niger" value="158">
                                                            Niger
                                                        </option>
                                                        <option label="Nigeria" value="159">
                                                            Nigeria
                                                        </option>
                                                        <option label="Niue" value="160">
                                                            Niue
                                                        </option>
                                                        <option label="Norfolk Island" value="161">
                                                            Norfolk Island
                                                        </option>
                                                        <option label="Northern Mariana Islands" value="162">
                                                            Northern Mariana Islands
                                                        </option>
                                                        <option label="Norway" value="163">
                                                            Norway
                                                        </option>
                                                        <option label="Oman" value="164">
                                                            Oman
                                                        </option>
                                                        <option label="Pakistan" value="165">
                                                            Pakistan
                                                        </option>
                                                        <option label="Palau" value="166">
                                                            Palau
                                                        </option>
                                                        <option label="Palestinian Territory, Occupied" value="167">
                                                            Palestinian Territory, Occupied
                                                        </option>
                                                        <option label="Panama" value="168">
                                                            Panama
                                                        </option>
                                                        <option label="Papua New Guinea" value="169">
                                                            Papua New Guinea
                                                        </option>
                                                        <option label="Paraguay" value="170">
                                                            Paraguay
                                                        </option>
                                                        <option label="Peru" value="171">
                                                            Peru
                                                        </option>
                                                        <option label="Philippines" value="172">
                                                            Philippines
                                                        </option>
                                                        <option label="Pitcairn" value="173">
                                                            Pitcairn
                                                        </option>
                                                        <option label="Poland" value="174">
                                                            Poland
                                                        </option>
                                                        <option label="Portugal" value="175">
                                                            Portugal
                                                        </option>
                                                        <option label="Puerto Rico" value="176">
                                                            Puerto Rico
                                                        </option>
                                                        <option label="Qatar" value="177">
                                                            Qatar
                                                        </option>
                                                        <option label="Reunion" value="178">
                                                            Reunion
                                                        </option>
                                                        <option label="Romania" value="179">
                                                            Romania
                                                        </option>
                                                        <option label="Russian Federation" value="180">
                                                            Russian Federation
                                                        </option>
                                                        <option label="Rwanda" value="181">
                                                            Rwanda
                                                        </option>
                                                        <option label="Saint Helena" value="182">
                                                            Saint Helena
                                                        </option>
                                                        <option label="Saint Kitts And Nevis" value="183">
                                                            Saint Kitts And Nevis
                                                        </option>
                                                        <option label="Saint Lucia" value="184">
                                                            Saint Lucia
                                                        </option>
                                                        <option label="Saint Pierre And Miquelon" value="185">
                                                            Saint Pierre And Miquelon
                                                        </option>
                                                        <option label="Saint Vincent And The Grenadines" value="186">
                                                            Saint Vincent And The Grenadines
                                                        </option>
                                                        <option label="Samoa" value="187">
                                                            Samoa
                                                        </option>
                                                        <option label="San Marino" value="188">
                                                            San Marino
                                                        </option>
                                                        <option label="Sao Tome And Principe" value="189">
                                                            Sao Tome And Principe
                                                        </option>
                                                        <option label="Saudi Arabia" value="190">
                                                            Saudi Arabia
                                                        </option>
                                                        <option label="Senegal" value="191">
                                                            Senegal
                                                        </option>
                                                        <option label="Serbia" value="192">
                                                            Serbia
                                                        </option>
                                                        <option label="Seychelles" value="193">
                                                            Seychelles
                                                        </option>
                                                        <option label="Sierra Leone" value="194">
                                                            Sierra Leone
                                                        </option>
                                                        <option label="Singapore" value="195">
                                                            Singapore
                                                        </option>
                                                        <option label="Slovakia" value="196">
                                                            Slovakia
                                                        </option>
                                                        <option label="Slovenia" value="197">
                                                            Slovenia
                                                        </option>
                                                        <option label="Solomon Islands" value="198">
                                                            Solomon Islands
                                                        </option>
                                                        <option label="Somalia" value="199">
                                                            Somalia
                                                        </option>
                                                        <option label="South Africa" value="200">
                                                            South Africa
                                                        </option>
                                                        <option label="South Georgia And The South Sandwich Islands" value="201">
                                                            South Georgia And The South Sandwich Islands
                                                        </option>
                                                        <option label="Spain" value="202">
                                                            Spain
                                                        </option>
                                                        <option label="Sri Lanka" value="203">
                                                            Sri Lanka
                                                        </option>
                                                        <option label="Sudan" value="204">
                                                            Sudan
                                                        </option>
                                                        <option label="Suriname" value="205">
                                                            Suriname
                                                        </option>
                                                        <option label="Svalbard And Jan Mayen" value="206">
                                                            Svalbard And Jan Mayen
                                                        </option>
                                                        <option label="Swaziland" value="207">
                                                            Swaziland
                                                        </option>
                                                        <option label="Sweden" value="208">
                                                            Sweden
                                                        </option>
                                                        <option label="Switzerland" value="209">
                                                            Switzerland
                                                        </option>
                                                        <option label="Syrian Arab Republic" value="210">
                                                            Syrian Arab Republic
                                                        </option>
                                                        <option label="Taiwan, Province Of China" value="211">
                                                            Taiwan, Province Of China
                                                        </option>
                                                        <option label="Tajikistan" value="212">
                                                            Tajikistan
                                                        </option>
                                                        <option label="Tanzania, United Republic Of" value="213">
                                                            Tanzania, United Republic Of
                                                        </option>
                                                        <option label="Thailand" value="214">
                                                            Thailand
                                                        </option>
                                                        <option label="Togo" value="215">
                                                            Togo
                                                        </option>
                                                        <option label="Tokelau" value="216">
                                                            Tokelau
                                                        </option>
                                                        <option label="Tonga" value="217">
                                                            Tonga
                                                        </option>
                                                        <option label="Trinidad And Tobago" value="218">
                                                            Trinidad And Tobago
                                                        </option>
                                                        <option label="Tunisia" value="219">
                                                            Tunisia
                                                        </option>
                                                        <option label="Turkey" value="220">
                                                            Turkey
                                                        </option>
                                                        <option label="Turkmenistan" value="221">
                                                            Turkmenistan
                                                        </option>
                                                        <option label="Turks And Caicos Islands" value="222">
                                                            Turks And Caicos Islands
                                                        </option>
                                                        <option label="Tuvalu" value="223">
                                                            Tuvalu
                                                        </option>
                                                        <option label="Uganda" value="224">
                                                            Uganda
                                                        </option>
                                                        <option label="Ukraine" value="225">
                                                            Ukraine
                                                        </option>
                                                        <option label="United Arab Emirates" value="226">
                                                            United Arab Emirates
                                                        </option>
                                                        <option label="United Kingdom" value="227">
                                                            United Kingdom
                                                        </option>
                                                        <option label="United States" value="228">
                                                            United States
                                                        </option>
                                                        <option label="United States Minor Outlying Islands" value="229">
                                                            United States Minor Outlying Islands
                                                        </option>
                                                        <option label="Uruguay" value="230">
                                                            Uruguay
                                                        </option>
                                                        <option label="Uzbekistan" value="231">
                                                            Uzbekistan
                                                        </option>
                                                        <option label="Vanuatu" value="232">
                                                            Vanuatu
                                                        </option>
                                                        <option label="Venezuela" value="233">
                                                            Venezuela
                                                        </option>
                                                        <option label="Viet Nam" value="234">
                                                            Viet Nam
                                                        </option>
                                                        <option label="Virgin Islands, British" value="235">
                                                            Virgin Islands, British
                                                        </option>
                                                        <option label="Virgin Islands, U.s." value="236">
                                                            Virgin Islands, U.s.
                                                        </option>
                                                        <option label="Wallis And Futuna" value="237">
                                                            Wallis And Futuna
                                                        </option>
                                                        <option label="Western Sahara" value="238">
                                                            Western Sahara
                                                        </option>
                                                        <option label="Yemen" value="239">
                                                            Yemen
                                                        </option>
                                                        <option label="Zambia" value="240">
                                                            Zambia
                                                        </option>
                                                        <option label="Zimbabwe" value="241">
                                                            Zimbabwe
                                                        </option>
                                                    </select>
                                                    <div class="locationAutoComplete">
                                                        <input class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" disabled="disabled" id="location" ng-disabled=" disableLocation" ng-model="searchLocation" ng-required="true" placeholder="Select a Location" required="required" type="text"> <input class="ng-pristine ng-untouched ng-valid ng-empty" id="LocationId" ng-model="LocationId" type="hidden">
                                                        <ul class="result ng-hide" id="autoDataLocation" ng-hide="hideme">
                                                            <!-- ngRepeat: (key, value) in autoLocation -->
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr class="divider">
                                                <h4>Other Details</h4>
                                                <div class="field text nolabel">
                                                    <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_nz_business_num" name="nz_business_num" ng-keypress="numbersOnly($event)" ng-model="nz_business_num" placeholder="NZ Business Number" type="text">
                                                </div>
                                                <div class="field email text nolabel">
                                                    <div class="file-upload-wrapper">
                                                        <input class="file ng-pristine ng-valid ng-empty ng-touched custom-file-upload-hidden" id="Form_my_file" placeholder="Company Logo" style="position: absolute; left: -9999px;" tabindex="-1" type="file"><input class="file-upload-input" ng-show="true" placeholder="Upload company logo" type="text"><button class="file-upload-button" data-docfiletype="image" ng-click="open_file_modal($event)" tabindex="-1" type="button">Browse</button>
                                                    </div>
                                                    <p><i class="pvm-gray" style="font-size:0.9em;">you will get better results using a 150x150 pixels image</i></p>
                                                    <div id="file_upload_msg"></div>
                                                    <div animate="true" class="progress-striped active ng-hide progress ng-isolate-scope" id="data_progress" max="100" type="success" value="progressResumeValue">
                                                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="" aria-valuetext="%" class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" ng-style="{width: percent + '%'}" ng-transclude="" role="progressbar"></div>
                                                    </div><input class="ng-pristine ng-untouched ng-valid ng-empty ng-hide" name="logo_url" ng-hide="true" ng-model="logo_url" type="text" val="">
                                                </div>
                                                <div class="clearfix"></div>
                                                <hr class="divider">
                                            </fieldset>
                                            <div class="Actions">
                                                <input class="action submitblue submit pull-right" id="Form_action_doNothing" name="action_doNothing" type="submit" value="Continue">
                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div id="Step3">
                                    <div id="FormStep3">
                                        <div class="register-form-container">
                                            <div class="loadme ng-hide" ng-hide="preload"><img src="https://staging.previewmedev.co//themes/bbt/images/preloader.gif"></div>
                                            <h3>Company Members</h3>
                                            <ul class="errmsg">
                                                <!-- ngRepeat: (key, val) in ErrorMsgs -->
                                            </ul>
                                            <div class="alert alert-success alert-dismissible ng-hide" ng-hide="hideme" role="alert">
                                                <button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> Member invited.
                                                <ul class="addMember">
                                                    <!-- ngRepeat: data in newstep3 -->
                                                </ul>
                                            </div>
                                            <form class="ng-pristine ng-invalid ng-invalid-required ng-valid-email" id="Step3Form" name="Step3Form" ng-submit="SubmitEmployerStep3()">
                                                <fieldset>
                                                    <hr class="divider">
                                                    <h4>Add Company Members</h4>
                                                    <p>If you have additional team members that will be managing the recruiting process, you may add them here.</p>
                                                    <div class="field text nolabel">
                                                        <input class="text nolabel required ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_first_name" name="first_name" ng-model="step3_first_name" placeholder="First Name" required="required" type="text"> <span class="asterisk s3_fname">*</span>
                                                    </div>
                                                    <div class="field text nolabel" id="Form_last_name_Holder">
                                                        <input class="text nolabel required ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_last_name" name="last_name" ng-model="step3_last_name" placeholder="Last Name" required="required" type="text"> <span class="asterisk s3_lname">*</span>
                                                    </div>
                                                    <div class="field text nolabel">
                                                        <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_work_title" name="work_title" ng-model="step3_work_title" placeholder="Title" type="text">
                                                    </div>
                                                    <div class="field text nolabel">
                                                        <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_work_dept" name="work_dept" ng-model="step3_work_dept" placeholder="Department" type="text">
                                                    </div>
                                                    <div class="field email text nolabel">
                                                        <div class="file-upload-wrapper">
                                                            <input class="file ng-pristine ng-valid ng-empty ng-touched custom-file-upload-hidden" id="Form_my_file2" placeholder="Profile Image" style="position: absolute; left: -9999px;" tabindex="-1" type="file"><input class="file-upload-input" ng-show="true" placeholder="Upload profile image" type="text"><button class="file-upload-button" data-docfiletype="image" ng-click="open_file_modal($event)" tabindex="-1" type="button">Browse</button>
                                                        </div>
                                                        <div id="file_upload_msg2"></div>
                                                        <div animate="true" class="progress-striped active ng-hide progress ng-isolate-scope" id="data_progress2" max="100" type="success" value="progressResumeValue">
                                                            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="" aria-valuetext="%" class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" ng-style="{width: percent + '%'}" ng-transclude="" role="progressbar"></div>
                                                        </div><input class="ng-pristine ng-untouched ng-valid ng-empty ng-hide" name="profile_picture_url" ng-hide="true" ng-model="image_url" type="text" val="">
                                                    </div>
                                                    <hr class="divider" style="margin-bottom: 15px">
                                                    <div class="field email text nolabel">
                                                        <input class="email text nolabel required ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" id="Form_email" name="email" ng-model="step3_email" placeholder="Email" required="required" type="email"> <span class="asterisk s3_email">*</span>
                                                    </div>
                                                    <div class="field text nolabel">
                                                        <input class="text nolabel ng-pristine ng-untouched ng-valid ng-empty" id="Form_nickname" name="nickname" ng-model="step3_nickname" placeholder="Nickname" type="text">
                                                    </div>
                                                    <div class="field text nolabel inline-field">
                                                        <input class="text nolabel left ng-pristine ng-untouched ng-valid ng-empty" id="Form_phone_number" name="phone_number" ng-keypress="numbersOnly()" ng-model="step3_phone_number" placeholder="Phone Number" type="text"> <input class="text nolabel right ng-pristine ng-untouched ng-valid ng-empty" id="Form_phone_extension" name="phone_extension" ng-keypress="numbersOnly()" ng-model="step3_phone_extension" placeholder="Extension" type="text">
                                                    </div>
                                                    <div class="field text nolabel inline-field">
                                                        <input class="text nolabel left ng-pristine ng-untouched ng-valid ng-empty" id="Form_mobile_number" name="mobile_number" ng-keypress="numbersOnly()" ng-model="step3_mobile_number" placeholder="Mobile Number" type="text">
                                                    </div>
                                                    <hr class="divider" style="margin-bottom: 15px">
                                                    <div class="field text nolabel">
                                                        <select class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="account_type" ng-model="step3_account_type" required="required">
                                                            <option value="">
                                                                Select Account Type
                                                            </option>
                                                            <option value="5">
                                                                Company Admin
                                                            </option>
                                                            <option value="6">
                                                                Company Member
                                                            </option>
                                                        </select> <span class="asterisk s3_atype">*</span>
                                                    </div>
                                                    <div class="clearfix">
                                                        <!-- -->
                                                    </div>
                                                </fieldset>
                                                <div class="Actions">
                                                    <hr class="divider" style="margin-bottom: 15px">
                                                    <div class="inline-button step3buttons">
                                                        <input button-id="addmore" class="action submitbluegreen left pull-left" id="Form_action_doNothing" name="action_doNothing" type="submit" value="Add Member &amp; Add another"> <input button-id="addcontinue" class="action submitbluegreen right pull-right" id="Form_action_doNothing" name="action_doNothing" type="submit" value="Add Member &amp; Continue">
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <hr class="divider">
                                                    <div class="inline-button skipper">
                                                        <div class="btnhalf submitgray pull-left left submit item text-center ng-isolate-scope" data-slide="prev" href="/register/employer/#carousel-example-generic" ng-class="{ 'active': leaving || (active &amp;&amp; !entering), 'prev': (next || active) &amp;&amp; direction=='prev', 'next': (next || active) &amp;&amp; direction=='next', 'right': direction=='prev', 'left': direction=='next' }" ng-transclude="" role="button">
                                                            <span class="ng-scope">Back</span>
                                                        </div>
                                                        <div class="btnhalf submitbluegreen pull-right right submit item text-center ng-isolate-scope" data-slide="next" href="/register/employer/#carousel-example-generic" ng-class="{ 'active': leaving || (active &amp;&amp; !entering), 'prev': (next || active) &amp;&amp; direction=='prev', 'next': (next || active) &amp;&amp; direction=='next', 'right': direction=='prev', 'left': direction=='next' }" ng-transclude="" role="button">
                                                            <span class="ng-scope">Skip</span>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div id="Step4">
                                    <div class="register-form-container">
                                        <div class="loadme ng-hide" ng-hide="preload"><img src="https://staging.previewmedev.co//themes/bbt/images/preloader.gif"></div>
                                        <h3>Review &amp; Submit</h3>
                                        <div class="text-center section-title">
                                            Personal Information
                                        </div>
                                        <ul>
                                            <!-- ngRepeat: data in step1data -->
                                        </ul>
                                        <div class="text-center section-title">
                                            Company Information
                                        </div>
                                        <ul>
                                            <!-- ngRepeat: data in step2data -->
                                        </ul>
                                        <div class="text-center section-title">
                                            Company Members
                                        </div>
                                        <hr class="divider">
                                        <h4>Company Members</h4>
                                        <ul class="ListStep3">
                                            <!-- ngRepeat: data in newstep3 -->
                                        </ul>
                                        <hr class="divider">
                                        <button class="action submitblue submit pull-right GTM-employer-continue" ng-click="confirmEmployerRegistration()">Continue</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div id="StepConfirm">
                                    <div>
                                        <div class="text-center">
                                            <h1 class="employer_title_last_step">Thanks for signing up!</h1>
                                            <h4 class="employer_title_last_step">An email verification has been sent to your email address.</h4>
                                        </div><!-- div class="row">
                                            <div class="container">
                                                <div class="containme">
                                                    <div class="col-md-4">
                                                        <a href="/register/employer/#" class="btn btn-primary btn-lg btn-block">Create and publish a role</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="/register/employer/#" class="btn btn-primary btn-lg btn-block">Take me to my company profile</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="/register/employer/#" class="btn btn-primary btn-lg btn-block">Take me to my dashboard</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvCameraModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropVideoModal(event)">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">×</button>
                                <h4 class="modal-title">Record Camera or Upload Video</h4>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <video controls="" data-file_folder="" data-ob_key="" data-old_file="" id="preview" muted="" width="100"></video>
                                    <div class="c100 p small" id="modal_percent">
                                        <span class="ng-binding">%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <!-- show if desktop -->
                                    <div id="browse_video" ng-show="mobile_agent == false" style="height:120px;">
                                        <div class="field file" id="Form_video_upload_Holder">
                                            <label class="btn" for="Form_video_upload_modal" style="color:#337ab7; cursor:pointer">Upload Video<br>
                                            <br>
                                            <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-ob_key="" data-old_file="" id="Form_video_upload_modal" name="video_upload_modal" ng-hide="true" type="file"></label>
                                        </div>
                                    </div><!-- show if desktop -->
                                    <div id="record_camera" ng-show="mobile_agent == false" style="height:120px; text-align:center">
                                        <div>
                                            <label class="btn" style="color:#337ab7">Record Video<br>
                                            <br>
                                            <i class="glyphicon glyphicon-facetime-video" style="font-size: 40px;"></i></label>
                                        </div>
                                    </div><!-- show if mobile -->
                                    <div class="ng-hide" ng-show="mobile_agent == true">
                                        <label class="btn" for="mobile_camera_capture" style="color:#337ab7; cursor:pointer">Record or Upload a Video<br>
                                        <br>
                                        <i class="glyphicon glyphicon-facetime-video" style="font-size: 40px;"></i> <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;padding-left:10px"></i> <input accept="video/*" class="ng-hide" data-old_file="" id="mobile_camera_capture" name="mobile_camera_capture" ng-hide="true" type="file"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger ng-hide video_buttons" data-recorded="" id="record" type="button">Record</button> <button class="btn btn-default ng-hide video_buttons" disabled id="stop" type="button">Stop</button> <button class="btn btn-default ng-hide video_buttons" data-save_type="camera" disabled id="save" type="button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvCameraModalNew" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content modal-video-modal">
                            <div class="x-buttom-container">
                                <span class="close x-button" data-dismiss="modal"></span>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12" style="background: #fff">
                                <div ng-show="upload_init == 0 || !upload_init">
                                    <div class="sections-holder" id="section1-holder" ng-hide="showSection1">
                                        <div class="col-md-6 modal-image modal-image-left-con" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropVideoModalNew(event)">
                                            <img ng-hide="ondragoverout_image" src="themes/bbt/images/drag_drop_img.png" width="113px"> <img ng-hide="ondragover_image" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                            <div class="text-label">
                                                <h4 class="pvm-blue">Drag &amp; drop or upload your video</h4>
                                                <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                                    <span class="ng-binding">%</span>
                                                    <div class="slice">
                                                        <div class="bar"></div>
                                                        <div class="fill"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="modal-buttons" for="video_upload_modal_new">BROWSE <input accept="video/mp4,video/x-m4v,video/*" class="ng-pristine ng-untouched ng-valid ng-empty" data-old_file="" id="video_upload_modal_new" name="video_upload_modal_new" ng-model="video_upload" style="margin-left:-9999px" type="file"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 modal-image">
                                            <img src="themes/bbt/images/record_video_img.png" width="113px">
                                            <div class="text-label">
                                                <h4 class="pvm-blue">Record a video</h4>
                                            </div>
                                            <div class="modal-button-right-con">
                                                <label class="modal-buttons" ng-click="startVideo()">START</label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="little-note-yellow">
                                            <i aria-hidden="true" class="fa fa-info-circle"></i> File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                                        </div>
                                    </div>
                                    <div class="sections-holder ng-hide" id="section2-holder" ng-hide="showSection2">
                                        <div class="col-md-12 video-holder">
                                            <video class="video-elm" controls="" data-file_folder="" data-ob_key="" data-old_file="" id="preview_new" muted=""></video>
                                            <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 buttons-holder">
                                            <span class="video-buttons" id="stop_btn" ng-click="stopVideo()" ng-hide="stop_btn"></span> <span class="video-buttons" id="record_btn" ng-click="recordVideo()" ng-hide="record_btn"></span> <span class="video-buttons" id="record_again_btn" ng-click="recordVideoAgain()" ng-hide="record_again_btn"></span> <span class="video-buttons" id="change_btn" ng-click="changeVideo()" ng-hide="change_btn"></span> <span class="video-buttons" id="save_btn" ng-click="saveVideo()" ng-hide="save_btn"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <style>
                                        .progressContainer {display: none;}
                                        #pmvCameraModalNew .modal-video-modal{height: 100%!important; min-height: 360px}
                                        .statusBar{background-color: #FFF; padding-bottom: 15px}
                                        .progressBarOutside {border: 1px solid #333; height: 25px; background-color: #FFF}
                                        .progressbar {height: 23px; background-color: #00afed; text-align: right; color: #FFF;width: 0px; padding-right: 15px}
                                        .preparing, .errorUpload, .successUpload, .finalize {display: none}
                                        </style>
                                        <div class="col-sm-12 statusBar text-center">
                                            <div class="preparing">
                                                Preparing upload. Please wait...<br>
                                                <strong>Please do not refresh or close this page</strong>
                                            </div>
                                            <div class="finalize">
                                                Finalizing upload. Please wait...<br>
                                                <strong>Please do not refresh or close this page</strong>
                                            </div>
                                            <div class="progressContainer">
                                                <div class="text">
                                                    Uploading. Please do not refresh or close this page
                                                </div>
                                                <div class="progressBarOutside">
                                                    <div class="progressbar">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="errorUpload alert alert-danger">
                                                <div class="text">
                                                    Failed with error: <span></span>
                                                </div>
                                            </div>
                                            <div class="successUpload alert alert-success">
                                                <div class="text">
                                                    <strong>Successful.</strong> The video will be encoded before it can be viewed.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ng-hide" ng-show="upload_init == 1 &amp;&amp; upload_init">
                                    <div class="ng-binding" style="margin: 0 auto;padding: 60px 0px;font-size: 18px;line-height: 28px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvCameraModalNew" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content modal-video-modal">
                            <div class="x-buttom-container">
                                <span class="close x-button" data-dismiss="modal"></span>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="sections-holder" id="section1-holder" ng-hide="showSection1">
                                    <div class="col-md-6 modal-image modal-image-left-con" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropVideoModalNew(event)">
                                        <img ng-hide="ondragoverout_image" src="themes/bbt/images/drag_drop_img.png" width="113px"> <img ng-hide="ondragover_image" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Drag &amp; drop or upload your video</h4>
                                            <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="modal-buttons" for="video_upload_modal_new">BROWSE <input accept="video/*" class="ng-pristine ng-untouched ng-valid ng-empty" data-old_file="" id="video_upload_modal_new" name="video_upload_modal_new" ng-model="video_upload" style="margin-left:-9999px" type="file"></label>
                                            <div class="little-note-yellow">
                                                <i aria-hidden="true" class="fa fa-info-circle"></i> File extension must be one of these - flv, mxf, gxf, ts, ps, 3gp, 3gpp, mpg, wmv, asf, avi, mp4, m4a, m4v, isma, ismv, dvr-ms, mkv, wav, mov
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 modal-image">
                                        <img src="themes/bbt/images/record_video_img.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Record a video</h4>
                                        </div>
                                        <div class="modal-button-right-con">
                                            <label class="modal-buttons" ng-click="startVideo()">START</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="sections-holder ng-hide" id="section2-holder" ng-hide="showSection2">
                                    <div class="col-md-12 video-holder">
                                        <video class="video-elm" controls="" data-file_folder="" data-ob_key="" data-old_file="" id="preview_new" muted=""></video>
                                        <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 buttons-holder">
                                        <span class="video-buttons" id="stop_btn" ng-click="stopVideo()" ng-hide="stop_btn"></span> <span class="video-buttons" id="record_btn" ng-click="recordVideo()" ng-hide="record_btn"></span> <span class="video-buttons" id="record_again_btn" ng-click="recordVideoAgain()" ng-hide="record_again_btn"></span> <span class="video-buttons" id="change_btn" ng-click="changeVideo()" ng-hide="change_btn"></span> <span class="video-buttons" id="save_btn" ng-click="saveVideo()" ng-hide="save_btn"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvImageModalNew" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content modal-video-modal">
                            <div class="x-buttom-container">
                                <span class="close x-button" data-dismiss="modal"></span>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="sections-holder" id="section1-holder" ng-hide="showSection1">
                                    <div class="col-md-6 modal-image modal-image-left-con" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropImageModalNew(event)">
                                        <img ng-hide="ondragoverout_image" src="themes/bbt/images/drag_drop_img.png" width="113px"> <img ng-hide="ondragover_image" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Drag &amp; drop or upload your image</h4>
                                            <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="modal-buttons" for="image_upload_modal_new">BROWSE <input accept="image/*" data-old_file="" id="image_upload_modal_new" name="image_upload_modal_new" style="margin-left:-9999px" type="file"></label>
                                        </div><span class="little-note little-note-yellow">Recommended dimensions: 150 x 150px</span>
                                    </div>
                                    <div class="col-md-6 modal-image">
                                        <img src="themes/bbt/images/record_video_img.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Take a picture</h4>
                                        </div>
                                        <div class="modal-button-right-con">
                                            <label class="modal-buttons" ng-click="startVideoImage()">START</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="sections-holder ng-hide" id="section2-holder" ng-hide="showSection2">
                                    <div class="col-md-12 video-holder" id="preview_img_new_holder">
                                        <video class="video-elm" data-file_folder="" data-ob_key="" data-old_file="" id="preview_img_new" muted="" ng-hide="isSafari" poster="" style="background-color:#fff"></video> <img class="ng-hide" id="preview_img_new_safari" ng-show="isSafari" style="background-color:#fff">
                                        <canvas id="my_canvas" style="display:none;"></canvas>
                                        <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 buttons-holder">
                                        <span class="video-buttons" id="stop_btn" ng-click="stop()" ng-hide="stop_btn"></span> <span class="video-buttons" id="take_photo_btn" ng-click="take_photo()" ng-hide="record_btn"></span> <span class="video-buttons" id="record_again_btn" ng-click="take_photo_again()" ng-hide="record_again_btn"></span> <span class="video-buttons" id="change_btn" ng-click="changeVideo()" ng-hide="change_btn"></span> <span class="video-buttons" id="save_btn" ng-click="save_photo()" ng-hide="save_btn"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvImageModalEmployerRegister" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content modal-video-modal">
                            <div class="x-buttom-container">
                                <span class="close x-button" data-dismiss="modal"></span>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="sections-holder" id="section1-holder" ng-hide="showSection1RE">
                                    <div class="col-md-6 modal-image modal-image-left-con" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropImageModalNew(event)">
                                        <img ng-hide="ondragoverout_imageRE" src="themes/bbt/images/drag_drop_img.png" width="113px"> <img ng-hide="ondragover_imageRE" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Drag &amp; drop or upload your image</h4>
                                            <div class="c100 p small" id="modal_percent_new" ng-hide="modal_percentRE">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="modal-buttons" for="image_upload_modal_newRE">BROWSE <input accept="image/*" data-old_file="" id="image_upload_modal_newRE" name="image_upload_modal_newRE" style="margin-left:9999px" type="file"></label>
                                        </div><small style="position: absolute;width:100%;left:0;top:270px;">Recommended dimensions: 150x150px</small>
                                    </div>
                                    <div class="col-md-6 modal-image">
                                        <img src="themes/bbt/images/record_video_img.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Take a picture</h4>
                                        </div>
                                        <div class="modal-button-right-con">
                                            <label class="modal-buttons" ng-click="startVideoImage()">START</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="sections-holder" id="section2-holder" ng-hide="showSection2RE">
                                    <div class="col-md-12 video-holder" id="preview_img_new_holderRE">
                                        <video class="video-elm" data-file_folder="" data-ob_key="" data-old_file="" height="240" id="preview_img_newRE" muted="" ng-hide="isSafari" poster=""></video> <img class="ng-hide" id="preview_img_newRE_safari" ng-show="isSafari" style="background-color:#fff; height:240px">
                                        <canvas id="my_canvasRE" style="display:none;"></canvas>
                                        <div class="c100 p small" id="modal_percent_new" ng-hide="modal_percentRE">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 buttons-holder">
                                        <span class="video-buttons" id="stop_btn" ng-click="stopRE()" ng-hide="stop_btnRE"></span> <span class="video-buttons" id="take_photo_btn" ng-click="take_photo()" ng-hide="record_btnRE"></span> <span class="video-buttons" id="record_again_btn" ng-click="take_photo_again()" ng-hide="record_again_btnRE"></span> <span class="video-buttons" id="change_btn" ng-click="changeVideo()" ng-hide="change_btnRE"></span> <span class="video-buttons" id="save_btn" ng-click="save_photoRE()" ng-hide="save_btnRE"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvFileModalNew" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content modal-video-modal">
                            <div class="x-buttom-container">
                                <span class="close x-button" data-dismiss="modal"></span>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="sections-holder" id="section1-holder" ng-hide="showSection1">
                                    <div class="col-md-12 modal-image" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropFileModalNew(event)">
                                        <img ng-hide="ondragoverout_image" src="themes/bbt/images/drag_drop_img.png" width="113px"> <img ng-hide="ondragover_image" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Drag &amp; drop or upload your file</h4>
                                            <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="modal-buttons" for="file_upload">BROWSE <input class="ng-pristine ng-untouched ng-valid ng-empty ng-hide" data-old_file="" id="file_upload" name="file_upload" ng-hide="true" ng-model="file_upload" type="file"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="sections-holder ng-hide" id="section2-holder" ng-hide="showSection2">
                                    <div class="col-md-12 video-holder">
                                        <div class="ng-binding" id="uploadResponseText" ng-bind-html="uploadResponseText"></div>
                                    </div>
                                    <div class="col-md-12 buttons-holder">
                                        <span class="video-buttons" id="change_btn" ng-click="file_change()" ng-hide="change_btn"></span> <span class="video-buttons" id="save_btn" ng-click="file_save($event)" ng-hide="save_btn"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvErrorMsg" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">×</button>
                                <h4 class="modal-title text-danger">Error</h4>
                            </div>
                            <div class="modal-body pvm-video-container-error"></div>
                            <div class="modal-footer">
                                <button class="btn btn-default-bbt" data-dismiss="modal" type="button">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvImageModalMsg" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="padding:20px">
                                Profile image saved. Please wait a few moment to update.
                            </div>
                            <div class="modal-footer" style="padding-top:10px;padding-bottom:10px">
                                <button class="btn btn-default-bbt pvm-blue" data-dismiss="modal" style="border:none;" type="button">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvResumeModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropResumeModal(event)">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">×</button>
                                <h4 class="modal-title">Upload Resume</h4>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div id="file_drag_drop">
                                        <span>You can also drag and drop resume here.</span>
                                        <div class="hidden c100 p small" id="modal_percent_file">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <!-- show if desktop -->
                                    <div id="browse_resume" style="height:120px; margin-top:35px">
                                        <div class="field file" id="Form_video_upload_Holder">
                                            <label class="btn" for="Form_resume_upload_modal" style="color:#337ab7; cursor:pointer">Upload Resume<br>
                                            <br>
                                            <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-folder="resume" data-ob_key="" data-old_file="" id="Form_resume_upload_modal" name="Form_resume_upload_modal" ng-hide="true" type="file"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal" type="button">Cancel</button> <button class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="resume_save" ng-click="save_file($event)" type="button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvPortfolioModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropResumeModal(event)">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">×</button>
                                <h4 class="modal-title">Upload Portfolio</h4>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div id="file_drag_drop">
                                        <span>You can also drag and drop file here.</span>
                                        <div class="hidden c100 p small" id="modal_percent_file">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <!-- show if desktop -->
                                    <div id="browse_resume" style="height:120px; margin-top:35px">
                                        <div class="field file" id="Form_video_upload_Holder">
                                            <label class="btn" for="Form_portfolio_upload_modal" style="color:#337ab7; cursor:pointer">Upload Porfolio<br>
                                            <br>
                                            <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-folder="portfolio" data-ob_key="" data-old_file="" id="Form_portfolio_upload_modal" name="Form_portfolio_upload_modal" ng-hide="true" type="file"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal" type="button">Cancel</button> <button class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="portfolio_save" ng-click="save_file($event)" type="button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="pmvImageModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content" ondragover="allowDrop(event)" ondrop="dropImageModal(event)">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" type="button">×</button>
                                <h4 class="modal-title">Upload Picture</h4>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div id="file_drag_drop">
                                        <span>You can also drag and drop your picture here.</span>
                                        <div class="hidden c100 p small" id="modal_percent_image">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <!-- show if desktop -->
                                    <div id="browse_resume" style="height:120px; margin-top:35px">
                                        <div class="field file" id="Form_video_upload_Holder">
                                            <label class="btn" for="Form_image_upload_modal" style="color:#337ab7; cursor:pointer">Upload Image<br>
                                            <br>
                                            <i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i> <input class="file ng-pristine ng-valid ng-empty ng-touched ng-untouched ng-hide" data-ob_key="" data-old_file="" id="Form_image_upload_modal" name="Form_image_upload_modal" ng-hide="true" type="file"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default-bbt ng-hide resume_buttons" data-dismiss="modal" type="button">Cancel</button> <button class="btn btn-primary-bbt ng-hide resume_buttons" data-dismiss="modal" data-filename="" data-folder="" id="image_save" ng-click="save_file($event)" type="button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="companyBannerModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content modal-video-modal">
                            <div class="x-buttom-container">
                                <span class="close x-button" data-dismiss="modal"></span>
                            </div>
                            <div class="modal-body pvm-video-container col-md-12 col-sm-12 col-xs-12">
                                <div class="banner-sections-holder" id="banner-section1-holder" ng-hide="showSection1">
                                    <div class="col-md-12 modal-image" ondragleave="leaveIt(event)" ondragover="allowDrop(event)" ondrop="dropImageModalNew(event)">
                                        <img ng-hide="ondragoverout_image" src="themes/bbt/images/drag_drop_img.png" width="113px"> <img ng-hide="ondragover_image" src="themes/bbt/images/drag_drop_img_gray.png" width="113px">
                                        <div class="text-label">
                                            <h4 class="pvm-blue">Drag &amp; drop or upload your image</h4>
                                            <div class="c100 p small ng-hide" id="modal_percent_new" ng-hide="modal_percent">
                                                <span class="ng-binding">%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="modal-buttons" for="banner_image_upload">BROWSE <input accept="image/*" data-old_file="" id="banner_image_upload" name="banner_image_upload" style="margin-left:-9999px" type="file"></label> <small style="position: absolute;width:100%;left:0;top:270px;">Recommended dimensions: 2000x221px</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner-sections-holder ng-hide" id="banner-section2-holder" ng-hide="showSection2">
                                    <div class="col-md-12 video-holder" id="banner_preview_img_new_holder">
                                        <div style="height:240px;position:relative"><img id="banner_img" ng-hide="video_preview"></div>
                                        <div class="c100 p small ng-hide" id="banner_modal_percent_new" ng-hide="modal_percent">
                                            <span class="ng-binding">%</span>
                                            <div class="slice">
                                                <div class="bar"></div>
                                                <div class="fill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 buttons-holder">
                                        <span class="video-buttons" id="banner_change_btn" ng-click="file_change()" ng-hide="change_btn"></span> <span class="video-buttons" id="banner_save_btn" ng-click="saveBanner()" ng-hide="save_btn"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/register.min.js"></script>
@stop