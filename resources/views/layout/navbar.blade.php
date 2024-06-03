<nav class="navbar display fixed-top p-5" id="nav">
    <div class="container-fluid">

        <div class="">
            <div class="row">
                <div class="col-3">
                  <a class="mr-5" data-bs-toggle="offcanvas" href="#navcanvas" role="button" aria-controls="navcanvas">
                <img src="{{ asset('public\images\arrow.svg') }}">
                </a>
                </div>
                <div class="col-7">
                    <a class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="{{ asset('public\images\logo.svg') }}">
                </a>
                </div>
            </div>


        </div>

        @if (!Illuminate\Support\Facades\Auth::user())
        <div class="">
          <ul class="navbar-nav">
            <li class="nav-item">
                <a class="auth_btn" aria-current="page" href="{{ route('login') }}">войти</a>
            </li>

          </ul>
        </div>
        @endif
      </div>
    {{-- <div>
        <div class="">
            <a class="" data-bs-toggle="offcanvas" href="#navcanvas" role="button" aria-controls="navcanvas">
            <img src="{{ asset('public\images\arrow.svg') }}">
            </a>
        <a class="navbar-brand" href="#">
            <img src="{{ asset('public\images\logo.svg') }}">
        </a>
        </div>
        <div class="">
            <a class="auth_btn" aria-current="page" href="{{ route('login') }}">войти</a>
        </div>
    </div> --}}
  </nav>
  <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="navcanvas" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">меню</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body">
      <div>

        <ul class="navbar-nav mt-4">
            <hr>
            <li class="nav-item">
              <a class="nav-link white-link" aria-current="page" href="{{ route('welcome') }}">главная</a>
            </li>
            <li class="nav-item">
              <a class="nav-link white-link" aria-current="page" href="{{ route('contact') }}">контакты</a>
            </li>
            @guest
            <hr>
              <li class="nav-item">
              <a class="nav-link white-link" href="{{ route('login') }}">авторизация</a>
            </li>
            <li class="nav-item">
              <a class="nav-link white-link" href="{{ route('reg') }}">регистрация</a>
            </li>
            @endguest

        </ul>
        @auth
        <ul class="navbar-nav mt-4">
            <hr>
            <li class="nav-item">
              <a class="nav-link white-link" aria-current="page" href="{{ route('my_ticket') }}">мои билеты</a>
            </li>
            <li class="nav-item">
              <a class="nav-link white-link" href="{{ route('profile') }}">мой профиль</a>
            </li>
          </ul>
          @if (Illuminate\Support\Facades\Auth::user()->role === 1)
            <ul class="navbar-nav mt-4">
            <hr>
            <li class="nav-item">
              <a class="nav-link white-link" aria-current="page" href="{{ route('control_city') }}">города</a>
            </li>
            <li class="nav-item">
              <a class="nav-link white-link" href="{{ route('control_airport') }}">аэропорты</a>
            </li>
            <li class="nav-item">
              <a class="nav-link white-link" href="{{ route('control_flight') }}">рейсы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link white-link" href="{{ route('control_user') }}">пользователи</a>
            </li>
            <li class="nav-item">
                <a class="nav-link white-link" href="{{ route('control_ticket') }}">билеты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link white-link" href="{{ route('control_seat') }}">места</a>
            </li>
            <li class="nav-item">
                <a class="nav-link white-link" href="{{ route('control_seat_in_plane') }}">места в самолете</a>
            </li>
            <li class="nav-item">
                <a class="nav-link white-link" href="{{ route('control_airplane') }}">самолеты</a>
            </li>

        </ul>
          @endif
          <ul class="navbar-nav mt-4">
            <hr>
            <li class="nav-item">
              <a class="nav-link white-link" aria-current="page" href="{{ route('logout') }}">выход</a>
            </li>
          </ul>
        @endauth
      </div>
      {{-- <div class="dropdown mt-3">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Кнопка раскрывающегося списка
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Действие</a></li>
          <li><a class="dropdown-item" href="#">Другое действие</a></li>
          <li><a class="dropdown-item" href="#">Что-то еще здесь</a></li>
        </ul>
      </div> --}}
    </div>
  </div>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    h5,a{
        color: #FFF;
        font-family: Montserrat;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-decoration: none;
    }
    nav{
        background-color: transparent;
    }
    .offcanvas{
        background: linear-gradient(180deg, #517F97 0%, #012439 100%);
    }
    .nav-link,hr{
        color: white;
    }
    .auth_btn{
        color: white;
        border-radius: 12px;
        border: 1px solid #FFF;
        background-color: none;
        padding: 10px 40px;
        font-size: 16px;
        transition: 0.5s;
    }
    .auth_btn:hover{
        color: #04273C;
        background-color: white;
    }
  </style>
