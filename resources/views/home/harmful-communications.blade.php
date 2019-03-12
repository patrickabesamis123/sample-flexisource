@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div id="static-harmful-content">
    <div class="container-fluid" role="main">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 text-center padb-30">
                <h1>Harmful Digital<br>
                Communication Complaint</h1>
                <p>You must enter your personal details for the complaint to be valid.<br>
                With your consent, we can send your contact information to the author of the content. This may help you resolve your complaint directly with the author. You do not need to consent to releasing your contact information.<br>
                Your complaint may be sent to the author of the content.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 padb-100">
                <div ng-controller="ContactUsController" class="ng-scope">
                    <div class="form-container">
                        <form id="harmfulForm" class="ng-pristine ng-valid" onsubmit="alert('send email...')">
                            <input type="text" placeholder="First name" name="firstName" required="">
                            <input type="text" placeholder="Last name" name="lastName" required="">
                            <input type="text" placeholder="Phone number" name="phoneNumber" required="">
                            <input type="email" placeholder="Email address" name="emailAddress" required="">
                            <textarea placeholder="Address" name="address" rows="3"></textarea>
                            <div>
                                <input type="checkbox" name="userConsent" class="pull-left">
                                <span class="checkbox_consent"> I consent that my contact information may be released to the author of the content.</span>
                            </div>
                            <br>
                            <div>
                                <label for="slCommunicationType" class="pull-left">Communication Type</label>
                                <select id="slCommunicationType" name="communicationType">
                                <option value="Listing Content">Listing Content</option>
                                <option value="Message Board">Message Board</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Q+A">Q &amp; A</option>
                                <option value="Classified Message">Classified Message</option>
                                <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="pull-left" for="txtContentLink">Link to Abusive Content</label>
                                <div class="clearfix"></div>
                                <p class="text-left">
                                <small class="pvm-gray">
                                Please copy and paste a link to the abusive content.
                                </small>
                                </p>
                                <input class="text" id="txtContentLink" type="text" name="linkToAbusiveContent">
                            </div>
                            <div>
                                <label class="pull-left" for="taBreachDetails">Breach Details</label>
                                <div class="clearfix"></div>
                                <p class="text-left"><small class="pvm-gray">Please explain how this content is unlawful or breaches communication principles and has caused harm.</small></p>
                                <textarea id="taBreachDetails" name="breachDetails" class="text textarea" required=""></textarea>
                            </div>
                            <input type="submit" style="line-height:2" value="SEND" name="send" class="btn pvm-blue-background pvm-white no-curved-border">
                        </form>
                    </div>
                </div>
            </div>    
        </div><!-- eof row -->
    </div>
</div>    

@stop

@section('scripts')
@stop
