@extends('layout.app')
@section('title')
Airlines - Рейсы
@endsection
@section('content')
<div style="margin-top: 150px" class="container" id="Catalog">
    <div class="row">
        <div class="col-3">
            <div class="row mb-3">
                <h3>Фильтры</h3>
            </div>
            <form @submit.prevent="filterFlight" id='search-form'>
                <div class="row mb-4">
                    <div class="col-6">
                        <select v-model="select_city_start" name="city_start_id" class="form-control">
                            <option disabled selected value="">город вылета</option>
                            <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <select v-model="select_city_finish" name="city_finish_id" class="form-control">
                            <option disabled selected value="">город прилета</option>
                            <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <p>Наценка</p>
                    <div class="col-6">
                        <input class="form-control" v-model="select_overprice_start" placeholder="от" name="price_start" id="price_start">
                    </div>
                    <div class="col-6">
                        <input class="form-control" v-model="select_overprice_finish" placeholder="до" name="price_finish" id="price_finish">
                    </div>
                </div>
                {{-- <div class="row justify-content-center">
                    <div class="col-8">
                        <button type="button" @click="filterFlight" class="btn btn-outline-success">применить</button>
                    </div>
                </div> --}}

            </form>
        </div>
        <div class="col-9">
            <div class="row mb-3">
                <h1>Рейсы</h1>
            </div>
            <div v-for="fly in filterFlight" v-if="flights.length != 0" class="row mb-3">
                <div class="col-7">
                    <div class="fly-card mr-1">
                        <div class="fly-header row d-flex justify-content-between">

                                <div class="col-4">
                                    <p>@{{ fly.airplane.name }}</p>
                                </div>
                                <div class="col-8">
                                <div class="d-flex align-items-start justify-content-around">
                                    <p class="bold">@{{ (this.cities.filter(el=>el.id === fly.city_start_id))[0].title }}</p>
                                    <img class="mt-2" src="{{ asset('public\images\arrow roght.svg') }}">
                                    <p class="bold">@{{ (this.cities.filter(el=>el.id === fly.city_finish_id))[0].title }}</p>
                                </div>

                            </div>



                        </div>
                        <hr class="hr-dark">
                        <div class="fly-body">
                            <div class="row align-items-start justify-content-between align-items-end">
                                <div class="col-4 d-flex flex-column ">
                                    <p>@{{ (this.cities.filter(el=>el.id === fly.city_start_id))[0].title }}</p>
                                    {{-- <p>@{{ (this.airports.filter(el=>el.id === fly.airport_start_id))[0].title }}</p> --}}
                                    <p>@{{ fly.date_start.split(' ')[0].split("-").reverse().join(".") }}</p>
                                    <p style="font-size: 25px">@{{ fly.date_start.split(' ')[1].slice(0,5) }}</p>
                                </div>
                                <div class="col-3 d-flex align-items-center flex-column">
                                    <p class="text-center">@{{ (fly.time_in_air)/60 }} минут</p>
                                </div>
                                <div class="col-4 d-flex flex-column">
                                    <p>   @{{ (this.cities.filter(el=>el.id === fly.city_finish_id))[0].title }}</p>
                                    {{-- <p>@{{ (this.airports.filter(el=>el.id === fly.airport_finish_id))[0].title }}</p> --}}
                                    <p>@{{ fly.date_finish.split(' ')[0].split("-").reverse().join(".") }}</p>
                                    <p style="font-size: 25px">@{{ fly.date_finish.split(' ')[1].slice(0,5) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="fly-card flex-column justify-content-between">
                        <div class="row mb-5">
                            <div class="row">
                                <div class="col-10">
                                    <p>Наценка рейса:</p>
                                </div>
                                <div class="col-2">
                                    <p class="bold">@{{ fly.overprice }}</p>
                                </div>
                            </div>

                        </div>
                        @auth
                            <div class="row justify-content-center">
                            <div class="col-9 d-flex justify-content-center">
                                <a :href="`{{ route('detail') }}/${fly.id}`" class="search-btn">выбрать место</a>
                            </div>

                            </div>
                        @endauth

                    </div>
                </div>
            </div>
            <div class="row" v-else>
                <h1>По Вашему запросу ничего не найдено</h1>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    const app = {
        data(){
            return {
                flights:[],
                cities:[],
                airplanes:[],
                airports:[],

                select_overprice_start:'',
                select_overprice_finish:'',
                select_city_start:'',
                select_city_finish:'',
            }
        },
        methods:{
            async getData(){
                let req = localStorage.getItem('inputValue')

                const response_city = await fetch('{{ route('get_catalog_city') }}')
                const response_airport = await fetch('{{ route('get_catalog_airport') }}')
                const response_airplane = await fetch('{{ route('get_catalog_airplane') }}')
                const response_flights = await fetch('{{ route('get_catalog_flights') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json',
                    },
                    body:req
                })
                this.cities = await response_city.json()
                this.airplanes = await response_airplane.json()
                this.airports = await response_airport.json()
                if(response_flights.status == 200){
                    this.flights = await response_flights.json()
                }
                console.log(this.flights)
            },

            // async filterFlight(){
            //     let form = document.getElementById('search-form')
            //     let form_data = new FormData(form)
            //     form_data.append('flights',JSON.stringify(this.flights))
            //     const response = await fetch('{{ route('filter_flights') }}',{
            //         method:'post',
            //         headers:{
            //             'X-CSRF-TOKEN':'{{ csrf_token() }}',
            //         },
            //         body:form_data
            //     })
            //     if(response.status == 200){
            //         this.flights = await response.json()
            //     }
            // }
        },
        computed:{
            filterFlight(){
                let res = this.flights
                if(this.select_overprice_start || this.select_overprice_finish || this.select_city_start || this.select_city_finish){

                    if(this.select_city_start){

                    res = res.filter((fly) => fly.city_start_id == this.select_city_start)
                    }
                    if(this.select_city_finish){

                        res = res.filter((fly) => fly.city_finish_id == this.select_city_finish)
                    }
                    if(this.select_overprice_start){

                        res = (res.filter((fly) => fly.overprice >= this.select_overprice_start))

                    }
                    if(this.select_overprice_finish){

                        res = res.filter((fly) => fly.overprice <= this.select_overprice_finish)
                    }
                }
                return res
            }
        },
        mounted(){

            // console.log(req)
            this.getData()

        }
    }
    setTimeout(() => {
        Vue.createApp(app).mount('#Catalog')
    }, 500);
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    .display{
        width: 100%;
        background: linear-gradient(90deg, #517F97 6.11%, #012439 93.44%);
    }
    p,h2,h5{
        color: #04273C !important;
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
</style>
