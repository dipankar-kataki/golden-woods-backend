@extends('admin.welcome')
@section('title', 'All Blog')

@section('custom-styles')
    <style>
        .card-wrapper {
            padding: 2%;
        }

        .card-wrapper .card {
            margin: 0 auto;
        }

        .card {
            position relative;
            max-width: 500px;
            background-color: #FEEFDE;
            border-radius: 8px;
            overflow: hidden;
            padding-bottom: 10px;
            box-shadow: 1px 2px 8px rgba(100, 100, 100, 0.1);
        }

        .image-wrapper {
            background-color: rgb(255, 255, 255);
            width: auto;
            height: 300px;
            overflow: hidden;
        }

        img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            object-position: top;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        img:hover {
            -webkit-transform: scale3d(1.2, 1.2, 1);
            transform: scale3d(1.2, 1.2, 1);
            transition: all 1s linear;
        }

        .text-box-wrapper {
            padding: 20px
        }

        .heading {
            font-family: 'Playfair-Display';
            font-size: 20px;
            font-weight: 500;
            line-height: 1;
        }

        .heading::after {
            content: '';
            display: block;
            margin-top: 0.5em;
            width: 30px;
            height: 5px;
            background-color: black;
        }

        .text {
            font-family: 'Poppins', sans-serif;
            font-weight: 100;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            margin-left: 10px;
            padding: 5px 10px;

            font-family: 'Poppins';
            font-size: 12px;
            font-weight: 700;
            color: #8C5450;
            text-decoration: none;

        }

        .button:hover {
            color: black;

            transition: linear 0.2s;
        }

        h2{
            font-size:18px;
        }
    </style>
@endsection

@section('content')
    <h4 class="mb-4">All Blog</h4>
    <div class="row">
        @foreach ($all_blogs as $item)
        <div class="col-md-4">
            <div class="card-wrapper">
                <div class="card">
                    <div class="image-wrapper">
                        <a class="image-link" href="">
                            <img src='{{asset($item->blogImage)}}' alt='Blog Image'>
                        <a />
                    </div>
                    <div class="text-box-wrapper">
                        <div class="text-box">
                            <h4 class="heading">
                                {{$item->title}}
                            </h4>
                        </div>
                    </div>
        
                    <div class="button-wrapper">
                        <a class="button" href="{{route('admin.blog.details', ['id' => $item->id])}}">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
    

    

@endsection


@section('custom-scripts')
@endsection
