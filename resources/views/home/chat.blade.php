<?php use App\Models\Chat; ?>
@extends('layouts.default')
@section('title', __( 'Chat' ))
@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<style type="text/css">
	.chat-app .people-list {
	    width: 280px;
	    position: absolute;
	    left: 0;
	    top: 0;
	    padding: 20px;
	    z-index: 7
	}

	.chat-app .chat {
	    margin-left: 280px;
	    border-left: 1px solid #eaeaea
	}

	.people-list {
	    -moz-transition: .5s;
	    -o-transition: .5s;
	    -webkit-transition: .5s;
	    transition: .5s
	}

	.people-list .chat-list li {
	    padding: 10px 15px;
	    list-style: none;
	    border-radius: 3px
	}

	.people-list .chat-list li:hover {
	    background: #efefef;
	    cursor: pointer
	}

	.people-list .chat-list li.active {
	    background: #efefef
	}

	.people-list .chat-list li .name {
	    font-size: 15px
	}

	.people-list .chat-list img {
	    width: 45px;
	    border-radius: 50%
	}

	.people-list img {
	    float: left;
	    border-radius: 50%
	}

	.people-list .about {
	    float: left;
	    padding-left: 8px
	}

	.people-list .status {
	    color: #999;
	    font-size: 13px
	}

	.chat .chat-header {
	    padding: 15px 20px;
	    border-bottom: 2px solid #f4f7f6
	}

	.chat .chat-header img {
	    float: left;
	    border-radius: 40px;
	    width: 40px
	}

	.chat .chat-header .chat-about {
	    float: left;
	    padding-left: 10px
	}

	.chat .chat-history {
	    padding: 20px;
	    border-bottom: 2px solid #fff;
	    height: 400px;
	    overflow-y: auto;
	}

	.chat .chat-history ul {
	    padding: 0
	}

	.chat .chat-history ul li {
	    list-style: none;
	    margin-bottom: 30px
	}

	.chat .chat-history ul li:last-child {
	    margin-bottom: 0px
	}

	.chat .chat-history .message-data {
	    margin-bottom: 15px
	}

	.chat .chat-history .message-data img {
	    border-radius: 40px;
	    width: 40px
	}

	.chat .chat-history .message-data-time {
	    color: #434651;
	    padding-left: 6px
	}

	.chat .chat-history .message {
	    color: #444;
	    padding: 18px 20px;
	    line-height: 26px;
	    font-size: 16px;
	    border-radius: 7px;
	    display: inline-block;
	    position: relative;
	    word-wrap: break-word;
	    word-break: break-word;
	    max-width: 80%;
	}

	.chat .chat-history .message:after {
	    bottom: 100%;
	    left: 7%;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-bottom-color: #fff;
	    border-width: 10px;
	    margin-left: -10px
	}

	.chat .chat-history .my-message {
	    background: #000;
	    color: #fff;
	}

	.chat .chat-history .my-message:after {
	    bottom: 100%;
	    left: 30px;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-bottom-color: #000;
	    border-width: 10px;
	    margin-left: -10px
	}

	.chat .chat-history .other-message {
	    background: #fff;
	    color: #000;
	    border: 1px solid #eaeaea;
	    text-align: right
	}

	.chat .chat-history .other-message:after {
	    border-bottom-color: #eaeaea;
	    left: 93%
	}

	.chat .chat-message {
	    padding: 20px
	}

	.online,
	.offline,
	.me {
	    margin-right: 2px;
	    font-size: 8px;
	    vertical-align: middle
	}

	.online {
	    color: #86c541
	}

	.offline {
	    color: #e47297
	}

	.me {
	    color: #1d8ecd
	}

	.float-right {
	    float: right
	}

	.clearfix:after {
	    visibility: hidden;
	    display: block;
	    font-size: 0;
	    content: " ";
	    clear: both;
	    height: 0
	}

	@media only screen and (max-width: 767px) {
	    .chat-app .people-list {
	        height: 465px;
	        width: 100%;
	        overflow-x: auto;
	        background: #fff;
	        left: -400px;
	        display: none
	    }
	    .chat-app .people-list.open {
	        left: 0
	    }
	    .chat-app .chat {
	        margin: 0
	    }
	    .chat-app .chat .chat-header {
	        border-radius: 0.55rem 0.55rem 0 0
	    }
	    .chat-app .chat-history {
	        height: 300px;
	        overflow-x: auto
	    }
	}

	@media only screen and (min-width: 768px) and (max-width: 992px) {
	    .chat-app .chat-list {
	        height: 650px;
	        overflow-x: auto
	    }
	    .chat-app .chat-history {
	        height: 600px;
	        overflow-x: auto
	    }
	}

	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
	    .chat-app .chat-list {
	        height: 480px;
	        overflow-x: auto
	    }
	    .chat-app .chat-history {
	        height: calc(100vh - 350px);
	        overflow-x: auto
	    }
	}
</style>

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
            	<div class="card card-bordered card-preview" style="padding:30px;">
                	<div class="card-inner">
				        <div class="chat-app">
				            <div id="plist" class="people-list">
				                <ul class="list-unstyled chat-list mt-2 mb-0 nav nav-tabs" role="tablist">
				                	@foreach($dataChat as $keys => $values)
				                    <li class="clearfix">
				                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
				                        <div class="about">
				                        	<a class="nav-link @if($keys == 0) active @endif name" role="tab" data-bs-toggle="tab" href="#navs_{{ $values->sender_id }}" aria-controls="navs_{{ $values->sender_id }}">{{ $values->nama }}</a>
				                        </div>
				                    </li>
				                    @endforeach
				                </ul>
				            </div>
				            
				           	<div class="tab-content">
			            		@foreach($dataChat as $k => $val)
			            		<?php  
			            		$data2 = Chat::join('detail_chat as dd', 'dd.chat_id','chat.id')->select('dd.*')->where('sender_id', $val->sender_id)->get();
			            		?>
								<div class="tab-pane fade @if($k == 0) show active @endif" id="navs_{{ $val->sender_id }}" role="tabpanel">
				            		<div class="chat">
						                <div class="chat-header clearfix">
						                    <div class="row">
						                        <div class="col-lg-6">
						                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
						                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
						                            </a>
						                            <div class="chat-about">
						                                <h6 class="m-b-0">{{ $val->nama }}</h6>
						                            </div>
						                        </div>
						                    </div>
						                </div>
						                <div class="chat-history">
						                    <ul class="m-b-0">
						                    	@foreach($data2 as $key => $value)
						                    	@if(!empty($value->chat_sender))
						                        <li class="clearfix">
						                            <div class="message other-message float-right">{{ $value->chat_sender }}</div>
						                        </li>
						                        @else
						                        <li class="clearfix">
						                            <div class="message my-message">{{ $value->chat_receiver }}</div>                                    
						                        </li>
						                        @endif
						                        @endforeach
						                    </ul>
						                </div>
						                <form method="post" action="{{ URL::to('do-add-chat') }}">
						                	@csrf
							                <div class="chat-message clearfix">
							                    <div class="input-group mb-0">
							                    	<input type="hidden" name="sender_id" value="{{ $val->sender_id }}">
							                        <input type="text" class="form-control" name="chat" placeholder="Enter text here...">  
							                        <div class="input-group-prepend">
							                            <button type="submit" class="btn btn-default"><span class="input-group-text"><i class="fa fa-send"></i></span></button>
							                        </div>
							                    </div>
							                </div>
					                    </form> 
					                </div>
					            </div> 
				                @endforeach                              
				            </div>
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
@endsection