@extends('layout.app')
@section('title')
Airlines Управление
@endsection
@section('content')
<div style="margin-top: 150px;" class="container" id="Control">
    <div class="row">
        <div :class="message?'alert alert-success':'d-none'">
            @{{ message }}
            </div>
    </div>
    <div class="row mb-5">
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a @click="openTab('city')" id="nav-city" class="nav-link active" aria-current="page" href="#">Города</a>
            </li>
            <li class="nav-item">
              <a @click="openTab('airplane')" id="nav-airplane" class="nav-link" href="#">Самолеты</a>
            </li>
            <li class="nav-item">
              <a @click="openTab('airport')" id="nav-airport" class="nav-link" href="#">Аэропорты</a>
            </li>
            <li class="nav-item">
                <a @click="openTab('seat')" id="nav-seat" class="nav-link" href="#">Места</a>
            </li>
            <li class="nav-item">
                <a @click="openTab('seat_in_plane')" id="nav-seat_in_plane" class="nav-link" href="#">Места в самолете</a>
            </li>
            <li class="nav-item">
                <a @click="openTab('flight')" id="nav-flight" class="nav-link" href="#">Рейсы</a>
            </li>
            <li class="nav-item">
                <a @click="openTab('ticket')" id="nav-ticket" class="nav-link" href="#">Билеты</a>
            </li>
            <li class="nav-item">
                <a @click="openTab('user')" id="nav-user" class="nav-link" href="#">Пользователи</a>
            </li>

          </ul>
    </div>
    <div id="city" class="row control-page">
        <div class="row">
            <div class="col-6">
                <h3>Доступные города</h3>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-6">
                <div class="accordion" id="accordion1">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                          Добавить новый город
                        </button>
                      </h2>
                      <div id="collapseOne1" class="accordion-collapse collapse" data-bs-parent="#accordion1">
                        <div class="accordion-body">
                            <form @submit.prevent="store_city" id="form-city" enctype="multipart/form-data">
                                <div class="mb-3">
                                  <label for="title" class="form-label">Город</label>
                                  <input type="text" class="form-control" id="title" name="title" :class="errors.title?'is-invalid':''">
                                  <div class="invalid-feedback" v-for="error in errors.title">
                                    @{{ error }}
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="img" class="form-label">Изображение</label>
                                  <input type="file" class="form-control" id="img" name="img" :class="errors.img?'is-invalid':''">
                                  <div class="invalid-feedback" v-for="error in errors.img">
                                    @{{ error }}
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                              </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Изображение</th>
                    <th scope="col">Действия</th>

                  </tr>
                </thead>
                <tbody>
                  <tr v-for="city in cities">
                    <th scope="row">@{{ city.id }}</th>
                    <td>@{{ city.title }}</td>
                    <td style="width: 300px;"><img class="img-fluid" style="object-fit: cover" :src="'/public'+city.img"></td>
                    <td>
                      <div class="row">
                        <div class="col-3">
                          <a class="btn btn-outline-danger" :href="`{{ route('city_destroy') }}/${city.id}`">удалить</a>
                        </div>
                        <div class="col-4">
                          <button data-bs-toggle="modal" :data-bs-target="'#editCityModal'+city.id" class="btn btn-outline-primary">изменить</button>
                        </div>

                      </div>
                      <div class="modal fade" :id="'editCityModal'+city.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5">Редактирование @{{ city.title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form @submit.prevent="edit_city(city.id)" :id="'form-edit-city-'+city.id" enctype="multipart/form-data">
                              <div class="mb-3">
                                <label for="title1" class="form-label">Название города</label>
                                <input :value="city.title" type="text" class="form-control" id="title1" name="title" :class="errors.title?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.title">
                                  @{{ error }}
                                </div>

                              </div>
                              <div class="mb-3">
                                <label for="img1" class="form-label">Изображение</label>
                                <input type="file" class="form-control" id="img1" name="img" :class="errors.img?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.img">
                                  @{{ error }}
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary">Сохранить</button>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                    </td>

                  </tr>
                </tbody>
              </table>
        </div>

    </div>
    <div id="airplane" class="row d-none control-page">
        <div class="row">
            <div class="col-6">
                <h3>Доступные самолеты</h3>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-6">
                <div class="accordion" id="accordion2">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                          Добавить новый самолет
                        </button>
                      </h2>
                      <div id="collapseOne2" class="accordion-collapse collapse" data-bs-parent="#accordion2">
                        <div class="accordion-body">
                            <form @submit.prevent="store_airplane" id="form-airplane">
                                <div class="mb-3">
                                  <label  class="form-label">Название</label>
                                  <input type="text" class="form-control"  name="name" :class="errors.name?'is-invalid':''">
                                  <div class="invalid-feedback" v-for="error in errors.name">
                                    @{{ error }}
                                  </div>

                                </div>
                                <div class="mb-3">
                                    <label for="status1" class="form-label">Статус самолета</label>
                                    <input type="text" class="form-control" id="status1" name="status" :class="errors.status?'is-invalid':''">
                                  <div class="invalid-feedback" v-for="error in errors.status">
                                    @{{ error }}
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                              </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Действия</th>

                  </tr>
                </thead>
                <tbody>
                  <tr v-for="airplane in airplanes">
                    <th scope="row">@{{ airplane.id }}</th>
                    <td>@{{ airplane.name }}</td>
                    <td>@{{ airplane.status }}</td>
                    <td>
                      <div class="row">
                        <div class="col-3">
                          <a class="btn btn-outline-danger" :href="`{{ route('airplane_destroy') }}/${airplane.id}`">удалить</a>
                        </div>
                        <div class="col-4">
                          <button data-bs-toggle="modal" :data-bs-target="'#editAirplaneModal'+airplane.id" class="btn btn-outline-primary">изменить</button>
                        </div>

                      </div>
                      <div class="modal fade" :id="'editAirplaneModal'+airplane.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" >Редактирование @{{ airplane.name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form @submit.prevent="edit_airplane(airplane.id)" :id="'form-edit-airplane-'+airplane.id">
                              <div class="mb-3">
                                <label for="name2" class="form-label">Название</label>
                                <input :value="airplane.name" type="text" class="form-control" id="name2" name="name" :class="errors.name?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.name">
                                  @{{ error }}
                                </div>

                              </div>
                              <div class="mb-3">
                                  <label for="status2" class="form-label">Статус самолета</label>
                                  <input :value="airplane.status" type="text" class="form-control" id="status2" name="status" :class="errors.status?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.status">
                                  @{{ error }}
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary">Сохранить</button>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                    </td>

                  </tr>
                </tbody>
              </table>

        </div>
    </div>

    <div id="airport" class="row d-none control-page">
      <div class="row">
          <div class="col-6">
              <h3>Доступные аэропорты</h3>
          </div>
      </div>
      <div class="row mb-5">
          <div class="col-6">
              <div class="accordion" id="accordion3">
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne">
                        Добавить новый аэропорт
                      </button>
                    </h2>
                    <div id="collapseOne3" class="accordion-collapse collapse" data-bs-parent="#accordion3">
                      <div class="accordion-body">
                          <form @submit.prevent="store_airport" id="form-airport">
                              <div class="mb-3">
                                <label for="title3" class="form-label">Название</label>
                                <input type="text" class="form-control" id="title3" name="title" :class="errors.title?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.title">
                                  @{{ error }}
                                </div>
                              </div>
                              <div class="mb-3">
                                  <label for="code" class="form-label">Код аэропорта</label>
                                  <input type="text" class="form-control" id="code" name="code" :class="errors.code?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.code">
                                  @{{ error }}
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="address" class="form-label">Адрес аэропорта</label>
                                <input type="text" class="form-control" id="address" name="address" :class="errors.address?'is-invalid':''">
                              <div class="invalid-feedback" v-for="error in errors.address">
                                @{{ error }}
                              </div>
                            </div>
                              <button type="submit" class="btn btn-primary">Сохранить</button>
                            </form>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Название</th>
                  <th scope="col">Код</th>
                  <th scope="col">Адрес</th>
                  <th scope="col">Действия</th>

                </tr>
              </thead>
              <tbody>
                <tr v-for="airport in airports">
                  <th scope="row">@{{ airport.id }}</th>
                  <td>@{{ airport.title }}</td>
                  <td>@{{ airport.code }}</td>
                  <td>@{{ airport.address }}</td>
                  <td><div class="row">
                    <div class="col-6">
                      <a class="btn btn-outline-danger" :href="`{{ route('airport_destroy') }}/${airport.id}`">удалить</a>
                    </div>
                    <div class="col-6">
                      <button data-bs-toggle="modal" :data-bs-target="'#editAirportModal'+airport.id" class="btn btn-outline-primary">изменить</button>
                    </div>

                  </div>
                  <div class="modal fade" :id="'editAirportModal'+airport.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">Редактирование @{{ airport.title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form @submit.prevent="edit_airport(airport.id)" :id="'form-edit-airport-'+airport.id">
                          <div class="mb-3">
                            <label for="title3" class="form-label">Название</label>
                            <input :value="airport.title" type="text" class="form-control" id="title3" name="title" :class="errors.title?'is-invalid':''">
                            <div class="invalid-feedback" v-for="error in errors.title">
                              @{{ error }}
                            </div>
                          </div>
                          <div class="mb-3">
                              <label for="code3" class="form-label">Код аэропорта</label>
                              <input :value="airport.code" type="text" class="form-control" id="code3" name="code" :class="errors.code?'is-invalid':''">
                            <div class="invalid-feedback" v-for="error in errors.code">
                              @{{ error }}
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="address3" class="form-label">Адрес аэропорта</label>
                            <input type="text" :value="airport.address" class="form-control" id="address3" name="address" :class="errors.address?'is-invalid':''">
                          <div class="invalid-feedback" v-for="error in errors.address">
                            @{{ error }}
                          </div>
                        </div>
                          <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div></td>
                </tr>
              </tbody>
            </table>
      </div>
  </div>
  <div id="user" class="row d-none control-page">
    <div class="row">
        <div class="col-6">
            <h3>Пользователи</h3>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            <div class="accordion" id="accordion4">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                      Добавить нового пользователя
                    </button>
                  </h2>
                  <div id="collapseOne4" class="accordion-collapse collapse" data-bs-parent="#accordion4">
                    <div class="accordion-body">
                        <form class="d-flex mt-5 flex-column" id="form-user" @submit.prevent="store_user">
                            <div class="row mb-5">
                                <div class="col-4">
                                   <div class="d-flex flex-column">
                                    <label for="fio" class="form-label">ФИО</label>
                                    <input class="form-control" :class="errors.fio?'is-invalid':''" type="text" id="fio" name="fio">
                                    <div class="invalid-feedback" v-for="error in errors.fio">
                                        @{{ error }}
                                    </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex flex-column">
                                     <label for="phone" class="form-label">Телефон</label>
                                     <input class="form-control" :class="errors.phone?'is-invalid':''" type="text" id="phone" name="phone">
                                     <div class="invalid-feedback" v-for="error in errors.phone">
                                        @{{ error }}
                                    </div>
                                     </div>
                                 </div>
                                 <div class="col-4">
                                    <div class="d-flex flex-column">
                                     <label for="birthday" class="form-label">Дата рождения</label>
                                     <input class="form-control" :class="errors.birthday?'is-invalid':''" style="background: transparent"  type="date" id="birthday" name="birthday">
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
                                    <input class="form-control" type="email" :class="errors.email?'is-invalid':''" id="email" name="email">
                                    <div class="invalid-feedback" v-for="error in errors.email">
                                        @{{ error }}
                                    </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex flex-column">
                                     <label for="password" class="form-label">Пароль</label>
                                     <input class="form-control" type="password" :class="errors.password?'is-invalid':''" id="password" name="password">
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
                            <button type="submit" class="btn btn-success align-self-center">Сохранить</button>
                            </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Фио</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Email</th>
                <th scope="col">Телефон</th>
                <th scope="col">Действия</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users">
                <th scope="row">@{{ user.id }}</th>
                <td>@{{ user.fio }}</td>
                <td>@{{ user.birthday }}</td>
                <td>@{{ user.email }}</td>
                <td>@{{ user.phone }}</td>
                <td><div class="row">
                  <div class="col-6">
                    <a class="btn btn-outline-danger" :href="`{{ route('user_destroy') }}/${user.id}`">удалить</a>
                  </div>
                  <div class="col-6">
                    <button data-bs-toggle="modal" :data-bs-target="'#editUserModal'+user.id" class="btn btn-outline-primary">изменить</button>
                  </div>

                </div>
                <div class="modal fade" :id="'editUserModal'+user.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" >Редактирование @{{ user.fio }}</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="edit_user(user.id)" :id="'form-edit-user-'+user.id">
                        <div class="row mb-5">
                            <div class="col-4">
                               <div class="d-flex flex-column">
                                <label for="fio_edit" class="form-label">ФИО</label>
                                <input :value="user.fio" class="form-control" :class="errors.fio?'is-invalid':''" type="text" id="fio_edit" name="fio">
                                <div class="invalid-feedback" v-for="error in errors.fio">
                                    @{{ error }}
                                </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-column">
                                 <label for="phone_edit" class="form-label">Телефон</label>
                                 <input :value="user.phone" class="form-control" :class="errors.phone?'is-invalid':''" type="text" id="phone_edit" name="phone">
                                 <div class="invalid-feedback" v-for="error in errors.phone">
                                    @{{ error }}
                                </div>
                                 </div>
                             </div>
                             <div class="col-4">
                                <div class="d-flex flex-column">
                                 <label for="birthday_edit" class="form-label">Дата рождения</label>
                                 <input :value="user.birthday" class="form-control" :class="errors.birthday?'is-invalid':''" style="background: transparent"  type="date" id="birthday_edit" name="birthday">
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
                                <input :value="user.email" class="form-control" type="email" :class="errors.email?'is-invalid':''" id="email_edit" name="email">
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
                        <button type="submit" class="btn btn-success align-self-center">Сохранить</button>
                      </form>
                    </div>

                  </div>
                </div>
              </div></td>
              </tr>
            </tbody>
          </table>
    </div>
</div>
  <div id="seat" class="row control-page">
    <div class="row">
        <div class="col-6">
            <h3>Доступные места</h3>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            <div class="accordion" id="accordion5">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
                      Добавить новое место
                    </button>
                  </h2>
                  <div id="collapseOne5" class="accordion-collapse collapse" data-bs-parent="#accordion5">
                    <div class="accordion-body">
                        <form @submit.prevent="store_seat" id="form-seat">
                            <div class="mb-3">
                              <label for="number" class="form-label">Номер</label>
                              <input type="text" class="form-control" id="number" name="number" :class="errors.number?'is-invalid':''">
                              <div class="invalid-feedback" v-for="error in errors.number">
                                @{{ error }}
                              </div>
                            </div>
                            <div class="mb-3">
                              <label for="cost" class="form-label">Стоимость</label>
                              <input type="text" class="form-control" id="cost" name="cost" :class="errors.cost?'is-invalid':''">
                              <div class="invalid-feedback" v-for="error in errors.cost">
                                @{{ error }}
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                          </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Номер</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Действия</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="seat in seats">
                <th scope="row">@{{ seat.id }}</th>
                <td>@{{ seat.number }}</td>
                <td>@{{ seat.cost }}</td>
                <td>
                  <div class="row">
                    <div class="col-3">
                      <a class="btn btn-outline-danger" :href="`{{ route('seat_destroy') }}/${seat.id}`">удалить</a>
                    </div>
                    <div class="col-4">
                      <button data-bs-toggle="modal" :data-bs-target="'#editSeatModal'+seat.id" class="btn btn-outline-primary">изменить</button>
                    </div>

                  </div>
                  <div class="modal fade" :id="'editSeatModal'+seat.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">Редактирование @{{ seat.number }} места</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form @submit.prevent="edit_seat(seat.id)" :id="'form-edit-seat-'+seat.id">
                            <div class="mb-3">
                              <label for="number4" class="form-label">Номер</label>
                              <input type="text" :value="seat.number" class="form-control" id="number4" name="number" :class="errors.number?'is-invalid':''">
                              <div class="invalid-feedback" v-for="error in errors.number">
                                @{{ error }}
                              </div>
                            </div>
                            <div class="mb-3">
                              <label for="cost4" class="form-label">Стоимость</label>
                              <input type="text" :value="seat.cost" class="form-control" id="cost4" name="cost" :class="errors.cost?'is-invalid':''">
                              <div class="invalid-feedback" v-for="error in errors.cost">
                                @{{ error }}
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                          </form>
                      </div>

                    </div>
                  </div>
                </div>
                </td>

              </tr>
            </tbody>
          </table>
    </div>

</div>

<div id="seat_in_plane" class="row control-page">
    <div class="row">
        <div class="col-6">
            <h3>Доступные места в самолете</h3>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
            <div class="accordion" id="accordion6">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6" aria-expanded="true" aria-controls="collapseOne6">
                      Добавить новое место в самолет
                    </button>
                  </h2>
                  <div id="collapseOne6" class="accordion-collapse collapse" data-bs-parent="#accordion6">
                    <div class="accordion-body">
                        {{-- @submit.prevent="store_seat_in_plane" id="form-seat-in-plane" --}}
                        <form @submit.prevent="store_seat_in_plane" id="form-seat-in-plane">
                            <div class="mb-3">
                              <label for="airplane_id" class="form-label">Выберите самолет</label>
                              <select class="form-control" name="airplane_id" id="airplane_id">
                                <option v-for="airplane in airplanes" :value="airplane.id">@{{ airplane.name }}</option>
                              </select>
                            </div>
                            <div class="mb-3">
                              <label for="cost" class="form-label">Номер места</label>
                                <div class="row" v-for="seat in seats">
                                    <div class="col-2">
                                        <input name="inputSeatsInPlane[]" :value="seat.id" class="form-check-input mr-2" :id="'seat'+seat.id" type="checkbox">
                                        <label class="form-check-label" :for="'seat'+seat.id">@{{ seat.number }}</label>

                                    </div>


                                </div>
                            </div>
                            <div class="invalid-feedback" v-for="error in errors">
                                @{{ error }}
                              </div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                          </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Самолет</th>
                <th scope="col">Место</th>
                <th scope="col">Статус</th>
                <th scope="col">Действия</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="seat in seats_in_plane">
                <th scope="row">@{{ seat.id }}</th>
                <td>@{{ seat.airplane.name }}</td>
                <td>@{{ seat.seat.number }}</td>
                <td>@{{ seat.status }}</td>
                <td>
                  <div class="row">
                    <div class="col-3">
                      <a class="btn btn-outline-danger" :href="`{{ route('seat_in_plane_destroy') }}/${seat.id}`">удалить</a>
                    </div>
                    <div class="col-5">
                        <button data-bs-toggle="modal" data-bs-target="#statusModal" type="button" class="btn btn-outline-info">изменить статус</button>
                      </div>
                      <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5">Смена статуса места @{{ seat.seat.number }} в самолете @{{ seat.airplane.name }}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form @submit.prevent="edit_seat_in_plane(seat.id)" :id="'form-edit-seat-in-plane-'+seat.id">
                                <label for="status6" class="label-control mb-3">Введите статус места</label>
                                <input class="form-control mb-3" :value="seat.status" name="status" id="status6" :class="errors.status?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.status">
                                    @{{ error }}
                                  </div>
                                <button type="submit" class="btn btn-outline-success">Сохранить</button>
                              </form>
                            </div>

                          </div>
                        </div>
                      </div>

                  </div>

                </td>

              </tr>
            </tbody>
          </table>
    </div>


</div>

<div id="flight" class="row control-page">
    <div class="row">
        <div class="col-6">
            <h3>Доступные рейсы</h3>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-8">
            <div class="accordion" id="accordion7">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne7" aria-expanded="true" aria-controls="collapseOne7">
                      Добавить новый рейс
                    </button>
                  </h2>
                  <div id="collapseOne7" class="accordion-collapse collapse" data-bs-parent="#accordion7">
                    <div class="accordion-body">
                        <form @submit.prevent="store_flight" id="form-flight">
                            <h5>Откуда</h5>
                            <div class="row g-3">
                                <div class="col">
                                    <label for="city_start_id" class="form-label">Город вылета</label>
                                    <select class="form-control" name="city_start_id" id="city_start_id">
                                        <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="airport_start_id" class="form-label">Аэропорт вылета</label>
                                    <select class="form-control" name="airport_start_id" id="airport_start_id">
                                        <option v-for="airport in airports" :value="airport.id">@{{ airport.title }}</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="mb-4 hr-dark">
                            <h5>Куда</h5>
                            <div class="row g-3">
                                <div class="col">
                                    <label for="city_finish_id" class="form-label">Город прилета</label>
                                    <select class="form-control" name="city_finish_id" id="city_finish_id">
                                        <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="airport_finish_id" class="form-label">Аэропорт прилета</label>
                                    <select class="form-control" name="airport_finish_id" id="airport_finish_id">
                                        <option v-for="airport in airports" :value="airport.id">@{{ airport.title }}</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="mb-4 hr-dark">
                            <div class="row g-3">
                                <div class="col">
                                    <label for="date_start" class="form-label">Дата вылета</label>
                                    <input type="date" class="form-control" id="date_start" name="date_start" :class="errors.date_start?'is-invalid':''">
                                    <div class="invalid-feedback" v-for="error in errors.date_start">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="date_finish" class="form-label">Дата прилета</label>
                                    <input type="date" class="form-control" id="date_finish" name="date_finish" :class="errors.date_finish?'is-invalid':''">
                                    <div class="invalid-feedback" v-for="error in errors.date_finish">
                                        @{{ error }}
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-4 hr-dark">
                            <div class="row g-3">
                                <div class="col">
                                    <label for="time_start" class="form-label">Время вылета</label>
                                    <input type="text" style="width: 65px" placeholder="00:00" class="form-control" id="time_start" name="time_start" :class="errors.date_start?'is-invalid':''">
                                    <div class="invalid-feedback" v-for="error in errors.time_start">
                                        @{{ error }}
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="time_finish" class="form-label">Время прилета</label>
                                    <input type="text" style="width: 65px" placeholder="00:00" class="form-control" id="time_finish" name="time_finish" :class="errors.time_finish?'is-invalid':''">
                                    <div class="invalid-feedback" v-for="error in errors.time_finish">
                                        @{{ error }}
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-4 hr-dark">
                            <div class="mb-3">
                              <label for="airplane_id" class="form-label">Самолет</label>
                              <select class="form-control" name="airplane_id" id="airplane_id">
                                <option v-for="airplane in valid_airplanes" :value="airplane.id">@{{ airplane.name }}</option>
                            </select>
                              <div class="invalid-feedback" v-for="error in errors.airplane_id">
                                @{{ error }}
                              </div>
                            </div>
                            <hr class="mb-4 hr-dark">
                            <div class="mb-3">
                              <label for="overprice" class="form-label">Наценка рейса, %</label>
                              <input style="width: 50px;" type="text" class="form-control" id="overprice" name="overprice" :class="errors.overprice?'is-invalid':''">
                              <div class="invalid-feedback" v-for="error in errors.overprice">
                                @{{ error }}
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>
                          </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="fly-card m-3" style="max-width: 500px;" v-for="fly in flights">
            {{-- <div class="fly-header d-flex justify-content-between">
                <p>@{{ fly.airplane.name }}</p>
                <div class="d-flex">
                    <p>@{{ (this.cities.filter(el=>el.id === fly.city_start_id))[0].title }}</p>
                    <p>-></p>
                    <p>@{{ (this.cities.filter(el=>el.id === fly.city_finish_id))[0].title }}</p>
                </div>

            </div>
            <hr class="hr-dark"> --}}
            <div class="fly-body">
                <div class="row align-items-start justify-content-between">
                    <div class="col-4 d-flex flex-column">
                        <p class="bold">@{{ (this.cities.filter(el=>el.id === fly.city_start_id))[0].title }}</p>
                        <p>@{{ (this.airports.filter(el=>el.id === fly.airport_start_id))[0].title }}</p>
                        <p>@{{ fly.date_start.split(' ')[0].split("-").reverse().join(".") }}</p>
                        <p>@{{ fly.date_start.split(' ')[1] }}</p>
                    </div>
                    <div class="col-3 d-flex flex-column">
                        <p>@{{ (fly.time_in_air)/60 }} минут</p>
                    </div>
                    <div class="col-4 d-flex flex-column">
                        <p class="bold">@{{ (this.cities.filter(el=>el.id === fly.city_finish_id))[0].title }}</p>
                        <p>@{{ (this.airports.filter(el=>el.id === fly.airport_finish_id))[0].title }}</p>
                        <p>@{{ fly.date_finish.split(' ')[0].split("-").reverse().join(".") }}</p>
                        <p>@{{ fly.date_finish.split(' ')[1] }}</p>
                    </div>
                </div>
            </div>
            <hr class="hr-dark">
            <div class="fly-footer d-flex justify-content-between">
                <div class="col-6 d-flex flex-column">
                    <p>Самолет:</p>

                    <p>Наценка рейса:</p>
                    <p>Статус:</p>
                </div>
                <div class="col-6 d-flex flex-column align-items-end">
                    <p class="bold">@{{ fly.airplane.name }}</p>

                    <p class="bold">@{{ fly.overprice }}</p>
                    <p class="bold">@{{ fly.status }}</p>
                </div>


            </div>
            <div class="fly-btns row">
                <div class="col-3">
                    <a class="btn btn-outline-danger" :href="`{{ route('flight_destroy') }}/${fly.id}`">удалить</a>
                </div>
                <div class="col-4">
                    <button data-bs-toggle="modal" :data-bs-target="'#editFlightModal'+fly.id" class="btn btn-outline-primary">изменить</button>
                  </div>
            </div>
            <div class="modal fade" :id="'editFlightModal'+fly.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" >
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Редактирование рейса #@{{ fly.id }}</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="edit_flight(fly.id)" :id="'form-edit-flight-'+fly.id">
                        <h5>Откуда</h5>
                        <div class="row g-3">
                            <div class="col">
                                <p>Выбранный город: @{{(this.cities.filter(el=>el.id === fly.city_start_id))[0].title }}</p>

                                <label for="city_start_id1" class="form-label">Город вылета</label>
                                <select class="form-control" name="city_start_id" id="city_start_id1">
                                    <option value="0">Выберите город</option>
                                    <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                                </select>
                            </div>
                            <div class="col">
                                <p>Выбранный аэропорт: @{{(this.airports.filter(el=>el.id === fly.airport_start_id))[0].title }}</p>

                                <label for="airport_start_id1" class="form-label">Аэропорт вылета</label>
                                <select class="form-control" name="airport_start_id" id="airport_start_id1">
                                    <option value="0">Выберите аэропорт</option>
                                    <option v-for="airport in airports" :value="airport.id">@{{ airport.title }}</option>
                                </select>
                            </div>
                        </div>
                        <hr class="mb-4 hr-dark">
                        <h5>Куда</h5>
                        <div class="row g-3">
                            <div class="col">
                                <p>Выбранный город: @{{(this.cities.filter(el=>el.id === fly.city_finish_id))[0].title }}</p>

                                <label for="city_finish_id1" class="form-label">Город прилета</label>
                                <select class="form-control" name="city_finish_id" id="city_finish_id1">
                                    <option value="0">Выберите город</option>

                                    <option v-for="city in cities" :value="city.id">@{{ city.title }}</option>
                                </select>
                            </div>
                            <div class="col">
                                <p>Выбранный аэропорт: @{{(this.airports.filter(el=>el.id === fly.airport_finish_id))[0].title }}</p>
                                <label for="airport_finish_id1" class="form-label">Аэропорт прилета</label>
                                <select class="form-control" name="airport_finish_id" id="airport_finish_id1">
                                    <option value="0">Выберите аэропорт</option>
                                    <option v-for="airport in airports" :value="airport.id">@{{ airport.title }}</option>
                                </select>
                            </div>
                        </div>
                        <hr class="mb-4 hr-dark">
                        <h5>Когда</h5>
                        <div class="row g-3">
                            <div class="col">
                                <label for="date_start1" class="form-label">Дата вылета</label>
                                <input type="date" class="form-control" :value="fly.date_start.split(' ')[0]" id="date_start1" name="date_start" :class="errors.date_start?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.date_start">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="col">
                                <label for="date_finish1" class="form-label">Дата прилета</label>
                                <input type="date" class="form-control" :value="fly.date_finish.split(' ')[0]" id="date_finish1" name="date_finish" :class="errors.date_finish?'is-invalid':''">
                                <div class="invalid-feedback" v-for="error in errors.date_finish">
                                    @{{ error }}
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <label for="date_start_fact1" class="form-label">Фактическая дата вылета</label>
                                <input type="date" class="form-control" id="date_start_fact1" name="date_start_fact">

                            </div>
                            <div class="col">
                                <label for="date_finish_fact1" class="form-label">Фактическая дата прилета</label>
                                <input type="date" class="form-control" id="date_finish_fact1" name="date_finish_fact">

                            </div>
                        </div>
                        <hr class="mb-4 hr-dark">
                        <div class="row g-3">
                            <div class="col">

                                <label for="time_start1" class="form-label">Время вылета</label>
                                <input type="text" :value="fly.date_start.split(' ')[1]" style="width: 100px" class="form-control" id="time_start1" name="time_start">

                            </div>
                            <div class="col">

                                <label for="time_finish1" class="form-label">Время прилета</label>
                                <input type="text" :value="fly.date_finish.split(' ')[1]" style="width: 100px" class="form-control" id="time_finish1" name="time_finish">

                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <label for="time_start_fact1" class="form-label">Фактическое время вылета</label>
                                <input type="text" style="width: 100px" class="form-control" id="time_start_fact1" name="time_start_fact">

                            </div>
                            <div class="col">
                                <label for="time_finish_fact1" class="form-label">Фактическое время прилета</label>
                                <input type="text" style="width: 100px" class="form-control" id="time_finish_fact1" name="time_finish_fact">

                            </div>
                        </div>
                        <hr class="mb-4 hr-dark">
                        <div class="mb-3">
                          <label for="airplane_id" class="form-label">Самолет</label>
                          <select class="form-control" name="airplane_id" id="airplane_id">
                            <option disabled selected value="">Выбранный самолет: @{{(this.airplanes.filter(el=>el.id === fly.airplane_id))[0].name }}</option>
                            <option v-for="airplane in valid_airplanes" :value="airplane.id">@{{ airplane.name }}</option>
                        </select>
                          <div class="invalid-feedback" v-for="error in errors.airplane_id">
                            @{{ error }}
                          </div>
                        </div>
                        <hr class="mb-4 hr-dark">
                        <div class="mb-3">
                          <label for="overprice8" class="form-label">Наценка рейса, %</label>
                          <input style="width: 50px;" :value="fly.overprice" type="text" class="form-control" id="overprice8" name="overprice" :class="errors.overprice?'is-invalid':''">
                          <div class="invalid-feedback" v-for="error in errors.overprice">
                            @{{ error }}
                          </div>
                        </div>
                        <hr class="mb-4 hr-dark">
                        <div class="mb-3">
                          <label for="status8" class="form-label">Статус рейса</label>
                          <input :value="fly.status" type="text" class="form-control" id="status8" name="status">

                        </div>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>

                  </div>
                </div>
              </div>
        </div>
    </div>

</div>
<div id="ticket" class="row control-page">
    <div class="row mb-5">
        <div class="col-6">
            <h3>Приобретенные билеты</h3>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-4">
            <select v-model="selectedFilter" name="city" class="form-control" @change="filterTicket">
                <option disabled selected value="">Фильтр статуса</option>
                <option value="бронь">бронь</option>
                <option value="отменен">отменен</option>
                <option value="использован">использован</option>
            </select>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th scope="col"># билета</th>
                <th scope="col">ФИО пассажира</th>
                <th scope="col">Статус рейса</th>
                <th scope="col">Статус билета</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in tickets">
                <th scope="row">@{{ ticket.id }}</th>
                <td>@{{ ticket.fio }}</td>
                <td>@{{ ticket.flight.status }}</td>
                <td>@{{ ticket.status }}</td>

              </tr>
            </tbody>
          </table>
    </div>

</div>

</div>
@endsection
<script>
    const app = {
        data(){
            return{
                message:'',
                errors:[],
                cities:[],
                airplanes:[],
                airports:[],
                tickets:[],
                users:[],
                seats:[],
                seats_in_plane:[],
                flights:[],
                valid_airplanes:[],

                selectedFilter:'',

                type:`{{ $type }}`
            }
        },
        methods:{
            openTab(id){
                let tabs = document.querySelectorAll('.control-page')
                let links = document.querySelectorAll('.nav-link')
                for(elem of tabs){
                    elem.classList.add('d-none')
                }
                for(elem of links){
                    elem.classList.remove('active')
                }
                let tab = document.getElementById(id);
                tab.classList.remove('d-none');

                let link = document.getElementById('nav-'+id);
                link.classList.add('active');

            },
            async store_user(){
                let form = document.getElementById('form-user')
                let form_data = new FormData(form)
                form_data.append('flag','admin')
                const response = await fetch('{{ route('user_store') }}',{
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
            async store_city(){
                let form = document.getElementById('form-city')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('city_store') }}',{
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
            async edit_city(id){
                let form = document.getElementById('form-edit-city-'+id)
                let form_data = new FormData(form)
                form_data.append('id',id)
                const response = await fetch('{{ route('city_edit') }}',{
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
            async store_airplane(){
                let form = document.getElementById('form-airplane')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('airplane_store') }}',{
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
            async edit_airplane(id){
                let form = document.getElementById('form-edit-airplane-'+id)
                let form_data = new FormData(form)
                form_data.append('id',id)
                const response = await fetch('{{ route('airplane_edit') }}',{
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
            async edit_airport(id){
                let form = document.getElementById('form-edit-airport-'+id)
                let form_data = new FormData(form)
                form_data.append('id',id)
                const response = await fetch('{{ route('airport_edit') }}',{
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
            async store_airport(){
                let form = document.getElementById('form-airport')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('airport_store') }}',{
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

            async edit_seat(id){
                let form = document.getElementById('form-edit-seat-'+id)
                let form_data = new FormData(form)
                form_data.append('id',id)
                const response = await fetch('{{ route('seat_edit') }}',{
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
            async store_seat(){
                let form = document.getElementById('form-seat')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('seat_store') }}',{
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
            async store_seat_in_plane(){
                let form = document.getElementById('form-seat-in-plane')
                let form_data = new FormData(form)
                const response = await fetch('{{ route('seat_in_plane_store') }}',{
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
            async edit_seat_in_plane(id){
                let form = document.getElementById('form-edit-seat-in-plane-'+id)
                console.log(id)
                console.log(form)
                let form_data = new FormData(form)
                form_data.append('id',id)
                const response = await fetch('{{ route('seat_in_plane_edit') }}',{
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
            async store_flight(){
                let form = document.getElementById('form-flight')
                let form_data = new FormData(form)

                const response = await fetch('{{ route('flight_store') }}',{
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
                if(response.status === 404){
                    this.message = await response.json()
                    setTimeout(() => {
                        this.message = ''
                    }, 2000);
                }

            },
            async edit_flight(id){
                let form = document.getElementById('form-edit-flight-'+id)
                let form_data = new FormData(form)
                form_data.append('id',id)
                const response = await fetch('{{ route('flight_edit') }}',{
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

            async getData(){
                const response_city = await fetch('{{ route('get_cities') }}')
                const response_airplane = await fetch('{{ route('get_airplanes') }}')
                const response_airport = await fetch('{{ route('get_airports') }}')
                const response_seat = await fetch('{{ route('get_seats') }}')
                const response_seat_in_plane = await fetch('{{ route('get_seats_in_plane') }}')
                const response_flight = await fetch('{{ route('get_flights') }}')
                const response_ticket = await fetch('{{ route('get_tickets') }}')
                const response_user = await fetch('{{ route('get_users') }}')

                this.cities = await response_city.json()
                this.airplanes = await response_airplane.json()
                this.valid_airplanes = this.airplanes.filter(elem=>elem.status === 'готов')
                this.airports = await response_airport.json()
                this.seats = await response_seat.json()
                this.seats_in_plane = await response_seat_in_plane.json()
                this.flights = await response_flight.json()
                this.tickets = await response_ticket.json()
                this.users = await response_user.json()
            }
        },
        computed:{
            async filterTicket(selectedFilter){
                if(this.selectedFilter){
                    const response = await fetch('{{ route('admin_filter_tickets') }}',{
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
                console.log(this.tickets)
            }
        },
        mounted(){
          this.getData()
          switch(this.type){
            case 'city':
              this.openTab('city')
              break
            case 'airport':
              this.openTab('airport')
              break
            case 'airplane':
                this.openTab('airplane')
                break
            case 'seat':
                this.openTab('seat')
                break
            case 'seat_in_plane':
                this.openTab('seat_in_plane')
                break
            case 'flight':
                this.openTab('flight')
                break
            case 'ticket':
                this.openTab('ticket')
                break
            case 'user':
                this.openTab('user')
                break
          }
        }
    }
    // Vue.createApp(app).mount('#Control')
    setTimeout(() => {
        Vue.createApp(app).mount('#Control')
    }, 1000);
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Syncopate&display=swap');
    .display{
        width: 100%;
        background: linear-gradient(90deg, #517F97 6.11%, #012439 93.44%);
    }
    p,h2,a,h5{
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
    }
    .bold{
        font-weight: 700;
    }
</style>
