@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/icomoon.css" />
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')

<div class="container-fluid" role="main" ng-controller="BlogPostDetailsController" ng-init="getDetails()">
    <div class="row">
        <div class="container content_container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <br><a href="/resources" class="small grey" style="font-weight: 300;">« Back to All Resources</a>
                        </div>
                    </div>
                    <h1 ng-bind="posts.Title"></h1>
                    <div class="blog_details">
                        <div class="row">
                            <div class="col-sm-8">
                                <a ng-repeat="category in posts.blog.categories" href="/resources/@{{category.category.Slug}}"
                                    ng-bind="category.category.Name"></a><span>|</span>
                                <span ng-bind="posts.blog.Author"></span> <span>|</span>
                                <span ng-bind="post_created | date: 'd MMMM yyyy'"></span>
                            </div>
                            <div class="col-sm-4 text-right text-xs-left ng-scope">
                                <a href="/resource/@{{posts.URLSegment}}" socialshare=""
                                    socialshare-provider="facebook" socialshare-text="@{{posts.Title}}"
                                    socialshare-url="https://previewme.co/resource/@{{posts.URLSegment}}"
                                    class="fa fa-facebook shareicon">
                                </a>
                                <a href="/resource/@{{posts.URLSegment}}" socialshare=""
                                    socialshare-provider="linkedin" socialshare-text="@{{posts.Title}}"
                                    socialshare-url="https://previewme.co/resource/@{{posts.URLSegment}}"
                                    class="fa fa-linkedin shareicon">
                                </a>
                                <a href="/resource/@{{posts.URLSegment}}" socialshare=""
                                    socialshare-provider="twitter" socialshare-text="@{{posts.Title}}"
                                    socialshare-url="https://previewme.co/resource/@{{posts.URLSegment}}"
                                    class="fa fa-twitter shareicon">
                                </a>
                                <a href="/resource/@{{posts.URLSegment}}" socialshare=""
                                    socialshare-provider="google" socialshare-text="@{{posts.Title}}"
                                    socialshare-url="https://previewme.co/resource/@{{posts.URLSegment}}"
                                    class="icomoon icon-google-plus shareicon">
                                </a>
                            </div>
                        </div>
                        <hr class="blogdivider">
                    </div>
                    <div class="ContentMain" style="margin-bottom: 55px">
                        <div class="row ">
                            <div class="col-md-12 ">
                                <img src="@{{posts.blog.file.Filename}}" alt="" class="img-responsive">
                                <br>
                            </div>
                        </div>
                        <div ng-bind-html="posts.Content"></div>
                        <p dir="ltr"><span>&nbsp;</span></p>
                    </div>
                </div><!-- eof col-md-9 -->
                <div class="col-md-3 padb-30">
                    <div class="widget">
                        <h3>What to read next</h3>
                        <hr>
                        <ul>
                            <li ng-repeat="widget in posts.widget" ng-cloak>
                                <a href="/resource/@{{widget.URLSegment}}" class="categoryLink">
                                    <img ng-src="@{{widget.blog.file.Filename || 'assets/Uploads/shutterstock-267635884.jpg'}}" class="img-responsive">
                                </a>
                                <h3><a href="/resource/@{{widget.URLSegment}}" class="categoryLink" ng-bind="widget.Title"></a></h3>
                                <div class="postDetails">
                                    <a href="resources/category/employee advice"> Employee Advice </a>
                                    <span>|</span>
                                    <span ng-bind="widget.blog.Author"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><!-- eof col-md-3 -->
            </div><!-- eof row -->
        </div>
    </div><!-- eof row -->
</div>

@stop
@section('scripts')
<script type="text/javascript" src="js/minified/public/blog-post-details.min.js"></script>
@stop
