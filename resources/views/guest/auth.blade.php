@extends('layout.app')
@section('title')
Регистрация
@endsection
@section('content')
<div style="overflow-x:hidden;" class="bg">
<h1 class="bg_text">time<br>totravel</h1>

<div class="row form-block justify-content-center" id="Auth">

    <div :class="message?'alert alert-danger':'d-none'">
    @{{ message }}
    </div>


    <div class="col-3">
        <p class="text-center">Авторизация</p>
        <form class="d-flex mt-5 flex-column" id="auth-form" @submit.prevent="auth">
            <div class="mb-4 d-flex flex-column">
                <label for="phone" class="form-label">Телефон</label>
                <input :class="errors.phone?'is-invalid':''" type="text" id="phone" name="phone">
                <div class="invalid-feedback" v-for="error in errors.phone">
                    @{{ error }}
                </div>
            </div>
            <div class="mb-4 d-flex flex-column">
                <label for="password" class="form-label">Пароль</label>
                <input :class="errors.password?'is-invalid':''" type="password" id="password" name="password">
                <div class="invalid-feedback" v-for="error in errors.password">
                    @{{ error }}
                </div>
            </div>

            <button type="submit" class="btn-send align-self-center">войти</button>
        </form>
    </div>
</div>
</div>
@endsection
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    .bg{
        background: linear-gradient(180deg, #517F97 0%, #012439 100%);
        height: 100%;
        /* background-image: url({{ asset('public/images/guest_img.jpg') }});
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh; */
    }
    .bg_text{
        position: fixed;
        left: 0;
        bottom: 0;
        color: rgba(175, 178, 191, 0.20);
        font-family: Syncopate;
        font-size: 150px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .invalid-feedback{
        background-color: rgb(241, 117, 117);
        color: white !important;
        padding: 10px;
        border-radius: 8px;
    }
    .is-invalid{
        border-color: rgb(241, 117, 117);
    }
    .form-block{
        /* padding-top: 100px; */
        position: relative;
        top: 30%;

    }
    p{
        color: #FFF;
        font-family: Montserrat;
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-bottom: 32px;
    }
    input{
        border-radius: 10px;
        border: 1px solid #FFF;
        background: transparent;
        height: 40px;
        padding: 10px;
        color: white;
    }
    input:focus{
        color: white;
        outline: none;
        }

    label{
        color: #FFF;
        font-family: Montserrat;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .btn-send{
        color: white;
        border-radius: 12px;
        border: 1px solid #FFF;
        background: none;
        padding: 10px 40px;
        font-size: 16px;
        transition: 0.5s;
    }
    .btn-send:hover{
        color: #04273C;
        background-color: white;
    }
</style>
<script>
    const app = {
        data(){
            return{
                errors:[],
                message:''
            }
        },
        methods:{
            async auth(){
                let form = document.getElementById('auth-form')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('auth') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body:form_data
                })
                if(response.status === 404){
                    this.errors = await response.json()
                    setTimeout(() => {
                        this.errors = []
                    }, 2000);
                }
                if(response.status === 400){
                    this.message = await response.json()
                }
                if(response.status===200){
                    window.location = response.url
                }
            }
        }
    }
    setTimeout(() => {
        Vue.createApp(app).mount('#Auth')
    }, 100);
</script>
