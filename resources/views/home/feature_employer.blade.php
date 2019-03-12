@extends('layouts.home')

@section('styles')
@stop

@section('content')

<div class="container-fluid" role="main">
<div class="row">
<div>
<div class="container-fluid ng-scope" ng-controller="FeaturesBenefitController">

<div class="row" id="FeaturedBenefitBanner">
<div class="tab-content">

<div role="tabpanel" class=" fade in  tab-pane active tabs tabbedbanner" id="featuredBanner1">
<div class="col-md-12">
<div class="text-center">
<h3>Features for Employers</h3>
<div class="bannertext">
We take the costs and time out of the recruitment process. Promote your brand and employment opportunities to find the perfect match for your company. The cost of hiring the wrong employee can be financially draining and detrimental to the morale of the business, so let’s get it right first time.
</div>
</div>
</div>
</div>

<div role="tabpanel" class=" fade in  tab-pane tabs tabbedbanner" id="featuredBanner2">
<div class="col-md-12">
<div class="text-center">
<h3>Features for Candidates</h3>
<div class="bannertext">
Our algorithms will only match you with the job opportunities you want and the advanced analytics will keep you up to date with your progress. What’s more, you will receive feedback on your all your applications. Never be left in the dark again!
</div>
</div>
</div>
</div>

</div>
</div>


<div class="row" id="TabberNavs">
<ul class="nav nav-tabs" role="tablist">
<li role="tab" class="">
    <a href="/features/employers#employers" data-target="#featuredBanner1, #employers" role="tab" data-toggle="tab" class="tabnav1" aria-expanded="false">Features for Employers</a>
</li>

<li role="tab" class="active">
    <a href="/features/employers#candidates" data-target="#featuredBanner2, #candidates" role="tab" data-toggle="tab" class="tabnav2" aria-expanded="true">Features for Candidates</a>
</li>
</ul>
</div>


<div class="row tab-content">
<div role="tabpanel" class="fade  tab-pane tabs contentfeatures" id="employers">
<div class="col-md-12">
<div class="row FeatureContentNavSlider " id="EmployerNavScroller">
<div class="col-md-12">
<div id="carousel1" class="carouselthis slide" data-ride="carousel">
<div class="row">
<div class="container">
<div class="carousel-inner" role="listbox">
<div class="item ng-scope active">
<div class="row">
<ul>
<li class="ng-scope">
<a href="/features/employers#scroll1" class="slideme ng-binding">Pre-Application Assessment</a>
</li>
<li class="ng-scope">
<a href="/features/employers#scroll2" class="slideme ng-binding">Video</a>
</li>
<li class="ng-scope active col-md-offset-1">
<a href="/features/employers#scroll3" class="slideme ng-binding">Profile</a>
</li>
<li class="ng-scope">
<a href="/features/employers#scroll4" class="slideme ng-binding">TMS</a>
</li>
<li class="ng-scope">
<a href="/features/employers#scroll5" class="slideme ng-binding">Dashboards</a>
</li>
<li class="ng-scope">
<a href="/features/employers#scroll6" class="slideme ng-binding">Messaging</a>
</li>
<li class="ng-scope">
<a href="/features/employers#scroll7" class="slideme ng-binding">Social Media Sharing</a>
</li>
</ul>
</div>
</div>
<div class="item ng-scope">
<div class="row">
<ul>
<li class="ng-scope">
<a href="/features/employers#scroll8" class="slideme ng-binding">Data insights</a>
</li>
<li class="ng-scope">
<a href="/features/employers#scroll9" class="slideme ng-binding">Teams</a>
</li>
<li class="ng-scope active col-md-offset-1">
<a href="/features/employers#scroll10" class="slideme ng-binding">Pricing</a>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
<a class="left carousel-control" data-target="#carousel1">
<i class="fa fa-angle-left"></i>
<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" data-target="#carousel1">
<i class="fa fa-angle-right"></i>
<span class="sr-only">Next</span>
</a>
</div>


</div>
</div>
<div id="CandidateFeaturesContent" class="MainContentFeatureContainer">
<div class="row">
<div class="container">
<div class="row" id="scroll1">
<div class="col-md-6"><img src="images/features/features-emp-1@2x.png" width="470" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Pre-Application Assessment</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Do it your way</div>
<div class="sectionContent">
<ul>
<li>You choose how you recruit. You set the questions, you set the requirements. We save you the time.</li>
<li>Convert your minimum requirements into pre-application questions so you only attract and process candidates with the right skills.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll2">
<div class="col-md-6 pull-md-right"><img src="images/features/features-emp-2@2x.png" width="323" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Video</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Find your fit with video </div>
<div class="sectionContent">
<ul>
<li>Ask video questions to get a better understanding of the candidate’s skills, capabilities and cultural fit.</li>
<li>Assess more people in less time.</li>
<li>Promote your company and culture through video embedded into personalised company profiles.</li>
<li>Give candidates a better insight into your company, culture and employment opportunities by advertising roles as a video.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll3">
<div class="col-md-6"><img src="images/features/features-emp-3.png" width="323" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Profile</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Show off your brand</div>
<div class="sectionContent">
<ul>
<li>Promote your company, brand and employment opportunities using a combination of video and text.</li>
<li>Enjoy a customisable hub with all the employer information and opportunities in one place.</li>
<li>Employer profiles are an extension of your online presence and double as your company careers page.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll4">
<div class="col-md-6 pull-md-right"><img src="images/features/features-emp-4.png" width="323" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">TMS (Talent Management System)</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Track and manage with ease</div>
<div class="sectionContent">
<ul>
<li>Track, categorise and manage all applicants with the drag and drop system. It’s where simplicity meets sophistication.</li>
<li>Build and manage the application assessment process to suit you.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll5">
<div class="col-md-6"><img src="images/features/features-emp-3a.png" width="323" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Dashboards</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Know where you stand</div>
<div class="sectionContent">
<ul>
<li>The live dashboard feature allows you to have complete transparency over the response to your listings, performance and insights to your business and industry.</li>
<li>Real time adjusting and easy to use.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll6">
<div class="col-md-6 pull-md-right"><img src="images/features/features-emp-6.png" width="323" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Messaging</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Let’s talk</div>
<div class="sectionContent">
<ul>
<li>Interact with colleagues and candidates with message threads.</li>
<li>Connect directly with interested candidates.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll7">
<div class="col-md-6"><img src="images/features/features-emp-8@2x.png" width="165" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Social Media Sharing</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Get social</div>
<div class="sectionContent">
<ul>
<li>Harness the power of social media and promote your employment opportunities across social media platforms.</li>
<li>Expand your reach and stay efficient.</li>
<li>One-click publishing direct to social media platforms to save you time and promote your brand.</li>
</ul>
</div>
</div>
</div>
</div>
 </div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll8">
<div class="col-md-6 pull-md-right"><img src="images/features/features-emp-9@2x.png" width="323" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Data insights</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Reports and analytics just got fun!</div>
<div class="sectionContent">
<ul>
<li>Use data driven insights to make more informed decisions.</li>
<li>Big data analytics without the complexity or expense.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll9">
<div class="col-md-6"><img src="images/features/features-emp-10@2x.png" width="323" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Teams</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Teamwork</div>
<div class="sectionContent">
<ul>
<li>Work with your internal team to never miss great talent. </li>
<li>Build your team or lots of teams to share, review and record points of view.</li>
<li>Assign tasks and share the recruitment load to make the process more efficient and transparent.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="scroll10">
<div class="col-md-6 pull-md-right"><img src="images/features/candidate_feature8.png" width="170" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Pricing</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">No Hidden costs</div>
<div class="sectionContent">
In fact, there is no cost at all
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div role="tabpanel" class="tab-pane tabs contentfeatures active in" id="candidates">
<div class="col-md-12">
<div class="row FeatureContentNavSlider" id="candidateNavScroller">
<div class="col-md-12">
<div>
<ul class="carouselthis">
    <!-- ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="#c_scroll1" class="slideme ng-binding">Video</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="/features/candidates#c_scroll2" class="slideme ng-binding">Dashboard</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="/features/candidates#c_scroll3" class="slideme ng-binding">Analytics</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="/features/candidates#c_scroll4" class="slideme ng-binding">Job Pairing</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="/features/employers#c_scroll5" class="slideme ng-binding">Messaging and notifications</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="/features/employers#c_scroll6" class="slideme ng-binding">Privacy</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
    <li class="ng-scope">
        <a href="/features/employers#c_scroll7" class="slideme ng-binding">Pricing</a>
    </li><!-- end ngRepeat: (key, val) in CandidateNav -->
</ul>
</div>
</div>
</div>
<div id="CandidateFeaturesContent" class="MainContentFeatureContainer" style="padding-top: 0px;">
<div class="row">
<div class="container">
<div class="row" id="c_scroll1">
<div class="col-md-6"><img src="images/features/candidate_feature1@2x.png" width="323" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Video</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Annnnd action!</div>
<div class="sectionContent">
<ul>
<li>A CV does not have a personality. You do. Our video feature allows you to showcase your personality, skills and experience.</li>
<li>Our profile feature allows you to apply for many jobs without having to tailor your CV every time.</li>
<li>Quick and easy to create from any device and across any platform.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="c_scroll2">
<div class="col-md-6 pull-md-right"><img src="images/features/candidate_feature2@2x.png" width="323" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Dashboard</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Manage all your applications from one easy location</div>
<div class="sectionContent">
<ul>
<li>Easy to use and mobile responsive.</li>
<li>Real time adjusting.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="c_scroll3">
<div class="col-md-6"><img src="images/features/features-emp-9@2x.png" width="323" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Analytics</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">How did you do?</div>
<div class="sectionContent">
<ul>
<li>Stop being left in the dark with our feedback and progress features.</li>
<li>Insights into active job application progress.</li>
<li>Feedback on past job applications.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="c_scroll4">
<div class="col-md-6 pull-md-right"><img src="images/features/candidate_feature4.png" width="212" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Job Pairing</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Algorithms that make sense</div>
<div class="sectionContent">
<ul>
<li>We can match you with employers and employment opportunities as they are published.</li>
<li>We only match you with the job opportunities you want.</li>
<li>Real-time notification of new opportunities.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="c_scroll5">
<div class="col-md-6"><img src="images/features/features-emp-6.png" width="364" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Messaging and Notifications</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Join the community</div>
<div class="sectionContent">
<ul>
<li>Communication is the key to success. Talk with employers and receive notifications of new opportunities. </li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="c_scroll6">
<div class="col-md-6 pull-md-right"><img src="images/features/candidate_feature7@2x.png" width="170" class="img-responsive"></div>
<div class="col-md-6 pull-md-left">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Privacy</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">We respect your privacy</div>
<div class="sectionContent">
<ul>
<li>Take control of your content and share your profile only with companies for employment opportunities you want.</li>
<li>Anonymously browse employer profiles and join their communities to stay in the loop.</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="container">
<div class="row" id="c_scroll7">
<div class="col-md-6"><img src="images/features/candidate_feature8.png" width="203" class="img-responsive"></div>
<div class="col-md-6">
<div class="featurecontentCont">
<div class="subtitle text-xs-center text-sm-center text-md-left">Pricing</div>
<div class="sectiontTitle text-xs-center text-sm-center text-md-left">Free and easy</div>
<div class="sectionContent">
<ul>
<li>We are making job hunting fun and effective.</li>
<li>Our features have been carefully designed to be easy to use with effective outcomes.</li>
<li>Our service is completely free. We just care about finding you a great job.</li>
</ul>
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
<a href="/features/employers#" class="glyphicon glyphicon-circle-arrow-up backtoTop" style="display: none;"><br><span>Back to top</span> </a>
</div>
</div>
</div>
</div>

@stop

@section('scripts')
@stop