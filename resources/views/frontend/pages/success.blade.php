@extends('frontend.master')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>

        .success-message {
            position: relative;
            text-align: center;
            padding: 60px;
            background-color: #d4edda;
            border: 2px solid #c3e6cb;
            border-radius: 10px;
            animation-name: bounceInUp;
            animation-duration: 1s;
            overflow: hidden;
        }
        
        .success-message h3 {
            margin-bottom: 20px;
            font-size: 32px;
            color: #155724;
        }
        
        .success-icon {
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #155724;
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            color: #d4edda;
            font-size: 48px;
            animation-name: rotate;
            animation-duration: 2s;
            animation-timing-function: cubic-bezier(0.5, 0.1, 0.1, 1);
        }

        @keyframes bounceInUp {
            0% {
                opacity: 0;
                transform: translate3d(0, 100%, 0);
            }
            60% {
                opacity: 1;
                transform: translate3d(0, -20px, 0);
            }
            80% {
                transform: translate3d(0, 10px, 0);
            }
            100% {
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes rotate {
            0% {
                transform: translateX(-50%) rotate(0deg);
            }
            100% {
                transform: translateX(-50%) rotate(360deg);
            }
        }
    </style>
    <center>
    <div class="success-message" style="margin:25%;top:100px;padding-left: 0px;padding-right: 0px;">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h3 style="margin-top: 100px;">Success!</h3>
    </div>
    </center>

@stop