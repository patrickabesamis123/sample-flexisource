@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div id="static-faq-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 static-top-content text-center">
                <h1>Frequently Asked Questions</h1>
                <h4>Go on, ask us anything</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 static-bottom-content">
                <div class="faq-containter">
                    <br><br><br>
                    <div class="faq_selection faq_subheader">WHAT IS YOUR QUESTION ABOUT?</div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent1" class="openFilter1">
                        <h2>
                        Cost
                        <small class="glyphicon fa fa-angle-down pull-right cursor-pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents" id="FilterContent1">
                            <div class="faq-inner-selection">
                                <p class="faq-question">HOW MUCH DOES IT COST TO CREATE AN ACCOUNT?</p>
                                <div class="pvm-gray">Absolutely nothing.</div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent7" class="openFilter7">
                        <h2>
                        Registration
                        <small class="glyphicon fa fa-angle-down pull-right"></small>
                        </h2>
                        </a>
                        <div class="faq-contents hide-faq" id="FilterContent7">
                            <div class="faq-inner-selection">
                                <p class="faq-question">I've just signed up to create an account but I still have not received a verification email. I can't try and create a new account because it says that my email address is already in use. Can you please assist?</p>
                                <div class="pvm-gray">Verification emails may take a couple of minutes to come through. The verification email may appear in 'Spam' or 'Updates' depending on your email account provider and settings. If the verification email does not appear please submit a reset request through our <a href="https://previewme.co/contact-us">Contact Us</a> portal.</div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent2" class="openFilter2">
                        <h2>
                        Generic Profile and Access
                        <small class="glyphicon fa fa-angle-down pull-right" style="cursor:pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents" id="FilterContent2">
                            <div class="faq-inner-selection">
                                <p class="faq-question">I FORGOT MY USERNAME.</p>
                                <div class="pvm-gray">
                                Your username should be your email address. If that is not working, please contact us at:
                                <a href="https://previewme.co/contact-us">www.previewme.co/contact-us</a>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">HOW DO I CHANGE MY PASSWORD?</p>
                                <div class="pvm-gray">
                                Changing your password along with any other access settings relating to your profile can be done by going to your Dashboard, then selecting 'Settings' which is located on the left navigation pane. You must enter your existing password in order to change it.
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">HOW DO I CHANGE MY EMAIL ADDRESS?</p>
                                <div class="pvm-gray">
                                Changing your email address along with any other access settings relating to your profile can be done by going to your Dashboard, then selecting 'Settings' which is located on the left navigation pane.
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">HOW DO I UPDATE MY PROFILE?</p>
                                <div class="pvm-gray">
                                <p>As a candidate, once logged in select the 'Profile' icon on the top right hand side and you will be taken to your 'Profile'. Underneath your profile photo / placeholder for profile photo, select 'Edit Profile'. All updating can be done from that screen in similar fashion to how you edit your social media profile content.</p>
                                <p>As an employer, only 'Company Admins' can update and edit the company profile so first check that you are an 'Admin'. When logged in, select the 'Company Profile' icon on the top right hand side and you will be taken to your 'Profile'. Underneath your profile photo / placeholder for profile photo, select 'Edit Profile'. All updating can be done from that screen.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">WHY CREATE A PROFILE AT ALL?</p>
                                <div class="pvm-gray">
                                Your profile contains generic personal and professional information that is used to pair you with employment opportunities. A completed profile streamlines the application process for roles you apply for. Aside from that, be proud of your Profile, it is personal and private and can be drawn upon when the right opportunities come up. It also makes an employer’s job easier when it comes to understanding more about you.
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">PROFILE VISIBILITY - WHO CAN SEE MY PROFILE?</p>
                                <div class="pvm-gray">
                                <p>PreviewMe Candidate Profiles are private by design. The Candidate Profile and its attachments are accessible only on PreviewMe when you share your Profile information or Profile URL with employers when applying for a role published on PreviewMe.<br><br>
                                Employers on PreviewMe who receive Candidate Profiles may retain access to those Profiles after the role has closed by virtue of receiving it as part of a job application (just like when you send employers a paper CV they may keep it on file).</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">Can employers search the database of candidates?</p>
                                <div class="pvm-gray">
                                <p>No. PreviewMe does not allow employers to search the candidate database and view candidate profiles in the manner candidates can search for jobs.
                                If this functionality changes overtime, all users will be notified.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I'm being logged out off my account while loading a video on my profile. Any way to prevent this from happening?</p>
                                <div class="pvm-gray">
                                <p>PreviewMe will time users out after a certain period for security reasons so simply log back in if you are requested to do so. This process can repeat itself if you have an unstable internet connection so please check this if you are requested to log back in over short periods of time.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">Nothing happens when I click on 'Apply for this job' button. I'm using my work computer. Any advice?</p>
                                <div class="pvm-gray">
                                <p>Your work internet may have a firewall preventing actions/applications from proceeding on the PreviewMe platform. Try submitting your application using a personal computer/laptop/mobile device.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I've just signed up to create an account but I still have not received a verification email. I can't try and create a new account because it says that my email address is already in use. Can you please assist?</p>
                                <div class="pvm-gray">
                                <p>Verification emails may take a couple of minutes to come through. The verification email may appear in 'Spam' or 'Updates' depending on your email account provider and settings. If the verification email does not appear please submit a reset request through our 'contact us' portal.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I have reset my password but no email has come through to reset it. Where can I find the email?</p>
                                <div class="pvm-gray">
                                <p>Depending on your email settings some communications may be captured in 'Junk', 'Spam' or 'Updates' folder so check in there. If the reset password email did not send, you can contact us directly through the contact us portal: <a href="https://previewme.co/contant-us">https://previewme.co/contact-us</a> to reset your password manually.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent8" class="openFilter8">
                        <h2>
                        Video
                        <small class="glyphicon fa fa-angle-down pull-right cursor-pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents hide-faq" id="FilterContent8">
                            <div class="faq-inner-selection">
                                <p class="faq-question">Is making a video compulsory when applying for a job?</p>
                                <div class="pvm-gray">Creating a video may be compulsory for some jobs. This will depend on the requirements set by the employer. You can see which ‘Profile Requirements’ are set by the employer by opening the job advert and looking at the list of items (with a green tick) in the box on the right hand side.</div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What is a 'Profile Video' and how is it different from an application video?</p>
                                <div class="pvm-gray">
                                <p>The Profile Video is a generic video for your Candidate Profile and should not be tailored specifically to a company or a job. It should contain general information only (for example, you can use your completed Candidate Profile as a script and cover a bit about you, your work history and education). It helps you centralise all of your generic information so that it does not have to be created over and over again when applying for new jobs on PreviewMe. Please refer to our Profile Video Examples located <a href="https://previewme.co/resources/category/profile%20video%20examples">here</a>.</p>
                                <p>On the other hand, an application video is only made in response to a question asked by the employer when applying for a job. The answer should be tailored specifically to the employer's question.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">My video still says 'Currently Processing'. What should I do? How could I proceed with my application?</p>
                                <div class="pvm-gray">
                                <p>When uploading videos, they will continue to encode and save when the placeholder states 'currently processing'. You are free to move through the application process and submit your application without having to wait for this placeholder to change. </p>
                                <p>If you are unable to proceed with the application while the video is loading (this would be continuing to 'Stage 3' of an application), you can exit that process and return to your dashboard, go to "My Drafts" and then "Continue". You can then proceed with your application and the video will have encoded. Please note that your internet connection and internet speed can also impact on video loading and encoding times.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What are the supported video file formats?</p>
                                <div class="pvm-gray">
                                <p>
                                PreviewMe supports the following video file formats:<br>
                                FLV (with H.264 and AAC codecs) (.flv); MXF (.mxf); GXF (.gxf); MPEG2-PS, MPEG2-TS, 3GP (.ts, .ps, .3gp, .3gpp, .mpg); Windows Media Video (WMV)/ASF (.wmv, .asf); AVI (Uncompressed 8bit/10bit) (.avi); MP4 (.mp4, .m4a, .m4v)/ISMV (.isma, .ismv); Microsoft Digital Video Recording(DVR-MS) (.dvr-ms); Matroska/WebM (.mkv); WAVE/WAV (.wav); QuickTime (.mov)
                                </p>
                                For further information on accepted file formats please see <a href="https://docs.microsoft.com/en-us/azure/media-services/media-services-media-encoder-standard-formats">Microsoft Information HUB</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent9" class="openFilter9">
                        <h2>
                        Candidate Account and Navigation
                        <small class="glyphicon fa fa-angle-down pull-right cursor-pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents hide-faq" id="FilterContent9">
                            <div class="faq-inner-selection">
                                <p class="faq-question">I already submitted an application for a job and decided to edit my candidate profile. Will any changes I make be reflected in the application(s) I have already submitted?</p>
                                <div class="pvm-gray">
                                <p>Yes, changes/updates to your candidate profile will be reflected in the application(s) you have already submitted, but only the 'candidate profile' component.</p>
                                <p>Your Candidate Profile is updated in real time. For example, if you modify or update your Profile Video, this change will be carried over into any application(s) you have made. That same goes for text based content on your Candidate Profile.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What is a 'Profile Video' and how is it different from an application video?</p>
                                <div class="pvm-gray">
                                <p>The Profile Video is a generic video for your Candidate Profile and should not be tailored specifically to a company or a job. It should contain general information only (for example, you can use your completed Candidate Profile as a script and cover a bit about you, your work history and education). It helps you centralise all of your generic information so that it does not have to be created over and over again when applying for new jobs on PreviewMe. Please refer to our Profile Video Examples located <a href="https://previewme.co/resources/category/profile%20video%20examples">here</a>.</p>
                                <p>On the other hand, an application video is only made in response to a question asked by the employer when applying for a job. The answer should be tailored specifically to the employer's question.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I have received an email that I have moved to the next stage of the recruitment process for a job, this is reflected in my Candidate Dashboard and I don't understand what the title means. Can you help?</p>
                                <div class="pvm-gray">
                                <p>PreviewMe has 5 standard stages (Long List, Short List, Interview, Hired, and Not Successful). The employer may customise this process and add up to 5 additional stages that fit their hiring protocols. The employer can elect to rename or label each step and in some cases, the label may be less clear because it is an internal reference for their recruitment team.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I started an application for a role and went away (closed PreviewMe) and now I cannot find my application. How do I get back to my unfinished job application? </p>
                                <div class="pvm-gray">
                                <p>If you have clicked 'Apply' and commenced the application process and gone away from it, the role will be saved in 'Drafts'. This tab can be located by going to your Dashboard and selecting 'My Drafts' on the left hand navigation pane.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">How can I review the applications I have submitted?</p>
                                <div class="pvm-gray">
                                <p>You can check your application content by going to your Dashboard and selecting 'My Job Applications' from the left hand navigation pane, then 'Active Jobs'.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What does 'Long List' actually mean?</p>
                                <div class="pvm-gray">
                                <p>Long List means that having made it through the 'pre-application stage', completed your PreviewMe candidate profile to the standard required by the employer and answered the employers standard questions. The long list is where the application starts in the employers recruitment process.</p>
                                <p>The employer can customise their processing stages based on their recruiting protocols so as you move through the process your dashboard will be updated to reflect progress stages set by the employer.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I have reset my password but no email has come through to reset it. Where can I find the email?</p>
                                <div class="pvm-gray">
                                <p>Depending on your email settings some communications may be captured in 'Junk', 'Spam' or 'Updates' folder so check in there. If the reset password email did not send, you can contact us directly through the contact us portal: <a href="https://previewme.co/contant-us">https://previewme.co/contact-us</a> to reset your password manually.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent3" class="openFilter3">
                        <h2>
                        Searching and Applying for Employment Opportunities
                        <small class=" glyphicon fa fa-angle-down pull-right" style="cursor:pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents" id="FilterContent3">
                            <div class="faq-inner-selection">
                                <p class="faq-question">WHEN I ENTER A SEARCH, OTHER EMPLOYMENT OPPORTUNITIES ALSO COME UP. WHY?</p>
                                <div class="pvm-gray">
                                Those other employment opportunities come up because of the content you have published on your profile. This is our algorithm at work. If your preferences have changed then let us know by modifying your profile to reflect what you are looking for, that way we will promote the opportunities that you actually want to see.
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">THE OPPORTUNITY I AM LOOKING AT DOESN'T GIVE ME A SALARY RANGE. WHY?</p>
                                <div class="pvm-gray">
                                <p>Some employers chose not to put in a salary range. There is flexibility for them to offer a salary based on the experience of the candidates who apply for the role. If this is the case, the employer will advise what the salary is as you progress through the application stages for the role.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">HOW DO I KNOW THAT UPDATES ABOUT EMPLOYMENT OPPORTUNITIES SENT TO MY EMAIL ADDRESS ARE LEGITIMATE?</p>
                                <div class="pvm-gray">
                                <p>PreviewMe is dedicated to providing a safe environment from which you can apply for employment opportunities.</p>
                                <p>Be wary of email spoofs and phishing. Only emails that come from “previewme.co” are authentic and we would never promote roles that required the transfer of money or disclosure of bank account details. If you are concerned that an email received is a fake or a fraud, forward it on to us at <a href="https://previewme.co/contact-us">www.previewme.co/contact-us</a></p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">CAN I APPLY FOR THE SAME ROLE MORE THAT ONCE?</p>
                                <div class="pvm-gray">No. Once you’ve applied for a role you cannot apply for it again.</div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I already submitted an application for a job and decided to edit my candidate profile. Will any changes I make be reflected in the application(s) I have already submitted?</p>
                                <div class="pvm-gray">
                                <p>Yes, changes/updates to your candidate profile will be reflected in the application(s) you have already submitted, but only the 'candidate profile' component.</p>
                                <p>Your Candidate Profile is updated in real time. For example, if you modify or update your Profile Video, this change will be carried over into any application(s) you have made. That same goes for text based content on your Candidate Profile.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">Is making a video compulsory when applying for a job?</p>
                                <div class="pvm-gray">
                                <p>Creating a video may be compulsory for some jobs. This will depend on the requirements set by the employer. You can see which ‘Profile Requirements’ are set by the employer by opening the job advert and looking at the list of items (with a green tick) in the box on the right hand side.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I have received an email that I have moved to the next stage of the recruitment process for a job, this is reflected in my Candidate Dashboard and I don't understand what the title means. Can you help?</p>
                                <div class="pvm-gray">
                                <p>PreviewMe has 5 standard stages (Long List, Short List, Interview, Hired, and Not Successful). The employer may customise this process and add up to 5 additional stages that fit their hiring protocols. The employer can elect to rename or label each step and in some cases, the label may be less clear because it is an internal reference for their recruitment team.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I started an application for a role and went away (closed PreviewMe) and now I cannot find my application. How do I get back to my unfinished job application?</p>
                                <div class="pvm-gray">
                                <p>If you have clicked 'Apply' and commenced the application process and gone away from it, the role will be saved in 'Drafts'. This tab can be located by going to your Dashboard and selecting 'My Drafts' on the left hand navigation pane.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">The employer wants a cover letter - who should I address my cover letter to?</p>
                                <div class="pvm-gray">
                                <p>If you are unsure about the content of your cover letter (or any other company / job specific document) please contact the employer directly for clarification.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">I have reached the final stage of a job application and clicked submit however I get scrolled back up to the top of the page. Why?</p>
                                <div class="pvm-gray">
                                <p>If the application returns to the top of the page it means that there's information missing (that you have not completed) that is required at that stage of the application.</p>
                                <p>Please make sure that any documents you have been asked to upload are uploaded and that you have answered all multi-choice, text and video questions.</p>
                                <p>If everything is complete but the page is still not saving, refresh or reload the page. Please note that if this is required you will lose your answers so save any text you have entered into the answer fields.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">My video still says 'Currently Processing'. What should I do? How could I proceed with my application?</p>
                                <div class="pvm-gray">
                                <p>When uploading videos they will continue to encode and save when the placeholder states 'currently processing'. You are free to move through the application process and submit your application it without having to wait for this placeholder to change. </p>
                                <p>If you are unable to proceed with the application while the video is loading (this would be continuing to 'Stage 3' of an application) you can exit that process and return to your dashboard, then go to "My Drafts" then "Continue." You can then proceed with your application and the video will have encoded. Please note that your internet connection and internet speed can also impact on video loading and encoding times.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What does 'Long List' actually mean?</p>
                                <div class="pvm-gray">
                                <p>Long List means that having made it through the 'pre-application stage', completed your PreviewMe candidate profile to the standard required by the employer and answered the employers standard questions. The long list is where the application starts in the employers recruitment process.</p>
                                <p>The employer can customise their processing stages based on their recruiting protocols so as you move through the process your dashboard will be updated to reflect progress stages set by the employer.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What are the supported video file formats?</p>
                                <div class="pvm-gray">
                                <p>PreviewMe supports the following video file formats:<br>
                                FLV (with H.264 and AAC codecs) (.flv); MXF (.mxf); GXF (.gxf); MPEG2-PS, MPEG2-TS, 3GP (.ts, .ps, .3gp, .3gpp, .mpg); Windows Media Video (WMV)/ASF (.wmv, .asf); AVI (Uncompressed 8bit/10bit) (.avi); MP4 (.mp4, .m4a, .m4v)/ISMV (.isma, .ismv); Microsoft Digital Video Recording(DVR-MS) (.dvr-ms); Matroska/WebM (.mkv); WAVE/WAV (.wav); QuickTime (.mov) </p>
                                <p>For further information on accepted file formats please see <a href="https://docs.microsoft.com/en-us/azure/media-services/media-services-media-encoder-standard-formats">Microsoft Information HUB</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent4" class="openFilter4">
                        <h2>
                        Reporting Content and Behaviour
                        <small class=" glyphicon fa fa-angle-down pull-right" style="cursor:pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents" id="FilterContent4">
                            <div class="faq-inner-selection">
                                <p class="faq-question">How do I report inappropriate content or suspicious behaviour?</p>
                                <div class="pvm-gray">
                                You can report inappropriate content or suspicious behaviour by submitting a “Contact Us” message on the
                                <a href="https://previewme.co/contact-us">Contact Us</a> page and selecting “Reporting inappropriate content or suspicious behaviour”.
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What happens after I have reported inappropriate content or suspicious behaviour?</p>
                                <div class="pvm-gray">We will review inappropriate content or suspicious behaviour that is reported and take action if appropriate.</div>
                                <p class="pvm-gray">If the reported inappropriate content or suspicious behaviour is removed / addressed, you will be sent an email. If it is not removed or addressed, you will not be notified.</p>
                                </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What happens if the inappropriate content or suspicious behaviour relates to my Intellectual Property?</p>
                                <div class="pvm-gray">
                                <p>If you are the copyright / intellectual property right holder, then identify yourself as the intellectual property holder when making the complaint and provide your contact details. You will then be contacted directly by a PreviewMe representative.</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What are ‘harmful communications’?</p>
                                <div class="pvm-gray">
                                <p>Harmful communications are governed by the New Zealand Harmful Digital Communications Act (“HDCA”).</p>
                                <p>The HDCA sets out to deter, prevent and mitigate harm caused to individuals by harmful digital communications.</p>
                                <p>The HDCA is made up of a&nbsp;<a href="http://legislation.govt.nz/act/public/2015/0063/latest/DLM5711838.html">list of communication principles</a>, all of which apply to digital communications (which means any form of electronic communication).</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What are the communication principles?</p>
                                <div class="pvm-gray">
                                <p>The communication principles are set out in the New Zealand Harmful Communications Act and can be under our ‘<a href="https://previewme.co/terms-and-conditions">Terms and Conditions</a>’ or by clicking the link below.</p>
                                <p>
                                <a href="http://legislation.govt.nz/act/public/2015/0063/latest/DLM5711810.html"> HDCA Communication Principles</a>
                                </p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What can I do if I’ve received a harmful communication?</p>
                                <div class="pvm-gray">
                                <p>If you’re subject to a harmful communication from another member on PreviewMe (e.g., this could be through the feedback you’ve received, a message thread or content published in a Role) you can report this by clicking the ‘Report harmful communications’ button below.</p>
                                <p>Once we’ve received a complaint we will assess whether to remove the content based on our&nbsp;<a href="https://previewme.co/terms-and-conditions">terms and conditions</a>, or, if it’s not clear that it’s in breach of our terms, we may get in touch with the person who posted the communication to see whether they stand behind it (known as the ‘safe harbour’ process under the HDCA).</p>
                                </div>
                            </div>
                            <div class="faq-inner-selection">
                                <p class="faq-question">What is the ‘safe harbour’ process?</p>
                                <div class="pvm-gray">
                                <p>The safe harbour process means that we will notify the author of the content complained about within 48-hours – scrubbing any personal information if requested. If we cannot notify the author within the initial 48-hour period, we will remove the content from the site.</p>
                                <p>Once notified, the author of the content must make a decision within the next 48-hours to stand by the content and dispute the complaint, or request for the content to be removed entirely. If the author doesn’t contact us after notification, we’ll remove the content from the site.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq_selection">
                        <a href="/faq#" style="font-weight:bold;color:#00afed" data-target="FilterContent5" class="openFilter5">
                        <h2>
                        Employer Navigation
                        <small class=" glyphicon fa fa-angle-down pull-right" style="cursor:pointer"></small>
                        </h2>
                        </a>
                        <div class="faq-contents" id="FilterContent5" style="display:none">
                            <div class="faq-inner-selection">
                            <p class="faq-question">I am trying to edit / change my employer profile, teams or account settings but cannot. Why?</p>
                            <div class="pvm-gray">
                            <p>Only a ‘Company Admin’ has permission to make changes / edit:</p>
                            <div>
                            <ol>
                            <li>The Employer Profile;</li>
                            <li>Employer Account Settings; and /or</li>
                            <li>Teams.</li>
                            </ol>
                            </div>
                            </div>
                            <p class="faq-question">How do I know whether I am a Company Admin or not?</p>
                            <div class="pvm-gray">
                            <p>You will be identified as either a Company Admin or a Company Team Member.</p>
                            <p>You can find out what classification you are by opening your employer dashboard page, on the left-hand side of the page beneath your circular profile photo your classification will be stated as either:</p>
                            <p>Company Admin’ <br>Or<br>‘Team Member’</p>
                            </div>
                            <p class="faq-question">How do I change from a ‘Team Member’ to a ‘Company Admin’?</p>
                            <div class="pvm-gray">
                            <p>You must contact the Company Admin for your company and request to be changed. The Company admin will then upgrade your account to Company Admin from the settings tab within their account.</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div id="faq_selection_last">
                        <p>
                        CAN'T FIND THE QUESTION YOU'RE LOOKING FOR? PLEASE CONTACT US
                        <a href="https://previewme.co/contact-us">HERE.</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    

@stop

@section('scripts')
@stop
