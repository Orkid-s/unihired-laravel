<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/lecturer_view_applied_applicants.css">
    <link rel="stylesheet" href="/css/lecturer_star_rating.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/267fcdfaf1.js" crossorigin="anonymous"></script>

    <title>Job Tracker</title>
</head>
<body>
    <div class="sidebar-container">
        <div class="logo">
            <a href="">
                <img src="/assets/unihired-main-logo1.png" alt="Logo">
            </a>  
        </div>
        <ul class="sidebar-navigation ">      
            <li class="">
                <a href="{{ route('lecturer.talents_feed') }}">
                    <i class="fa" aria-hidden="true">
                        <img class="nav-icons" src="/assets/icons-find-user.png" alt="">
                    </i> 
                    Talents Feed
                </a>
            </li>
            <li class="mt-2">
                <a href="{{ route('lecturer.post_job') }}">
                    <i class="fa" aria-hidden="true">
                        <img class="nav-icons" src="/assets/icons-briefcase.png" alt="">
                    </i> 
                    Post a Job
                </a>
            </li>
            <li class="mt-2">
                <a href="{{ route('lecturer.job.tracker') }}">
                    <i class="fa" aria-hidden="true">
                        <img class="nav-icons" src="/assets/icons-radar.png" alt="">
                    </i> 
                    Job Tracker
                </a>
            </li>
            <li class="mt-2" >
                <a href="{{ route('lecturer.profile') }}">
                    <i class="fa" aria-hidden="true">
                        <img class="nav-icons" src="/assets/icons-male.png" alt="">
                    </i>  
                    Profile
                </a>
            </li>
            <li class="mt-2">
                <a class="" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa" aria-hidden="true">
                        <img class="nav-icons" src="/assets/logout-icon.png" alt="">
                    </i>
                    {{ __('Logout') }} 
                </a>
                                            
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">                      
                    @csrf                        
                </form>
            </li>
        </ul> 
        <div class="container p-1" style="width: 14em;">
            <p class="name mb-0">{{ Auth::user()->first_name.' '.Auth::user()->last_name}}
            <div class="role">
                @if(Auth::user()->role == 1)  
                <p>Lecturer</p>
                    @else
                    <p>Student</p>
                @endif
            </div></p>              
        </div>        
    </div>

    <div class="bg-image">
        <div class="content-container">
            <div class="title-border p-2 ms-4 me-3 mt-1 " style="font-size: 25px; width: 400px">                  
                <div style="margin-left: 30px; margin-top: 20px" class="d-flex justify-content-start back-icon">
                    <a href="{{ route('lecturer.job.tracker') }}" style="font-size: 12px; color: black;">
                        <i class="fa" aria-hidden="true">
                            <img class="nav-back" src="/assets/icons-back-100.png" alt="">
                        </i> 
                        Back 
                    </a>
                </div> 
                <div class="d-flex justify-content-between" style="width: 42.3em">
                    <div class="d-flex flex-column bd-highlight">
                        <p style="font-size: 16px; margin-left: 43px" class="mt-5 mb-0">Give Review and Rating</p>
                    </div>
                </div>
            </div>   
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show accept-alerts" role="alert">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div> 
        <br>

        <div class="form-container rounded mt-0">
            <div class="review-box">    
                @foreach ($list_applicant->many_job as $user)
                    @foreach ($applicant_profile as $applicant)
                        @if ($user->pivot->user_id == $applicant->user_id && $user->pivot->status=='4')
                            <div class="d-flex flex-row bd-highlight">
                                <div class="start mb-4">
                                    <img src="/assets/img_avatar.png" alt="Avatar" style="width:100px; border-radius: 50%;">
                                </div>
                                <div class="ms-3 align-self-start">
                                    <p style="font-size: 16px; font-weight: bold"class="mb-1">{{$applicant->full_name}}</p>

                                    @if ($applicant->college == 'CES')
                                        <p>College of Energy Economics and Social Sciences (CES)</p>
                                        @elseif ($applicant->college == 'CCI')
                                            <p>College of Computing and Informatics (CCI)</p>
                                        @elseif ($applicant->college == 'COE')
                                            <p>College of Engineering (COE)</p>
                                        @elseif ($applicant->college  == 'COBA')
                                            <p>College of Business Management and Accounting (COBA)</p>
                                        @else
                                        <p>College of Graduate Studies (COGS)</p>
                                    @endif
                                        <form method="post" action="submit-review-rating/{{$user->id}}">
                                        @csrf
                                        <input
                                            class="rating mt-2 mb-3" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="1" style="--stars:5;--value:2" type="range" value="2" id="star_rating" name="star_rating">
                                        <textarea id="review" name="review" rows="4" type="text "cols="100" placeholder="Tell us your satisfaction working with this student."></textarea>
                                </div>
                                <div class="text-end ">
                                    <button style = "font-size: 12px;" type="submit" class="btn btn-primary ms-1">Submit Review</button>  
                                    
                                </div>
                            </form>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
<body>
</html>