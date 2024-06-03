@extends('layout.app')
@section('title')
Airlines - Time To Travel
@endsection
@section('content')
<div class="" id="Welcome">
    <div class="bg">
    <div class="search-block container">

            <form @submit.prevent="search" id="form-search" class="row m-2 align-items-end justify-content-center">
                @csrf
                @method('post')
            <div class="col-3 d-flex flex-column align-items-start">
                <label for="city_start" class="form-label">откуда</label>
                <input type="text" class="form-control" id="city_start" name="city_start">
            </div>
            <div class="col-3 d-flex flex-column align-items-start">
                <label for="city_finish" class="form-label">куда</label>
                <input type="text" class="form-control" id="city_finish" name="city_finish">
            </div>
            <div class="col-3 d-flex flex-column align-items-start">
                <label for="date_start" class="form-label">когда</label>
                <input type="date" class="form-control" id="date_start" name="date_start">
            </div>
            <div class="col-3 d-flex justify-content-center">
                <button type="submit" class="search-btn">найти</button>
            </div>
            </form>
    </div>
    </div>
    <section class="popular-direction container">

        <div class="row">
            <div v-for="el in popular" style="height: 400px; background-size: cover; background-position:center; border-radius:16px; filter: brightness(80%)" class="col-3" :style="'background-image:url(public'+this.cities.filter(elem=>elem.id === el.city_finish_id)[0].img+');'">
                <p class="m-1" style="color: white; text-align:left; filter: brightness(100%);font-size: 35px;">@{{ this.cities.filter(elem=>elem.id === el.city_finish_id)[0].title }}</p>
                {{-- <img :src="'public'+this.cities.filter(elem=>elem.id === el.city_finish_id)[0].img"> --}}
            </div>
            <div style="margin-top: -20px; z-index:3; width:100%; padding:0;">
                <div style="border-radius: 16px; background: #04273C;">
                   <h4 style="color: white;" class="text-center p-3">популярные направления</h4>
                </div>

            </div>
        </div>
    </section>
    <section class="all-direction container">

    <h2 class="mb-5" style="text-align: left">Все рейсы</h2>
    <div class="row">
        <div style="text-align: left" class="col-3">Откуда</div>
        <div style="text-align: left" class="col-3">Куда</div>
        <div style="text-align: left" class="col-3">Дата и время вылета</div>
        <div style="text-align: left" class="col-3">         </div>
    </div>
    <hr style="color: #04273C">
    <div class="row mb-3" v-for="fly in flights">

        <div style="text-align: left" class="col-3">@{{(this.cities.filter(el=>el.id === fly.city_start_id))[0].title }}</div>
        <div style="text-align: left" class="col-3">@{{(this.cities.filter(el=>el.id === fly.city_finish_id))[0].title }}</div>
        <div style="text-align: left" class="col-3">@{{ fly.date_start }}</div>
        @auth
                <div style="text-align: left" class="col-3"><a :href="`{{ route('detail') }}/${fly.id}`" class="btn btn-link">выбрать место</a></div>
        @endauth
    </div>
    </section>

</div>

@endsection
<script>
    const app = {
        data(){
            return {
                flights:[],
                cities:[],
                resp_flights:[],
                popular:[],
            }
        },
        methods:{
            async getData(){
                const response_flight = await fetch('{{ route('get_valid_flights') }}')
                const response_city = await fetch('{{ route('welcome_get_cities') }}')
                const response_popular = await fetch('{{ route('welcome_get_popular') }}')

                this.cities = await response_city.json()
                this.flights = await response_flight.json()
                this.popular = await response_popular.json()

                console.log(this.cities)
                console.log(this.flights)
                console.log(this.popular)

            },
            async search(){
                let form = document.getElementById('form-search')
                let form_data = new FormData(form)

                const req = {
                    city_start:form_data.get('city_start'),
                    city_finish:form_data.get('city_finish'),
                    date_start:form_data.get('date_start')
                }
                // const city_strat =  // 'John'
                // const surname = formData.get('surname');
                console.log(req)
                localStorage.setItem('inputValue', JSON.stringify(req))
                const response = await fetch('{{ route('show_catalog') }}')
                if(response.status==200){
                    window.location = response.url
                }
            }

        },
        mounted(){
            this.getData()
        }

    }
    setTimeout(() => {
        Vue.createApp(app).mount('#Welcome')
    }, 1000);
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    h1{
        font-family: 'Syncopate', sans-serif;
        color: #FFF;
        font-size: 96px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-align: center;
        margin-top: 100px;
    }
    h2,p,div{
        font-family: 'Montserrat', sans-serif;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-align: center;
    }
    .bg{
        background-image: url({{ asset('public/images/welcome_img.jpg') }});
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
        position: relative;
        display:flex;
        justify-content: center;
    }
    .search-block{
        background-color: white;
        padding-top: 15px;
        padding-bottom: 15px;
        border-radius: 16px;
        position: absolute;
        bottom: 80px;

    }
    .search-btn{
        border-radius: 4px;
        background: #04273C;
        color: white;
        padding: 6px 0px;
        width: 190px;
        transition: 0.5s;
    }
    .search-btn:hover{
        background: white;
        color: #04273C;
    }
    section{
        padding: 60px 0;
    }

</style>

