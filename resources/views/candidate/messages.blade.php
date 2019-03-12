@extends('layouts.candidate')

@section('title', 'Messages')

@section('styles')
<link href="css/candidate-settings.css" rel="stylesheet">
<link rel="stylesheet" href="css/helpers2.css" />
<link rel="stylesheet" href="css/responsive-media.css" />
@endsection

@section('content')

<div class="panel panel-default messages">
    <div class="panel-body">
        <div class="row border-b">
            <div class="col-sm-3 border-r">
                <div class="input-group search">
                    <input type="text" class="form-control" placeholder="Search for conversation.">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
            <div class="col-sm-9">
                <h2 class="hidden-xs">Caryl Fagela</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 nopad">
                <ul class="messages__thread">
                    <li>
                        <div class="messages__content active">
                            <div class="messages-detail">
                                {{-- <figure>
                                    <img src="{{asset('/images/defaultPhoto.png')}}" alt="..." class="img-circle">
                                </figure> --}}
                                <span class="member-initials member-initials--pvm-red">
                                    CF
                                </span>
                                <div>
                                    <h4>Caryl Fagela</h4>
                                    <h5>PreviewMe</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="messages__content">
                            <div class="messages-detail">
                                {{-- <figure>
                                    <img src="{{asset('/images/defaultPhoto.png')}}" alt="..." class="img-circle">
                                </figure> --}}
                                <span class="member-initials member-initials--pvm-green">
                                    A
                                </span>
                                <div>
                                    <h4>Asta</h4>
                                    <h5>PreviewMe</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="messages__content">
                            <div class="messages-detail">
                                {{-- <figure>
                                    <img src="{{asset('/images/defaultPhoto.png')}}" alt="..." class="img-circle">
                                </figure> --}}
                                <span class="member-initials member-initials--pvm-orange">
                                    N
                                </span>
                                <div>
                                    <h4>Noelle</h4>
                                    <h5>PreviewMe</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-sm-9 border-l">
                <section class="messages__chat">
                    <div class="conversation">

                        <div class="messages__head">
                            <div class="messages-detail">
                                <span class="member-initials member-initials--pvm-red">
                                    CF
                                </span>
                                <div>
                                    <h4>Caryl Fagela</h4>
                                    <p>direct message</p>
                                </div>
                            </div>
                            <span class="chat-time">13/06/2018 8:00 PM</span>
                        </div>

                        <div class="messages__head">
                            <div class="messages-detail">
                                <span class="member-initials member-initials--sky">
                                    D
                                </span>
                                <div>
                                    <h4>Despasito</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Necessitatibus sunt, debitis, nulla esse fugiat earum ea molestiae sed assumenda quae enim blanditiis consequuntur exercitationem quibusdam. Praesentium laudantium molestiae optio excepturi.</p>
                                </div>
                            </div>
                            <span class="chat-time">13/06/2018 8:00 PM</span>
                        </div>

                    </div>
                    <div class="messages__footer">
                        <textarea name="" id="" cols="30" rows="6" placeholder="Please type your message."></textarea>
                        <input type="submit" value="Send" class="btn-pvm btn-primary pull-right">
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection