(function () {

    'use strict';
    var app = angular.module('app');

    app.controller('BlogPostController', ['$scope', '$window', '$http', '$cookies',
        ($scope, $window, $http, $cookies) => {

            $scope.posts = [];
            $scope.totalPages = 0;
            $scope.currentPage = 1;
            $scope.range = [];
            $scope.show = false;

            $scope.getPosts = (pageNumber) => {

                if (pageNumber === undefined) {
                    pageNumber = '1';
                }

                var resource_uri = window.location.pathname.split('/').filter(el => {
                    return !!el;
                }).pop();

                resource_uri = decodeURIComponent(resource_uri);
                if (resource_uri === 'resources') {
                    $http.get(window.location.origin + '/api/blog-posts?page=' + pageNumber + '&uri=' + resource_uri)
                        .then(response => {
                            if (response.status === 200) {
                                $scope.posts = response.data.data;
                                $scope.totalPages = response.data.last_page;
                                $scope.currentPage = response.data.current_page;

                                // Pagination Range
                                var pages = [];
                                for (var i = 1; i <= response.data.last_page; i++) {
                                    pages.push(i);
                                }
                                $scope.range = pages;
                                $scope.show = true;
                            }
                        });
                    return false;
                }

                $http.get(window.location.origin + '/api/blog-posts?page=' + pageNumber + '&uri=' + resource_uri)
                    .then(response => {
                        if (response.status === 200) {

                            let blogPostData = [];
                            let raw_data = response.data.data;

                            raw_data.forEach(blog => {
                                blogPostData.push({
                                    ID: blog.blogs[0].ID,
                                    Featured: blog.blogs[0].Featured,
                                    Teaser: blog.blogs[0].Teaser,
                                    PostDate: blog.blogs[0].PostDate,
                                    Author: blog.blogs[0].Author,
                                    FeaturedImageID: blog.blogs[0].FeaturedImageID,
                                    file: {
                                        ID: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.ID : null,
                                        ClassName: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.ClassName : null,
                                        LastEdited: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.LastEdited : null,
                                        Created: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.Created : null,
                                        Name: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.Name : null,
                                        Title: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.Title : null,
                                        Filename: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.Filename : null,
                                        Content: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.Content : null,
                                        ShowInSearch: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.ShowInSearch : null,
                                        ParentID: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.ParentID : null,
                                        OwnerID: (blog.blogs[0].hasOwnProperty('file')) ? blog.blogs[0].file.OwnerID : null
                                    },
                                    detail: {
                                        ID: blog.blogs[0].detail.ID,
                                        ClassName: blog.blogs[0].detail.ClassName,
                                        LastEdited: blog.blogs[0].detail.LastEdited,
                                        Created: blog.blogs[0].detail.Created,
                                        URLSegment: blog.blogs[0].detail.URLSegment,
                                        Title: blog.blogs[0].detail.Title,
                                        MenuTitle: blog.blogs[0].detail.MenuTitle,
                                        Content: blog.blogs[0].detail.Content,
                                        MetaDescription: blog.blogs[0].detail.MetaDescription,
                                        ExtraMeta: blog.blogs[0].detail.ExtraMeta,
                                        ShowInMenus: blog.blogs[0].detail.ShowInMenus,
                                        ShowInSearch: blog.blogs[0].detail.ShowInSearch,
                                        Sort: blog.blogs[0].detail.Sort,
                                        HasBrokenFile: blog.blogs[0].detail.HasBrokenFile,
                                        HasBrokenLink: blog.blogs[0].detail.HasBrokenLink,
                                        ReportClass: blog.blogs[0].detail.ReportClass,
                                        CanViewType: blog.blogs[0].detail.CanViewType,
                                        CanEditType: blog.blogs[0].detail.CanEditType,
                                        Version: blog.blogs[0].detail.Version,
                                        ParentID: blog.blogs[0].detail.ParentID
                                    },
                                    categories: [{
                                        ID: blog.ID,
                                        BlogPostID: blog.BlogPostID,
                                        BlogPostCategoryID: blog.BlogPostCategoryID,
                                        category: {
                                            ID: blog.category.ID,
                                            ClassName: blog.category.ClassName,
                                            LastEdited: blog.category.LastEdited,
                                            Created: blog.category.Created,
                                            Name: blog.category.Name,
                                            Slug: blog.category.Slug
                                        }
                                    }]
                                });
                            });

                            $scope.posts = blogPostData;
                            $scope.totalPages = response.data.last_page;
                            $scope.currentPage = response.data.current_page;

                            // Pagination Range
                            var pages = [];
                            for (var i = 1; i <= response.data.last_page; i++) {
                                pages.push(i);
                            }
                            $scope.range = pages;
                            $scope.show = true;
                        }
                    });

            };
        }
    ]);

    app.directive('postsPagination', () => {
        return {
            restrict: 'E',
            template: '<ul class="hidden-xs pagination">' +
                '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getPosts(1)">&laquo;</a></li>' +
                '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getPosts(currentPage-1)">&lsaquo; Prev</a></li>' +
                '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">' +
                '<a href="javascript:void(0)" ng-click="getPosts(i)">{{i}}</a>' +
                '</li>' +
                '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getPosts(currentPage+1)">Next &rsaquo;</a></li>' +
                '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getPosts(totalPages)">&raquo;</a></li>' +
                '</ul>'
        };
    });

}());
