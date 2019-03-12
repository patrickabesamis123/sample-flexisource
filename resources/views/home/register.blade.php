@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/base64.css?ver=1" />
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>

<div id="Register">
    <div class="container-fluid" role="main">
        <div class="row">
            <div class="col-md-12">
                    
                <div class="register-form-container">
                    <div ng-controller="RegisterController" class="ng-scope">

                    <h1>Sign up for FREE!</h1>
                    <div class="divider"></div>
                    <ul class="errmsg">
                    <!-- ngRepeat: (key, val) in ErrorMsgs -->
                    </ul>
                    <form id="Form" @submit="checkForm" method="post" enctype="application/x-www-form-urlencoded">
                    <!-- <form id="Form" action="/register/" method="post" enctype="application/x-www-form-urlencoded" ng-submit="save()" onsubmit="return false" class="ng-pristine ng-invalid ng-invalid-required ng-valid-email"> -->
                    <p id="Form_error" class="message " style="display: none"></p>
                    <fieldset>
                       <div id="Form_first_name_Holder" class="field text">
                          <div class="middleColumn">
                             <input type="text" name="first_name" class="text ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_first_name" required="required" aria-required="true" ng-model="first_name" v-model="first_name" placeholder="FIRST NAME">
                             <span class="asterisk asterisk1">*</span>
                          </div>
                       </div>

                       <div id="Form_last_name_Holder" class="field text nolabel">
                          <div class="middleColumn">
                             <input type="text" name="last_name" class="text nolabel ng-pristine ng-empty ng-invalid ng-invalid-required ng-untouched" id="Form_last_name" required="required" aria-required="true" ng-model="last_name" v-model="last_name" placeholder="LAST NAME">
                             <span class="asterisk asterisk2">*</span>
                          </div>
                       </div>

                       <div id="Form_email_Holder" class="field email text nolabel">
                          <div class="middleColumn">
                             <input type="email" name="email" class="email text nolabel ng-pristine ng-untouched ng-empty ng-valid-email ng-invalid ng-invalid-required" id="Form_email" required="required" aria-required="true" ng-model="email" v-model="email" placeholder="EMAIL">
                             <span class="asterisk asterisk3">*</span>
                          </div>
                       </div>

                       <div id="Form_first_password_Holder" class="field text password nolabel">
                          <div class="middleColumn">
                             <input type="password" name="first_password" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_first_password" required="required" aria-required="true" ng-model="first_password" v-model="first_password" placeholder="PASSWORD" ng-blur="passwordHack($event)" autocomplete="off">
                             <span class="asterisk asterisk4">*</span>
                          </div>
                       </div>

                       <div id="Form_second_password_Holder" class="field text password nolabel">
                          <div class="middleColumn">
                             <input type="password" name="second_password" class="text password nolabel ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="Form_second_password" required="required" aria-required="true" ng-model="second_password" v-model="second_password" placeholder="CONFIRM PASSWORD" autocomplete="off">
                             <span class="asterisk asterisk5">*</span>
                          </div>
                       </div>

                       <div id="user_type_res" class="field">
                          <label class="left">I'm looking for...<span class="red">*</span></label>
                          <div class="middleColumn">
                             <ul name="user_type" class="optionset" id="Form_user_type" required="required" aria-required="true">
                                <li class="odd valcandidate">
                                <input type="radio" ng-change="updateUserType(user_type)" data-ng-model="user_type" v-model="user_type" value="candidate" class="radio ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="user_type" checked="checked" id="Form_user_type_candidate" required="required">
                                <label for="Form_user_type_candidate"><div class="check"></div><div class="text">A job</div></label>
                                </li>
                                <li class="even valemployer">
                                <input type="radio" ng-change="updateUserType(user_type)" data-ng-model="user_type" v-model="user_type" value="employer" class="radio ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="user_type" id="Form_user_type_employer" required="required">
                                <label for="Form_user_type_employer"><div class="check"></div><div class="text">An employee</div></label>
                                </li>
                             </ul>
                          </div>
                       </div>

                       <div class="pvm-registration-checkbox-container">
                          <div class="pvm-registration--check-items clear-float">
                             <div class="pvm-registration--checkbox">
                                <!-- ngIf: termsAndPolicies -->
                                <i ng-if="termsAndPolicies" class="fa fa-check ng-scope" aria-hidden="true"></i>
                                <input type="checkbox" ng-change="updateTermsAndPolicies(termsAndPolicies)" ng-model="termsAndPolicies" value="true" class="radio ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" name="checkboxTermsAndPolicies" required="required">
                             </div>   
                             <div class="pvm-registration--text-content">
                                <p>
                                   I understand &amp; accept the PreviewMe <a href="javascript:void(0)" ng-click="showTerms()">Terms of Service</a> &amp; <a ng-click="showPrivacy()" href="javascript:void(0)">Privacy Policy</a>
                                </p>
                             </div>
                          </div>
                          <div class="pvm-registration--check-items clear-float ng-scope" ng-if="newsLetterState">
                             <div class="pvm-registration--checkbox">
                                <!-- ngIf: subscribeLetter -->
                                <i ng-if="subscribeLetter" class="fa fa-check ng-scope" aria-hidden="true"></i>
                                <input type="checkbox" ng-change="updateNewsletter(subscribeLetter)" ng-model="subscribeLetter" class="radio ng-pristine ng-untouched ng-valid ng-empty" name="newsLetter">
                             </div>
                             <div class="pvm-registration--text-content">
                                <p>I would like to subscribe to PreviewMe's newsletter</p>
                             </div>
                          </div>
                       </div>
                       <input type="hidden" name="SecurityID" value="dad135c062b318b962f09d8e5d8918b537820122" class="hidden" id="Form_SecurityID">
                       <div class="clear"></div>
                    </fieldset>

                    <div class="Actions">
                       <input type="submit" name="action_doNothing" value="Sign Up" class="action" id="Form_action_doNothing" disabled="disabled" style="background-color: rgb(169, 169, 169) !important; border: 1px solid rgb(144, 144, 144) !important;">
                    </div>
                    </form>

                    <div ng-hide="preload" class="loadme text-center ng-hide"><img src="https://dev.previewmedev.co//themes/bbt/images/preloader.gif" height="40px"></div>
                        
                    </div>
                </div>
            </div>

          <!-- start: term service-modal-->
          <div class="pvm__modal-popup  pvm__modal-popup--confirm registration-popup" id="termsServiceModal">
             <div class="pvm__modal-popup__content pvm__modal-popup__content--large">
                <a href="#" id="termsServiceModal-x-btn" ng-click="showTerms()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
                <h1 class="registration-popup--title">Terms and Conditions</h1>
                <div class="registration-popup">
                   <h2 class="btn-toggler-container">
                      <a class="btn-toggler" data-toggle="collapse" data-target="#user-agreement-text" href="javascript:void(0)">User Agreement</a>
                      <span class="arrow-point"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                   </h2>
                <!-- start: User Agreement -->
                   <div class="collapse" id="user-agreement-text">
                      <p>Welcome to PreviewMe<sup>&reg;</sup> Limited&rsquo;s (&ldquo;<strong>PreviewMe</strong>&rdquo;, &ldquo;<strong>we</strong>&rdquo;, &ldquo;<strong>us</strong>&rdquo; or &ldquo;<strong>our</strong>&rdquo;) Website. We are an employment technology company that provides a network of employers and candidates with the tools to publish and apply for employment opportunities, promote themselves through video and communicate more effectively.</p>
                      <p>This User Agreement (&ldquo;Agreement&rdquo;) governs your access to and use of PreviewMe&rsquo;s:</p>
                      <ul>
                         <li>(a)&nbsp;website, being&nbsp;<a target="_blank" href="/">www.previewme.com</a> or such other websites (at other addresses) as are made available by us from time to time, and our related mobile apps (&ldquo;Website&rdquo;); and</li>
                         <li>(b)&nbsp;services, premium services or any content, analytics or any other information provided as part of these services that we make available to you,</li>
                      </ul>
                      <p>(collectively our &ldquo;Services&rdquo;).</p>
                      <ol>
                         <!--- start: Introduction -->
                         <li>
                            <h3>Introduction</h3>
                            <ol>
                               <li>
                                  <!-- start: Your use of services -->
                                  <h3>Your use of the Services</h3>
                                  <ol>
                                     <li>
                                        <p>By accessing, using or registering to use our Services, you agree to follow and be bound by this Agreement and our&nbsp;<a target="_blank" href="/privacy-policy">Privacy Policy</a> and if applicable the&nbsp;<a target="_blank" href="/terms-and-conditions">Role Publishing User Agreement.</a> If you do not agree to these terms and conditions you must cease using the Services immediately.</p>
                                     </li>
                                     <li>
                                        <p>If you register on behalf of a company, then you agree to be bound by this Agreement both in your personal capacity and on behalf of the company that you represent, and agree and warrant that you have the legal capacity and power to agree and be bound by this Agreement and perform the obligations under it.</p>
                                     </li>
                                     <li>
                                        <p>The Role Publishing User Agreement must also be accepted and adhered to by Employer Members who use our Services.</p>
                                     </li>
                                     <li>
                                        <p>This Agreement may change at PreviewMe&rsquo;s sole discretion and we will notify you of any changes made in accordance with clause 2.5. If you do not agree to be bound by the amended Agreement, you must not access or otherwise use any of the Services.</p>
                                     </li>
                                     <li>
                                        <p>Registered users of our Services are referred to as &ldquo;Members&rdquo; in this Agreement (of which you will be either a Candidate Member or an Employer Member, as defined in clause 2.1 below) and non-registered users are referred to as &ldquo;Visitors&rdquo;. You may use the Services only in accordance with this Agreement.</p>
                                     </li>
                                  </ol>
                                  <!-- end: Your use of services -->
                               </li>
                            </ol>
                         </li>
                         <!--- end: Introduction -->
                         <!-- start: Obligation -->
                         <li>
                            <h3>Obligations</h3>
                            <ol>
                               <!-- start: Service Eligibility -->
                               <li>
                                  <h3>Service Eligibility</h3>
                                  <ol>
                                     <!-- start: By accessing and using our Services, you agree that: -->
                                     <li>
                                        <p>By accessing and using our Services, you agree that:</p>
                                        <ol>
                                           <li>
                                              <p>you are the Minimum Age (as defined below);</p>
                                           </li>
                                           <li>
                                              <p>if you register with us to seek employment opportunities (&ldquo;<strong>Candidate Members</strong>&rdquo;), you will only have 1 (one) PreviewMe candidate account and your name and other descriptions in your account and profile are true and accurate; and</p>
                                           </li>
                                           <li>
                                              <p>if you register with us as an employer (&ldquo;<strong>Employer Members</strong>&rdquo;), you will only have 1 (one) PreviewMe employer/company account and your name, the company name, your team member details and other descriptions in the account and employer profile are true and accurate.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: By accessing and using our Services, you agree that: -->
                                     <li><strong>Minimum Age</strong> means over the age of 14 years old. However, if a law requires that you must be older in order for us to lawfully provide the Services to you (including the collection, storage and use of your personal information) then the Minimum Age is that older age.</li>
                                  </ol>
                               </li>
                               <!-- end: Service Eligibility -->
                               <!-- start: Membership -->
                               <li>
                                  <h3>Membership</h3>
                                  <ol>
                                     <!-- start: To become a Member -->
                                     <li>
                                        <p>To become a Member, you must provide us with a first name, last name, verified email address, password and some further information depending on whether you are joining as an Employer Member or Candidate Member. As a Member you agree to: </p>
                                        <ol>
                                           <li>
                                              <p>keep your password a secret;</p>
                                           </li>
                                           <li>
                                              <p>not share an account with anyone else except as otherwise permitted under this Agreement;</p>
                                           </li>
                                           <li>
                                              <p>be entirely responsible for all activities that occur under your account;</p>
                                           </li>
                                           <li>
                                              <p>agree to immediately notify PreviewMe of any unauthorised use of your login or any other breach of security known to you; and</p>
                                           </li>
                                           <li>
                                              <p>pay the fees relevant to your membership as set out on the Website, or if applicable the Role Publishing User Agreement, which may be amended by us from time to time.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: To become a Member -->
                                     <!-- start: As a Member you may: -->
                                     <li>
                                        As a Member you may:
                                        <ol>
                                           <li>
                                              <p>change your profile, password and contact at any time by following the instructions on our Website;</p>
                                           </li>
                                           <li>
                                              <p>delete Services attached to your membership at your own convenience.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: As a Member you may: -->
                                  </ol>
                               </li>
                               <!-- end: Membership -->
                               <!-- start: Acceptable Use of PreviewMe -->
                               <li>
                                  <h3>Acceptable Use of PreviewMe</h3>
                                  <ol>
                                     <li>
                                        <p>PreviewMe is trusted by its Members and Visitors and PreviewMe trusts you to use the Services responsibly. You must not, and must not attempt to, do the following: </p>
                                        <ol>
                                           <li>
                                              <p>use the Services for any unlawful purposes or for promotion of illegal activities;</p>
                                           </li>
                                           <li>
                                              <p>publish, share or otherwise deal with information on the Services in violation of any applicable laws of New Zealand or any other relevant jurisdiction, including intellectual property laws, privacy laws or any contractual obligation;</p>
                                           </li>
                                           <li>
                                              <p>impersonate another person or an entity through the Services or otherwise misrepresent your affiliation with a person or entity in a manner that does or is intended to mislead, confuse or deceive others;</p>
                                           </li>
                                           <li>
                                              <p>publish or share another Member&rsquo;s or Visitor&rsquo;s private or personally identifiable information without their express authorisation and permission;</p>
                                           </li>
                                           <li>
                                              <p>use any feature of the Services to send unsolicited commercial electronic messages as defined in section 4 of Unsolicited Electronic Messages Act 2007;</p>
                                           </li>
                                           <li>
                                              <p>publish or link malicious content or information intended to damage or disrupt other Members&rsquo; or Visitors&rsquo; browsers or computers or to compromise privacy;</p>
                                           </li>
                                           <li>
                                              <p>access, tamper with, or use non-public areas of the Services, including PreviewMe&rsquo;s computer systems and the technical delivery systems of PreviewMe&rsquo;s providers or partners;</p>
                                           </li>
                                           <li>
                                              <p>probe, scan, or test the vulnerability of any system or network or breach or circumvent any security or authentication measures, access or search the Services by any means other than PreviewMe&rsquo;s publicly supported interfaces;</p>
                                           </li>
                                           <li>
                                              <p>forge any part of the header of any information published or shared, or use the Service in any way to send altered, deceptive or false information;</p>
                                           </li>
                                           <li>
                                              <p>interfere with, or disrupt, the access of any Member or Visitor, host or network, including without limitation, sending viruses, overloading, flooding, spamming, mail-bombing the Service, or using the Service in such a manner as to interfere or create an undue burden on the Service;</p>
                                           </li>
                                           <li>
                                              <p>use the Services or the Website to upload, download, transact, store or make available data that is unlawful, harassing, threatening, harmful, tortious, defamatory, libellous, abusive, violent, obscene, invasive, of another&rsquo;s privacy, racially or ethnically offensive or otherwise in our opinion objectionable or damaging to PreviewMe, its Members, Visitors or persons generally; and</p>
                                           </li>
                                           <li>
                                              <p>use data mining, robots, screen scraping, or similar automated data gathering, extraction or publication tools on the Website (including without limitation for the purposes of establishing, maintaining, advancing or reproducing information contained on our Website on another website or in any other publication), without our prior written approval.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <li>
                                        <p>Members and Visitors who are located outside New Zealand agree to comply with all local laws regarding online conduct and acceptable content and information.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Acceptable Use of PreviewMe -->
                               <!-- start: Use of Information -->
                               <li>
                                  <h3>Use of Information</h3>
                                  <ol>
                                     <li>
                                        <p>All content and information that you provide to us via the Service, whether publicly visible or privately transmitted to us through messages, notifications or electronic mail (&ldquo;<strong>Member Information</strong>&rdquo;) is solely your responsibility. PreviewMe does not endorse, support, represent or guarantee the completeness, truthfulness, accuracy, or reliability of any Member Information shared via the Service or endorse any opinions expressed via the Service. </p>
                                     </li>
                                     <li>
                                        <p>If you use or rely on any content or materials shared via the Service or obtained by you through the Service, whether it is content that we provide or Member Information that other Members provide through our Service (collectively &ldquo;<strong>Content</strong>&rdquo;), it is at your own risk. To the fullest extent permitted by law, under no circumstances will PreviewMe be liable in any way for the Content, or any loss or damage of any kind incurred as a result of the use of any Content provided through the Services.</p>
                                     </li>
                                     <li>
                                        <p>You agree that you are responsible for your use of the Service and warrant that you have all the rights, power and authority in respect of any Member Information that you provide to us including all necessary rights to upload the Member Information in accordance with this Agreement.</p>
                                     </li>
                                     <li>
                                        <p>You agree that Content contained on the Website is for personal use or otherwise as permitted by this Agreement only and may not be sold, redistributed or used for any commercial purpose. </p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Use of Information -->
                               <!-- start: Notices and Messages -->
                               <li>
                                  <h3>Notices and Messages</h3>
                                  <ol>
                                     <li>
                                        <p>From time to time we may provide you with important notices by email or via our Website.</p>
                                     </li>
                                     <!-- start: You agree that we may provide notices -->
                                     <li>
                                        <p>You agree that we may provide notices to you in the following ways:</p>
                                        <ol>
                                           <li>
                                              <p>banner notices on our Service;</p>
                                           </li>
                                           <li>
                                              <p>PreviewMe message threads and notifications on the Service;</p>
                                           </li>
                                           <li>
                                              <p>email sent to an email address you provide; or</p>
                                           </li>
                                           <li>
                                              <p>through other means including mobile number, telephone, or mail.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: You agree that we may provide notices -->
                                     <li>
                                        <p>You agree to keep your contact information up to date on your account profile.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Notices and Messages -->
                               <!-- start: Messages and Sharing Information -->
                               <li>
                                  <h3>Messages and Sharing Information</h3>
                                  <ol>
                                     <li>
                                        <p>Our Services allow messaging and sharing of information in a number of ways including through your Member profile, employment applications, Role Publications (as defined in the Role Publishing User Agreement) and messaging either between an Employer Member and a Candidate Member (where permitted) or amongst team members under an Employer Member profile. Information and content you share may be seen by other Members, or, if public, by Visitors.</p>
                                     </li>
                                     <li>
                                        <p>Where we have made settings available, we will honour the choices you make about who can see content or information. This includes limiting the visibility of your profile from public view and restricting your profile information during the job application process.</p>
                                     </li>
                                     <li>
                                        <p>Job applications or communications relating to Roles (as defined in the Role Publishing User Agreement) via our Services are private by default and only visible to you and the recipient. Where a Candidate Member communicates with an Employer Member about a job opportunity, all members registered as team members to that job opportunity of the Employer Member account will receive the communication. If you are a Candidate Member, you agree that if your Member Information is made available to an Employer Member, it may be retained by that Employer Member in relation to any Role: (i) you have enquired about and/or applied for; and/or (ii) that the Employer Member may publish in the future and that it considers may be of interest to you.</p>
                                     </li>
                                     <li>
                                        <p>If you are subject to a harmful communication that contravenes the communication principles of the Harmful Digital Communications Act 2015, you can report the communication via the Communications Portal at&nbsp;<a target="_blank" href="{$BaseHref}harmful-communications">Harmful Communications</a>. Alternatively, report the communication through the Message Thread portal.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe takes your privacy seriously and is committed to ensuring that the privacy and integrity of any personal information (as defined in the Privacy Act) you provide to us is protected. By using our Services, you are agreeing to us and any of our affiliates to collect, hold, use and share your personal information in accordance with our Privacy Policy. There does remain the possibility that such personal information is unlawfully observed by a third party while in transit over the internet or while stored on the Website. PreviewMe disclaims all liability to you to the greatest extent possible should this occur.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Messages and Sharing Information -->
                            </ol>
                         </li>
                         <!-- end: Obligation -->
                         <!-- start: Rights and Limits -->
                         <li>
                            <h3>Rights and Limits</h3>
                            <ol>
                               <!-- start: Member Information -->
                               <li>
                                  <h3>Member Information</h3>
                                  <ol>
                                     <li>
                                        <p>
                                           All Member Information that you provide to PreviewMe and which is stored on the Website is owned by you. PreviewMe acknowledges and agrees that all rights including intellectual property rights in such Member Information belong to you, and we shall have no rights in or to such Member Information other than as expressly provided in this Agreement.
                                        </p>
                                     </li>
                                     <!-- start: You grant PreviewMe and our affiliates -->
                                     <li>
                                        <p>You grant PreviewMe and our affiliates a non-exclusive licence to use your Member Information to:</p>
                                        <ol>
                                           <li>
                                              <p>manage internal reporting requirements;</p>
                                           </li>
                                           <li>
                                              <p>collate statistical information about the use of the Website and submission of online applications;</p>
                                           </li>
                                           <li>
                                              <p>analyse the behaviour on the Website;</p>
                                           </li>
                                           <li>
                                              <p>obtain and analyse high level trends and prepare reports and analytics relating thereto;</p>
                                           </li>
                                           <li>
                                              <p>improve the user experience of our Services; and</p>
                                           </li>
                                           <li>
                                              <p>otherwise use in accordance with our Privacy Policy. </p>
                                              <p>The licence is a worldwide, transferrable and sub-licensable right to use, copy, modify, distribute, publish and process Member Information that you provide through our Services, without any further consent, notice and/or compensation to you or others.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: You grant PreviewMe and our affiliates -->
                                     <!-- start: The licence granted to PreviewMe set out in 3.1.2 may be terminated by: -->
                                     <li>
                                        <p>The licence granted to PreviewMe set out in 3.1.2 may be terminated by: </p>
                                        <ol>
                                           <li>
                                              <p>the Member deleting such Member Information from the Services; or</p>
                                           </li>
                                           <li>
                                              <p>terminating this Agreement in accordance with clause 5.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: The licence granted to PreviewMe set out in 3.1.2 may be terminated by: -->
                                     <li>
                                        <p>PreviewMe will not include any Member Information in advertisements for products and services of others without your separate consent. However, we have the right, without compensation to you or others, to display advertisements (at PreviewMe&rsquo;s own discretion) near your Member Information.</p>
                                     </li>
                                     <li>
                                        <p>Because you own your Member Information and we only have non-exclusive rights to it, you may choose to make it available to others, for example, you may provide information as a Candidate Member to an Employer Member when applying for a Role.</p>
                                     </li>
                                     <li>
                                        <p>You agree that PreviewMe and our affiliates may access, store and use any Information that you provide in accordance with this Agreement, the Privacy Policy and your privacy settings.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Member Information -->
                               <!-- start: Service Availability -->
                               <li>
                                  <h3>Service Availability</h3>
                                  <ol>
                                     <li>
                                        <p>PreviewMe may change, suspend or end any Service, or change and modify prices at PreviewMe&rsquo;s sole discretion. We can make these changes without prior notice to you. However, where the change is significant we will use reasonable endeavours to tell you about the change by giving notice to you per clause 2.5.2.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe provides no warranty that the Services will be available, uninterrupted or error-free or that defects in the Service will be corrected.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe does not guarantee or warrant that Content made available through the Website or transmitted by electronic mail will be free of infection or viruses, worms, Trojan horses or other code that manifest contaminating or destructive properties. You are responsible for implementing sufficient procedures and checkpoints to satisfy your particular requirements for accuracy of data input and output, and for maintaining a means external to the Website for the reconstruction of any data lost.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Service Availability -->
                               <!-- start: Other Content, Providers, Apps, Sites -->
                               <li>
                                  <h3>Other Content, Providers, Apps, Sites</h3>
                                  <ol>
                                     <li>
                                        <p>Information provided by PreviewMe in any form or through any medium does not constitute professional advice.</p>
                                     </li>
                                     <li>
                                        <p>You acknowledge and agree that information published by PreviewMe is intended to provide general information only. This includes, but is not limited to, guidance for registration, member profile (including video) creation, role creation and candidate processing.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe does not endorse or recommend any of the jobs or employment opportunities published and advertised on the Website and PreviewMe recommends that prior to entering into any agreement with any Member that you obtain your own independent human resources, legal, accounting, financial or taxation advice as appropriate.</p>
                                     </li>
                                     <li>
                                        <p>It is the Member&rsquo;s sole responsibility to evaluate the accuracy, completeness and currency of all opinions, advice, services, guidance and other information provided through the Services.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe provides links, pointers and guidance to websites maintained by third parties from the Website. Such linked sites are not under the control of PreviewMe and PreviewMe is not responsible for the content, material or advertisements of any linked website or any link contained in a linked website.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe provides links to third parties websites to you only as a convenience, and the inclusion of any link to a website does not imply endorsement or approval by PreviewMe of content, material or advertisements of the linked website.</p>
                                     </li>
                                     <li>
                                        <p>PreviewMe will not be liable for any damages or loss arising in any way out of or in connection with or incidental to any Member Information, third party content, or third party service provided by any third party.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Other Content, Providers, Apps, Sites -->
                               <!-- start: Limits on use -->
                               <li>
                                  <h3>Limits on use</h3>
                                  <ol>
                                     <!-- start: Subject to this Agreement, PreviewMe grants: -->
                                     <li>
                                        <p>Subject to this Agreement, PreviewMe grants:</p>
                                        <ol>
                                           <li>
                                              <p>Candidate Members a personal, non-assignable, non-sublicensable and non-exclusive license to use the Service; and</p>
                                           </li>
                                           <li>
                                              <p>Employer Members a non-assignable, non-sublicensable and non-exclusive licence to use the Service for use by those authorised to use the Service. PreviewMe reserves all of its intellectual property rights in the Services. This includes PreviewMe&rsquo;s trade marks, rights in domain names, copyright, patents, registered designs, circuit layouts, rights in computer software, databases and lists, rights in inventions, confidential information, know-how and trade secrets, operating manuals, quality manuals and all other intellectual property, in each case whether registered or unregistered (including applications for the grant of any of the foregoing) and all rights or forms of protection having equivalent or similar effect to any of the foregoing which may subsist anywhere in the world, including the goodwill associated with the foregoing and all rights of action, powers and benefits in respect of the same, all code and software that forms part of the Services.</p>
                                           </li>
                                        </ol>
                                     </li>
                                     <!-- end: Subject to this Agreement, PreviewMe grants: -->
                                     <li>
                                        <p>Except as otherwise permitted under this Agreement you may not modify, copy, reproduce, republish, upload, post, transmit or dilute in anyway any material from the Website or our Services.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Limits on use -->
                            </ol>
                         </li>
                         <!-- end: Rights and Limits -->
                         <!-- start: Disclaimer and limit of liability -->
                         <li>
                            <h3>Disclaimer and limit of liability</h3>
                            <ol>
                               <!-- start: No Warranty -->
                               <li>
                                  <h3>No Warranty</h3>
                                  <ol>
                                     <li>
                                        <p>You acknowledge that, except for those warranties or representations that cannot be excluded by law (including under the Consumer Guarantees Act 1993), the Services are provided on an &ldquo;as is&rdquo; basis and all representations, conditions or warranties in respect of the Service (whether express or implied, statutory or otherwise, and including warranties of merchantability and fitness for a particular purpose) are expressly excluded.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: No Warranty -->
                               <!-- start: Exclusion of Liability-->
                               <li>
                                  <h3>Exclusion of Liability</h3>
                                  <ol>
                                     <li>
                                        <p>To the maximum extent permitted by law, PreviewMe shall not be liable in tort (including negligence), contract, breach of statutory duty or otherwise for any direct, indirect, incidental, special, consequential or punitive damages, or any loss of data, opportunities, reputation, profits or revenues, related to the Services or arising out of or in connection with this Agreement.</p>
                                     </li>
                                     <li>
                                        <p>If, notwithstanding clause 4.2.1, we are found to be liable to you for any form of loss or damage, then to the maximum extent permitted by law, our maximum aggregate liability to you will not exceed </p>
                                        <p>the fees paid by you to us for the Services in the six months prior to the date on which the claim arose (if applicable).</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Exclusion of Liability-->
                            </ol>
                         </li>
                         <!-- end: Disclaimer and limit of liability -->
                         <!-- start: Termination -->
                         <li>
                            <h3>Termination</h3>
                            <ol>
                               <li>
                                  <p>PreviewMe reserves the right to limit the use of the Services. This includes the right to restrict, suspend or terminate your account without notice if PreviewMe believes that you may be in breach of this Agreement or law or are misusing the Services.</p>
                               </li>
                               <li>
                                  <p>PreviewMe or the Member may terminate this Agreement at any time upon notice to the other, or in the case of the Member, that Member choosing to close its account through the Settings Tab from located next to the dashboard of the Member&rsquo;s account on PreviewMe. On termination, the Member loses the right to access or use certain parts of the Services provided to Members only.</p>
                               </li>
                               <li>
                                  <p>Termination of the Agreement as a result of you breaching one or more terms of this Agreement will not terminate those provisions of these Agreement capable of surviving termination. For example, any amounts owed by either party prior to termination remain owed after termination.</p>
                               </li>
                            </ol>
                         </li>
                         <!-- end: Termination -->
                         <!-- start: General provisions -->
                         <li>
                            <h3>General provisions</h3>
                            <ol>
                               <!-- start: Partial Invalidity -->
                               <li>
                                  <h3>Partial Invalidity</h3>
                                  <ol>
                                     <li>
                                        <p>any provision of this Agreement or its application to any party or circumstance is or becomes invalid or unenforceable to any extent, the remainder of this Agreement and its application will not be affected and will remain enforceable to the greatest extent permitted by law.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Partial Invalidity -->
                               <!-- start: Assignment -->
                               <li>
                                  <h3>Assignment</h3>
                                  <ol>
                                     <li>
                                        <p>You may not assign or transfer your rights and obligations under this Agreement to any entity without PreviewMe&rsquo;s written approval. If you are a company, any change in your effective control shall be deemed an assignment for the purpose of this clause.</p>
                                     </li>
                                     <li>
                                        <p>You agree that PreviewMe may assign, transfer and/or sub-contract its rights and/or obligations under this Agreement to any third party without your consent.</p>
                                     </li>
                                     <li>
                                        <p>There are no third party beneficiaries to this Agreement.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Assignment -->
                               <!-- start: Waiver -->
                               <li>
                                  <h3>Waiver</h3>
                                  <ol>
                                     <li>
                                        <p>No exercise or failure to exercise or delay in exercising any right or remedy by PreviewMe will constitute a waiver by PreviewMe of that or any other right or remedy available to it.</p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Waiver -->
                               <!-- start: Governing Law -->
                               <li>
                                  <h3>Governing Law</h3>
                                  <ol>
                                     <li>
                                        <p>This Agreement is governed by the laws of New Zealand and the courts of New Zealand have exclusive jurisdiction in respect of any matter concerning use of our Services. </p>
                                     </li>
                                  </ol>
                               </li>
                               <!-- end: Governing Law -->
                            </ol>
                         </li>
                         <!-- start: General provisions -->
                      </ol>
                   </div>
                <!-- end: User Agreement -->

                   <h2 class="btn-toggler-container">
                      <a class="btn-toggler" data-toggle="collapse" data-target="#publish-agreement" href="javascript:void(0)">Role Publishing User Agreement</a>
                      <span class="arrow-point"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                   </h2>
                   <div class="collapse" id="publish-agreement">
                      <p>Welcome to PreviewMe<sup>&reg;</sup> Limited&rsquo;s (&ldquo;<strong>PreviewMe</strong>&rdquo;, &ldquo;<strong>we</strong>&rdquo;, &ldquo;<strong>us</strong>&rdquo; or&nbsp;<strong>our</strong>&rdquo;) website. We are an employment technology company providing a network of employers and candidates with the tools to publish and apply for employment opportunities, promote themselves through video and communicate more effectively. This Role Publishing User Agreement (&ldquo;<strong>Terms</strong>&rdquo;) applies to all Employer Members (&ldquo;<strong>you</strong>&rdquo; or &ldquo;<strong>your</strong>&rdquo;) that:</p>
                      <ul>
                         <li>(a) have an employment opportunity or job vacancy (&ldquo;<strong>Role</strong>&rdquo;) and wish to advertise and publish on the Website a publication or an advertisement in respect of that Role (&ldquo;<strong>Role Publication</strong>&rdquo;);</li>
                         <li>(b) have access to an Employer Member account through which Employment Members can publish Roles (&ldquo;<strong>Employer Account</strong>&rdquo;);</li>
                         <li>(c) receive applications submitted by Candidate Members;</li>
                         <li>
                            (d)&nbsp;utilise specific Services available to them by virtue of creating an Employer Account;&nbsp;
                            <br>
                            <br>
                            <p>By using our Services, you agree to follow and be bound by these Terms and the&nbsp;<a target="_blank" href="/terms-and-conditions">User Agreement</a> (including the&nbsp;<a target="_blank" href="/privacy-policy">Privacy Policy)</a>. If you do not agree to all the Terms, you must cease using our Services immediately. Capitalised terms used in these Terms have the same meaning as set out in the User Agreement (unless otherwise defined in these Terms).</p>
                         </li>
                      </ul>
                      <ol>
                         <li>
                            <h3>Variation of Terms</h3>
                            <ol>
                               <li>PreviewMe may vary these Terms at any time. If PreviewMe varies these Terms we will provide notice of any changes.</li>
                            </ol>
                         </li>
                         <li>
                            <h3>Payment</h3>
                            <ol>
                               <li>PreviewMe will give notice of changes to fees and/or payment for Services. Changes to fees and/or payment for Services are made at PreviewMe&rsquo;s sole discretion.</li>
                               <li>You will pay for the Services that PreviewMe provides you with that require payment, regardless of whether you utilise or fully utilise those Services. If you do not provide PreviewMe with the necessary materials or information for PreviewMe to deliver these Services to you, you are still liable to PreviewMe for full payment.</li>
                               <li>Payments using credit cards may incur an extra nominal charge of approximately 2.5% of the payment amount. The rates are the same that PreviewMe is charged by the credit card merchant used by PreviewMe.</li>
                               <li>PreviewMe may charge interest on late payments at its applicable bank interest rate plus any costs we incur as a result of collecting your payment.</li>
                               <li>If you do not pay your account on time, PreviewMe may, without liability, disable your account without notice and refuse to supply you with further Services.</li>
                               <li>You agree that pursuant to the Credit Reporting Privacy Code 2004, PreviewMe may obtain from a credit reporter or other credit providers credit information about you or your other directors or a credit report about you for the purpose of collecting overdue payments relating to debt owed by you.</li>
                               <li>You agree that PreviewMe may disclose any default payment and related information to a credit reporter.</li>
                            </ol>
                         </li>
                         <li>
                            <h3>Obligations</h3>
                            <ol>
                               <li>
                                  You indemnify and will keep indemnified PreviewMe, its officers, employees and agents against all claims, actions, suits, liabilities, actual or contingent costs, damages and expenses incurred by PreviewMe arising out of or in connection with:
                                  <ol>
                                     <li>any breach of these Terms or the User Agreement (including the Privacy Policy) by you;</li>
                                     <li>any negligent act or omission by you;</li>
                                     <li>any Role Publication or proposed Role Publication by you on the Website (including any claim that the Role Publication infringes the intellectual property rights of any third party); or</li>
                                     <li>n actual or alleged breach by you of any law, legislation, regulation, by-law, ordinances or codes of conduct which occurs as a consequence of your Role Publication appearing on the Website.</li>
                                  </ol>
                               </li>
                               <li>You may not ask or require any potential Candidate Members to pay a fee, charge, cost or pay any money whatsoever to apply for any Role on the Website whether such fee, charge, cost or money is asked or required of the Candidate Members in the Role Publication itself or in any communication (on the Website or external to the Website) with the Candidate Members that takes place as a result of a Role Publication on the Website.</li>
                               <li>Where you are in a business of providing recruitment related services, any Role Publications published on the Website must be branded with your recruitment company brand or co-branded with both your recruitment company brand and the brand of your client to whom the Role is being published for.</li>
                            </ol>
                         </li>
                         <li>
                            <h3>Misuse of Information and on-selling</h3>
                            <ol>
                               <li>Any content or personal information within the meaning of the Privacy Act 1993 of any Candidate Member that applies for a Role through the Services must only be used by you in relation to your genuine employment and/or recruitment activities.</li>
                               <li>You are prohibited from selling or offering products or services in Role Publications to Candidate Members whose personal information you have obtained through the Services on the Website. Any selling or offering of your own products or services may only be done through your profile page that Candidate Members can subscribe to or Visitors can browse or as a third party supplier of products or services to PreviewMe.</li>
                               <li>Subject to any features provided by PreviewMe in the course of enabling the processing and screening of Candidate Members, you may not provide any personal information you have obtained through your use of the Services (including job applications received from Candidate Members) to any other party, including to any affiliate or related party of yours (unless PreviewMe has otherwise consented to this). This restriction on forwarding such personal information or other information applies irrespective of whether you receive direct financial benefit for doing so.</li>
                               <li>
                                  If PreviewMe believes that you have misused personal information (as defined in the Privacy Act 1993) for any reason, PreviewMe reserves the right to:
                                  <ol>
                                     <li>immediately suspend or terminate your use of the Services and Employer Account, and or suspend or terminate the account of any party that has received personal information or other Candidate Member Information from you in breach of these Terms;</li>
                                     <li>report any potential contraventions of the applicable data protection legislation such as the Privacy Act 1993 in New Zealand to the relevant authorities including the Office of the Privacy Commissioner; and / or</li>
                                     <li>take legal action against you seeking any number of remedies provided by law, including an award of monetary damages.</li>
                                  </ol>
                               </li>
                            </ol>
                         </li>
                         <li>
                            <h3>Role Publications</h3>
                            <ol>
                               <li>You must ensure that all Role Publications, and the Roles to which they pertain, published on the Website comply with all applicable legislation, regulations, by-laws, ordinances and codes of conduct. You must also ensure that all Role Publications do not infringe the intellectual property rights of a third party.</li>
                               <li>You must adhere to the principles of truth in advertising set out in the Recruitment and Consulting Services Association&rsquo;s Code for Professional Practice.</li>
                               <li>
                                  You are not permitted to insert links to an external website or an externally hosted application form:
                                  <ol>
                                     <li>within the details of the Role Publication;</li>
                                     <li>rom within PreviewMe&rsquo;s Pre-Application and Secondary Question process; or</li>
                                     <li>within or from a previously approved externally hosted application form,&nbsp;
                                        <br>
                                        <br>without PreviewMe&rsquo;s express written approval which may be granted or withheld or withdrawn at PreviewMe&rsquo;s sole discretion.
                                     </li>
                                  </ol>
                               </li>
                               <li>You may only publish Role Publications on the Website that are in respect of a genuine Role that is current as at the time of posting the Role Publication, and for which you are currently recruiting. PreviewMe reserves the right to request any information from you that it deems necessary to verify that a genuine Role exists.</li>
                               <li>You must ensure that Role Publications published on the Website are published under the appropriate category of the Website. It is your responsibility to ensure that you familiarise yourself with publishing and or advertising requirements of each available category on the Website to ensure the appropriate placement of Role Publications.</li>
                               <li>You acknowledge and agree that only one employment or job opportunity is contained in every Role Publication published. This does not prohibit you from employing more than one Candidate Member, as more often than not, roles can be created for the right person who comes along during the recruitment process. We encourage you to create opportunities for the right Candidate Member who is connected with you.</li>
                               <li>You must ensure that all information entered in any data entry field, as part of the Role Publication process, relates directly to the relevant data field category. PreviewMe reserves the right to amend, alter or remove any information that does not meet this requirement.</li>
                               <li>PreviewMe reserves the right and Employer Members must accept as a condition of publishing Role Publications on the Website, PreviewMe&rsquo;s right to re-classify Role Publications on the Website, entitling PreviewMe to withdraw Role Publications from one category of the Website and to re-publish those Role Publications in another category on the Website.</li>
                               <li>A standard Role Publication that is published is valid for 30 days after which the Role Publication will no longer be published on the Website. The Role Publication can be withdrawn earlier at the discretion of the publisher of the Role.</li>
                               <li>
                                  The following constitutes a new Role Publication:
                                  <ol>
                                     <li>re-publishing the template of a previous Role Publication; and</li>
                                     <li>refreshing or changing the zone classification of any Role Publication. Refreshing is the process of deleting and re-publishing the same or substantially similar Role.</li>
                                  </ol>
                               </li>
                               <li>Without limiting clause 4.1 of the User Agreement, you acknowledge and agree that PreviewMe does not warrant, represent or guarantee that the publication of any Role Publication will result in any enquiries or submissions by any Candidate Member or other person, or the placement of a Candidate Member or any other person in the relevant Role.</li>
                            </ol>
                         </li>
                         <li>
                            <h3>Processing Candidate Member Applications</h3>
                            <ol>
                               <li>PreviewMe provides as part of its Service the ability for the Employer Member to process Candidate Member applications (&ldquo;Candidate Processing Services&rdquo;) within the Website including reviewing textual and video information supplied by the Candidate Member as part of the application process.</li>
                               <li>You authorise PreviewMe to store and retain all Candidate Member applications submitted in response to the relevant Role Publication on your behalf.</li>
                               <li>You may choose to retain Candidate Member applications within your Employer Account after a Role Publication has expired. The level of communication is determined between you and the Candidate Member.</li>
                               <li>
                                  Before using our Candidate Processing Services in respect of Candidate Member Applications, you must ensure that you:
                                  <ol>
                                     <li>ep all personal information relating to the Candidate Member safe and secure;</li>
                                     <li>do not use any of the information contained in Candidate Member applications for purposes other than processing Candidate Member applications for a genuine Role;</li>
                                     <li>only use the Candidate Processing Services to communicate with Candidate Members for Roles and provide any updates and notifications;</li>
                                     <li>have expressly obtained the consent of every individual whose personal information you process as part of the Candidate Processing Services to such usage and any other usage;</li>
                                     <li>have fully disclosed to such individuals the purpose for which their personal information has been collected by you;</li>
                                     <li>have otherwise fully complied with your obligations under the Privacy Act 1993 in respect of the collection and storage of such information.</li>
                                  </ol>
                               </li>
                            </ol>
                         </li>
                         <li>
                            <h3>Hardware and Software</h3>
                            <ol>
                               <li>You are responsible for ensuring that you have the necessary computer hardware and software systems in place to access and utilise the Website.</li>
                            </ol>
                         </li>
                      </ol>
                   </div>
                   <h2 class="btn-toggler-container">
                      <a class="btn-toggler" data-toggle="collapse" data-target="#new-zea-harm" href="javascript:void(0)">New Zealand Harmful Digital Communications Act 2015</a>
                      <span class="arrow-point"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                   </h2>
                   <div class="collapse" id="new-zea-harm">
                      <h4>(1)</h4>
                      <p><em>Principle 1</em></p>
                      <p>A digital communication should not disclose sensitive personal facts about an individual.</p>
                      <p><em>Principle 2</em></p>
                      <p>A digital communication should not be threatening, intimidating, or menacing.</p>
                      <p><em>Principle 3</em></p>
                      <p>A digital communication should not be grossly offensive to a reasonable person in the position of the affected individual.</p>
                      <p><em>Principle 4</em></p>
                      <p>A digital communication should not be indecent or obscene.</p>
                      <p><em>Principle 5</em></p>
                      <p>A digital communication should not be used to harass an individual.</p>
                      <p><em>Principle 6</em></p>
                      <p>A digital communication should not make a false allegation.</p>
                      <p><em>Principle 7</em></p>
                      <p>A digital communication should not contain a matter that is published in breach of confidence.</p>
                      <p><em>Principle 8</em></p>
                      <p>A digital communication should not incite or encourage anyone to send a message to an individual for the purpose of causing harm to the individual.</p>
                      <p><em>Principle 9</em></p>
                      <p>A digital communication should not incite or encourage an individual to commit suicide.</p>
                      <p><em>Principle 10</em></p>
                      <p>A digital communication should not denigrate an individual by reason of his or her colour, race, ethnic or national origins, religion, gender, sexual orientation, or disability.</p>
                      <h4>(2)</h4>
                      <p>In performing functions or exercising powers under this Act, the Approved Agency and courts must&mdash;</p>
                      <p>(a) take account of the communication principles; and</p>
                      <p>(b) act consistently with the rights and freedoms contained in the&nbsp;<a href="http://www.legislation.co.nz/act/public/1990/0109/latest/DLM224792.html">New Zealand Bill of Rights Act 1990.</a></p>
                   </div>
                </div>
                <div class="modal_btn_container">
                   <button id="termsServiceModal-close-btn" ng-click="showTerms()" class="btn-pvm modal_btn modal_btn--red">Close</button>
                </div>
             </div>
          </div>
          <!-- end: term-service-modal -->

          <div class="pvm__modal-popup  pvm__modal-popup--confirm registration-popup " id="privacyPolicyModal">
             <div class="pvm__modal-popup__content pvm__modal-popup__content--large">
                <a href="#" id="privacyPolicyModal-x-btn" ng-click="showTerms()" class="close pvm-color-red"><i class="fa fa-times" aria-hidden="true"></i></a>
                <h1 class="registration-popup--title">PreviewMe Privacy Policy</h1>
                <div class="registration-popup">
                   <p>Welcome to PreviewMe Limited&rsquo;s (&ldquo;PreviewMe&rdquo;, &ldquo;we&rdquo;, &ldquo;us&rdquo; or &ldquo;our&rdquo;) website. We are an employment technology company that provides a network of employers and candidates with the tools to publish and apply for employment opportunities, promote themselves through video and communicate more effectively.</p>
                   <p>This Privacy Policy sets out our, and your, rights and obligations in relation to personal information (as defined in the Privacy Act 1993) provided through the use of our Services. By using our Services, you agree to follow and be bound by the terms and conditions of this Privacy Policy, the User Agreement and, if applicable, the Role Publishing User Agreement.</p>
                   <p>If you have any concerns about providing personal information to us or having such information displayed on our Service or otherwise used in manner permitted in this Privacy Policy and the User Agreement and Role Publishing User Agreement then you should not become a Member and you should not use our Website or use any of our other Services. Capitalised terms used in this Privacy Policy have the same meaning as set out in the&nbsp;<a target="_blank" href="/terms-and-conditions">User Agreement</a> and the&nbsp;<a target="_blank" href="/terms-and-conditions">Role Publishing User Agreement</a> (unless otherwise defined in this Privacy Policy).</p>
                   <p>For more information on the Privacy Act 1993 &ndash; Privacy Principles, please&nbsp;<a href="http://www.legislation.govt.nz/act/public/1993/0028/latest/whole.html" target="_blank">visit this website.</a></p>
                   <ol>
                      <li>
                         <h3>COLLECTION OF PERSONAL INFORMATION</h3>
                         <p>Personal Information is collected in the following ways:</p>
                         <ol>
                            <li>
                               <h5>REGISTRATION</h5>
                               <p>When you create an account with PreviewMe we collect information including your name, email address and password. You may provide additional information during the registration process, your postal and/or current address or location, job title and company name. Collectively, this information that you provide is the &ldquo;Registration Information&rdquo;.</p>
                               <p>To create an account on PreviewMe you must provide the Registration Information and agree to the User Agreement, the Role Publishing User Agreement (if applicable) and this Privacy Policy which govern how we treat your Registration Information. This Registration Information is used to help you build your PreviewMe profile and to provide you with more customized services, such as matching you with Roles (as defined in the Role Publishing User Agreement), updates and notifications. You understand that by registering as a Member, we and other Members (subject to your account privacy settings) will be able to identify you by your PreviewMe profile.</p>
                            </li>
                            <li>
                               <h5>PROFILE INFORMATION</h5>
                               <p>We collect personal information when you fill out your PreviewMe profile. You can complete the PreviewMe profile at anytime after registration. You may choose to populate your profile with additional information such as description of your skills, employment history, and educational background. This can be provided as a mix of textual or visual (photographic and video) content.</p>
                               <p>We collect this information to simplify the application process when you apply for a Role and provide it to the Employer Member in a manner completely controlled by you.</p>
                               <p>We may also provide recommendations to you about companies to engage with and follow, Roles that we consider match your criteria and other updates and notifications. Providing additional information enables you to derive more benefit from our Services by helping you express yourself to find Roles.</p>
                            </li>
                            <li>
                               <h5>CUSTOMER SERVICES</h5>
                               <p>We collect personal information when you contact our customer support team.</p>
                               <p>When you contact our customer support services, we may have to access your account to respond to your questions and if applicable, investigate any breach of the PreviewMe User Agreement, Role Publishing User Agreement or this Privacy Policy. We also use this personal information to track potential problems and trends and customize our support responses to better serve you. We do not use this personal information for advertising.</p>
                            </li>
                            <li>
                               <h5>USING PREVIEWME</h5>
                               <p>We collect personal information when you use the Website, applications, platform technologies or other Services (whether as a Member or a Visitor). For example, we collect personal information when you click on Employer Member profiles, follow Employer Members, install our applications onto mobile devices or apply for Roles through our Service. If you are logged into your PreviewMe account or one of our cookies on your device identifies you, your usage information and log data (described below) such as your IP address, will be associated by us with your account even if you are not logged into a Service or your PreviewMe account. We log information about devices used to access our Services, including IP addresses.</p>
                            </li>
                            <li>
                               <h5>COOKIES</h5>
                               <p>We use cookies and similar technologies that can identify details of your IP address, device platform (e.g. Windows, Mac OS, iOS or Android), browser (e.g. Internet Explorer, Edge, Safari, Chrome or other, plus the version of browser), domain (whether you are accessing the Services from New Zealand or elsewhere) and other user information (e.g. your username) to collect information.</p>
                               <p>We use cookies and similar technologies, including mobile application identifiers, to help us recognize you across different Services, learn about your interests both on and off our Services, improve your experience, increase security, measure use and improve the effectiveness of our Services. You can control cookies through your browser settings and other tools. By visiting our Services, you consent to the placement of cookies and beacons in your browser and HTML-based emails in accordance with this Privacy Policy. You can choose to refuse cookies by turning them off in your browser and/or deleting them from your hard drive. You do not need to have cookies turned on to use the Services but you will need them to log on to the Services and to access personalised or secure content on the Services. Some pages may not function properly if the cookies are turned off.</p>
                            </li>
                            <li>
                               <h5>USING THIRD-PARTY SERVICES AND VISITING THIRD PARTY WEBSITES</h5>
                               <p>PreviewMe collects information about you when you use your account to sign in to other websites or services and when you view pages that include our plugins and cookies.</p>
                               <p>We receive information about your visits and interaction with the sites and services of our partners that include our cookies and similar technologies, unless you disable such technologies.</p>
                            </li>
                            <li>
                               <h5>LOG FILES, IP ADDRESSES AND INFORMATION ABOUT YOUR COMPUTER AND MOBILE DEVICE</h5>
                               <p>We collect personal information from the devices and networks that you use to access our Services.</p>
                               <p>When you visit or leave our Services (whether as a Member or a Visitor) by clicking a hyperlink or when you view a third party site that includes our plugin or cookies (or similar technologies), we automatically receive the URL of the website from which you came from or the one to which you are directed.</p>
                            </li>
                            <li>
                               <h5>OTHER</h5>
                               <p>We are constantly innovating to improve our Services and your experience which means we may create new ways to collect information on the Services in the future. Our Services are a dynamic, innovative environment and we are always improving the Services we offer you. We often introduce new features, some of which may result in the collection of new information. Furthermore, new partnerships or corporate acquisitions may result in new features, and we may potentially collect new types of information.</p>
                               <p>If PreviewMe starts collecting substantially new types of personal information and materially change how we handle your personal information and other content you introduce to the Services, we will modify this Privacy Policy and notify you.</p>
                            </li>
                         </ol>
                      </li>
                      <li>
                         <h3>HOW WE USE, DISCLOSE AND SHARE YOUR PERSONAL INFORMATION</h3>
                         <ol>
                            <li>
                               <h5>PREVIEWME USING INFORMATION ABOUT YOU</h5>
                               <p>Information you provide on your profile can be seen by others and used by us as described in this Privacy Policy, our User Agreement and Role Publishing User Agreement.</p>
                               <p>The personal information that you provide to us may reveal or allow others to identify aspects of your life that are not expressly stated on your profile. By providing personal information to us when you create or update your account and profile, you are expressly and voluntarily accepting the terms and conditions of our User Agreement and freely accepting and agreeing to our processing of your personal information in the ways set out by this Privacy Policy.</p>
                               <p>You can withdraw or modify your consent to our collection and use of the personal information you provide at any time in accordance with the terms of this Privacy Policy and User Agreement and Role Publishing User Agreement by changing your account settings or your profile on PreviewMe or by closing your PreviewMe account in accordance with clause 3.1.</p>
                            </li>
                            <li>
                               <h5>PREVIEWME COMMUNICATIONS</h5>
                               <p>We communicate with you through electronic mail, notifications published on the Website or partner websites, messages to your PreviewMe inbox and other means available through the Service, including mobile text messages and push notifications.</p>
                               <p>We may send you messages relating to the availability of the Services, security, or other service-related issues. You agree that we may also may send promotional messages to your PreviewMe inbox.</p>
                            </li>
                            <li>
                               <h5>USER COMMUNICATIONS</h5>
                               <p>With certain communications you send on our Services, the recipient can see your name, email address, and some network information.</p>
                               <p>Many communications that Members initiate through our Services will list your name in the primary header of the message. Messages you initiate may also provide the recipient with aggregate information about you or, if communicating from an Employer Member account, the company you represent.</p>
                               <p>Full profile information is private by design until the Member applies for a Role published by an Employer Member with the Employer Member then having access to your PreviewMe profile URL.</p>
                            </li>
                            <li>
                               <h5>SERVICE DEVELOPMENT; CUSTOMIZED EXPERIENCE</h5>
                               <p>We may use personal information provided by you in an anonymised aggregated form to conduct research and development, generate reports and analytics, and to customize your experience and try to make it relevant and useful to you.</p>
                               <p>We may use personal information that you and other Members provide to us to improve our Services in order to provide you and other Members and visitors with a better and more intuitive experience, drive membership growth and engagement on our Service.</p>
                               <p>We also customize your experience on our Services. For example, when you sign into your account, we may display new Role Publications (as defined in the Role Publishing User Agreement) or Employer Members in your account for you to view, apply and / or follow. We try to show you content that is relevant to you based on the information you have provided us in accordance with this Privacy Policy.</p>
                            </li>
                            <li>
                               <h5>SHARING INFORMATION WITH THIRD PARTIES</h5>
                               <p>Any personal information you put on your profile or you provide to a prospective employer (whether in relation to a particular Role or not) may be seen by others.</p>
                               <p>We do not provide any of your non-public personal information to third parties without your consent, unless required by law or as set out in this Privacy Policy.</p>
                               <p>Any of our affiliates may assist us with the operation of the Service including the processing and storage of any information and exercising any of our rights under this Privacy Policy, the User Agreement and the Role Publishing User Agreement. Accordingly, you acknowledge and agree that we may provide any of your personal information to any of our affiliates for that purpose.</p>
                               <p>Candidate Member profiles on PreviewMe are private by default. Employer Member profiles are public by default. Where any part of a profile is made public, that public profile will be indexed and displayed through public search engines when someone searches the Member&rsquo;s name (be it an individual or a company).</p>
                            </li>
                            <li>
                               <h5>POLLS AND SURVEYS AND REPORTS</h5>
                               <p>We conduct our own surveys and polls and also help third parties do this type of research. Your participation in surveys or polls is up to you. You may opt in to or opt out of getting invitations to participate in surveys.</p>
                               <p>We may use your personal information in an anonymised aggregated form to generate reports as part of our Service. The reports are designed to help our Employer Members and third parties conduct research and improve their service offerings. We also generate reports for Members looking for Roles. For example, we generate market data that can assist our Members&rsquo; understanding of the employment landscape in a particular industry, how a Member progressed through an application process for a Role or, we generate reports that identify skill shortages and skills obsolescence to feed into the education lifecycle. We gather analytics and generate these reports to improve the quality of our Service. You will not be personally identifiable in reports generated by us.</p>
                            </li>
                            <li>
                               <h5>SEARCHING AND SEARCHABILITY</h5>
                               <p>Members may also search for Employer Members and Roles and filter Employer Members and Roles in a number of ways. The Employer Members cannot personally identify you when you search them.</p>
                            </li>
                            <li>
                               <h5>PROFILES FOR EMPLOYERS</h5>
                               <p>Employers can create profile pages on our Service after they have registered an Employer Member account. If you follow one of these pages and form part of the Employer Member&rsquo;s profile page, you form part of that profile page&rsquo;s &ldquo;Community&rdquo;. Non-identifiable information about you will be provided to the profile page&rsquo;s administrator.</p>
                               <p>Certain profile pages on the Service are public (such as the Employer Member pages). When following those profile pages as part of a Community, we use aggregate information about followers and viewers to provide data for reporting on such pages (performance, conversions, updates, visits, cut-through).</p>
                            </li>
                            <li>
                               <h5>GROUPS AND FOLLOWING</h5>
                               <p>When a Member carries out an action including viewing a Role Publication, an Employer Member profile or applying for a Role, the Member is given the choice to follow the Employer. This is different to saving a Role Publication on a watch list in your profile.</p>
                               <p>In addition to clause 2.8, when you elect to follow an Employer Member and form part of that Employer Member&rsquo;s Community, you can receive notifications and updates on that Employer Member. For example, you may get notifications about Roles or networking functions. These notifications are sent to your account. You can opt out of a Community at any time by adjusting the settings in your account.</p>
                               <p>When you follow an Employer Member, that Employer Member may elect to search for skills amongst its Community for an upcoming Role. You will be notified if you have the skills that match the upcoming Role but you will not be personally identified.</p>
                            </li>
                            <li>
                               <h5>TESTIMONIALS ABOUT PREVIEWME</h5>
                               <p>If you provide any testimonials about our Service, we may publish those testimonials from time to time. Testimonials may include your name (or company) and other personal information you have provided including the testimonial.</p>
                            </li>
                            <li>
                               <h5>COMPLIANCE WITH LEGAL PROCESS AND OTHER DISCLOSURES</h5>
                               <p>We may need to disclose personal information, profile information, or information about your activities as a Member or Visitor when required by law, subpoena, or other legal process in New Zealand, Australia or other jurisdictions, or if we have a good faith belief that disclosure is reasonably necessary to:</p>
                               <ul>
                                  <li>investigate, prevent or take action regarding suspected or actual illegal activities or to assist government enforcement agencies;</li>
                                  <li>enforce the User Agreement or Role Publication User Agreement, investigate and defend ourselves against any third party claims or allegations, or protect the security and integrity of our Service;</li>
                                  <li>Exercise or protect the rights, property of safety of Members, personnel or others.</li>
                               </ul>
                            </li>
                            <li>
                               <p>We will attempt to notify the Member about legal demands for their personal information when appropriate in our judgement, unless prohibited by law or court order or when the request is an emergency. In light of our principles, we may dispute such demands at our discretion.</p>
                            </li>
                            <li>
                               <h5>DISCLOSURES TO OTHERS AS A RESULT OF A CHANGE IN CONTROL OR SALE OF PREVIEWME</h5>
                               <p>If there is a change in control or sale of all or part of PreviewMe, we may share your personal information with a third party, who will have the right to use that personal information in line with this Privacy Policy.</p>
                               <p>We may also disclose your personal information to a third party as part of a sale of the assets of PreviewMe, a subsidiary, a parent, or division, or as a result of a change in control of PreviewMe or one of our affiliates, or in preparation for any of these events.</p>
                               <p>Any third party to which we transfer or sell our assets will have the right to continue to use the personal and other information that you provide to us in the manner set out in this Privacy Policy.</p>
                            </li>
                            <li>
                               <h5>SERVICE PROVIDERS</h5>
                               <p>We may employ third parties to help us with the Service.</p>
                               <p>We may employ third party companies and individuals, such as Microsoft Azure, to facilitate our Services, including for maintenance, analysis, audit, marketing and development, video production. These third parties have access to your personal information only to perform these tasks on our behalf and are obligated to PreviewMe not to disclose or use it for any other purpose.</p>
                            </li>
                            <li>
                               <h5>DATA PROCESSING OUTSIDE NEW ZEALAND</h5>
                               <p>We may transfer your personal information for the purpose of storage or processing outside New Zealand, wherever PreviewMe, its affiliates or its service providers operate.</p>
                            </li>
                            <li>
                               <h5>STORAGE OF INFORMATION</h5>
                               <p>Any personal information provided to us will be collected and held by, or on behalf of, us at Microsoft&rsquo;s data centres used by PreviewMe. We may use cloud providers or data centres (whether in New Zealand or overseas), to manage and store personal and other information we collect, and will ensure that any storage on such a platform provides adequate security measures.</p>
                               <p>Refer to&nbsp;<a href="https://www.microsoft.com/en-us/trustcenter" target="_blank">www.microsoft.com/en-us/trustcenter</a> for more information on Microsoft&rsquo;s compliance, security and cloud storage facilities.</p>
                            </li>
                         </ol>
                      </li>
                      <li>
                         <h3>OTHER RIGHTS AND OBLIGATIONS</h3>
                         <ol>
                            <li>
                               <h5>RIGHTS TO ACCESS, CORRECT OR DELETE YOUR PERSONAL INFORMATION AND CLOSING YOUR ACCOUNT</h5>
                               <p>You can change your personal information at any time by editing your profile, deleting your personal information that you have uploaded or published, or by closing your account. You can also ask us for additional personal information we may have about you.</p>
                               <p>You have the right to:</p>
                               <ul>
                                  <li>access, modify, correct, or delete your personal information controlled by PreviewMe regarding your profile or any other personal information we hold about you;</li>
                                  <li>change or remove your content and personal information; and</li>
                                  <li>close your account.</li>
                               </ul>
                            </li>
                            <li>
                               <p>You can request access to and/or correction of your personal information that is not viewable on your profile or readily accessible to you (such as your IP access logs) through PreviewMe&rsquo;s help centre.</p>
                               <p>If you close your account, your personal information will generally be removed from the Service within 48 hours. We generally delete closed account information and will de-personalize any logs or other backup information through the deletion process within 30 days of account closure except as noted below.</p>
                               <p>Personal information you have shared with other Members or other entities (for example, personal information provided through the job application process or messaging prospective employers) or that other Members have copied and stored may also remain visible after you have closed your account or deleted the personal information from your own profile.</p>
                               <p>We may not be able to provide you with access to, correct, or remove any information about you that other Members copied or exported out of our Service because this information may not be within our control. You can make such requests directly from Employer Members to whom you have applied via our Services.</p>
                            </li>
                            <li>
                               <h5>DATA RETENTION</h5>
                               <p>We retain the personal information you provide while your account is in existence or as needed to provide you with services. We may retain your personal information even after you have closed your account if retention is reasonably necessary to comply with our legal obligations, meet regulatory requirements, resolve disputes between Members, prevent fraud or abuse, or enforce this Privacy Policy, our User Agreement or the Role Publishing User Agreement.</p>
                               <p>We may retain personal information, for a limited period of time, if requested by law enforcement. Our Customer Service team may retain information for as long as necessary to provide support, related reporting and trend analysis only, but we generally delete or de-personalize closed account data.</p>
                            </li>
                         </ol>
                      </li>
                      <li>
                         <h3>THIRD PARTY LINKS</h3>
                         <p>Our Services may contain links to and from websites that are not controlled by us. By using our Services, you may also provide your non-public personal information to third parties such as Employer Members receiving your Role applications. If you follow a link to any other website or provide your personal information to third parties, you should note that they have their own rules around privacy. We do not accept any responsibility or liability for anyone else&rsquo;s policies or for any transactions that you enter into with them.</p>
                      </li>
                      <li>
                         <h3>IMPORTANT INFORMATION</h3>
                         <ol>
                            <li>
                               <h5>CHANGES TO THIS PRIVACY POLICY</h5>
                               <p>We may change this Privacy Policy from time to time. If we make significant changes in the way we treat your personal information, or to the Privacy Policy, we will provide notice to you on the Services or by some other means. Please review the changes carefully.</p>
                               <p>If you agree to the changes, simply continue to use the Service. If you object to any of the changes to our terms and you no longer wish to use our Services, you may close your account.</p>
                               <p>Unless otherwise stated, our current Privacy Policy applies to all personal information that you provide to us. Using our Services after a notice of changes has been communicated to you or published on our Services shall constitute consent to the changed terms or practices.</p>
                            </li>
                            <li>
                               <h5>SECURITY</h5>
                               <p>We have implemented privacy safeguards designed to protect the personal information that you provide in accordance with industry standards. Access to your data on our Services is password protected, and data such as credit card information is protected by SSL encryption when it is exchanged between your web browser and the Services.</p>
                               <p>There is no guarantee that personal information may not be accessed, disclosed, altered, or destroyed by breach of any of our physical, technical or managerial safeguards. It is your responsibility to protect the security of your login information. Please note that emails, instant (SMS) messaging and similar means of communication with other Members are not encrypted, and we strongly advise you not to communicate any confidential information through those means.</p>
                               <p>Please help to keep your account safe by using a strong password.</p>
                            </li>
                         </ol>
                      </li>
                   </ol>
                </div>
                <div class="modal_btn_container">
                   <button id="privacyPolicyModal-close-btn" ng-click="showTerms()" class="btn-pvm modal_btn modal_btn--red">Close</button>
                </div>
             </div>
          </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script type="text/javascript" src="js/minified/login/register.min.js"></script>
<script type="text/javascript" src="/js/login/register.js"></script>
@stop