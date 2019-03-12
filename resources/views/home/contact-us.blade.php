@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div id="contact-us-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Contact Us</h1>
                <h3>Something on your mind?<br>
                Tell us by filling in the fields below.</h3>
            </div>
        </div>
        <div class="row">
            <div id="contact-us-content-color-back" ng-controller="ContactUsController" class="ng-scope">
                <div class="contact-us-form-container">
                    <form id="contactUsForm" class="ng-pristine ng-valid ng-submitted" onsubmit="alert('send email...')">
                        <input type="text" placeholder="FIRST NAME*" name="firstName" required="">
                        <input type="text" placeholder="LAST NAME*" name="lastName" required="">
                        <input type="text" placeholder="BUSINESS NAME" name="businessName">
                        <input type="email" placeholder="EMAIL ADDRESS*" name="emailAddress" required="">
                        <select name="subject">
                            <option value="">Select subject</option>
                            <option value="Employer: Candidate processing facility">Employer: Candidate processing facility</option>
                            <option value="Employer: Teams and Messaging">Employer: Teams and Messaging</option>
                            <option value="Employer: Profile / Careers Page">Employer: Profile / Careers Page</option>
                            <option value="Employer: Building a role">Employer: Building a role</option>
                            <option value="Employer: Navigation">Employer: Navigation</option>
                            <option value="Employer: Analytics">Employer: Analytics</option>
                            <option value="Candidate: Applying for a role">Candidate: Applying for a role</option>
                            <option value="Candidate: Profile page">Candidate: Profile page</option>
                            <option value="Candidate: Analytics">Candidate: Analytics</option>
                            <option value="Video">Video</option>
                            <option value="Settings">Settings</option>
                            <option value="Privacy">Privacy</option>
                            <option value="Reporting inappropriate content or suspicious behaviour">Reporting inappropriate content or suspicious behaviour</option>
                        </select>
                        <textarea placeholder="YOUR MESSAGE*" name="message" rows="7" required=""></textarea>
                        <input type="submit" style="line-height:2" value="SEND" name="send" class="btn pvm-blue-background pvm-white no-curved-border">
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 contactus_selection_lastend">
                REPORT HARMFUL COMMUNICATIONS <a href="/harmful-communications">HERE.</a>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
@stop
