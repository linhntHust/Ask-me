@extends('layouts.master')
@section('title')
    Ask New Question
@endsection
@section('page_header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
@section('content')
<div class="breadcrumbs">
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Ask Question</h1>
            </div>
            <div class="col-md-12">
                <div class="crumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="crumbs-span">/</span>
                    <a href="#">Pages</a>
                    <span class="crumbs-span">/</span>
                    <span class="current">Ask Question</span>
                </div>
            </div>
        </div><!-- End row -->
    </section><!-- End container -->
</div><!-- End breadcrumbs -->

<section class="container main-content">
    <div class="row">
        <div class="col-md-9">

            @if ($message = Session::get('error'))
                <div class="alert-message error">
                    <i class="icon-flag"></i>
                    <p><span>success message</span><br>
                        {{$message}}</p>
                </div>
            @endif

            <div class="page-content ask-question">
                <div class="boxedtitle page-title"><h2>Ask Question</h2></div>
                                
                <div class="form-style form-style-3 form-create" id="question-submit">
                    <form action="{{ route('question.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-inputs clearfix">
                            <p>
                                <label class="required">Question Title<span>*</span></label>
                                <input type="text" id="question-title" name="title">
                                <span class="form-description">Please choose an appropriate title for the question to answer it even easier .</span>
                            </p>
                            <p>
                                <label>Tags</label>
                                <input type="text" class="input" id="question_tags" data-seperator="," name="tags">
                                <span class="form-description">Please choose  suitable Keywords Ex : <strong class="color" id="recommendTag">question, poll, </strong>..</span>
                            </p>
                            <p>
                                <label class="required">Category<span>*</span></label>
                                <span class="styled-select">
                                    <select name="category" id="category">
                                        <option value="">Select a Category</option>
                                        @foreach( $categories as $category)
                                            <option value="{{$category->id}}"> {{ $category->name_category }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                <span class="form-description">Please choose the appropriate section so easily search for your question .</span>
                            </p>
                            <p class="question_poll_p">
                                <label for="question_poll">Poll</label>
                                <input type="checkbox" id="question_poll" value="1" name="question_poll" >
                                <span class="question_poll">This question is a poll ?</span>
                                <span class="poll-description">If you want to be doing a poll click here .</span>
                            </p>
                            <div class="clearfix"></div>
                            <div class="poll_options">
                                <p class="form-submit add_poll">
                                    <button id="add_poll" type="button" class="button color small submit"><i class="icon-plus"></i>Add Field</button>
                                </p>
                                <ul id="question_poll_item">
                                    <li id="poll_li_1">
                                        <div class="poll-li">
                                            <p><input id="ask[1][title]" class="ask" name="ask[1][title]" value="" type="text"></p>
                                            <input id="ask[1][value]" name="ask[1][value]" value="1" type="hidden">
                                            <input id="ask[1][id]" name="ask[1][id]" value="1" type="hidden">
                                            <div class="del-poll-li"><i class="icon-remove"></i></div>
                                            <div class="move-poll-li"><i class="icon-fullscreen"></i></div>
                                        </div>
                                    </li>
                                </ul>
                                <script> var nextli = 2;</script>
                                <div class="clearfix"></div>
                            </div>
                            
                            <label>Attachment</label>
                            <div class="fileinputs">
                                <input type="file" class="file" name="filename">
                                <div class="fakefile">
                                    <button type="button" id="buttonUpload"  class="button small margin_0">Select file</button>
                                    <span><i class="icon-arrow-up"></i>Browse</span>
                                </div>
                            </div>
                            
                        </div>
                        <div id="form-textarea">
                                <p>
                                    <label class="required">Details<span>*</span></label>
                                    <textarea id="question-details" aria-required="true" cols="58" rows="8" name="details"></textarea>
                                    <span class="form-description">Type the description thoroughly and in detail .</span>
                                </p>
                            <div class="button small lime-green-button custom-button" id="tag_generate">Auto generate Tag</div>
                        </div>
                        <p class="form-submit">
                            <input type="submit" id="publish-question" value="Publish Your Question" class="button color small submit">
                        </p>
                    </form>
                </div>
            </div><!-- End page-content -->
        </div><!-- End main -->

        @include('layouts.asside_bar')

		</div><!-- End row -->
	</section><!-- End container -->
@endsection
@section('page_scripts')
    @parent
    <!-- toastr notifications -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://algorithmia.com/v1/clients/js/algorithmia-0.2.0.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                $("#buttonUpload").text(fileName);
            });

            $("#tag_generate").on('click', function(){
                var input = $("#question-details").val();
                Algorithmia.client("simIPNBrbvumkpUsto9/Oogy+2W1")
                    .algo("nlp/AutoTag/1.0.1?timeout=300")
                    .pipe(input)
                    .then(function(output) {
                        output.result.forEach(function(element) {
                            var e = jQuery.Event("keypress");
                            e.which = 13;
                            $(".input :input").val(element).trigger(e);
                        });
                    });
            });

            $(".form-create").submit(function () {
                var thisform = $(this);
                jQuery('.required-error',thisform).remove();
                var title	= $("#question-title").val();
                var category = $("#category").val();
                var details	= $("#question-details").val();
                if (title == "") {
                    $("#question-title").after('<span class="form-description required-error">Please fill the required field.</span>');
                }else {
                    $("#question-title").parent().find('.required-error').remove();
                }
                if (category == "") {
                    $("#category").parent().after('<span class="form-description required-error">Please fill the required field.</span>');
                }else {
                    $("#category").parent().find('.required-error').remove();
                }
                if (details == "") {
                    $("#question-details").after('<span class="form-description required-error">Please fill the required field.</span>');
                }else {
                    $("#question-details").parent().find('.required-error').remove();
                }

                if (title != "" && category != "" && details != "") {
                    return true;
                } else {
                    return false;
                }
            });

            $('#category').change(function(){
                id = $(this).val();
                $.ajax({
                    type: 'post',
                    url: "{{ route('recommend.tag') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id,
                    },
                    success: function(data) {
                        $('#recommendTag').html(data);
                    },
                    error(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection
