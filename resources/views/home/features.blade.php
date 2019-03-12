@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div class="container-fluid" role="main">
    <div class="row" id="FeaturesLanding">
        <div class="col-md-6 text-center">
            <div id="CandidateColFeature">
                <div class="featuresLandingLinks">
                <h3>For Candidates</h3>
                <a href="/features/candidates" class="learnmore btn btn-pvm btn-large btn-primary">Learn more</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <div id="EmployerColFeature">
                <div class="featuresLandingLinks">
                <h3>For Employers</h3>
                <a href="/features/employers" class="learnmore btn btn-pvm btn-large btn-tertiary">Learn more</a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
@stop