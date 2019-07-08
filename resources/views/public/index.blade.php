<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Smartz Human Asset Management software (c) Kalija Global">
        <meta name="author" content="Kalija Global">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Smartz Human Asset Management</title>
        <style>
            body{margin:0;background-color:#F8F8F8}
            header{
                min-height: 55px;
                box-shadow: 0 0 2px rgba(0,0,0,0.3);
                background: #FFF;
                z-index:1;
            }
            .logo{
                display:block;
                background: no-repeat url('../images/logo-gold-header2.png');
            }
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            a{text-decoration:none}
            .row {
            margin-right: -15px;
            margin-left: -15px;
            }
            .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
            }
            .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
            }
            .col-xs-12 {
            width: 100%;
            }
            .col-lg-4 {
                width: 33.33333333%;
            }
            @media (min-width: 768px) {
                .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                    float: left;
                }
                .col-sm-8 {
                    width: 66.66666667%;
                }
            }
            .jp_job_post_main_wrapper_cont{
                float:left;
                width:100%;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_main_wrapper{
                border:1px solid #23c0e9;
                border-bottom:0;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper{
                border:1px solid #23c0e9;
                border-top:0;
                background:#23c0e9;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper li,
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper li i,
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper li a{
                color:#ffffff;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont2{
                margin-top:35px;
            }

            .jp_job_post_main_wrapper{
                float:left;
                width:100%;
                background:#ffffff;
                padding: 30px;
                border:1px solid #e9e9e9;
                border-bottom:0;
                transition: all 0.5s;
            }
            .jp_job_post_side_img{
                float:left;
                width:105px;
            }
            .jp_job_post_right_cont{
                float:left;
                width:calc(100% - 105px);
                padding-left:30px;
                padding-top:10px;
            }
            .jp_job_post_right_cont h4{
                font-size:16px;
                color:#000000;
                font-weight:bold;
            }
            .jp_job_post_right_cont p{
                font-size:16px;
                color:#23c0e9;
                padding-top:5px;
            }
            .jp_job_post_right_cont li{
                margin-left:20px;
                float:left;
            }
            .jp_job_post_right_cont li i{
                color:#f36969;
            }
            .jp_job_post_right_cont li:first-child{
                margin-left:0;
                color:#000000;
                font-size:16px;
                font-weight:bold;
            }
            .jp_job_post_right_cont li:last-child{
                color:#797979;
                font-size:16px;
            }
            .jp_job_post_heading_wrapper{
                float:left;
            }
            .jp_job_post_right_btn_wrapper ul{
                float:right;
                margin-top: 15px;
            }
            .jp_job_post_right_btn_wrapper li{
                float:left;
                margin-left:20px;
            }
            .jp_job_post_right_btn_wrapper li:first-child a:hover{
                background:#f36969;
                color:#ffffff;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_right_btn_wrapper li:nth-child(1){
                float:none;
                margin-left:50px;
            }
            .jp_job_post_right_btn_wrapper li:nth-child(1) a{
                float:left;
                width:100px;
                height:30px;
                line-height:30px;
                text-align:center;
                background:#37d09c;
                color:#ffffff;
                font-size:12px;
                text-transform:uppercase;
                -webkit-border-radius:10px;
                -moz-border-radius:10px;
                border-radius:10px;
            }
            .jp_job_post_right_btn_wrapper li:last-child{
                margin-left:50px;
                margin-top:40px;
                float:none;
            }
            .jp_job_post_right_btn_wrapper li:last-child a{
                float:left;
                width:100px;
                height:30px;
                line-height:30px;
                text-align:center;
                background:#f36969;
                color:#ffffff;
                font-size:12px;
                text-transform:uppercase;
                -webkit-border-radius:10px;
                -moz-border-radius:10px;
                border-radius:10px;
            }
            .jp_job_post_keyword_wrapper{
                float:left;
                width:100%;
                padding-top:20px;
                padding-bottom:20px;
                padding-left: 30px;
                padding-right: 30px;
                border:1px solid #e9e9e9;
                background:transparent;
                border-top:0;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_keyword_wrapper li{
                float:left;
                margin-left:20px;
            }
            .jp_job_post_keyword_wrapper li:first-child{
                margin-left:0;
                color:#000000;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_keyword_wrapper li i{
                padding-right:5px;
                color:#23c0e9;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_keyword_wrapper li a{
                color:#797979;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
                
            }
            .jp_job_post_main_wrapper_cont{
                float:left;
                width:100%;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_main_wrapper{
                border:1px solid #23c0e9;
                border-bottom:0;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper{
                border:1px solid #23c0e9;
                border-top:0;
                background:#23c0e9;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper li,
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper li i,
            .jp_job_post_main_wrapper_cont:hover .jp_job_post_keyword_wrapper li a{
                color:#ffffff;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_job_post_main_wrapper_cont2{
                margin-top:35px;
            }
            .jp_register_section_main_wrapper{
                float:left;
                width:100%;
                margin-top:100px;
            }
            .jp_regis_left_side_box_wrapper{
                float:left;
                width:50%;
                text-align:center;
                background:#ffffff;
                border:1px solid #e9e9e9;
                border-bottom:1px solid #23c0e9;
                border-right:0;
                padding-top:85px;
                padding-bottom:85px;
            }
            .jp_regis_left_side_box{
                display:inline-block;
            }
            .jp_regis_left_side_box h4{
                font-size:20px;
                font-weight:bold;
                color:#000000;
                text-transform:uppercase;
                padding-top:15px;
                position:relative;
            }
            .jp_regis_left_side_box h4:before {
                content: '';
                border: 1px solid #23c0e9;
                width: 8px;
                position: absolute;
                bottom: -15px;
                left: -45px;
                right:0;
                margin:0px auto;
            }
            .jp_regis_left_side_box h4:after {
                content: '';
                border: 1px solid #23c0e9;
                width: 30px;
                position: absolute;
                bottom: -15px;
                left: 0;
                right:0;
                margin:0px auto;
            }
            .jp_regis_left_side_box p{
                padding-top:50px;
            }
            .jp_regis_left_side_box ul{
                display:inline-block;
                margin-top:25px;
            }
            .jp_regis_left_side_box li a{
                float:left;
                width:230px;
                height:50px;
                text-align:center;
                line-height:50px;
                color:#ffffff;
                font-weight:bold;
                background:#23c0e9;
                -webkit-border-radius: 10px; 
            -moz-border-radius: 10px; 
            border-radius: 10px; 
            -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_regis_left_side_box li a:hover{
                background:#f36964;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_regis_right_side_box_wrapper{
                float:left;
                width:50%;
                padding-top:85px;
                padding-bottom:85px;
                background:url('../images/content/register_bg.jpg') 50% 0 repeat-y;
                background-position":center 0;
                background-size:cover;
                background-repeat:no-repeat;
                position:relative;
                text-align:center;
            }
            .jp_regis_right_img_overlay{
                position:absolute;
                top:0%;
                left:0%;
                right:0%;
                bottom:0%;
                background:rgba(0,0,0,0.9);
            }
            .jp_regis_right_side_box{
                display:inline-block;
                position:relative;
            }
            .jp_regis_right_side_box h4{
                font-size:20px;
                font-weight:bold;
                color:#ffffff;
                text-transform:uppercase;
                padding-top:15px;
                position:relative;
            }
            .jp_regis_right_side_box h4:before {
                content: '';
                border: 1px solid #23c0e9;
                width: 8px;
                position: absolute;
                bottom: -15px;
                left: -45px;
                right:0;
                margin:0px auto;
            }
            .jp_regis_right_side_box h4:after {
                content: '';
                border: 1px solid #23c0e9;
                width: 30px;
                position: absolute;
                bottom: -15px;
                left: 0;
                right:0;
                margin:0px auto;
            }
            .jp_regis_right_side_box p{
                padding-top:50px;
                color:#ffffffa3;
            }
            .jp_regis_right_side_box ul{
                display:inline-block;
                margin-top:25px;
            }
            .jp_regis_right_side_box li a{
                float:left;
                width:230px;
                height:50px;
                text-align:center;
                line-height:50px;
                color:#ffffff;
                font-weight:bold;
                background:#f36969;
                -webkit-border-radius: 10px; 
            -moz-border-radius: 10px; 
            border-radius: 10px; 
            -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_regis_right_side_box li a:hover{
                background:#23c0e9;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_regis_center_tag_wrapper{
                width:70px;
                height:70px;
                background:#23c0e9;
                position: absolute;
                left: -34px;
                top: 50%;
                margin-top: -20px;
                -webkit-border-radius: 20px; 
            -moz-border-radius: 20px; 
                border-radius: 20px; 
                -ms-transform: rotate(45deg); 
                -webkit-transform: rotate(45deg); 
                transform: rotate(45deg);
            }
            .jp_regis_center_tag_wrapper p{
                color:#ffffff;
                font-weight:bold;
                -ms-transform: rotate(-45deg); 
                -webkit-transform: rotate(-45deg); 
                transform: rotate(-45deg);
                margin-top: 23px;
            }
            .jp_first_right_sidebar_main_wrapper{
                float:left;
                width:100%;
            }
            .jp_add_resume_wrapper{
                background:url('../images/content/resume-bg.jpg') 50% 0 repeat-y;
                width:100%;
                height:100%;
                background-position:center 0;
                background-size:cover;
                background-repeat:no-repeat;
                position:relative;
                text-align:center;
                padding-left:30px;
                padding-right:30px;
            }
            .jp_add_resume_img_overlay{
                position:absolute;
                top:0%;
                left:0%;
                right:0%;
                bottom:0%;
                background:rgba(0,0,0,0.9);
            }
            .jp_add_resume_cont{
                position:relative;
                display:inline-block;
                padding-top:45px;
                padding-bottom:45px;
            }
            .jp_add_resume_cont h4{
                font-size:16px;
                color:#ffffff;
                padding-top:25px;
                line-height: 25px;
                position:relative;
            }
            .jp_add_resume_cont h4:before {
                content: '';
                border: 1px solid #23c0e9;
                width: 8px;
                position: absolute;
                bottom: -15px;
                left: -45px;
                right: 0;
                margin: 0px auto;
            }
            .jp_add_resume_cont h4:after {
                content: '';
                border: 1px solid #23c0e9;
                width: 30px;
                position: absolute;
                bottom: -15px;
                left: 0;
                right: 0;
                margin: 0px auto;
            }
            .jp_add_resume_cont ul{
                display:inline-block;
                margin-top:35px;
            }
            .jp_add_resume_cont li a{
                float:left;
                width:160px;
                height:50px;
                text-align:center;
                line-height:50px;
                color:#ffffff;
                font-weight:bold;
                background:#23c0e9;
                -webkit-border-radius: 10px; 
            -moz-border-radius: 10px; 
            border-radius: 10px; 
            -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            .jp_add_resume_cont li a:hover{
                background:#f36969;
                -webkit-transition: all 0.5s;
                -o-transition: all 0.5s;
                -ms-transition: all 0.5s;
                -moz-transition: all 0.5s;
                transition: all 0.5s;
            }
            @media (max-width: 580px){
                .jp_job_post_right_cont li{
                    float:none;
                }
                .jp_job_post_right_cont li:last-child{
                    margin-left:0;
                }
                .jp_client_slider_img_wrapper{
                    float:none;
                }
                .jp_client_slider_cont_wrapper{
                    float:none;
                    width:100%;
                    padding-left:0;
                    padding-top:20px;
                }
            }
            @media (max-width: 380px){
                .jp_job_post_right_btn_wrapper ul li{
                    margin-left:10px !important;
                }
                .jp_job_post_side_img{
                    float:none;
                    width:100%;
                }
                .jp_job_post_right_cont{
                    float:none;
                    margin-top:20px;
                    width:100%;
                }
                .jp_job_post_right_btn_wrapper ul li{
                    float:none !important;
                    margin-left:0 !important;
                }
                .jp_job_post_right_btn_wrapper li a{
                    margin-top:10px !important;
                }
                .jp_job_post_right_cont{
                    padding-left:0;
                }
                .jp_tittle_name h3, .jp_tittle_name h4{
                    font-size:14px;
                }
                .jp_regis_left_side_box_wrapper, .jp_regis_right_side_box_wrapper{
                    padding-left:30px;
                    padding-right:30px;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <img src="{{asset('../images/logo-gold-header2.png')}}" width="170px" height="50px" />
        </header>
        <section>
            <div class="jp_job_post_main_wrapper_cont">
                <div class="jp_job_post_main_wrapper">
                    <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <div class="jp_job_post_side_img">
                                    <img src="images/content/job_post_img1.jpg" alt="post_img">
                                </div>
                                <div class="jp_job_post_right_cont">
                                    <h4>HTML Developer (1 - 2 Yrs Exp.)</h4>
                                    <p>Webstrot Technology Pvt. Ltd.</p>
                                    <ul>
                                        <li><i class="fa fa-cc-paypal"></i>&nbsp; $12K - 15k P.A.</li>
                                        <li><i class="fa fa-map-marker"></i>&nbsp; Caliphonia, PO 455001</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="jp_job_post_right_btn_wrapper">
                                    <ul>
                                        <li><a href="#">Part Time</a></li>
                                        <li><a href="#">Apply</a></li>
                                    </ul>
                                </div>
                            </div>	
                        </div>	
                        </div>
                        <div class="jp_job_post_keyword_wrapper">
                        <ul>
                            <li><i class="fa fa-tags"></i>Keywords :</li>
                            <li><a href="#">ui designer,</a></li>
                            <li><a href="#">developer,</a></li>
                            <li><a href="#">senior</a></li>
                            <li><a href="#">it company,</a></li>
                            <li><a href="#">design,</a></li>
                            <li><a href="#">call center</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>