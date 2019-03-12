@extends('layouts.home')

@section('styles')
<link rel="stylesheet" href="css/icomoon.css" />
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@stop

@section('content')
<div class="container-fluid" role="main">
    <div class="row">
        <div class="col-md-12 content-hub-top">
          Search Resources
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 content-hub-search">
            <!-- subnavigation menu -->
            <ul class="nav navbar-nav content-header-links col-md-10">
              <li><a href="/resources" data-ajax="false" class="ui-link @if (Request::segment(2) == '') current pvm-blue @endif">All Topics</a></li>
              <li><a href="/resources/employee advice" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'employee advice') current pvm-blue @endif">Employee Advice</a></li>
              <li><a href="/resources/employer advice" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'employer advice') current pvm-blue @endif">Employer Advice</a></li>
              <li><a href="/resources/video" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'video') current pvm-blue @endif">Video</a></li>
              <li><a href="/resources/news" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'news') current pvm-blue @endif">News</a></li>
              <li><a href="/resources/human resources" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'human resources') current pvm-blue @endif">Human Resources</a></li>
              <li><a href="/resources/video interview tips" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'video interview tips') current pvm-blue @endif">Video Interview Tips</a></li>
              <li><a href="/resources/profile video examples" data-ajax="false" class="ui-link link @if (Request::segment(2) == 'profile video examples') current pvm-blue @endif">Example Profile Videos</a></li>
            </ul>
            <!-- eof subnavigation menu -->
            <!-- search area -->
            <ul class="nav navbar-nav navbar-right col-md-2 searchPost" style="margin-top:8px">
              <li>
                <div class="">
                  <form id="SearchForm_SearchForm" method="get" enctype="application/x-www-form-urlencoded" class="ng-pristine ng-valid" onsubmit="alert('Search contents...')">
                    <p id="SearchForm_SearchForm_error" class="message " style="display: none"></p>
                    <fieldset>
                      <div id="SearchForm_SearchForm_Search_Holder" class="field text nolabel">
                        <div class="middleColumn">
                          <input type="text" name="Search" class="text nolabel" id="SearchForm_SearchForm_Search" placeholder="Search our Content hub" style="border-radius:0;border:0">
                        </div>
                      </div>
                      <button type="submit" name="action_results" value="Go" class="btn btn-default" id="SearchForm_SearchForm_action_results" style="border-radius:0;border:0">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </fieldset>
                  </form>
                </div>
              </li>
            </ul>
            <!-- eof search area -->
        </div>
        <div class="container-fluid" id="content-hub-content" ng-controller="BlogPostController" ng-init="getPosts()"
            ng-show="show">
            <span ng-bind="show" style="color:#CCCCCC"></span>
            <div class="row ng-scope" id="blog_post">
                <ul id="PostList" style="list-style:none">
                    <li ng-repeat="post in posts" ng-cloak>
                        <div class=" article-list-holder">
                            <div class="container-fluid article-list">
                                <div class="row">
                                    <a href="/resource/@{{post.detail.URLSegment}}" style="border: 0"> <img ng-src="@{{post.file.Filename || 'assets/Uploads/shutterstock-267635884.jpg'}}"
                                            class="img-responsive"></a>
                                </div>
                                <div class="categories">
                                    <div ng-repeat="category in post.categories">
                                        <a href="resources/@{{category.category.Slug}}" class="categoryLink" ng-bind="category.category.Name"></a>
                                    </div>
                                </div>
                                <h2><a href="/resource/@{{post.detail.URLSegment}}" ng-bind="post.detail.Title"></a></h2>
                                <div class="row">
                                    <div class="col-sm-6"><span class="author" ng-bind="post.Author"></span></div>
                                    <div class="col-sm-6 text-right text-xs-left">
                                        <a href="/resource" socialshare="" socialshare-provider="facebook"
                                            socialshare-text="@{{post.detail.Title}}"
                                            socialshare-url="https://previewme.co/resource/@{{post.detail.URLSegment}}" class="fa fa-facebook shareicon">
                                        </a>
                                        <a href="/resource" socialshare="" socialshare-provider="linkedin"
                                            socialshare-text="@{{post.detail.Title}}@ PreviewMe Resources"
                                            socialshare-url="https://previewme.co/resource/@{{post.detail.URLSegment}}" class="fa fa-linkedin shareicon">
                                        </a>
                                        <a href="/resource" socialshare="" socialshare-provider="twitter"
                                            socialshare-text="@{{post.detail.Title}}@ PreviewMe Resources"
                                            socialshare-url="https://previewme.co/resource/@{{post.detail.URLSegment}}" class="fa fa-twitter shareicon">
                                        </a>
                                        <a href="/resource" socialshare="" socialshare-provider="google"
                                            socialshare-text="@{{post.detail.Title}}@ PreviewMe Resources"
                                            socialshare-url="https://previewme.co/resource/@{{post.detail.URLSegment}}" class="icomoon icon-google-plus shareicon">
                                        </a>
                                    </div>
                                </div>
                                <hr class="blogdivider">
                                <div class="teaser" ng-bind-html="post.Teaser">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="pagination_div text-center">
                <posts-pagination></posts-pagination>
            </div>
        </div>
    </div><!-- eof row -->
</div>

@stop

@section('scripts')
<script type="text/javascript" src="js/minified/public/blog-post.min.js"></script>
@stop
