@extends('layout.app')
@section('title')
Airlines - Выбор места
@endsection
@section('content')
<div style="margin-top: 150px" class="container" id="Detail">
    <div class="row">
        <div :class="message?'alert alert-success':'d-none'">
            @{{ message }}
            </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="row mb-3">
                <h1>@{{ this.pageTitle }}</h1>
            </div>

                <div class="col-7">
                    <div class="fly-card mr-1">
                        <div class="fly-header row d-flex justify-content-between">

                                <div class="col-4">
                                    <p>@{{ this.airplane.name}}</p>
                                </div>
                                <div class="col-8">
                                <div class="d-flex align-items-start justify-content-around">
                                    <p class="bold">@{{ this.city_start }}</p>
                                    <img class="mt-2" src="{{ asset('public\images\arrow roght.svg') }}">
                                    <p class="bold">@{{ this.city_finish }}</p>
                                </div>

                            </div>



                        </div>
                        <hr class="hr-dark">
                        <div class="fly-body">
                            <div class="row align-items-start justify-content-between align-items-end">
                                <div class="col-4 d-flex flex-column ">
                                    <p>@{{ this.city_start }}</p>
                                    {{-- <p>@{{ (this.airports.filter(el=>el.id === fly.airport_start_id))[0].title }}</p> --}}
                                    <p>@{{ this.date_start }}</p>
                                    <p style="font-size: 25px">@{{ this.time_start }}</p>
                                </div>
                                <div class="col-3 d-flex align-items-center flex-column">
                                    <p class="text-center">@{{ this.time_in_air }} минут</p>
                                </div>
                                <div class="col-4 d-flex flex-column">
                                    <p>@{{ this.city_finish }}</p>
                                    {{-- <p>@{{ (this.airports.filter(el=>el.id === fly.airport_finish_id))[0].title }}</p> --}}
                                    <p>@{{ this.date_finish }}</p>
                                    <p style="font-size: 25px">@{{ this.time_finish }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="pageTitle == 'Регистрация на рейс'" class="mt-5">
                        <div class="row mb-2">
                            <div class="col-6">Номер Вашего места:</div>
                            <div class="col-6 bold">
                                @{{ this.selectedSeat.number }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Номер Вашего рейса:</div>
                            <div class="col-6 bold">
                                @{{ this.fly.id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">Стоимость билета:</div>
                            <div class="col-6 bold">
                                @{{ this.selectedSeat.cost + this.selectedSeat.cost*(this.fly.overprice/100) }} рублей
                            </div>
                        </div>
                    </div>
                </div>


        </div>
        <div class="col-6 ">
            <div v-if="pageTitle == 'Выбор места'" class="">
            <p>Выберите посадочное место:</p>
            <div class="d-flex flex-wrap justufy-content-between">
                <div class="m-1" v-for="seat in seats">
                <div :id="`seat_${seat.id}`" class="seat-box disabled d-flex justify-content-center align-items-center" v-if="seat.status != 'свободно'"><span>@{{ seat.seat.number }}</span></div>
                <div :id="`seat_${seat.id}`" @click="selectSeat(seat.id)" class="seat seat-box d-flex justify-content-center align-items-center" v-else><span>@{{ seat.seat.number }}</span></div>
            </div>
            </div>
            <div class="row mt-5">
                <div class="col-4 d-flex">
                    <div class="free"></div>
                    <p>свободно</p>
                </div>
                <div class="col-4 d-flex">
                    <div class="selected"></div>
                    <p>выбрано Вами</p>
                </div>
                <div class="col-4 d-flex">
                    <div class="block"></div>
                    <p>занято</p>
                </div>
            </div>

        </div>
            <div v-if="pageTitle == 'Регистрация на рейс'">
                <p>Заполните личные данные для покупки и оформления билета<br>
                <span class="bold">ВНИМАНИЕ!</span> Если вы покупаете билет не для себя, введите данные человека, на которого оформляете билет</p>
                    <form @submit.prevent="send" method="post" id="reg-form">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="ФИО" name="fio" :class="errors.fio?'is-invalid':''">
                        <div class="invalid-feedback" v-for="error in errors.fio">
                            @{{ error }}
                          </div>
                        </div>
                        <div class="mb-3">
                            <label class="label-control">Дата рождения</label>
                           <input type="date" class="form-control" placeholder="дата рождения" name="birthday" :class="errors.birthday?'is-invalid':''">
                        <div class="invalid-feedback" v-for="error in errors.birthday">
                            @{{ error }}
                          </div>
                        </div>

                        <input type="text" class="form-control mb-3" placeholder="серия и номер паспорта" name="passport_data">
                        <input type="text" class="form-control" placeholder="номер сведительства о рождении" name="birth_certificate" >
                        <div style="font-style: italic" class="form-text mb-3">*eсли билет оформляется для ребёнка</div>

                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="введите пароль" name="password" :class="errors.password?'is-invalid':''">
                        <div class="invalid-feedback" v-for="error in errors.password">
                            @{{ error }}
                          </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rule" name="rule" :class="errors.rule?'is-invalid':''">
                            <label style="font-style: italic" class="form-check-label" for="rule">Я знаком с политикой конфиденциальности и даю свое согласие на обработку персональных данных. </label>
                          </div>
                          <div class="invalid-feedback" v-for="error in errors.rule">
                            @{{ error }}
                          </div>
                        </div>

                        <div class="row" justify-content-center>
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="search-btn bold">оформить</button>
                            </div>
                        </div>
                    </form>
            </div>


    </div>
    </div>
    <div v-if="showCost" class="row mt-5 justify-content-end">
        <div class="col-7">
            <div class="row align-items-center justify-content-between">
                <div class="col-6">
                    <h3 class="bold mr-2">Итоговая стоимость</h3>
                </div>
                <div class="col-5">
                    <span style="font-size: 25px;">@{{ this.selectedSeat.cost + this.selectedSeat.cost*(this.fly.overprice/100) }} рублей</span>
                </div>
            </div>
        <hr class="hr-dark">
        <div class="row justify-content-end">
            <div class="col-4 d-flex justify-content-center">
            <button type="button" @click="changePage()" class="search-btn">перейти к оформлению</button>
            </div>
        </div>
        </div>


    </div>


</div>
@endsection
<script>
    const app = {
        data(){
            return {
                errors:[],
                message:'',

                fly: '',
                cities:[],
                airplanes:[],
                airports:[],

                airplane:'',
                city_start:'',
                city_finish:'',
                date_start:'',
                date_finish:'',
                time_start:'',
                time_finish:'',
                time_in_air:'',
                seats:[],

                selectedSeat:'',
                pageTitle:'Выбор места',
                showCost: false,
            }
        },
        methods:{
            async send(){
                let form = document.getElementById('reg-form')
                let form_data = new FormData(form)
                form_data.append('flight_id',this.fly.id)
                form_data.append('airplane_id',this.airplane.id)
                form_data.append('seat_id',this.selectedSeat.id)

                const response = await fetch('{{ route('buy_ticket') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body:form_data
                })
                if(response.status == 200){
                    this.message = await response.json()
                    setTimeout(() => {
                        this.message = ''
                    }, 2000);
                }
                if(response.status == 400){
                    this.errors = await response.json()
                    setTimeout(() => {
                        this.errors = []
                    }, 2000);
                }
                if(response.status == 404){
                    this.message = await response.json()
                    setTimeout(() => {
                        this.message = ''
                    }, 2000);
                }
            },
            async getData(){
                const response_flight = await fetch('{{ route('get_flight') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json',
                    },
                    body:JSON.stringify({
                        id:{{ $id }}
                    })
                })
                this.fly = await response_flight.json()
                const response_airplane = await fetch('{{ route('get_airplane') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json',
                    },
                    body:JSON.stringify({
                        id:this.fly.airplane_id
                    })
                })

                const response_city = await fetch('{{ route('get_catalog_city') }}')
                const response_airport = await fetch('{{ route('get_catalog_airport') }}')

                this.cities = await response_city.json()
                this.airplane = await response_airplane.json()
                this.airports = await response_airport.json()
                this.seats = this.airplane.seatinplanes
                console.log(this.seats)

                // this.airplane = (this.airplanes.filter(el=>el.id === this.fly.airplane_id))[0].name
                this.city_start = (this.cities.filter(el=>el.id === this.fly.city_start_id))[0].title
                this.city_finish = (this.cities.filter(el=>el.id === this.fly.city_finish_id))[0].title
                this.date_start = this.fly.date_start.split(' ')[0].split("-").reverse().join(".")
                this.date_finish = this.fly.date_finish.split(' ')[0].split("-").reverse().join(".")
                this.time_start = this.fly.date_start.split(' ')[1].slice(0,5)
                this.time_finish = this.fly.date_finish.split(' ')[1].slice(0,5)
                this.time_in_air = (this.fly.time_in_air)/60


            },
            selectSeat(id){
                let btns = document.querySelectorAll('.seat')
                for(elem of btns){
                    elem.classList.remove('choosen')
                    elem.classList.add('seat-box')
                }
                let btn_el = document.getElementById('seat_'+id)

                btn_el.classList.toggle('choosen')
                btn_el.classList.toggle('seat-box')
                let btn = this.seats.filter(el=>el.id==id)[0]
                this.selectedSeat = {
                    'id':btn.id,
                    'number':btn.seat.number,
                    'cost':btn.seat.cost
                }
                console.log(this.selectedSeat)
                this.showCost = true
            },
            changePage(){
                this.pageTitle = 'Регистрация на рейс'
                this.showCost = false
            }
        },
        mounted(){
            console.log('mount')
            this.getData()

        }
    }
    setTimeout(() => {
        Vue.createApp(app).mount('#Detail')
    }, 500);
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    .display{
        width: 100%;
        background: linear-gradient(90deg, #517F97 6.11%, #012439 93.44%);
    }
    p,h2,h5,h3{
        color: #04273C !important;
        font-family: Montserrat !important;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    span{
        font-family: Montserrat !important;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .hr-dark{
        color: #04273C;
    }
    .white-link{
      color: white !important;
    }

    .fly-card{
        border-radius: 33px;
        border: 2px solid #04273C;
        padding: 41px;
        height: 250px;
    }
    .bold{
        font-weight: 700;
    }
    .search-btn{
        border-radius: 4px;
        background: #04273C;
        color: white;
        padding: 8px 10px;
        transition: 0.5s;
        font-size: 14px;

    }
    .seat-box{
        width: 40px;
        height: 40px;
        border-radius: 10px;
        color: #04273C;
        border: 1px solid #04273C;
        transition: 0.5s;
    }
    .disabled{
        background: #D9D9D9;
        color: #04273C;
        border: none;
    }
    .free{
        border-radius: 1px;
        border: 1px solid #04273C;
        width: 20px;
        height: 20px;
        background: #FFF;
    }
    .selected{
        border-radius: 1px;
        border: 1px solid #04273C;
        width: 20px;
        height: 20px;
        background: #04273C;
    }
    .block{
        border-radius: 1px;
        border: 1px solid #D9D9D9;
        width: 20px;
        height: 20px;
        background: #D9D9D9;
    }
    .choosen{
        border-radius: 10px;
        border: 1px solid #04273C;
        background: #04273C;
        color: white !important;
        width: 40px;
        height: 40px;
        transition: 0.5s;
    }

</style>
