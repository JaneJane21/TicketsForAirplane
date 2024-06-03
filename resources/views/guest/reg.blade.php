@extends('layout.app')
@section('title')
Регистрация
@endsection
@section('content')
<div style="overflow-x:hidden;" class="bg">
<h1 class="bg_text">time<br>totravel</h1>

<div class="row form-block justify-content-center" id="Registration">
    <div class="col-6">
        <p class="text-center">Регистрация</p>
        <form class="d-flex mt-5 flex-column" id="reg-form" @submit.prevent="send_data">
            <div class="row mb-5">
                <div class="col-4">
                   <div class="d-flex flex-column">
                    <label for="fio" class="form-label">Фамилия Имя Отчество</label>
                    <input :class="errors.fio?'is-invalid':''" type="text" id="fio" name="fio">
                    <div class="invalid-feedback" v-for="error in errors.fio">
                        @{{ error }}
                    </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="phone" class="form-label">Телефон</label>
                     <input :class="errors.phone?'is-invalid':''" type="text" id="phone" name="phone">
                     <div class="invalid-feedback" v-for="error in errors.phone">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
                 <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="birthday" class="form-label">Дата рождения</label>
                     <input :class="errors.birthday?'is-invalid':''" style="background: transparent"  type="date" id="birthday" name="birthday">
                     <div class="invalid-feedback" v-for="error in errors.birthday">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
            </div>
            <div class="row mb-5">
                <div class="col-4">
                   <div class="d-flex flex-column">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" :class="errors.email?'is-invalid':''" id="email" name="email">
                    <div class="invalid-feedback" v-for="error in errors.email">
                        @{{ error }}
                    </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="password" class="form-label">Пароль</label>
                     <input type="password" :class="errors.password?'is-invalid':''" id="password" name="password">
                     <div class="invalid-feedback" v-for="error in errors.password">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
                 <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="password_confirmation" class="form-label">Повторите пароль</label>
                     <input type="password" :class="errors.password?'is-invalid':''" id="password_confirmation" name="password_confirmation">
                     <div class="invalid-feedback" v-for="error in errors.password">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
            </div>
            <div class="row mb-5">
                <div class="col-12 ">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" :class="errors.rule?'is-invalid':''" class="form-check-input" style="margin-right: 10px; margin-top:0px;" id="rule" name="rule">
                        <label for="rule" class="form-check-label">Согласен(-на) с правилами регистрации</label>
                        <div class="invalid-feedback" v-for="error in errors.rule">
                            @{{ error }}
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-send align-self-center">зарегистрироваться</button>
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
    .form-block{
        /* padding-top: 100px; */
        position: relative;
        top: 30%;

    }
    .invalid-feedback{
        background-color: rgb(241, 117, 117);
        color: white !important;
        padding: 10px;
        border-radius: 8px;
    }
    p{
        color: #FFF;
        font-family: Montserrat;
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .is-invalid{
        border-color: rgb(241, 117, 117);
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
                message:'',
                errors:[],
            }
        },
        methods:{
            async send_data(){
                let form = document.getElementById('reg-form')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('save_user') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body:form_data
                })
                if (response.status === 400){
                this.errors = await response.json();
                setTimeout(() => {
                    this.errors = []
                }, 5000);
                }
                if(response.status === 200){
                    window.location = response.url
                }
            }

        }
    }
    setTimeout(() => {
        Vue.createApp(app).mount('#Registration')
    }, 100);

</script>
