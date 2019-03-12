@extends('layouts.candidate')

@section('title', 'Job Applications')

@section('styles')
<link href="css/candidate-settings.css" rel="stylesheet">
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@endsection

@push('css')
{{-- <link rel="stylesheet" href="{{assets('/css')}}"> --}}
@endpush

@section('content')

    <main class="user-settings user-settings--candidate analytics" ng-controller="CandidateController" id="CandidateSettings">
        <section ng-controller="CandidateSettingsController" class="can-settings" style="width: 100%">
            <div class="dropdown-wrap">
                <ul class="pvm-tab-list pvm-tab-list--settings">
                    <li ng-class="{'active' : tab1}" class="pvm-tab__item">
                        <a ng-disabled="tab1" ng-click="!tab1 && updateTab('tab1')" href="javascript:void(0)">Job Applications</a>
                    </li>
                    <li ng-class="{'active' : tab2}" class="pvm-tab__item">
                        <a ng-disabled="tab2" ng-click="!tab2 && updateTab('tab2')" href="javascript:void(0)">Pre-application Questions</a>
                    </li>
                </ul>
                <select>
                    <option label="IT Consultant - No Vancancy - VXF Inc. - Wed, 11 Oct 2017" value="J1153NW1EU1JF">IT Consultant - No Vancancy - VXF Inc. - Wed, 11 Oct 2017</option>
                    <option label="Analytics check (no vacancy) - PreviewMe - Wed, 11 Oct 2017" value="J11543PCRX6FS">Analytics check (no vacancy) - PreviewMe - Wed, 11 Oct 2017</option>
                    <option label="Financial Analyst (2 - 3 years' PQE) - PreviewMe - Wed, 21 Mar 2018" value="JRUKJDN3X">Financial Analyst (2 - 3 years' PQE) - PreviewMe - Wed, 21 Mar 2018</option>
                </select>
            </div>
            <div class="pvm-tab-content settings settings--account">
                <article class="pvm-tab-page pvm-tab-page--privacy pvm-fadein pvm-animated " ng-show="tab1">
                    <h1 class="pvm__header">My Job Applications</h1>
                    
                    <div class="clearfix"></div>
                    <section class="job-views">
                        <div class="row">
                            <div class="col-md-6">
                                <article class="job-views__count">
                                    <h4>Job Listing Views</h4>
                                    <h1>123</h1>
                                </article>
                            </div>
                            <div class="col-md-6">
                                <article class="job-views__count">
                                    <h4>Job Listing Video Views</h4>
                                    <h1>1,462</h1>
                                </article>
                            </div>
                        </div>
                    </section>
                    <section class="well applications">
                        <h4 class="head-secondary">Applications</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="pie-application" style=""></div>
                            </div>
                            
                            <div class="col-md-6">
                                <ul>
                                    <li>
                                        <div class="flexbox">
                                            <h4 class="head-secondary">Total Applications</h4>
                                            <div class="toooltip-wrap">
                                                <span class="toooltip">
                                                    <i class="toooltip__icon fas fa-question-circle"></i>
                                                    <span class="toooltip__msg">Total Applications are defined as the number of candidates who commenced their application and submitted answers at the pre-application stage for the role.</span>
                                                </span>
                                            </div>
                                        </div>
                                        <h1>1,000</h1>
                                    </li>
                                    <li>
                                        <h4 class="head-secondary">Completed Applications</h4>
                                        <h2 class="head-tertiary head-tertiary--green">800 (80%)</h2>
                                    </li>
                                    <li>
                                        <h4 class="head-secondary">Failed Pre-Application Questions</h4>
                                        <h2 class="head-tertiary head-tertiary--violet">150 (15%)</h2>
                                    </li>
                                    <li>
                                        <h4 class="head-secondary">Incomplete Applications</h4>
                                        <h2 class="head-tertiary head-tertiary--red">50 (5%)</h2>
                                    </li>
                                </ul> 
                            </div>
                        </div>
                    </section>
                    <section class="well experience nopad">
                        <h4 class="head-secondary">Experience in Classifications</h4>
                        <div class="container-fluid eqh-wrap nopad">
                            <div class="col-md-3 nopad eqh__list">
                                <div class="experience__yr">
                                    <i class="glyphicon glyphicon-triangle-right hidden-sm hidden-xs"></i>
                                    <p>Deployed is<br>
                                        looking for:
                                    </p>
                                    <h1>3-6</h1>
                                    <p>years of<br>
                                        experience
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-9 nopad eqh__list">
                                <table class="table table-bordered experience__table responsive-table">
                                    <thead class="responsive-table__header">
                                        <tr class="tbl-nobtop">
                                            <th></th>
                                            <th>Highest Experience</th>
                                            <th>Lowest Experience</th>
                                            <th>Average Experience</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Design & Architecture</td>
                                            <td data-name="Highest experience"><p class="head-tertiary head-tertiary--green">16</p></td>
                                            <td data-name="Lowest experience"><p class="head-tertiary head-tertiary--red">2</p></td>
                                            <td data-name="Average experience"><p class="head-tertiary">8.6</p></td>
                                        </tr>
                                        <tr>
                                            <td class="noborder">Web & Interaction Design</td>
                                            <td data-name="Highest experience"><p class="head-tertiary head-tertiary--green">8</p></td>
                                            <td data-name="Lowest experience"><p class="head-tertiary head-tertiary--red">1</p></td>
                                            <td data-name="Average experience"><p class="head-tertiary">3.4</p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    
                    <section class="well regions">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="head-secondary">All Candidate Regions</h4>
                                <div id="pie-candidate" style=""></div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="head-secondary">Top 5 Candidate Regions</h4>
                                <ul class="regions__list">
                                    <li>
                                        <div class="regions__info">
                                            <p>Auckland</p>
                                            <p class="regions__info-count">540</p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="regions__info">
                                            <p>Wellington</p>
                                            <p class="regions__info-count">230</p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 23%;"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="regions__info">
                                            <p>Hamilton</p>
                                            <p class="regions__info-count">15</p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="1.5" aria-valuemin="0" aria-valuemax="100" style="width: 1.5%;"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="regions__info">
                                            <p>Christchurch</p>
                                            <p class="regions__info-count">46</p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="4.6" aria-valuemin="0" aria-valuemax="100" style="width: 4.6%;"></div>
                                        </div>                                        
                                    </li>
                                    <li>
                                        <div class="regions__info">
                                            <p>Dunedin</p>
                                            <p class="regions__info-count">149</p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="14.9" aria-valuemin="0" aria-valuemax="100" style="width: 14.9%;"></div>
                                        </div>                                        
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <h1 class="pvm__header">Key</h1>
                                <div class="clearfix"></div>
                                <div id="legend" class="legend"></div>
                            </div>
                        </div>
                    </section>
                </article>
                @include('candidate.analytics.questions')
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script>

        // Build the chart
        Highcharts.chart('pie-application', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            credits: false,
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: false
                }
            },
            series: [{
                name: '',
                colorByPoint: true,
                data: [{
                name: 'Completed Applications',
                y: 80,
                }, {
                name: 'Failed Pre-application Questions',
                y: 15
                }, {
                name: 'Incomplete Applicatons',
                y: 5
                }]
            }]
        });

        // Build the chart
        
        var chart;
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'pie-candidate',
                defaultSeriesType: 'pie',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                events: {
                    load: function () {
                        var chart = this;
                        $(chart.series[0].data).each(function (i, serie) {
                        //console.log(serie)
                            $('<li style="color: ' + serie.color + '">' + serie.name + '</li>').click(function () {
                                serie.visible ? serie.setVisible(false) : serie.setVisible(true);
                            }).appendTo('#legend');
                        });
                    }
                }
            },
            credits: false,
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                
                }
            },
            series: [{
                name: '',
                colorByPoint: true,
                data: [{
                name: 'Auckland',
                y: 54
                }, {
                name: 'Wellington',
                y: 23
                }, {
                name: 'Dunedin',
                y: 1.5
                }, {
                name: 'Christchurch',
                y: 2
                }, {
                name: 'Hamilton',
                y: 1.5
                }, {
                name: 'Bay of Plenty',
                y: 0
                }, {
                name: 'Kaitaia',
                y: 1
                }, {
                name: 'Mariborough',
                y: 1.1
                }, {
                name: 'Taranaki',
                y: 0
                }, {
                name: 'Hawkes Bay',
                y: 14.9
                }, {
                name: 'Nelson',
                y: 1
                }]
            }]
        });
    </script>
@endsection