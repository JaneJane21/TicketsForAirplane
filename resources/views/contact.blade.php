@extends('layout.app')
@section('title')
Airlines - Контакты
@endsection
@section('content')
<div style="margin-top: 150px" class="container">
    <div class="row">
        <div class="col-6">
            <div class="contact-info">
            <h2 class="mb-5">Возникли сложности? Свяжитесь с нами</h2>
            <p>Номер для связи: 8-800-555-35-35</p>
            <p>Email: airlines@mail.com</p>
            </div>
        </div>
        <div class="col-6 d-flex justify-content-center">
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A6de9b3ab562f6248d20ab621156913aee428ef8e23c53a2c0c9f6be46fc7c836&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>
    </div>
</div>
@endsection
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    .display{
        width: 100%;
        background: linear-gradient(90deg, #517F97 6.11%, #012439 93.44%);
    }
    p,h2{
        color: #04273C;
        font-family: Montserrat;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .contact-info{
        padding: 40px;
        border-radius: 16px;
        border: 1px solid grey;
    }
</style>

