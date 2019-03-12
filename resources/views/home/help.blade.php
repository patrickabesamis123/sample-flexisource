@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>

<!-- Help -->
<div id="static-faq-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 static-top-content text-center">
				<h1>Help</h1>
			</div>
		</div>
		<div class="row">
            <div class="col-12 static-bottom-content">
                <div class="faq-containter">
					<br><br><br>
					<div class="faq_selection faq_subheader">WHAT IS YOUR QUESTION ABOUT?</div>
                    <div class="faq_selection">
                    <h2><a href="/help" style="font-weight:bold;color:#00afed" data-target="FilterContent1" class="openFilter1">Reporting inappropriate content or suspicious behaviour <small  class="glyphicon fa fa-angle-down pull-right cursor-pointer"></small></a></h2>
                    <div class="faq-contents" id="FilterContent1">
                    <div class="faq-inner-selection pvm-gray">
                    <p>You can report inappropriate content or suspicious behaviour that you consider are in breach of our <a href="/terms-and-conditions">terms and conditions</a> by submitting a message selecting “Reporting inappropriate content or suspicious behaviour” from the "<a href="/contact-us">Contact Us</a>" page</p>
                    <p>We will review all inappropriate content or suspicious behaviour that is reported and take action if appropriate.</p>
                    <p>If the reported inappropriate content or suspicious behaviour is removed, you will be sent an email. If the inappropriate content or suspicious behaviour is not removed, you will not be notified.</p>
                    <p>If you are the copyright / intellectual property right holder, then identify yourself as the holder when making the complaint and provide your contact details. You will then be contacted directly by a PreviewMe representative.</p>
                    </div>
                    </div>
                    </div>
                    <div class="faq_selection">
                    <h2><a href="/help" style="font-weight:bold;color:#00afed" data-target="FilterContent2" class="openFilter2">Harmful Communications <small class="glyphicon fa fa-angle-down pull-right" style="cursor:pointer"></small></a></h2>
                    <div class="faq-contents" id="FilterContent2">
                    <div class="faq-inner-selection pvm-gray">
                    <p>The Harmful Digital Communications Act (“HDCA”) sets out to deter, prevent and mitigate harm caused to individuals by harmful digital communications.</p>
                    <p>The HDCA is made up of a list of communication principles, all of which apply to digital communications (which means any form of electronic communication). All PreviewMe members are expected to abide by these principles.</p>
                    <p>While it's the right thing to do, it's now outlined in law that members must respect others and conduct themselves honestly and in good faith at all times. If a member breaches these principles or their content is deemed harmful and/or offensive, PreviewMe may take action by removing specific content.</p>
                    </div>
                    <div class="faq-inner-selection">
                        <p style="margin-bottom:7px;">What can I do if I've received a harmful communication? </p>
                        <p class="pvm-gray">
                            If you're subject to a harmful communication from another member on PreviewMe (e.g., this could be through the feedback you’ve received, a message thread or content published in a Role) you can report this by clicking the 'Report harmful communications’ button below. 
                        </p>
                        <p class="pvm-gray">
                            Once we've received a complaint we will assess whether to remove the content based on our own <a href="/terms-and-conditions">terms and conditions,</a> or, if it's not clear that it's in breach of our terms, we may get in touch with the person who posted the communication to see whether they stand behind it (known as the 'safe harbour' process under the HDCA). 
                        </p>
                    </div>
                    <div class="faq-inner-selection">
                        <p style="margin-bottom:7px;">What is the 'safe harbour' process?</p>
                        <div class="pvm-gray">
                            The safe harbour process means that we will notify the author of the content complained about within 48-hours – scrubbing any personal information if requested. If we cannot notify the author within the initial 48-hour period, we will remove the content from the site. Once notified, the author of the content must make a decision within the next 48-hours to stand by the content and dispute the complaint, or request for the content to be removed entirely. If the author doesn't contact us after notification, we'll remove the content from the site.
                        </div>
                    </div>
                    </div>
                    </div>
                    <div id="faq_selection_last">
                    <p>REPORT HARMFUL COMMUNICATIONS <a href="/harmful-communications">HERE.</a></p>
                    </div>

				</div>
			</div>
		</div><!-- eof row -->
	</div>
</div>
@stop