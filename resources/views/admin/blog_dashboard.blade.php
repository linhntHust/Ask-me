@extends('admin.layouts.master')
@section('page_header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li>
                            <a href="{{ route('admin.index') }}">Ask-me</a>
                        </li>
                        <li class="active">
                            Blog Dashboard
                        </li>
                    </ol>
                </div>
                <h4 class="page-title"> Blogs Statistical</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
        @if ($message = Session::get('success'))
            <div class="alert alert-icon alert-info alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="mdi mdi-check-all"></i>
                <strong>Congratulation!</strong> {{$message}}
            </div>
        @endif

        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-three">
                <div class="bg-icon pull-left">
                    <i class="ti-image"></i>
                </div>
                <div class="text-right">
                    <p class="text-muted m-t-5 text-uppercase font-600 font-secondary">Total Post</p>
                    <h2 class="m-b-10"><span data-plugin="counterup">{{ count($blogs) }}</span></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-three">
                <div class="bg-icon pull-left">
                    <i class="ti-agenda"></i>
                </div>
                <div class="text-right">
                    <p class="text-muted m-t-5 text-uppercase font-600 font-secondary">Approved</p>
                    <h2 class="m-b-10"><span data-plugin="counterup">{{ count($verified) }}</span></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-three">
                <div class="bg-icon pull-left">
                    <i class="ti-comment-alt"></i>
                </div>
                <div class="text-right">
                    <p class="text-muted m-t-5 text-uppercase font-600 font-secondary">Comments</p>
                    <h2 class="m-b-10"><span data-plugin="counterup">{{ count($totalComments) }}</span></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card-box widget-box-three">
                <div class="bg-icon pull-left">
                    <i class="ti-view-list-alt"></i>
                </div>
                <div class="text-right">
                    <p class="text-muted m-t-5 text-uppercase font-600 font-secondary">Categories</p>
                    <h2 class="m-b-10"><span data-plugin="counterup">{{ count($totalCategories) }}</span></h2>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title">All Blogs</h4>

                <div class="table-responsive">
                    <table class="table table-colored table-centered table-inverse m-0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $blogs as $blog)
                            <tr id="itemBlog_{{$blog->id}}">
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('admin.blog.detail', $blog->id) }}"> {{ $blog->title }}</a></td>
                                <td>{{ \App\Models\Blog::$type[$blog->type] }}</td>
                                <td>{{ $blog->user->name }}</td>
                                <td>{{ count($blog->comments) }}</td>

                                @switch( $blog->approve_status)
                                    @case (0)
                                    <td><span class="label label-warning">Pending</span></td>
                                    @break
                                    @case (1)
                                    <td><span class="label label-success">Approved</span></td>
                                    @break;
                                    @case (2)
                                    <td><span class="label label-danger">Denied</span></td>
                                    @break;
                                @endswitch
                                <td>
                                    <button class="btn btn-icon waves-effect waves-light btn-danger delete-modal" data-toggle="modal" data-target=".bs-example-modal-lg" data-id = "{{$blog->id}}"> <i class="fa fa-trash-o"></i> </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-right">
                {{ $blogs->render('admin.elements.pagination') }}
            </div>
        </div>
    </div>

    <script>
        var resizefunc = [];
    </script>
    <div class="modal fade bs-example-modal-lg" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Delete modal</h4>
                </div>
                <form class="form-confirm" method="post">
                    <input type="hidden" name="_method" value="delete" />
                    {{ csrf_field() }}
                    <input type="hidden" id="id_delete" name="question_id">
                    <input type="hidden" id="url_delete">
                    <div class="modal-body">
                        <h4 class="text-center">Are you sure you want to delete the following blog?</h4>
                        <p class="text-center">Bạn có chắc muốn xoá bài đăng này không?</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group no-margin">
                                    <label for="field-7" class="control-label">Reason:</label>
                                    <textarea class="form-control autogrow" id="reason" placeholder="Write down reason to delete for owner" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="delete_modal" class='glyphicon glyphicon-trash'></span> Delete
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section ('page_scripts')
    @parent
    <!-- toastr notifications -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script type="text/javascript">
        $(document).on('click', '.delete-modal', function() {
            $('#id_delete').val($(this).data('id'));
            $('#deleteModal').modal('show');
            id = $('#id_delete').val();
        });
        $('.modal-footer').on('click', '.delete', function() {
            reason = $('#reason').val();
            $.ajax({
                type: 'post',
                url: "{{ route('admin.delete.blog') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    blog_id : id,
                    reason: reason,
                },
                success: function(data) {
                    toastr.success('Successfully deleted Blog!', 'Success Alert', {timeOut: 5000});
                    $('#itemBlog_' + data['id']).remove();
                },
                error(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endsection
