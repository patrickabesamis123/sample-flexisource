@extends('layouts.home')

@section('content')

<?php 
$baseUrl = "http://previewme.co/";
?>
<div class="container-fluid">
   <div class="row">      
        <div class="col-md-12" id="RegisterConfirm" style="background-image: url('/images/confirmBG.jpg');">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="content-container col-md-12">
                        <h1 class="Title">Confirm Email</h1>
                        <p class="subTitle">An Email has been sent to your email address,<br>
                        please follow the link to confirm your registration.</p>
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