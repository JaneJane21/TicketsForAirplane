@extends('layout.app')
@section('title')
Airlines - Профиль пассажира
@endsection
@section('content')
<div class="container" style="margin-top: 150px" id="Profile">
<div class="row justify-content-between">
    <h1 class="mb-5">Профиль пассажира</h1>
    <div class="col-6">
        <form @submit.prevent="edit_user({{ $user->id }})" :id="'form-edit-user-'+{{ $user->id }}">
            <div class="row mb-5">
                <div class="col-4">
                   <div class="d-flex flex-column">
                    <label for="fio_edit" class="form-label">ФИО</label>
                    <input value="{{ $user->fio }}" class="form-control" :class="errors.fio?'is-invalid':''" type="text" id="fio_edit" name="fio">
                    <div class="invalid-feedback" v-for="error in errors.fio">
                        @{{ error }}
                    </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="phone_edit" class="form-label">Телефон</label>
                     <input value="{{ $user->phone }}" class="form-control" :class="errors.phone?'is-invalid':''" type="text" id="phone_edit" name="phone">
                     <div class="invalid-feedback" v-for="error in errors.phone">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
                 <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="birthday_edit" class="form-label">Дата рождения</label>
                     <input value="{{ $user->birthday }}" class="form-control" :class="errors.birthday?'is-invalid':''" style="background: transparent"  type="date" id="birthday_edit" name="birthday">
                     <div class="invalid-feedback" v-for="error in errors.birthday">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
            </div>
            <div class="row mb-5">
                <div class="col-4">
                   <div class="d-flex flex-column">
                    <label for="email_edit" class="form-label">Email</label>
                    <input value="{{ $user->email }}" class="form-control" type="email" :class="errors.email?'is-invalid':''" id="email_edit" name="email">
                    <div class="invalid-feedback" v-for="error in errors.email">
                        @{{ error }}
                    </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="password_edit" class="form-label">Пароль</label>
                     <input class="form-control" type="password" :class="errors.password?'is-invalid':''" id="password_edit" name="password">
                     <div class="invalid-feedback" v-for="error in errors.password">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
                 <div class="col-4">
                    <div class="d-flex flex-column">
                     <label for="password_confirmation" class="form-label">Повторите пароль</label>
                     <input class="form-control" type="password" :class="errors.password?'is-invalid':''" id="password_confirmation" name="password_confirmation">
                     <div class="invalid-feedback" v-for="error in errors.password">
                        @{{ error }}
                    </div>
                     </div>
                 </div>
            </div>
            <button type="submit" class="btn btn-success align-self-center">Сохранить изменения</button>
          </form>
    </div>
    <div class="col-4">
        <a class="btn btn-danger" href="{{ route('block_data') }}">Отозвать персональные данные</a>
    </div>
</div>
</div>
@endsection
<script>
    const app = {
        data(){
            return{
                user: '',
                errors:[],
                message:''
            }
        },
        methods:{
            async edit_user(id){
                let form = document.getElementById('form-edit-user-'+id)
                let form_data = new FormData(form)
                form_data.append('id',id)
                form_data.append('flag','admin')
                const response = await fetch('{{ route('user_edit') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body:form_data
                })
                if(response.status === 200){
                    this.getData()
                    this.message = await response.json()
                    setTimeout(() => {
                        this.message = ''
                    }, 2000);
                    form.reset()
                }
                if(response.status === 400){
                    this.errors = await response.json()
                    setTimeout(() => {
                        this.errors = []
                    }, 2000);
                }

            },
        }

    }
    setTimeout(() => {
        Vue.createApp(app).mount('#Profile')
    }, 500);
</script>
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
</style>
