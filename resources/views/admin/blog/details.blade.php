@extends('admin.welcome')
@section('title', 'Create Blog')

@section('custom-styles')
    <style>
        #previewImage{
            height:300px;
            width:100%;
            border:2px dashed rgb(207, 207, 207);
            border-radius:5px;
            padding:10px;
            background: rgb(247, 246, 246);
            overflow: hidden;
        }

        .blog-content textarea{
            width:100%;
            border-color:rgb(179, 177, 177);
            border-radius:5px;
            padding:10px;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 300px;
        }
        .ck-content .image {
            max-width: 80%;
            margin: 20px auto;
        }
    </style>
@endsection

@section('content')
    <h4 class="mb-4">Create Blog</h4>
    <div class="card">
        <div class="card-body">
            <div id="previewImage" class="mb-3 d-flex flex-row justify-content-center align-items-center">
                <img src="{{asset($get_details->blogImage)}}" alt="blog Image">
            </div>
            <form id="blogForm">
                @csrf
                <input type="hidden" name="blogId" value="{{$get_details->id}}">
                <div class="mb-4 mt-2">
                    <input type="file" name="blogImage" id="blogImage" class="form-control" accept=".jpg, .png, .jpeg">
                </div>
                <div class="mb-4 mt-2">
                    <label for="" class="mb-2">Enter Title</label>
                    <input type="text" name="blogTitle" id="blogTitle" class="form-control" placeholder="Title..." value ="{{$get_details->title}}" required>
                </div>
                <div class="blog-content">
                    <label for="" class="mb-2">Enter Content</label>
                    <div id="editor" required></div>
                    {{-- <textarea name="blogContent" id="blogContent" rows="15" placeholder="Type your content here...."></textarea> --}}
                </div>
                <div class="mt-2">
                    <button class="btn btn-primary blog-submit-btn" type="submit">Submit</button>
                    <button class="btn btn-danger blog-delete-btn">Delete Blog</button>
                </div>
            </form>
            
        </div>
    </div>
@endsection


@section('custom-scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function(){
            CKEDITOR.instances.editor.setData(`{!! $get_details->content !!}`);

        });
    </script>
    <script>
        CKEDITOR.replace( 'editor',{
            toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
                },
                {
                "name": "links",
                "groups": ["links"]
                },
                {
                "name": "paragraph",
                "groups": ["list", "blocks"]
                },
                {
                "name": "document",
                "groups": ["mode"]
                },
                {
                "name": "styles",
                "groups": ["styles"]
                },
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Anchor,Styles,Specialchar,PasteFromWord'
        });
    </script>
    <script>
        document.getElementById('blogImage').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').innerHTML = '<img src="' + e.target.result + '" style="max-width: 100%; max-height: 100%; border-radius:5px;">';
            };
            reader.readAsDataURL(file);
        });
    </script>

    <script>

        $('#blogForm').on('submit', function(e){
            e.preventDefault();

            $('.blog-submit-btn').text('Please wait....');
            $('.blog-submit-btn').attr('disabled', true);

            const blogImage = $('#blogImage').prop('files')[0];
            const blogContent = CKEDITOR.instances.editor.getData();
            let formData = new FormData(this);
            formData.append('blogImage', blogImage)
            formData.append('blogContent', blogContent)

            $.ajax({
                url:"{{route('admin.blog.update.details')}}",
                type:"POST",
                contentType:false,
                processData:false,
                data:formData,
                success:function(data){
                    if(data.status == 200){
                        toastr.success(data.message)
                        $('.blog-submit-btn').text('Submit');
                        $('.blog-submit-btn').attr('disabled', false);

                        if(data.data == 'deleted'){
                            window.location.replace('/admin/blog/all');
                        }
                    }else{
                        toastr.error(data.message)
                        $('.blog-submit-btn').text('Submit');
                        $('.blog-submit-btn').attr('disabled', false);
                    }
                },error:function(err){
                    toastr.error(err)
                    $('.blog-submit-btn').text('Submit');
                    $('.blog-submit-btn').attr('disabled', false);
                }
            })
            
        });


        $('.blog-delete-btn').on('click', function(e){
            e.preventDefault();

            $('.blog-delete-btn').text('Please wait....');
            $('.blog-delete-btn').attr('disabled', true);

            $.ajax({
                url:"{{route('admin.blog.delete')}}",
                type:"POST",
                data:{
                    'id' : "{{$get_details->id}}",
                    '_token' : "{{ csrf_token() }}"
                },
                success:function(data){
                    if(data.status == 200){
                        toastr.success(data.message)
                        $('.blog-delete-btn').text('Submit');
                        $('.blog-delete-btn').attr('disabled', false);

                        if(data.data == 'deleted'){
                            window.location.replace('/admin/blog/all');
                        }
                    }else{
                        toastr.error(data.message)
                        $('.blog-delete-btn').text('Submit');
                        $('.blog-delete-btn').attr('disabled', false);
                    }
                },error:function(err){
                    toastr.error(err)
                    $('.blog-delete-btn').text('Submit');
                    $('.blog-delete-btn').attr('disabled', false);
                }
            })
            
        });
    </script>
@endsection