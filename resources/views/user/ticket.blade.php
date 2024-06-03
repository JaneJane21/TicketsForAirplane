@extends('layout.app')
@section('title')
Airlines - Мои билеты
@endsection
@section('content')
<div class="container" style="margin-top: 150px" id="My-Ticket">
    <div class="row mb-5">
        <h1>Мои билеты</h1>
    </div>
    <div class="row mb-5">
        <div class="col-4">
            <select v-model="selectedSort" name="city" class="form-control" @change="sortTicket">
                <option disabled selected value="">Сортировать по</option>
                <option value="date_start">дате вылета</option>
                <option value="date_finish">дате прилета</option>
            </select>
        </div>
        <div class="col-4">
            <select v-model="selectedFilter" name="city" class="form-control" @change="filterTicket">
                <option disabled selected value="">Фильтр статуса</option>
                <option value="бронь">бронь</option>
                <option value="отменен">отменен</option>
                <option value="использован">использован</option>
            </select>
        </div>

    </div>
    <div class="row mb-3" v-for="ticket in tickets">
        <div class="col-5">
            <div class="fly-card">
                <div class="fly-header row d-flex justify-content-between">

                        <div class="col-4">
                            <p>@{{ ticket.flight.airplane.name }}</p>
                        </div>
                        <div class="col-8">
                        <div class="d-flex align-items-start justify-content-around">
                            <p class="bold">@{{ (this.cities.filter(el=>el.id === ticket.flight.city_start_id))[0].title }}</p>
                            <img class="mt-2" src="{{ asset('public\images\arrow roght.svg') }}">
                            <p class="bold">@{{ (this.cities.filter(el=>el.id === ticket.flight.city_finish_id))[0].title }}</p>
                        </div>

                    </div>



                </div>
                <hr class="hr-dark">
                <div class="fly-body">
                    <div class="row align-items-start justify-content-between align-items-end">
                        <div class="col-4 d-flex flex-column ">
                            <p>@{{ (this.cities.filter(el=>el.id === ticket.flight.city_start_id))[0].title }}</p>
                            <p style="font-size: 10px;">@{{ (this.airports.filter(el=>el.id === ticket.flight.airport_start_id))[0].title }}</p>
                            {{-- <p>@{{ (this.airports.filter(el=>el.id === fly.airport_start_id))[0].title }}</p> --}}
                            <p>@{{ ticket.flight.date_start.split(' ')[0].split("-").reverse().join(".") }}</p>
                            <p style="font-size: 25px">@{{ ticket.flight.date_start.split(' ')[1].slice(0,5) }}</p>
                        </div>
                        <div class="col-3 d-flex align-items-center flex-column">
                            <p class="text-center">@{{ ( ticket.flight.time_in_air)/60 }} минут</p>
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <p>@{{ (this.cities.filter(el=>el.id === ticket.flight.city_finish_id))[0].title }}</p>
                            <p style="font-size: 10px;">@{{ (this.airports.filter(el=>el.id === ticket.flight.airport_finish_id))[0].title }}</p>
                            {{-- <p>@{{ (this.airports.filter(el=>el.id === fly.airport_finish_id))[0].title }}</p> --}}
                            <p>@{{  ticket.flight.date_finish.split(' ')[0].split("-").reverse().join(".") }}</p>
                            <p style="font-size: 25px">@{{  ticket.flight.date_finish.split(' ')[1].slice(0,5) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="fly-card flex-column justify-content-around">
                <div class="row mb-3">
                    <div class="row">
                        <div class="col-8">
                            <p>Номер места:</p>
                        </div>
                        <div class="col-4">
                            <p class="bold">@{{ ticket.seat_in_plane.seat.number }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p>Статус рейса:</p>
                        </div>
                        <div class="col-4">
                            <p class="bold">@{{ ticket.flight.status }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p>Статус билета:</p>
                        </div>
                        <div class="col-4">
                            <p class="bold">@{{ ticket.status }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p>Билет на имя:</p>
                        </div>
                        <div class="col-4">
                            <p class="bold">@{{ ticket.fio }}</p>
                        </div>
                    </div>

                </div>

                    <div v-if="ticket.status == 'бронь'" class="row justify-content-center">
                    <div class="col-9 d-flex justify-content-center">
                        <a :href="`{{ route('cancel_ticket') }}/${ticket.id}`" class="search-btn">отменить бронь</a>
                    </div>

                    </div>
                

            </div>
        </div>
    </div>
</div>
@endsection
<script>
    const app = {
        data(){
            return{
                cities:[],
                tickets:[],
                airports:[],

                selectedSort:'',
                selectedFilter:'',
            }
        },
        methods:{
            async getData(){
                const response_ticket = await fetch('{{ route('get_user_ticket') }}')
                const response_city = await fetch('{{ route('get_catalog_city') }}')
                const response_airport = await fetch('{{ route('get_user_airport') }}')

                this.cities = await response_city.json()
                this.tickets = await response_ticket.json()
                this.airports = await response_airport.json()
                console.log(this.airports)
                console.log(this.tickets)

            }
        },
        computed:{
            async sortTicket(selectedSort){
                if(this.selectedSort){
                    const response = await fetch('{{ route('sort_tickets') }}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                            'Content-Type':'application/json',
                        },
                        body: JSON.stringify(this.selectedSort)
                    })
                    if(response.status == 200){

                        this.tickets = await response.json()
                        console.log(this.tickets)
                    }
                    return this.tickets
                    // return [...this.tickets].sort((t1,t2) => t1.flight[this.selectedSort]?.localeCompare(t2.flight[this.selectedSort]))
                }
                else{
                    return this.tickets
                }

            },
            async filterTicket(selectedFilter){
                if(this.selectedFilter){
                    const response = await fetch('{{ route('filter_tickets') }}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                            'Content-Type':'application/json',
                        },
                        body: JSON.stringify(this.selectedFilter)
                    })
                    if(response.status == 200){

                        this.tickets = await response.json()
                        console.log(this.tickets)
                    }
                    return this.tickets
                }
                else{
                    return this.tickets
                }
            }

        },
        mounted(){
            this.getData()
        }
    }
    setTimeout(() => {
        Vue.createApp(app).mount('#My-Ticket')
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
        font-size: 14px;
    }
    .hr-dark{
        color: #04273C;
        margin: 0;
    }
    .white-link{
      color: white !important;
    }

    .fly-card{
        border-radius: 33px;
        border: 2px solid #04273C;
        padding: 30px;
        height: 300px;
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
