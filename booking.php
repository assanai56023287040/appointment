<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="https://booking-system24.com/busbooking/assets/images/icons/favicon.png" />

    <link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/libraries/fontawesome/css/all.min.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/jquery-ui.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/datepicker3.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/sweetalert2.min.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/libraries/keyboard/css/keyboard.min.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/libraries/keyboard/css/keyboard-previewkeyset.min.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/vue-loading.css">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/style.css?v=10">
<link rel="stylesheet" href="https://booking-system24.com/busbooking/assets/css/responsive.css?v=3">    
<link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
    <title>Smart Bus Ticket</title>
    <style type="text/css">
      .ui-keyboard {
        border-radius: 0;
        left: 0 !important;
        top: auto !important;
        bottom: 0 !important;
        position: fixed !important;
        width: 100%;
      }

      #app {
        height: 100vh;
        overflow: scroll;
      }

      .mybadge {
        border-radius: 50%;
        background-color: white;
        width: 28%;
        border: 8px solid black; /*#ffc107; */
        margin-bottom: -10px;
      }

      body {
        font-size: 1.75rem;
      }

    </style>
  </head>
  <body>
    <div class="container-fluid" id="app">

      <div v-show="!documentMounted" tabindex="0" aria-label="Loading" class="vld-overlay is-active is-full-page" style="" aria-busy="true">
        <div class="vld-background" style="background: rgb(255, 255, 255);opacity:1!important;"></div>
        <div class="vld-icon">
          <svg viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#ff9900" width="400" height="400">
            <circle cx="15" cy="15" r="10.9642">
              <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
              <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
            </circle>
            <circle cx="60" cy="15" r="13.0358" fill-opacity="0.3">
              <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
              <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
            </circle>
            <circle cx="105" cy="15" r="10.9642">
              <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
              <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
            </circle>
          </svg>
        </div>
      </div>


      <div class="row flex-nowrap">
        <main class="col-9 p-0 bd-content bg-light">
          <div class="container" v-show="steps[4].isCurrent != true">
            <div class="row nav-step justify-content-center mt-3">
              <div class="col px-0 mx-0 step-line"
                v-for="(step, idx) in steps"
                v-if="step.isShowStep"
                :key="step.step"
                :class="{
                  'step-active': idx <= currentStep,
                  'step-active-last': step.isCurrent,
                  'step-inactive': idx > currentStep
                }">
                <span class="step-item" :class="{'first': step.step == 1, 'last': step.step == 4 || (step.step == 2 && isTimetable)}">
                  <img :src="step.defaultImg" v-show="idx > currentStep"/>
                  <img :src="step.currentImg" v-show="idx <= currentStep"/>
                </span>
                <h3 class="step-item-description" :class="{'step-active-text': idx <= currentStep}">
                  {{ step.title }}
                </h3>
              </div>
            </div><!-- /.row -->
          </div>

          <div class="container-fluid px-0 mt-2" v-show="steps[0].isCurrent == true">
            <div class="row justify-content-center">
              <div class="col-10">
                <div class="row">
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="selectTrip" id="selectTripRadio1" value="1" v-model="tripType">
                      <label class="form-check-label" for="selectTripRadio1"></label>
                      <label class="form-check-label myradio-label text-primary font-weight-bold" for="selectTripRadio1"><h3 class="mb-0">เที่ยวเดียว</h3></label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="selectTrip" id="selectTripRadio2" value="2" v-model="tripType">
                      <label class="form-check-label" for="selectTripRadio2"></label>
                      <label class="form-check-label myradio-label text-primary font-weight-bold" for="selectTripRadio2"><h3 class="mb-0">ไป-กลับ</h3></label>
                    </div>
                  </div>
                  <!-- <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="selectCarType" id="selectCartype1" value="1" v-model="carType">
                      <label class="form-check-label" for="selectCartype1"></label>
                      <label class="form-check-label myradio-label text-primary font-weight-bold" for="selectCartype1"><h3 class="mb-0">รถบัส</h3></label>
                    </div>
                  </div> -->
                </div><!-- /.row -->
              </div><!-- /.col-8 -->
            </div><!-- /.row -->

            <!-- <div class="row justify-content-center">
              <div class="col-10">
                <div class="row">
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="selectTrip" id="selectTripRadio2" value="2" v-model="tripType">
                      <label class="form-check-label" for="selectTripRadio2"></label>
                      <label class="form-check-label myradio-label text-primary font-weight-bold" for="selectTripRadio2"><h3 class="mb-0">ไป-กลับ</h3></label>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="selectCarType" id="selectCartype2" value="2" v-model="carType">
                      <label class="form-check-label" for="selectCartype2"></label>
                      <label class="form-check-label myradio-label text-primary font-weight-bold" for="selectCartype2"><h3 class="mb-0">รถตู้</h3></label>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <div class="row justify-content-center">
              <div class="col-10">
                <div class="card-group route-card">
                  <div class="card mycard text-center card-top-left-border" data-toggle="modal" data-target="#provinceDepartureModal">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted" v-show="depProvinceName">สถานีต้นทาง</h5>
                      <h4 class="card-title mb-0 muted" v-show="!depProvinceName">เลือกสถานีต้นทาง</h4>
                      <h4 class="card-title mb-0" v-show="depProvinceName">{{ depProvinceName }}</h4>
                    </div>
                  </div>
                  <div class="card mycard text-center card-top-center-border " style="max-width: 5rem;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <i class="fa fa-long-arrow-alt-right fa-2x" v-if="tripType == 1"></i>
                      <i class="fa fa-arrows-alt-h fa-2x" v-else></i>
                    </div>
                  </div>
                  <div class="card mycard text-center card-top-right-border" data-toggle="modal" data-target="#provinceDestinationModal">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted" v-show="desProvinceName">สถานีปลายทาง</h5>
                      <h4 class="card-title mb-0 muted" v-show="!desProvinceName">เลือกสถานีปลายทาง</h4>
                      <h4 class="card-title mb-0" v-show="desProvinceName">{{ desProvinceName }}</h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-10">
                <div class="card-group route-card">
                  <div class="card mycard text-center card-center-left-border" data-toggle="modal" data-target="#provinceDepartureModal">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted" v-show="depStationName">จุดขึ้นรถ</h5>
                      <h4 class="card-title mb-0 muted" v-show="!depStationName">เลือกจุดขึ้นรถ</h4>
                      <h4 class="card-title mb-0" v-show="depStationName">{{ depStationName }}</h4>
                    </div>
                  </div>
                  <div class="card mycard text-center card-center-center-border" style="max-width: 5rem;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <i class="fa fa-long-arrow-alt-right fa-2x" v-if="tripType == 1"></i>
                      <i class="fa fa-arrows-alt-h fa-2x" v-else></i>
                    </div>
                  </div>
                  <div class="card mycard text-center card-center-right-border" data-toggle="modal" data-target="#provinceDestinationModal">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted" v-show="desStationName">จุดลงรถ</h5>
                      <h4 class="card-title mb-0 muted" v-show="!desStationName">เลือกจุดลงรถ</h4>
                      <h4 class="card-title mb-0" v-show="desStationName">{{ desStationName }}</h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-10">
                <div class="card-group route-card">
                  <div class="card mycard text-center card-bottom-left-border card-bottom-right-border" data-toggle="modal" data-target="#dateModal" v-show="tripType == 1">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted">วันที่ไป</h5>
                      <h4 class="card-title mb-0">{{ depDateName }}</h4>
                    </div>
                  </div>
                  <div class="card mycard text-center card-bottom-left-border" data-toggle="modal" data-target="#date2Modal" v-show="tripType == 2">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted">วันที่เที่ยวไป</h5>
                      <h4 class="card-title mb-0">{{ depDateName }}</h4>
                    </div>
                  </div>
                  <div class="card mycard text-center card-bottom-center-border" style="max-width: 5rem;" v-show="tripType == 2">
                   <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <i class="fa fa-arrows-alt-h fa-2x"></i>
                    </div>
                  </div>
                  <div class="card mycard text-center card-bottom-right-border" data-toggle="modal" data-target="#date2Modal" v-show="tripType == 2">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                      <h5 class="card-title muted">วันที่เที่ยวกลับ</h5>
                      <h4 class="card-title mb-0">{{ desDateName }}</h4>
                    </div>
                  </div>
                </div>
              </div><!-- /.col-8 -->
            </div><!-- /.row -->
            <div class="row bg-warning m-0 time-panel" v-show="tripType == 1">
              <!-- <div class="col-12">
                <h4 class="text-center mt-2 text-white mb-0">เลือกรอบรถตามช่วงเวลา</h4>
                <p class="text-center m-0 text-white" style="font-size:1.75rem;">
                  พบทั้งหมด
                  &nbsp;&nbsp;&nbsp;
                  {{ depRoundList.length }}
                  &nbsp;&nbsp;&nbsp;
                  รอบรถ
                </p>
              </div> -->
              <div class="col-12">
                <h4 class="text-center mt-2 text-white mb-0">เลือกรอบรถตามช่วงเวลา</h4>
                <!-- <p class="m-0 text-white" style="font-size:1.75rem;">{{ depTimeSecond }}</p> -->
              </div>
              <div class="col-12">
                <div class="row px-5 justify-content-center">
                  <div class="col px-2">
                    <!-- <div class="text-center"><h5><span class="text-center m-0 badge badge-light" style="font-size:1.75rem;">{{ depTimeFirst }}</span></h5></div> -->
                    <p class="text-center m-0 text-white" style="font-size:1.75rem;">{{ depTimeFirst }}&nbsp;รอบ</p>
                    <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 1)" :class="{'active-text': depTimeFilter == 1}">
                      <h4 class="m-0 py-3">00:00 - 05:59 น.</h4>
                    </button>
                  </div>
                  <div class="col px-2">
                    <p class="text-center m-0 text-white" style="font-size:1.75rem;">{{ depTimeSecond }}&nbsp;รอบ</p>
                    <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 2)" :class="{'active-text': depTimeFilter == 2}">
                      <h4 class="m-0 py-3">06:00 - 11:59 น.</h4>
                    </button>
                  </div>
                  <div class="col px-2">
                    <p class="text-center m-0 text-white" style="font-size:1.75rem;">{{ depTimeThird }}&nbsp;รอบ</p>
                    <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 3)" :class="{'active-text': depTimeFilter == 3}">
                      <h4 class="m-0 py-3">12:00 - 17:59 น.</h4>
                    </button>
                  </div>
                  <div class="col px-2">
                    <p class="text-center m-0 text-white" style="font-size:1.75rem;">{{ depTimeFourth }}&nbsp;รอบ</p>
                    <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 4)" :class="{'active-text': depTimeFilter == 4}">
                      <h4 class="m-0 py-3">18:00 - 23:59 น.</h4>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row bg-warning m-0 time-panel" v-show="tripType == 2">
              <div class="col-6">
                <div class="row">
                  <div class="col-12">
                    <h4 class="text-center mt-2 text-white mb-0">เลือกรอบรถตามช่วงเวลา - เที่ยวไป</h4>
                    <!-- <p class="text-center m-0 text-white" style="font-size:1.75rem;">
                      พบทั้งหมด
                      &nbsp;&nbsp;&nbsp;
                      {{ depRoundList.length }}
                      &nbsp;&nbsp;&nbsp;
                      รอบรถ
                    </p> -->
                  </div>
                  <div class="col-12">
                    <div class="row justify-content-center">
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ depTimeFirst }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 1)" :class="{'active-text': depTimeFilter == 1}">
                          <h5 class="m-0">00:00 - 05:59 น.</h5>
                        </button>
                      </div>
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ depTimeSecond }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 2)" :class="{'active-text': depTimeFilter == 2}">
                          <h5 class="m-0">06:00 - 11:59 น.</h5>
                        </button>
                      </div>
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ depTimeThird }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 3)" :class="{'active-text': depTimeFilter == 3}">
                          <h5 class="m-0">12:00 - 17:59 น.</h5>
                        </button>
                      </div>
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ depTimeFourth }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 1, 4)" :class="{'active-text': depTimeFilter == 4}">
                          <h5 class="m-0">18:00 - 23:59 น.</h5>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-6" style="border-left:5px solid #fff;">
                <div class="row">
                  <div class="col-12">
                    <h4 class="text-center mt-2 text-white mb-0">เลือกรอบรถตามช่วงเวลา - เที่ยวกลับ</h4>
                    <!-- <p class="text-center m-0 text-white" style="font-size:1.75rem;">
                      พบทั้งหมด
                      &nbsp;&nbsp;&nbsp;
                      {{ desRoundList.length }}
                      &nbsp;&nbsp;&nbsp;
                      รอบรถ
                    </p> -->
                  </div>
                  <div class="col-12">
                    <div class="row justify-content-center">
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ desTimeFirst }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 2, 1)" :class="{'active-text': desTimeFilter == 1}">
                          <h5 class="m-0">00:00 - 05:59 น.</h5>
                        </button>
                      </div>
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ desTimeSecond }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 2, 2)" :class="{'active-text': desTimeFilter == 2}">
                          <h5 class="m-0">06:00 - 11:59 น.</h5>
                        </button>
                      </div>
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ desTimeThird }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 2, 3)" :class="{'active-text': desTimeFilter == 3}">
                          <h5 class="m-0">12:00 - 17:59 น.</h5>
                        </button>
                      </div>
                      <div class="col-6 px-4 mb-0">
                        <p class="text-center m-0 text-white" style="font-size:1.75rem;height:30px;padding-top:0">{{ desTimeFourth }}&nbsp;รอบ</p>
                        <button class="btn btn-primary btn-lg btn-block bg-white text-dark border-0" style="border-radius:15px;" @click="filterByTime('Route', 2, 4)" :class="{'active-text': desTimeFilter == 4}">
                          <h5 class="m-0">18:00 - 23:59 น.</h5>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>

          </div><!-- /.container step find route -->

          <!-- step select round -->
          <div class="container-fluid" v-show="steps[1].isCurrent == true">
            <div class="row mb-1">
              <div class="col" style="padding-left:0;">
                <div class="card mycard bg-light" style="padding:0;z-index:1000">
                  <div class="card-body" style="padding:0;" v-show="isTravelTrip">
                    <span class="pl-3" style="font-size:1.7rem;font-weight:bold;">ค้นหาจาก</span>
                    <ul class="search-bar">
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByTimeModal">เวลา</a></li>
                      <li v-show="tripType == 1"><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByDateModal">วันที่</a></li>
                      <li v-show="tripType == 2"><a href="javascript:void(0);" data-toggle="modal" data-target="#date2Modal">วันที่</a></li>
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByPriceModal">ราคา</a></li>
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByVendorModal">ผู้ให้บริการ</a></li>
                    </ul>
                  </div><!-- /.card-body -->
                  <div class="card-body" style="padding:0;" v-show="!isTravelTrip">
                    <span class="pl-3" style="font-size:1.7rem;font-weight:bold;">ค้นหาจาก</span>
                    <ul class="search-bar">
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByTimeRoundTripModal">เวลา</a></li>
                      <!-- <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByDateRoundTripModal">วันที่</a></li> -->
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#date2Modal">วันที่</a></li>
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByPriceRoundTripModal">ราคา</a></li>
                      <li><a href="javascript:void(0);" data-toggle="modal" data-target="#filterByVendorRoundTripModal">ผู้ให้บริการ</a></li>
                    </ul>
                  </div><!-- /.card-body -->
                </div><!-- /.card -->
                <div class="card mycard" style="width:640px;border-bottom:10px solid #ffb900;padding:0;margin-left:-20px;"></div>
              </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row justify-content-center round-nav-tab">
              <div class="col-6">
                <a href="javascript:void(0);" style="text-decoration:none;color:black;" @click="slideToDepart()">
                  <div class="row" id="depHeadCol" :class="{'tab-active': isTravelTrip, 'tab-inactive':!isTravelTrip}">
                    <div class="col-4 trip-text">
                      <h2 style="line-height:1;">เที่ยวไป</h2>
                    </div>
                    <div class="col-8">
                      <h5 class="mb-0">{{ depDateName }}</h5>
                      <h5 class="mb-0">{{ depProvinceName }} - {{ desProvinceName }}</h5>
                      <h6 class="mb-0">{{ depStationName }} - {{ desStationName }}</h6>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-6">
                <a href="javascript:void(0);" style="text-decoration:none;color:black;" @click="slideToReturn()">
                  <div class="row" id="desHeadCol" v-show="tripType == 2" :class="{'tab-active': !isTravelTrip, 'tab-inactive':isTravelTrip}">
                    <div class="col-4 trip-text">
                      <h2 style="line-height:1;">เที่ยวกลับ</h2>
                    </div>
                    <div class="col-8">
                      <h5 class="mb-0">{{ desDateName }}</h5>
                      <h5 class="mb-0">{{ desProvinceName }} - {{ depProvinceName }}</h5>
                      <h6 class="mb-0">{{ desStationName }} - {{ depStationName }}</h6>
                    </div>
                  </div>
                </a>
              </div>
            </div><!-- /.row -->
            <div class="row round-step-content">
              <section style="float:left;position:absolute;display:block;width:100%;" id="left-tab">
                <table class="table table-borderless table-striped table-hover">
                  <!-- v-show="isTravelTrip"  :class="{'left-data': isTravelTrip}" -->
                  <thead>
                    <tr class="text-light table-head">
                      <th scope="col" class="text-center" style="vertical-align:middle;width:60px;">&nbsp;</th>
                      <th scope="col" class="text-center pt-2 border-right" style="vertical-align:middle;" @click="sortBy(1, 'vendor')">
                        <span class="float-right" v-show="depRoundListSortBy == 'vendor'">
                          <i class="fa fa-sort-up text-warning" v-show="depRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="depRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right" v-show="depRoundListSortBy != 'vendor'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>ผู้ให้บริการ</span>
                      </th>
                      <th scope="col" class="text-center pt-2 border-right" style="vertical-align:middle;width:180px;" @click="sortBy(1, 'time')">
                        <span class="float-right" v-show="depRoundListSortBy == 'time'">
                          <i class="fa fa-sort-up text-warning" v-show="depRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="depRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right" v-show="depRoundListSortBy != 'time'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>เวลาออกเดินทาง</span>
                      </th>
                      <th scope="col" class="text-center pt-2 border-right" style="vertical-align:middle;width:230px;" @click="sortBy(1, 'standard')">
                        <span class="float-right" v-show="depRoundListSortBy == 'standard'">
                          <i class="fa fa-sort-up text-warning" v-show="depRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="depRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right" v-show="depRoundListSortBy != 'standard'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>มาตรฐานรถ</span>
                      </th>
                      <th scope="col" class="text-center border-right" style="vertical-align:middle;width:130px;line-height:1;" @click="sortBy(1, 'seat')">
                        <span class="float-right mt-3" v-show="depRoundListSortBy == 'seat'">
                          <i class="fa fa-sort-up text-warning" v-show="depRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="depRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right mt-3" v-show="depRoundListSortBy != 'seat'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>จำนวนที่นั่ง</span><br/>
                        <h5 class="m-0">(ว่าง/ทั้งหมด)</h5>
                      </th>
                      <th scope="col" class="text-center" style="vertical-align:middle;width:100px;line-height:1;" @click="sortBy(1, 'price')">
                        <span class="float-right mt-3" v-show="depRoundListSortBy == 'price'">
                          <i class="fa fa-sort-up text-warning" v-show="depRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="depRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right mt-3" v-show="depRoundListSortBy != 'price'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>ราคา</span><br/>
                        <h5 class="m-0">(บาท)</h5>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="linkable-row" v-for="row in depRoundList" :key="row.timid" @click="selectRound(1, row)" :class="{'row-active': row.timid == depRoundId}">
                      <td class="pt-2 text-center">
                        <input class="form-check-input myradio" style="margin-left:0" type="radio" :value="row.timid" :checked="row.timid == depRoundId">
                        <label for="" style="margin-bottom:0;"></label>
                      </td>
                      <td class="text-info py-1" style="line-height:0.7;">
                        <h4 class="mb-0">{{ row.name1 }}</h4>
                        <a v-for="(st, stidx) in row.station_list" href="javascript:void(0);" style="text-decoration:none;color:#4e4e4e;font-size:1.25rem;" >
                          <!--  :class="{'text-danger': (st.terid == depStationId || st.terid == desStationId)}"-->
                          {{ st.name }}
                          <span v-show="stidx != row.station_list.length - 1" class="text-dark">&rarr;</span>
                        </a>
                      </td>
                      <td class="text-center">{{ row.frtime }} น.</td>
                      <td class="text-center">{{ row.grade_name }}</td>
                      <td class="text-center">
                        <span class="text-success" style="font-size:2.5rem;">
                        {{ row.capacity_remain }}</span> / <span style="font-size:1.5rem;">{{ row.capacity }}</span>
                      </td>
                      <td class="text-center">{{ row.price | numberFormat }}</td>
                    </tr>
                  </tbody>
                </table>
              </section>
              <section style="float:left;position:absolute;display:none;width:100%;" id="right-tab">
                <table class="table table-borderless table-striped table-hover">
                  <!-- v-show="!isTravelTrip" :class="{'right-data' : !isTravelTrip }" -->
                  <thead>
                    <tr class="text-light table-head">
                      <th scope="col" class="text-center" style="vertical-align:middle;width:60px;">&nbsp;</th>
                      <th scope="col" class="text-center pt-2 border-right" style="vertical-align:middle;" @click="sortBy(2, 'vendor')">
                        <span class="float-right" v-show="desRoundListSortBy == 'vendor'">
                          <i class="fa fa-sort-up text-warning" v-show="desRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="desRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right" v-show="desRoundListSortBy != 'vendor'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>ผู้ให้บริการ</span>
                      </th>
                      <th scope="col" class="text-center pt-2 border-right" style="vertical-align:middle;width:180px;" @click="sortBy(2, 'time')">
                        <span class="float-right" v-show="desRoundListSortBy == 'time'">
                          <i class="fa fa-sort-up text-warning" v-show="desRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="desRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right" v-show="desRoundListSortBy != 'time'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>เวลาออกเดินทาง</span>
                      </th>
                      <th scope="col" class="text-center pt-2 border-right" style="vertical-align:middle;width:230px;" @click="sortBy(2, 'standard')">
                        <span class="float-right" v-show="desRoundListSortBy == 'standard'">
                          <i class="fa fa-sort-up text-warning" v-show="desRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="desRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right" v-show="desRoundListSortBy != 'standard'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>มาตรฐานรถ</span>
                      </th>
                      <th scope="col" class="text-center border-right" style="vertical-align:middle;width:130px;line-height:1;" @click="sortBy(2, 'seat')">
                        <span class="float-right mt-3" v-show="desRoundListSortBy == 'seat'">
                          <i class="fa fa-sort-up text-warning" v-show="desRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="desRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right mt-3" v-show="desRoundListSortBy != 'seat'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>จำนวนที่นั่ง</span><br/>
                        <h5 class="m-0">(ว่าง/ทั้งหมด)</h5>
                      </th>
                      <th scope="col" class="text-center" style="vertical-align:middle;width:100px;line-height:1;" @click="sortBy(2, 'price')">
                        <span class="float-right mt-3" v-show="desRoundListSortBy == 'price'">
                          <i class="fa fa-sort-up text-warning" v-show="desRoundListSortDir == 'ASC'"></i>
                          <i class="fa fa-sort-down text-warning" v-show="desRoundListSortDir != 'ASC'"></i>
                        </span>
                        <span class="float-right mt-3" v-show="desRoundListSortBy != 'price'">
                          <i class="fa fa-sort text-white-50"></i>
                        </span>
                        <span>ราคา</span><br/>
                        <h5 class="m-0">(บาท)</h5>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="linkable-row" v-for="row in desRoundList" :key="row.timid" @click="selectRound(2, row)" :class="{'row-active': row.timid == desRoundId}">
                      <td class="pt-2 text-center">
                        <input class="form-check-input myradio" style="margin-left:0" type="radio" :value="row.timid" :checked="row.timid == desRoundId">
                        <label for="" style="margin-bottom:0;"></label>
                      </td>
                      <td class="text-info py-1" style="line-height:0.7;">
                        <h4 class="mb-0">{{ row.name1 }}</h4>
                        <a v-for="(st, stidx) in row.station_list" href="javascript:void(0);" style="text-decoration:none;color:#4e4e4e;font-size:1.25rem;" >
                          <!--  :class="{'text-danger': (st.terid == depStationId || st.terid == desStationId)}"-->
                          {{ st.name }}
                          <span v-show="stidx != row.station_list.length - 1" class="text-dark">&rarr;</span>
                        </a>
                      </td>
                      <td class="text-center">{{ row.frtime }} น.</td>
                      <td class="text-center">{{ row.grade_name }}</td>
                      <td class="text-center">
                        <span class="text-success" style="font-size:2.5rem;">
                        {{ row.capacity_remain }}</span> / <span style="font-size:1.5rem;">{{ row.capacity }}</span>
                      </td>
                      <td class="text-center">{{ row.price | numberFormat }}</td>
                    </tr>
                  </tbody>
                </table>
              </section>
            </div><!-- /.row -->
          </div><!-- /.container-fluid step select round -->

          <!-- step passengers -->
          <div class="container-fluid" v-show="steps[2].isCurrent == true && steps[2].section == 1">
            <div class="row justify-content-center">
              <div class="col-12 mb-2">
                <div class="form-row justify-content-center">
                  <h4 class="my-2 mr-2">จำนวนผู้โดยสาร</h4>
                  <div class="col-3">
                    <div class="input-group">
                      <div class="input-group-append">
                        <button class="btn btn-secondary w-50p" type="button" @click="decrease()"><i class="fa fa-minus"></i></button>
                      </div>
                      <input type="text" class="form-control form-control-lg mytextbox text-center" v-model="passengerQty">
                      <div class="input-group-append">
                        <button class="btn btn-secondary w-50p" type="button" @click="increase()"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                  <h4 class="my-2 ml-2">ท่าน</h4>
                </div>
              </div>
              <div class="col-12">
                <h4 class="text-danger text-center">กรณีเกิน 4 ท่านต่อการจอง 1 ครั้ง กรุณาจองตั๋วครั้งถัดไป</h4>
              </div>
            </div><!-- /.row -->

            <div class="row justify-content-center passenger-nav-tab mb-3">
              <div class="col-6">
                <a href="javascript:void(0);" style="text-decoration:none;color:black;" @click="slideToDepartPassenger()">
                  <div class="row" :class="{'tab-active': isTravelTripPassengerTab, 'tab-inactive':!isTravelTripPassengerTab}">
                    <div class="col-4 trip-text">
                      <h2>เที่ยวไป</h2>
                    </div>
                    <div class="col-8">
                      <h5 class="mb-0">ผู้ให้บริการ</h5>
                      <h4 class="mb-0">{{ depRound.name1 }}</h4>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-6">
                <a href="javascript:void(0);" style="text-decoration:none;color:black;" @click="slideToReturnPassenger()">
                  <div class="row" v-show="tripType == 2" :class="{'tab-active': !isTravelTripPassengerTab, 'tab-inactive':isTravelTripPassengerTab}">
                    <div class="col-4 trip-text">
                      <h2>เที่ยวกลับ</h2>
                    </div>
                    <div class="col-8">
                      <h5 class="mb-0">ผู้ให้บริการ</h5>
                      <h4 class="mb-0">{{ desRound.name1 }}</h4>
                    </div>
                  </div>
                </a>
              </div>
            </div><!-- /.row -->

            <div class="row p-0 m-0 passenger-step-content">
              <div class="col-12 p-0">
                <!-- for one way travel -->
                <section style="float:left;position:absolute;display:block;width:100%;" id="left-tab-passenger">
                  <div class="row">
                    <div
                      v-if="depRound && depRound.is_passenger_active == 0"
                      class="col-12"
                    >
                      <h1>ไม่แสดงกล่องข้อมูลผู้โดยสาร</h1>
                    </div>
                    <div
                      v-else
                      class="col-6 mb-4"
                      v-for="(ps, idx) in passengersDeparture"
                      :key="'ps'+idx"
                    >
                      <div class="card card-border" style="border-top-left-radius:30px">
                        <button type="button" style="border-radius:50px;position:absolute;width:50px;height:50px;top:-5px;left:-5px;background-color:#fdc377;opacity:1;border:none;z-index:100">
                          <h1 class="text-white">{{ idx + 1 }}</h1>
                        </button>
                        <button
                          type="button"
                          class="close"
                          style="border-radius:50px;position:absolute;width:50px;height:50px;top:2px;right:2px;border:2px solid #fdc377;opacity:1;z-index:100"
                          @click="delPassenger(ps, 'departure', idx)"
                        >
                          <i class="fa fa-times fa-2x" style="color:#fdc377"></i>
                        </button>
                        <div class="card-body px-1">
                          <div
                            v-if="ps.is_active_gender"
                            class="form-group row mb-0"
                          >
                            <label
                              class="col-3 px-0 col-form-label text-right"
                            >
                              เพศ                              <span class="text-danger" v-if="ps.is_required_gender"> * </span>:
                            </label>
                            <div class="col-9">
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="1" v-model="ps.gender" :id="'radioGender1-'+idx" >
                                <label :for="'radioGender1-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioGender1-'+idx">ชาย</label>
                              </div>
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="2" v-model="ps.gender" :id=" 'radioGender2-' + idx">
                                <label :for="'radioGender2-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioGender2-'+idx">หญิง</label>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_passport"
                            class="form-group row mb-0"
                          >
                            <label
                              class="col-3 px-0 col-form-label text-right"
                            >
                              บัตร                              <span class="text-danger" v-if="ps.is_required_passport"> * </span>:
                            </label>
                            <div class="col-9">
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="1" v-model="ps.passportType" :id=" 'radioPassport1-'+idx" @change="checkPassengerDataRequired()">
                                <label :for="'radioPassport1-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioPassport1-'+idx">ปชช.</label>
                              </div>
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="2" v-model="ps.passportType" :id=" 'radioPassport2-'+idx" @change="checkPassengerDataRequired()">
                                <label :for="'radioPassport2-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioPassport2-'+idx">พาสปอร์ต</label>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_passport"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'passport'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                              เลขบัตร                              <span class="text-danger" v-if="ps.is_required_passport"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-passport"
                                placeholder="เลขบัตร ปชช. / พาสปอร์ต"
                                :value="ps.passport"
                                :id="'passport'+idx"
                                :data-index="idx"
                                data-name="passport"
                                data-type="departure"
                                autocomplete="off"
                                :class="{
                                  'is-valid':ps.valid_passport == true,
                                  'is-invalid':ps.valid_passport.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_passport" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_passport && ps.passportType == 1"
                            class="form-group row mb-1"
                          >
                            <div class="col-3">&nbsp;</div>
                            <div class="col-9">
                              <button class="btn btn-block btn-sm btn-primary" @click="idCardScan(idx, 'return', 'departure')">
                                <h5 class="m-0">สแกนข้อมูลจากบัตร ปชช. คลิกที่นี่!!</h5>
                              </button>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_name"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'name'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                              ชื่อ - สกุล                              <span class="text-danger" v-if="ps.is_required_name"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-name"
                                placeholder="ชื่อ - สกุล"
                                :value="ps.name"
                                :id="'name'+idx"
                                :data-index="idx"
                                data-name="name"
                                data-type="departure"
                                autocomplete="off"
                                :class="{
                                  'is-valid': ps.valid_name == true,
                                  'is-invalid': ps.valid_name.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_name" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_mobile"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'mobile'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                              เบอร์โทรฯ                              <span class="text-danger" v-if="ps.is_required_mobile"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-mobile"
                                placeholder="เบอร์โทรฯ"
                                :value="ps.mobile"
                                :id="'mobile'+idx"
                                :data-index="idx"
                                data-name="mobile"
                                data-type="departure"
                                autocomplete="off"
                                :class="{
                                  'is-valid':ps.valid_mobile == true,
                                  'is-invalid':ps.valid_mobile.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_mobile" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_email"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'email'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                                อีเมล                                <span class="text-danger" v-if="ps.is_required_email"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-email"
                                placeholder="อีเมล"
                                :value="ps.email"
                                :id="'email'+idx"
                                :data-index="idx"
                                data-name="email"
                                data-type="departure"
                                autocomplete="off"
                                :class="{
                                  'is-valid': ps.valid_email == true,
                                  'is-invalid': ps.valid_email.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_email" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="form-check form-check-inline"> -->
                          <div
                            v-if="ps.is_active_insurance"
                            class="form-group row"
                          >
                            <input class="form-check-input mycheckbox ml-5" type="checkbox" value="1" v-model="ps.insurance" :id="'checkboxInsurance1-' + idx" @change="checkPassengerDataRequired()">
                            <label :for="'checkboxInsurance1-'+idx" class="ml-5"></label>
                            <div>
                              <label class="form-check-label mt-2 ml-2" :for="'checkboxInsurance1-'+idx">ประกันภัยการเดินทาง</label>
                              <br/>
                              <label class="form-check-label ml-2 text-primary" data-toggle="modal" data-target="#insuranceModal">ดูข้อมูลเพิ่มเติม</label>
                              <div
                                class="invalid-feedback"
                                :class="{'d-block': ps.valid_insurance.length > 0}"
                              >
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_insurance" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.card -->
                    </div><!-- /.col-6 -->
                  </div><!-- /.row -->
                </section>
                <!-- for round trip travel -->
                <section style="float:left;position:absolute;display:none;width:100%;" id="right-tab-passenger" v-if="tripType == 2">
                  <div
                    v-if="desRound && desRound.is_passenger_active == 0"
                    class="row"
                  >
                    <div class="col-12">
                      <h1>ไม่แสดงกล่องข้อมูลผู้โดยสาร</h1>
                    </div>
                  </div>
                  <div
                    v-else
                    class="row"
                  >
                    <div class="col-12 text-center">
                        <button
                          class="btn btn-info mb-2"
                          @click="copyFromTravelTrip()"
                        >
                          <h5 class="m-0">คัดลอกจากเที่ยวไป</h5>
                      </button>
                    </div>
                    <div
                      class="col-6 mb-4"
                      v-for="(ps, idx) in passengersReturn"
                      :key="'ps2'+idx"
                    >
                      <div class="card card-border" style="border-top-left-radius:30px">
                        <button type="button" style="border-radius:50px;position:absolute;width:50px;height:50px;top:-5px;left:-5px;background-color:#fdc377;opacity:1;border:none;z-index:100">
                          <h1 class="text-white">{{ idx + 1 }}</h1>
                        </button>
                        <button
                          type="button"
                          class="close"
                          style="border-radius:50px;position:absolute;width:50px;height:50px;top:2px;right:2px;border:2px solid #fdc377;opacity:1;z-index:100"
                          @click="delPassenger(ps, 'return', idx)"
                        >
                          <i class="fa fa-times fa-2x" style="color:#fdc377"></i>
                        </button>
                        <div class="card-body px-1">
                          <div
                            v-if="ps.is_active_gender"
                            class="form-group row mb-0"
                          >
                            <label
                              class="col-3 px-0 col-form-label text-right"
                            >
                              เพศ                              <span class="text-danger" v-if="ps.is_required_gender"> * </span>:
                            </label>
                            <div class="col-9">
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="1" v-model="ps.gender" :id="'radioGender11-'+idx" >
                                <label :for="'radioGender11-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioGender11-'+idx">ชาย</label>
                              </div>
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="2" v-model="ps.gender" :id=" 'radioGender22-' + idx">
                                <label :for="'radioGender22-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioGender22-'+idx">หญิง</label>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_passport"
                            class="form-group row mb-0"
                          >
                            <label
                              class="col-3 px-0 col-form-label text-right"
                            >
                              บัตร                              <span class="text-danger" v-if="ps.is_required_passport"> * </span>:
                            </label>
                            <div class="col-9">
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="1" v-model="ps.passportType" :id=" 'radioPassport11-'+idx" @change="checkPassengerDataRequired()">
                                <label :for="'radioPassport11-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioPassport11-'+idx">ปชช.</label>
                              </div>
                              <div class="form-check form-check-inline pt-2">
                                <input class="form-check-input myradio radio40" type="radio" value="2" v-model="ps.passportType" :id=" 'radioPassport22-'+idx" @change="checkPassengerDataRequired()">
                                <label :for="'radioPassport22-'+idx"></label>
                                <label class="form-check-label mt--10 ml-2" :for="'radioPassport22-'+idx">พาสปอร์ต</label>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_passport"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'passport'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                              เลขบัตร                              <span class="text-danger" v-if="ps.is_required_passport"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-passport"
                                placeholder="เลขบัตร ปชช. / พาสปอร์ต"
                                :value="ps.passport"
                                :id="'passport'+idx"
                                :data-index="idx"
                                data-name="passport"
                                data-type="return"
                                autocomplete="off"
                                :class="{
                                  'is-valid':ps.valid_passport == true,
                                  'is-invalid':ps.valid_passport.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_passport" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_passport && ps.passportType == 1"
                            class="form-group row mb-1"
                          >
                            <div class="col-3">&nbsp;</div>
                            <div class="col-9">
                              <button class="btn btn-block btn-sm btn-primary" @click="idCardScan(idx, 'return')">
                                <h5 class="m-0">สแกนข้อมูลจากบัตร ปชช. คลิกที่นี่!!</h5>
                              </button>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_name"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'name'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                              ชื่อ - สกุล                              <span class="text-danger" v-if="ps.is_required_name"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-name"
                                placeholder="ชื่อ - สกุล"
                                :value="ps.name"
                                :id="'name'+idx"
                                :data-index="idx"
                                data-name="name"
                                data-type="return"
                                autocomplete="off"
                                :class="{
                                  'is-valid': ps.valid_name == true,
                                  'is-invalid': ps.valid_name.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_name" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_mobile"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'mobile'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                              เบอร์โทรฯ                              <span class="text-danger" v-if="ps.is_required_mobile"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-mobile"
                                placeholder="เบอร์โทรฯ"
                                :value="ps.mobile"
                                :id="'mobile'+idx"
                                :data-index="idx"
                                data-name="mobile"
                                data-type="return"
                                autocomplete="off"
                                :class="{
                                  'is-valid':ps.valid_mobile == true,
                                  'is-invalid':ps.valid_mobile.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_mobile" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            v-if="ps.is_active_email"
                            class="form-group row mb-0"
                          >
                            <label
                              :for="'email'+idx"
                              class="col-3 px-0 col-form-label text-right"
                            >
                                อีเมล                                <span class="text-danger" v-if="ps.is_required_email"> * </span>:
                            </label>
                            <div class="col-9">
                              <input
                                type="text"
                                class="form-control form-control-lg mytextbox passenger-email"
                                placeholder="อีเมล"
                                :value="ps.email"
                                :id="'email'+idx"
                                :data-index="idx"
                                data-name="email"
                                data-type="return"
                                autocomplete="off"
                                :class="{
                                  'is-valid': ps.valid_email == true,
                                  'is-invalid': ps.valid_email.length > 0
                                }"
                              >
                              <div class="invalid-feedback">
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_email" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="form-check form-check-inline"> -->
                          <div
                            v-if="ps.is_active_insurance"
                            class="form-group row"
                          >
                            <input class="form-check-input mycheckbox ml-5" type="checkbox" value="1" v-model="ps.insurance" :id="'checkboxInsurance2-' + idx" @change="checkPassengerDataRequired()">
                            <label :for="'checkboxInsurance2-'+idx" class="ml-5"></label>
                            <div>
                              <label class="form-check-label mt-2 ml-2" :for="'checkboxInsurance2-'+idx">ประกันภัยการเดินทาง</label>
                              <br/>
                              <label class="form-check-label ml-2 text-primary" data-toggle="modal" data-target="#insuranceModal">ดูข้อมูลเพิ่มเติม</label>
                              <div
                                class="invalid-feedback"
                                :class="{'d-block': ps.valid_insurance.length > 0}"
                              >
                                <ul class="pl-3 mb-0">
                                  <li v-for="(err, i) in ps.valid_insurance" :key="i">
                                    {{ err }}
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.card -->
                    </div><!-- /.col-6 -->
                  </div><!-- /.row -->
                </section>
              </div><!-- /.col-12 -->
            </div><!-- /.row -->
          </div><!-- /.container step passengers -->

          <div class="container" v-show="steps[2].isCurrent == true && steps[2].section == 2">
            <div class="row justify-content-center" style="height:70px;background-color:#ffd02c;margin-bottom:5px;">
              <div class="col-6">
                <a href="javascript:void(0);" style="text-decoration:none;color:black;" @click="slideSeatToDepart()">
                  <div class="row" style="padding-top:10px;" :class="{'tab-active': isTravelTripSeatTab, 'tab-inactive': !isTravelTripSeatTab}">
                    <div class="col text-center">
                      <h2>เที่ยวไป</h2>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-6" v-show="tripType == 2">
                <a href="javascript:void(0);" style="text-decoration:none;color:black;" @click="slideSeatToReturn()">
                  <div class="row" style="padding-top:10px;" :class="{'tab-active': !isTravelTripSeatTab, 'tab-inactive': isTravelTripSeatTab}">
                    <div class="col text-center">
                      <h2>เที่ยวกลับ</h2>
                    </div>
                  </div>
                </a>
              </div>
            </div><!-- /.row -->
            <div class="row m-0 justify-content-center">
              <div class="col p-0 seat-step-content">
                <section style="float:left;position:absolute;display:block;width:100%;" id="left-seat" v-show="!isDepSkipSeat">
                  <div class="row m-0" > <!-- v-show="isTravelTripSeatTab" -->
                    <div class="col-12" v-show="depSeatFirstList.length > 0">
                      <div class="card mb-2">
                        <div class="card-body">
                          <h4 class="card-title" v-show="depSeatSecondList.length > 0">ชั้นล่าง</h4>
                          <table class="table table-borderless table-sm" style="width:10rem;margin:5px auto;">
                            <tbody>
                              <tr v-for="(list, idx) in depSeatFirstList" :key="idx">
                                <td v-for="ls in list" :key="ls.gridid" :colspan="ls.colspan" class="text-center" :class="{'border border-warning': ls.seat_box_type == 5}" style="padding:0;margin:0;">

                                  <i v-if="ls.seat_box_type == 1" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">&nbsp;</i>

                                  <i v-else-if="ls.seat_box_type == 2" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">บันได</i>

                                  <i v-else-if="ls.seat_box_type == 3" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">ห้องน้ำ</i>

                                  <figure v-else-if="ls.seat_box_type == 4" class="figure" style="width:120px;height:90px;padding:0;margin:0;">
                                  <img :src="ls.pic_path" data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.seat_name}}</figcaption>
                                  </figure>

                                  <figure v-else class="figure seat" :class="{'seat-select' : ls.selected == 1, 'seat-reserve' : ls.sold == 1, 'seat-sold': ls.sold == 2}" style="width:120px;height:92px;padding:0;margin:0;" @click="selectSeatTravelTrip(ls, $event)">
                                  <img :src="ls.pic_path_new" :data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.scode}}</figcaption>
                                  </figure>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div><!-- /.card-body -->
                      </div><!-- /.card -->
                    </div><!-- /.col-6 -->
                    <div class="col-12" v-show="depSeatSecondList.length > 0">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">ชั้นบน</h4>
                          <table class="table table-borderless table-sm" style="width:10rem;margin:5px auto;">
                            <!-- <tbody id="one-trip-seat-floor-second"></tbody> -->
                            <tbody>
                              <tr v-for="(list, idx) in depSeatSecondList" :key="idx">
                                <td v-for="ls in list" :key="ls.gridid" :colspan="ls.colspan" class="text-center" :class="{'border border-warning': ls.seat_box_type == 5}" style="padding:0;margin:0;">

                                  <i v-if="ls.seat_box_type == 1" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">&nbsp;</i>

                                  <i v-else-if="ls.seat_box_type == 2" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">บันได</i>

                                  <i v-else-if="ls.seat_box_type == 3" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">ห้องน้ำ</i>

                                  <figure v-else-if="ls.seat_box_type == 4" class="figure" style="width:120px;height:90px;padding:0;margin:0;">
                                  <img :src="ls.pic_path" data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.seat_name}}</figcaption>
                                  </figure>

                                  <figure v-else class="figure seat" :class="{'seat-select' : ls.selected == 1, 'seat-reserve' : ls.sold == 1, 'seat-sold': ls.sold == 2}" style="width:120px;height:92px;padding:0;margin:0;" @click="selectSeatTravelTrip(ls, $event)">
                                  <img :src="ls.pic_path_new" :data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.scode}}</figcaption>
                                  </figure>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div><!-- /.card-body -->
                      </div><!-- /.card -->
                    </div><!-- /.col-6 -->
                  </div><!-- /.row -->
                </section>
                <section style="float:left;position:absolute;display:block;width:100%;" id="right-seat" v-show="!isRetSkipSeat">
                  <div class="row m-0"> <!-- v-show="!isTravelTripSeatTab" -->
                    <div class="col-12" v-show="desSeatFirstList.length > 0">
                      <div class="card mb-2">
                        <div class="card-body">
                          <h4 class="card-title" v-show="desSeatSecondList.length > 0">ชั้นล่าง</h4>
                          <table class="table table-borderless table-sm" style="width:10rem;margin:5px auto;">
                            <!-- <tbody id="round-trip-seat-floor-first"></tbody> -->
                            <tbody>
                              <tr v-for="(list, idx) in desSeatFirstList" :key="idx">
                                <td v-for="ls in list" :key="ls.gridid" :colspan="ls.colspan" class="text-center" :class="{'border border-warning': ls.seat_box_type == 5}" style="padding:0;margin:0;">

                                  <i v-if="ls.seat_box_type == 1" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">&nbsp;</i>

                                  <i v-else-if="ls.seat_box_type == 2" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">บันได</i>

                                  <i v-else-if="ls.seat_box_type == 3" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">ห้องน้ำ</i>

                                  <figure v-else-if="ls.seat_box_type == 4" class="figure" style="width:120px;height:90px;padding:0;margin:0;">
                                  <img :src="ls.pic_path" data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.seat_name}}</figcaption>
                                  </figure>

                                  <figure v-else class="figure seat" :class="{'seat-select' : ls.selected == 1, 'seat-reserve' : ls.sold == 1, 'seat-sold': ls.sold == 2}" style="width:120px;height:92px;padding:0;margin:0;" @click="selectSeatReturnTrip(ls, $event)">
                                  <img :src="ls.pic_path_new" :data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.scode}}</figcaption>
                                  </figure>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div><!-- /.card-body -->
                      </div><!-- /.card -->
                    </div><!-- /.col-6 -->
                    <div class="col-12" v-show="desSeatSecondList.length > 0">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">ชั้นบน</h4>
                          <table class="table table-borderless table-sm" style="width:10rem;margin:5px auto;">
                            <!-- <tbody id="round-trip-seat-floor-second"></tbody> -->
                            <tbody>
                              <tr v-for="(list, idx) in desSeatSecondList" :key="idx">
                                <td v-for="ls in list" :key="ls.gridid" :colspan="ls.colspan" class="text-center" :class="{'border border-warning': ls.seat_box_type == 5}" style="padding:0;margin:0;">

                                  <i v-if="ls.seat_box_type == 1" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">&nbsp;</i>

                                  <i v-else-if="ls.seat_box_type == 2" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">บันได</i>

                                  <i v-else-if="ls.seat_box_type == 3" class="btn-blank" style="width:120px;height:90px;pointer-events:none;">ห้องน้ำ</i>

                                  <figure v-else-if="ls.seat_box_type == 4" class="figure" style="width:120px;height:90px;padding:0;margin:0;">
                                  <img :src="ls.pic_path" data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.seat_name}}</figcaption>
                                  </figure>

                                  <figure v-else class="figure seat" :class="{'seat-select' : ls.selected == 1, 'seat-reserve' : ls.sold == 1, 'seat-sold': ls.sold == 2}" style="width:120px;height:92px;padding:0;margin:0;" @click="selectSeatReturnTrip(ls, $event)">
                                  <img :src="ls.pic_path_new" :data-oldsrc="ls.pic_path" class="figure-img img-fluid" style="width:50px;height:50px;padding:0;padding-top:5px;margin:0;pointer-events:none;" />
                                  <figcaption class="figure-caption" style="padding:0;margin:0;font-size:1.75rem;pointer-events:none;">{{ls.scode}}</figcaption>
                                  </figure>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div><!-- /.card-body -->
                      </div><!-- /.card -->
                    </div><!-- /.col-6 -->
                  </div><!-- /.row -->
                </section>

              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container step seat -->

          <div class="container-fluid mt-2" style="background-color:#ffdf7c;" v-show="steps[3].isCurrent == true && steps[3].section == 1">
            <div class="row">
              <div class="payment-top-left bg-white">&nbsp;</div>
              <div class="col py-3 m-0 payment-amount" style="height:150px;">
                <h3 class="text-center">จำนวนเงินที่ต้องชำระ</h3>
                <h1 class="text-center">{{ total | currencyFormat }}</h1>
                <h3 class="text-center">บาท</h3>
              </div>
              <div class="payment-top-right bg-white">&nbsp;</div>
            </div><!-- /.row -->
            <div class="row" style="min-height:700px;">
              <div class="col mr-2 py-5 bg-white">
                <div class="row">
                  <div class="col-12">
                    <h4 class="text-center">เที่ยวไป</h4>
                    <table class="table table-sm table-borderless summary">
                      <tbody>
                        <tr>
                          <td class="p-0" style="width:40%;">ผู้ให้บริการ</td>
                          <td class="p-0">: {{ depRound.name1 }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">เส้นทาง</td>
                          <td class="p-0">: {{ depProvinceName }} - {{ desProvinceName }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">จุดขึ้น/ลงรถโดยสาร</td>
                          <td class="p-0">: {{ depStationName }} - {{ desStationName }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">มาตรฐานรถ</td>
                          <td class="p-0">: {{ depRound.grade_name }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">วันที่เดินทาง</td>
                          <td class="p-0">: {{ depDateName }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">เวลาออกเดินทาง</td>
                          <td class="p-0">: {{ depRound.frtime }} น.</td>
                        </tr>
                        <tr>
                          <td class="p-0">จำนวนผู้โดยสาร</td>
                          <td class="p-0">: {{ passengerQty }} ท่าน</td>
                        </tr>
                        <tr>
                          <td class="p-0">ราคาตั๋ว</td>
                          <td class="p-0">:
                            {{ depRound.price | numberFormat }} x {{ passengerQty }} = {{ (depRound.price * passengerQty) | currencyFormat }}
                            บาท                          </td>
                        </tr>
                        <tr v-show="insuranceDepartureQty">
                          <td class="p-0">ค่าธรรมเนียมประกันภัย</td>
                          <td class="p-0">:
                            {{ insuranceAmount }} x {{ insuranceDepartureQty }} = {{ (insuranceAmount * insuranceDepartureQty) | numberFormat }}
                            บาท                          </td>
                        </tr>
                        <tr>
                          <td class="p-0">ราคารวม</td>
                          <td class="p-0">:
                            {{ ((depRound.price * passengerQty) + (insuranceAmount * insuranceDepartureQty)) | currencyFormat }}
                            บาท                          </td>
                        </tr>
                        <tr>
                          <td class="p-0">ผู้โดยสาร</td>
                          <td class="p-0">
                            <ul class="p-0" style="list-style:none;">
                              <li v-for="(p, i) in passengersDeparture" :key="'ps'+i">
                                {{ i + 1}}.
                                <span v-if="p.name">{{ p.name }}</span>
                                <span v-else>ไม่ได้ระบุชื่อ</span>
                              </li>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-12" v-show="tripType == 2">
                    <h4 class="text-center">เที่ยวกลับ</h4>
                    <table class="table table-sm table-borderless summary">
                      <tbody>
                        <tr>
                          <td class="p-0" style="width:40%;">ผู้ให้บริการ</td>
                          <td class="p-0">: {{ desRound.name1 }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">เส้นทาง</td>
                          <td class="p-0">: {{ desProvinceName }} - {{ depProvinceName }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">จุดขึ้น/ลงรถโดยสาร</td>
                          <td class="p-0">: {{ desStationName }} - {{ depStationName }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">มาตรฐานรถ</td>
                          <td class="p-0">: {{ desRound.grade_name }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">วันที่เดินทาง</td>
                          <td class="p-0">: {{ desDateName }}</td>
                        </tr>
                        <tr>
                          <td class="p-0">เวลาออกเดินทาง</td>
                          <td class="p-0">: {{ desRound.frtime }} น.</td>
                        </tr>
                        <tr>
                          <td class="p-0">จำนวนผู้โดยสาร</td>
                          <td class="p-0">: {{ passengerQty }} ท่าน</td>
                        </tr>
                        <tr>
                          <td class="p-0">ราคาตั๋ว</td>
                          <td class="p-0">:
                            {{ desRound.price | numberFormat }} x {{ passengerQty }} = {{ (desRound.price * passengerQty) | currencyFormat }}
                            บาท                          </td>
                        </tr>
                        <tr v-show="insuranceReturnQty">
                          <td class="p-0">ค่าธรรมเนียมประกันภัย</td>
                          <td class="p-0">:
                            {{ insuranceAmount }} x {{ insuranceReturnQty }} = {{ (insuranceAmount * insuranceReturnQty) | numberFormat }}
                            บาท                          </td>
                        </tr>
                        <tr>
                          <td class="p-0">ราคารวม</td>
                          <td class="p-0">:
                            {{ ((desRound.price * passengerQty) + (insuranceAmount * insuranceReturnQty)) | currencyFormat }}
                            บาท                          </td>
                        </tr>
                        <tr>
                          <td class="p-0">ผู้โดยสาร</td>
                          <td class="p-0">
                            <ul class="p-0" style="list-style:none;">
                              <li v-for="(p, i) in passengersReturn" :key="'ps'+i">
                                {{ i + 1}}.
                                <span v-if="p.name">{{ p.name }}</span>
                                <span v-else>ไม่ได้ระบุชื่อ</span>
                              </li>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col bg-white ml-2 py-5">
                <div class="mb-3">
                  <h5 class="text-danger" id="textPaymentDenger">** กรุณาตรวจสอบความถูกต้องของข้อมูล  ก่อนทำการชำระเงิน</h5>
                </div>
                <h2 class="text-center">เลือกวิธีการชำระเงิน</h2>
                <ul style="list-style:none;">
                  <li>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="paymentMethod" v-model="paymentMethod" value="1" id="paymentMethod1">
                      <label for="paymentMethod1"></label>
                      <label class="form-check-label myradio-label mt--10 w-300p" for="paymentMethod1">
                        <h3 class="mb-0">ชำระด้วยเงินสด</h3>
                      </label>
                    </div>
                  </li>
                  <li>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input myradio" type="radio" name="paymentMethod" v-model="paymentMethod" value="2" id="paymentMethod2">
                      <label for="paymentMethod2" @click="showPaymentGatewayModal()"></label>
                      <label class="form-check-label myradio-label mt--10 w-300p" for="paymentMethod2" @click="showPaymentGatewayModal()">
                        <h3 class="mb-0">ชำระด้วย QR CODE ผ่านแอพพลิเคชั่นบนสมาร์ทโฟน</h3>
                      </label>
                    </div>
                  </li>
                </ul>
              </div>
            </div><!-- /.row -->
          </div><!-- /.container step payment -->
          <div class="container-fluid mt-2" style="background-color:#ffdf7c;" v-show="steps[3].isCurrent == true && steps[3].section == 2">
            <div class="row justify-content-center">
              <h1 class="text-primary py-5">กรุณาใส่เงินเพื่อทำรายการต่อ</h1>
            </div>
            <div class="row" style="min-height:700px;">
              <div class="col-5">
                <div class="card box-warning">
                  <div class="card-body">
                    <h3 id="textblinker">กรุณาใส่เงินให้พอดีกับราคาตั๋ว ระบบจะทอนเงินคืนท่านได้ไม่เกินมูลค่า 50 บาท</h3>
                  </div>
                </div>
              </div>
              <div class="col-7 pr-5">
                <div class="d-flex justify-content-end align-items-center mb-4">
                  <h1 class="description-text">ต้องชำระ</h1>
                  <h1 class="amount-text">{{ total | currencyFormat }}</h1>
                  <h1 class="description-text">บาท</h1>
                </div>
                <div class="d-flex justify-content-end align-items-center mb-4">
                  <h1 class="description-text">ใส่เงินแล้ว</h1>
                  <h1 class="amount-text">{{ receivedBaht | currencyFormat }}</h1>
                  <h1 class="description-text">บาท</h1>
                </div>
                <div class="d-flex justify-content-end align-items-center mb-4">
                  <h1 class="description-text">ยังขาดอยู่</h1>
                  <h1 class="amount-text">{{ remainBaht | currencyFormat }}</h1>
                  <h1 class="description-text">บาท</h1>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                  <h1 class="description-text">เงินทอน</h1>
                  <h1 class="amount-text">{{ changeBaht | currencyFormat }}</h1>
                  <h1 class="description-text">บาท</h1>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid mt-2" style="background-color:#ffdf7c;" v-show="steps[3].isCurrent == true && steps[3].section == 3">
            <h1>เดบิต/เครดิต</h1>
          </div>

          <div class="container mt-5" v-show="steps[4].isCurrent == true">
            <div class="row">
              <div class="col">
                <h1 class="text-center" style="font-size:5.5rem;color:orange;">ทำรายการเสร็จสิ้น กรุณารับตั๋ว</h1>
                <h1 class="text-center" style="font-size:3rem;color:orange;">เดินทางโดยสวัสดิภาพ ขอบคุณที่ใช้บริการ</h1>
                <h1 class="text-center mt-4" style="font-size:3.5rem;">ท่านต้องการจองตั๋วรถต่อหรือไม่?</h1>
                <div class="text-center">
                  <a href="https://booking-system24.com/busbooking/index.php/booking" class="mybutton w-200p">ใช่</a>
                  <a href="https://booking-system24.com/busbooking/index.php" class="mybutton w-200p">ไม่ใช่</a>
                </div>
              </div>
              <img src="https://booking-system24.com/busbooking/assets/images/icons/sawasdee.png" alt="" style="position:absolute;height:50vh;bottom:0px;right:10px;">
            </div><!-- /.row -->
            <div class="row" style="margin-top:200px">
              <div class="col-8">
                <h1>สถานที่ท่องเที่ยวยอดนิยม</h1>
                <div class="row">
                  <div class="col">
                    <img class="img" src="http://booking-system24.com/smarttour/fileuploads/product/small/2_1549626761_CockBurn_1540962467.jpg" style="width:100%">
                  </div>
                  <div class="col">
                    <img class="img" src="http://booking-system24.com/smarttour/fileuploads/product/small/2_1549626761_CockBurn_1540962467.jpg" style="width:100%">
                  </div>
                  <div class="col">
                    <img class="img" src="http://booking-system24.com/smarttour/fileuploads/product/small/2_1549626761_CockBurn_1540962467.jpg" style="width:100%">
                  </div>
                </div>
              </div>
            </div>
          </div><!-- /.container step travel -->

        </main>
        <div class="col-3 right-box" style="background-color: cyan;">
          <div class="row h-100">
            <div class="col">
              <div class="row justify-content-center">
                <div class="card message-box" v-show="steps[0].isCurrent == true">
                  <div class="card-body">
                    <p class="card-text text-primary">
                    </p>
                  </div>
                </div>
                <div class="card message-box" v-show="steps[1].isCurrent == true">
                  <div class="card-body">
                    <p class="card-text text-primary">
                    </p>
                  </div>
                </div>
                <div class="card message-box" v-show="steps[2].isCurrent == true && steps[2].section == 1">
                  <div class="card-body">
                    <p class="card-text text-primary">

                    </p>
                  </div>
                </div>
                <div class="card message-box seat-description" v-show="steps[2].isCurrent == true && steps[2].section == 2">
                  <div class="card-body py-0">
                    <span class="font-weight-bold">ประเภทที่นั่ง</span>
                    <div class="row">
                      <div class="col-12">
                        <img src="https://booking-system24.com/smartbus/assets/images/smartbus_img/seat/blueseat01.png" alt=""> ที่นั่งทั่วไป                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/smartbus/assets/images/smartbus_img/seat/monkseat01.png" alt=""> ที่นั่งสำหรับพระภิกษุ                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/smartbus/assets/images/smartbus_img/seat/pregnantseat01.png" alt=""> ที่นั่งสำหรับสตรีมีครรภ์                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/smartbus/assets/images/smartbus_img/seat/redseat01.png" alt=""> ที่นั่งพิเศษ                      </div>
                    </div>
                    <hr style="margin:0;">
                    <span class="font-weight-bold">ผู้โดยสาร</span>
                    <div class="row">
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/male.png" alt=""> ชาย                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/female.png" alt=""> หญิง                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/mk.png" alt=""> พระภิกษุ                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/female2.png" alt=""> สตรีมีครรภ์                      </div>
                    </div>
                    <hr style="margin:0;">
                    <span class="font-weight-bold">สถานะที่นั่ง</span>
                    <div class="row">
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/seat-available.jpg" alt=""> ว่าง                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/seat-selected.jpg" alt=""> กำลังเลือก                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/seat-reserved.jpg" alt=""> จองแล้ว                      </div>
                      <div class="col-12">
                        <img src="https://booking-system24.com/busbooking/assets/images/icons/seat-sold.jpg" alt=""> ขายแล้ว                      </div>
                    </div>
                  </div>
                </div>
                <div class="card message-box" v-show="steps[3].isCurrent == true && steps[3].section == 1">
                  <div class="card-body">
                    <p class="card-text text-primary">
                    </p>
                  </div>
                </div>
                <div class="card message-box" v-show="steps[3].isCurrent == true && steps[3].section == 2">
                  <div class="card-body text-primary d-flex align-items-center justify-content-center">
                    <div>
                      <h2 class="text-center">เหลือเวลาอีก</h2>
                      <h1 class="text-center" style="font-size: 5rem">{{ timeReformat }}</h1>
                      <h2 class="text-center"><span v-show="minutes > 0">นาที</span><span v-show="timeReformat < 60">วินาที</span></h2>
                    </div>
                  </div>
                </div>
                <div class="card message-box" v-show="steps[3].isCurrent == true && steps[3].section == 3">
                  <div class="card-body">
                    <p class="card-text text-primary">
                    </p>
                  </div>
                </div>
                <div class="card message-box" v-show="steps[4].isCurrent == true">
                  <div class="card-body">
                    <p class="card-text text-primary">
                    </p>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="nextStepButtonShow && steps[4].isCurrent != true">
                <!-- <a href="" class="mybutton">ขั้นตอนถัดไป</a>  -->
                <a href="javascript:void(0);" @click="nextStep()" class="mybutton">ขั้นตอนถัดไป</a>
              </div>
              <!-- <div class="row justify-content-center" style="margin-bottom:10px;"> -->
                <!-- <a href="" class="mybutton">ขั้นตอนถัดไป</a>  -->
                <!-- <a href="javascript:void(0);" @click="printBooking()" class="mybutton">Print</a>
              </div> -->
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="roundButtonShow">
                <a href="javascript:void(0);" @click="nextStep()" class="mybutton">ดูรอบรถ</a>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="bookingButtonShow">
                <a href="javascript:void(0);" @click="nextStep()" class="mybutton">จองตั๋ว</a>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="saveButtonShow">
                <a href="javascript:void(0);" @click="saveBookingFromButtonClick()" class="mybutton">SAVE</a>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="RejectTicket && receivedBaht > 0">
                  <a href="javascript:void(0);" @click="rejectBillTicket()" class="mybutton">ยกเลิกรายการ</a>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="printTicketButtonShow">
                <a href="javascript:void(0);" @click="printBooking()" class="mybutton">PRINT</a>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;" v-show="prevStepButtonShow">
                <a href="javascript:void(0);" @click="previousStep()" class="mybutton">ย้อนกลับ</a>
              </div>
              <div class="row justify-content-center" style="margin-bottom:10px;position:absolute;bottom:10px;width:100%;">
                <a href="javascript:void(0);" @click="homeStep()" class="mybutton2">กลับสู่เมนู</a>
              </div>
            </div>
          </div>
        </div><!-- /.col-3 -->
      </div><!-- /.row -->


      <!-- Modal area -->

      <!-- Modal provinceDepartureModal -->
      <div class="modal fade" id="provinceDepartureModal" tabindex="-1" role="dialog" aria-labelledby="provinceDepartureModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered fit-height fit-width" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="input-group mb-3" style="position:sticky;">
                    <input type="text" class="form-control form-control-lg mytextbox province-search" id="searchProvinceDeparture" v-model="depProvinceSearch" placeholder="ค้นหาที่นี่">
                    <!-- <div class="input-group-append">
                      <button class="btn btn-warning" type="button" id="button-addon2" style="width:100px;height:48px;" @click="loadProvinceDepartureItem()">ค้นหาที่นี่</button>
                    </div> -->
                   <!--  <button type="button" class="close modal-close-btn ml-2" data-dismiss="modal" aria-label="Close">
                      <img src="" width="50">
                    </button> -->
                    <button type="button" class="close modal-close-btn2 ml-2" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-times fa-2x"></i>
                    </button>
                  </div>
                  <div class="col-6">
                    <div class="card mycard card-border-right">
                      <div class="card-body">
                        <h3>สถานีต้นทาง</h3>
                        <div id="provinceDepartureItem" class="list-group list-group-flush list-group-province mt-3" role="tablist">
                          <a
                            href="javascript:void(0);"
                            class="list-group-item list-group-item-action"
                            v-for="p in depProvinceList"
                            :key="p.provid"
                            :class="{'active show' : p.provid == depProvinceId}"
                            @click="loadStationDepartureItem(p)"
                          >
                            {{ p.name }}
                          </a>
                        </div><!-- /.list-group -->
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                  </div><!-- /.col-6 -->
                  <div class="col-6">
                    <div class="card mycard">
                      <div class="card-body">
                        <h3>จุดขึ้นรถ</h3>
                        <div id="stationDepartureItem" class="list-group list-group-flush list-group-province mt-3" role="tablist">
                          <a
                            href="javascript:void(0);"
                            class="list-group-item list-group-item-action"
                            v-for="s in depStationList"
                            :key="s.terid"
                            :class="{'active show' : s.terid == depStationId}"
                            @click="setStationDeparture(s)"
                          >
                            {{ s.name }}
                          </a>
                        </div><!-- /.list-group -->
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                  </div><!-- /.col-6 -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-warning w-150p" data-dismiss="modal">ตกลง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal provinceDestinationModal -->
      <div class="modal fade" id="provinceDestinationModal" tabindex="-1" role="dialog" aria-labelledby="provinceDestinationModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered fit-height fit-width" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="input-group mb-3" style="position:sticky;">
                    <input type="text" class="form-control form-control-lg mytextbox province-search" id="searchProvinceDestination" v-model="desProvinceSearch" placeholder="ค้นหาที่นี่">
                    <!-- <div class="input-group-append">
                      <button class="btn btn-warning" type="button" id="button-addon2" style="width:100px;height:48px;" @click="loadProvinceDestinationItem()">ค้นหาที่นี่</button>
                    </div> -->
                    <!-- <button type="button" class="close modal-close-btn ml-2" data-dismiss="modal" aria-label="Close">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/close.png" width="50">
                    </button> -->
                    <button type="button" class="close modal-close-btn2 ml-2" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-times fa-2x"></i>
                    </button>
                  </div>
                  <div class="col-6">
                    <div class="card mycard card-border-right">
                      <div class="card-body">
                        <h3>สถานีปลายทาง</h3>
                        <div id="provinceDestinationItem" class="list-group list-group-flush list-group-province mt-3" role="tablist">
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action" v-for="p in desProvinceList" :key="p.provid" :class="{'active show' : p.provid == desProvinceId}" @click="loadStationDestinationItem(p)">{{ p.name }}</a>
                        </div><!-- /.list-group -->
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                  </div><!-- /.col-6 -->
                  <div class="col-6">
                    <div class="card mycard">
                      <div class="card-body">
                        <h3>จุดลงรถ</h3>
                        <div id="stationDestinationItem" class="list-group list-group-flush list-group-province mt-3" role="tablist">
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action" v-for="s in desStationList" :key="s.terid" :class="{'active show' : s.terid == desStationId}" @click="setStationDestination(s)">{{ s.name }}</a>
                        </div><!-- /.list-group -->
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                  </div><!-- /.col-6 -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-warning w-150p" data-dismiss="modal">ตกลง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal dateModal -->
      <div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="pt-2">วันที่ไป</h3>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row justify-content-center">
                  <div class="col">
                    <div id="fromDate"></div>
                  </div><!-- /.col-6 -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary w-100p mr-auto" data-dismiss="modal">ปิด</button>
            </div> -->
          </div>
        </div>
      </div>

      <!-- Modal date2Modal -->
      <div class="modal fade" id="date2Modal" tabindex="-1" role="dialog" aria-labelledby="date2ModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="min-width:1000px;max-width:1000px;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="modal-close-btn2 ml-auto" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-6 text-center card-border-right">
                    <h3 style="margin-bottom:0">วันที่เที่ยวไป</h3>
                    <hr style="margin:0">
                    <div id="fromDate2"></div>
                  </div><!-- /.col-6 -->
                  <div class="col-6 text-center">
                    <h3 style="margin-bottom:0">วันที่เที่ยวกลับ</h3>
                    <hr style="margin:0">
                    <div id="toDate"></div>
                  </div><!-- /.col-6 -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary w-100p mr-auto" data-dismiss="modal">ปิด</button>
            </div> -->
          </div>
        </div>
      </div>

      <!-- Modal filterByTimeModal -->
      <div class="modal fade" id="filterByTimeModal" tabindex="-1" role="dialog" aria-labelledby="filterByTimeModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByTimeModalTitle">เลือกตามช่วงเวลา</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTime" id="filterByTime5" value="" v-model="depTimeFilter" @change="filterByTime('Round', 1)">
                <label for="filterByTime5"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTime5">
                  แสดงทั้งหมด                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTime" id="filterByTime1" value="1" v-model="depTimeFilter" @change="filterByTime('Round', 1)">
                <label for="filterByTime1"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTime1">
                  00:00 - 05:59
                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTime" id="filterByTime2" value="2" v-model="depTimeFilter" @change="filterByTime('Round', 1)">
                <label for="filterByTime2"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTime2">
                  06:00 - 11:59
                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTime" id="filterByTime3" value="3" v-model="depTimeFilter" @change="filterByTime('Round', 1)">
                <label for="filterByTime3"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTime3">
                  12:00 - 17:59
                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTime" id="filterByTime4" value="4" v-model="depTimeFilter" @change="filterByTime('Round', 1)">
                <label for="filterByTime4"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTime4">
                  18:00 - 23:59
                </label>
              </div>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg w-150p" data-dismiss="modal" @click="clearFilter(1, 'time')">ยกเลิกตัวกรอง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByTimeRoundTripModal -->
      <div class="modal fade" id="filterByTimeRoundTripModal" tabindex="-1" role="dialog" aria-labelledby="filterByTimeRoundTripModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByTimeRoundTripModalTitle">เลือกตามช่วงเวลา</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTimeRoundTrip" id="filterByTimeRoundTrip5" value="" v-model="desTimeFilter" @change="filterByTime('Round', 2)">
                <label for="filterByTimeRoundTrip5"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTimeRoundTrip5">
                  แสดงทั้งหมด                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTimeRoundTrip" id="filterByTimeRoundTrip1" value="1" v-model="desTimeFilter" @change="filterByTime('Round', 2)">
                <label for="filterByTimeRoundTrip1"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTimeRoundTrip1">
                  00:00 - 05:59
                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTimeRoundTrip" id="filterByTimeRoundTrip2" value="2" v-model="desTimeFilter" @change="filterByTime('Round', 2)">
                <label for="filterByTimeRoundTrip2"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTimeRoundTrip2">
                  06:00 - 11:59
                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTimeRoundTrip" id="filterByTimeRoundTrip3" value="3" v-model="desTimeFilter" @change="filterByTime('Round', 2)">
                <label for="filterByTimeRoundTrip3"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTimeRoundTrip3">
                  12:00 - 17:59
                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByTimeRoundTrip" id="filterByTimeRoundTrip4" value="4" v-model="desTimeFilter" @change="filterByTime('Round', 2)">
                <label for="filterByTimeRoundTrip4"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByTimeRoundTrip4">
                  18:00 - 23:59
                </label>
              </div>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg w-150p" data-dismiss="modal" @click="clearFilter(2, 'time')">ยกเลิกตัวกรอง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByPriceModal -->
      <div class="modal fade" id="filterByPriceModal" tabindex="-1" role="dialog" aria-labelledby="filterByPriceModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByPriceModalTitle">เลือกตามช่วงราคา</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPrice" id="filterByPrice5" value="" v-model="depPriceFilter">
                <label for="filterByPrice5"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPrice5">
                  แสดงทั้งหมด                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPrice" id="filterByPrice1" value="1" v-model="depPriceFilter">
                <label for="filterByPrice1"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPrice1">
                  ต่ำกว่า 100 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPrice" id="filterByPrice2" value="2" v-model="depPriceFilter">
                <label for="filterByPrice2"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPrice2">
                  100 - 199 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPrice" id="filterByPrice3" value="3" v-model="depPriceFilter">
                <label for="filterByPrice3"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPrice3">
                  200 - 299 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPrice" id="filterByPrice4" value="4" v-model="depPriceFilter">
                <label for="filterByPrice4"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPrice4">
                  300 - 399 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPrice" id="filterByPrice5" value="5" v-model="depPriceFilter">
                <label for="filterByPrice5"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPrice5">
                  400 บาท ขึ้นไป                </label>
              </div>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg w-150p" data-dismiss="modal" @click="clearFilter(1, 'price')">ยกเลิกตัวกรอง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByPriceRoundTripModal -->
      <div class="modal fade" id="filterByPriceRoundTripModal" tabindex="-1" role="dialog" aria-labelledby="filterByPriceRoundTripModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByPriceRoundTripModalTitle">เลือกตามช่วงราคา</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPriceRoundTrip" id="filterByPriceRoundTrip5" value="" v-model="desPriceFilter">
                <label for="filterByPriceRoundTrip5"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPriceRoundTrip5">
                  แสดงทั้งหมด                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPriceRoundTrip" id="filterByPriceRoundTrip1" value="1" v-model="desPriceFilter">
                <label for="filterByPriceRoundTrip1"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPriceRoundTrip1">
                  ต่ำกว่า 100 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPriceRoundTrip" id="filterByPriceRoundTrip2" value="2" v-model="desPriceFilter">
                <label for="filterByPriceRoundTrip2"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPriceRoundTrip2">
                  100 - 199 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPriceRoundTrip" id="filterByPriceRoundTrip3" value="3" v-model="desPriceFilter">
                <label for="filterByPriceRoundTrip3"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPriceRoundTrip3">
                  200 - 299 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPriceRoundTrip" id="filterByPriceRoundTrip4" value="4" v-model="desPriceFilter">
                <label for="filterByPriceRoundTrip4"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPriceRoundTrip4">
                  300 - 399 บาท                </label>
              </div>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input myradio radio40" type="radio" name="filterByPriceRoundTrip" id="filterByPriceRoundTrip5" value="5" v-model="desPriceFilter">
                <label for="filterByPriceRoundTrip5"></label>
                <label class="form-check-label myradio-label mt--10" for="filterByPriceRoundTrip5">
                  400 บาท ขึ้นไป                </label>
              </div>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg w-150p" data-dismiss="modal" @click="clearFilter(2, 'price')">ยกเลิกตัวกรอง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByDateModal -->
      <div class="modal fade" id="filterByDateModal" tabindex="-1" role="dialog" aria-labelledby="filterByDateModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByDateModalTitle">วันที่เที่ยวไป</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="col">
                <div id="fromDate3"></div>
              </div><!-- /.col-6 -->
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByDateRoundTripModal -->
      <div class="modal fade" id="filterByDateRoundTripModal" tabindex="-1" role="dialog" aria-labelledby="filterByDateRoundTripModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByDateRoundTripModalTitle">เลือกตามวันที่</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="col">
                <div id="toDate2"></div>
              </div><!-- /.col-6 -->
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByVendorModal -->
      <div class="modal fade" id="filterByVendorModal" tabindex="-1" role="dialog" aria-labelledby="filterByVendorModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByVendorModalTitle">เลือกตามผู้ให้บริการรถโดยสาร</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <ul style="list-style:none;">
                <li>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input myradio radio40" type="radio" name="radioGendor1" v-model="depVendorFilter" value="" id="radioGendor1-5">
                    <label for="radioGendor1-5"></label>
                    <label class="form-check-label myradio-label mt--10" for="radioGendor1-5">
                      แสดงทั้งหมด                    </label>
                  </div>
                </li>
                <li v-for="(v, idx) in vendorList" :key="v.code">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input myradio radio40" type="radio" name="radioGendor1" v-model="depVendorFilter" :value="v.code" :id="'radioGendor1-'+idx">
                    <label :for="'radioGendor1-'+idx"></label>
                    <label class="form-check-label myradio-label mt--10" :for="'radioGendor1-'+idx">
                      {{ v.name }}
                    </label>
                  </div>
                </li>
              </ul>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg w-150p" data-dismiss="modal" @click="clearFilter(1, 'vendor')">ยกเลิกตัวกรอง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal filterByVendorRoundTripModal -->
      <div class="modal fade" id="filterByVendorRoundTripModal" tabindex="-1" role="dialog" aria-labelledby="filterByVendorRoundTripModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterByVendorRoundTripModalTitle">เลือกตามผู้ให้บริการรถโดยสาร</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <ul style="list-style:none;">
                <li>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input myradio radio40" type="radio" name="radioGendor2" v-model="desVendorFilter" value="" id="radioGendor2-5">
                    <label for="radioGendor2-5"></label>
                    <label class="form-check-label myradio-label mt--10" for="radioGendor2-5">
                      แสดงทั้งหมด                    </label>
                  </div>
                </li>
                <li v-for="(v, idx) in vendorList" :key="v.code">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input myradio radio40" type="radio" name="radioGendor2" v-model="desVendorFilter" :value="v.code" :id="'radioGendor2-'+idx">
                    <label :for="'radioGendor2-'+idx"></label>
                    <label class="form-check-label myradio-label mt--10" :for="'radioGendor2-'+idx">
                      {{ v.name }}
                    </label>
                  </div>
                </li>
              </ul>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <!-- <button type="button" class="btn btn-outline-secondary btn-lg w-150p" data-dismiss="modal" @click="clearFilter(2, 'vendor')">ยกเลิกตัวกรอง</button> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Modal passengerTravelTripModal -->
      <div class="modal fade" id="passengerTravelTripModal" tabindex="-1" role="dialog" aria-labelledby="passengerTravelTripModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="passengerTravelTripModalTitle">เลือกรายชื่อ</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                 <div class="col-12" v-for="(ps, idx) in depPassengerRemainList" :key="'travelTripRadios'+ps.psuuid">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input myradio" type="radio" :id="'depPsRemainList'+ps.psuuid" :data-passport="ps.passport" :data-gender="ps.gender" :value="ps" v-model="depPassengerSelectObj">
                    <label :for="'depPsRemainList'+ps.psuuid"></label>
                    <label class="form-check-label myradio-label mt--10" :for="'depPsRemainList'+ps.psuuid">
                      <img style="height:30px;" :src="seatImgUrl.male" v-if="ps.gender == 1">
                      <img style="height:30px;" :src="seatImgUrl.female" v-else>
                      <span v-if="ps.name">{{ ps.name }}</span>
                      <span v-else>ไม่ได้ระบุชื่อ</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="useSeatTravelTrip()">ใช้รายการที่เลือก</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal passengerReturnTripModal -->
      <div class="modal fade" id="passengerReturnTripModal" tabindex="-1" role="dialog" aria-labelledby="passengerReturnTripModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="passengerReturnTripModalTitle">เลือกรายชื่อ</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                 <div class="col-12" v-for="(ps, idx) in desPassengerRemainList" :key="'returnTripRadios'+ps.psuuid">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input myradio" type="radio" :id="'desPsRemainList'+ps.psuuid" :data-passport="ps.passport" :data-gender="ps.gender" :value="ps" v-model="desPassengerSelectObj">
                    <label :for="'desPsRemainList'+ps.psuuid"></label>
                    <label class="form-check-label myradio-label mt--10" :for="'desPsRemainList'+ps.psuuid">
                      <img style="height:30px;" :src="seatImgUrl.male" v-if="ps.gender == 1">
                      <img style="height:30px;" :src="seatImgUrl.female" v-else>
                      <span v-if="ps.name">{{ ps.name }}</span>
                      <span v-else>ไม่ได้ระบุชื่อ</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="useSeatReturnTrip()">ใช้รายการที่เลือก</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal idCardScanModal -->
      <div class="modal fade" id="idCardScanModal" tabindex="-1" role="dialog" aria-labelledby="idCardScanModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="idCardScanModalTitle">เลือกรายชื่อ</h5>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                 <div class="col-12">

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100p mr-auto" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal insuranceModal -->
      <div class="modal fade" id="insuranceModal" tabindex="-1" role="dialog" aria-labelledby="insuranceModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered fit-height fit-width" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">รายละเอียดประกันภัยการเดินทาง
                <img src="https://booking-system24.com/busbooking/assets/images/icons/ASIALOGOENG-small.png" style="height:50px;">
              </h4>
              <button type="button" class="modal-close-btn2" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <h5>การประกันภัยนี้ให้ความคุ้มครองความสูญเสียหรือบาดเจ็บของผู้เอาประกันภัยโดยอุบัติเหตุ ซึ่งเกิดขึ้นระหว่างระยะเวลาการเดินทาง โดยมีความคุ้มครองดังต่อไปนี้</h5>
                  <hr/>
                </div>
                <div class="col-12 text-info">
                  <div class="d-flex align-items-between">
                    <h5>การสูญเสีย การสูญเสียอวัยวะ สายตาหรือทุพพลภาพถาวรโดยสิ้นเชิง</h5>
                    <h5 class="ml-auto">ท่านละ 1,000,000 THB</h5>
                  </div>
                  <hr/>
                </div>
                <div class="col-12 text-info">
                  <div class="d-flex align-items-between">
                    <h5>การรักษาพยาบาล</h5>
                    <h5 class="ml-auto">ท่านละ 500,000 THB</h5>
                  </div>
                  <hr/>
                </div>
                <div class="col-12">
                  <h5 class="text-info">ข้อกำหนดและเงื่อนไข :</h5>
                  <h5>
                    -&nbsp;&nbsp;ผู้เอาประกันภัยจะต้องแจ้ง ชื่อ-นามสกุล เลขบัตรประจำตัวประชาชน วันเดือนปีเกิด วันเดินทางไป-กลับ สถานที่ไปกับเจ้าหน้าที่ก่อนเดินทางทุกครั้ง<br/>
                    -&nbsp;&nbsp;ทุกครั้งที่ผู้เอาประกันภัยเดินทางภายในระยะเวลาประกันภัย โดยจำกัดระยะเวลาไม่เกิน 15 วันต่อการเดินทางแต่ละครั้ง<br/>
                    -&nbsp;&nbsp;หากมีกรณีเหตุฉุกเฉินทางการแพทย์ การจี้เครื่องบิน การล่าช้าขัดข้องของเครื่องบินที่ผู้เอาประกันภัยใช้โดยสาร ซึ่งทำให้ผู้เอาประกันภัยไม่สามารถเดินทางกลับได้ภายในกำหนดวันกลับ กรมธรรม์ประกันภัยนี้จะขยายความคุ้มครองออกไปอัตโนมัติจนกระทั่งสิ้นสุด

                  </h5>
                </div>
              </div>
            </div>
            <div class="modal-footer d-none">
              <button type="button" class="btn btn-outline-secondary w-100p mr-auto" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Reject bill -->
      <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1024px;width:700px !important">
              <div class="modal-content">
                <div class="modal-header" style="margin-left:230px">
                  <h1 class="modal-title" id="rejectModalTitle">ยกเลิกการทำรายการ</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <!-- <span aria-hidden="true">&times;</span> -->
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/close.png" width="50">
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12 pl-5"><h1>กรุณาเลือกสาเหตุการยกเลิก</h1></div>
                      <div class="col-12 form-check form-check-inline pl-5 ml-5">
                        <input class="form-check-input myradio" type="radio" name="paymentreason" v-model="disReject" value="2" id="paymentreason1">
                        <label for="paymentreason1"></label>
                        <label class="form-check-label myradio-label mt--10" for="paymentreason1"><h3>เงินทอนในเครื่องไม่พอ</h3></label>
                      </div>
                      <div class="col-12 form-check form-check-inline pl-5 ml-5">
                        <input class="form-check-input myradio" type="radio" name="paymentreason" v-model="disReject" value="3" id="paymentreason2">
                        <label for="paymentreason2"></label>
                        <label class="form-check-label myradio-label mt--10" for="paymentreason2"><h3>เงินไม่พอสำหรับการซื้อ</h3></label>
                      </div>
                      <div class="col-12">
                        <hr>
                      </div>
                      <div class="col-12 text-center" style="line-height:1">
                        <h4>เครื่องไม่สามารถคืนเงินได้</h4>
                        <h4>กรุณาติดต่อ Call Center โทร. 098-261-0126</h4>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-center">
                    <button type="button" class="mybutton-small" @click="nextFinalReject()"><h1>ยืนยัน</h1></button>
                    <button type="button" class="mybutton-small" data-dismiss="modal" @click="cancelReject()"><h1>ยกเลิก</h1></button>
                  </div>
                </div>
              </div>
            </div>
      <!-- End Reject bill-->
      <!-- Modal paymentGatewayModal -->
      <div class="modal fade" id="paymentGatewayModal" tabindex="-1" role="dialog" aria-labelledby="insuranceModalTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">ชำระด้วย QR CODE ผ่านแอพพลิเคชั่นบนสมาร์ทโฟน</h4>
              <button type="button" class="modal-close-btn2" @click="hidePaymentGatewayModal()" aria-label="Close" id="btnGatewayModalClose">
                <i class="fa fa-times fa-2x"></i>
              </button>
            </div>
            <div class="modal-body">
              <section id="choice-pad" style="float:left;width:100%;">
                <div class="row">
                  <div class="col-12">
                    <h5 class="text-danger" id="textQRDanger">การชำระเงินผ่านแอพพลิเคชั่น จะไม่สามารถคืนเงินได้ กรุณาตรวจสอบความถูกต้องก่อนชำระเงิน</h5>
                  </div>
                  <!-- first gateway -->
                  <div class="col-2">
                    <input class="form-check-input myradio" type="radio" name="paymentSelector" v-model="paymentSelector" value="thaiqr" id="selector1">
                    <label for="selector1"></label>
                  </div>
                  <div class="col-10 mt-1">
                    <label class="myradio-label mx-2" for="selector1">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/payment-gateway/thai-qr-logo.png" width="100" id="thaiqrlabel1"  />
                    </label>
                    <label class="myradio-label mx-2" for="selector1" id="thaiqrlabel2">
                      Thai QR Payment QR Code
                    </label>
                  </div>

                  <!-- second gateway -->
                  <div class="col-2" hidden="true">
                    <input class="form-check-input myradio" type="radio" name="paymentSelector" v-model="paymentSelector" value="linepay" id="selector2">
                    <label for="selector2"></label>
                  </div>
                  <div class="col-10 mt-1" hidden="true">
                    <label class="myradio-label mx-2" for="selector2">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/payment-gateway/line-pay-logo.png" width="100" id="linepaylabel1"  />
                    </label>
                    <label class="myradio-label mx-2" for="selector2" id="linepaylabel2">
                      Line Pay QR Code
                    </label>
                  </div>

                  <!-- third gateway -->
                  <div class="col-2">
                    <input class="form-check-input myradio" type="radio" name="paymentSelector" v-model="paymentSelector" value="waves" id="selector3">
                    <label for="selector3"></label>
                  </div>
                  <div class="col-10 mt-1">
                    <label class="myradio-label mx-2" for="selector3">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/payment-gateway/waves-logo.png" width="100" id="waveslabel1"  />
                    </label>
                    <label class="myradio-label mx-2" for="selector3" id="waveslabel2">
                      Waves QR Code
                    </label>
                  </div>

                  <!-- forth gateway -->
                  <div class="col-2">
                    <input class="form-check-input myradio" type="radio" name="paymentSelector" v-model="paymentSelector" value="alipay" id="selector4">
                    <label for="selector4"></label>
                  </div>
                  <div class="col-10 mt-1">
                    <label class="myradio-label mx-2" for="selector4">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/payment-gateway/alipay-logo.png" width="100" id="alipaylabel1"  />
                    </label>
                    <label class="myradio-label mx-2" for="selector4" id="alipaylabel2">
                      AliPay QR Code
                    </label>
                  </div>

                  <!-- fifth gateway -->
                  <div class="col-2">
                    <input class="form-check-input myradio" type="radio" name="paymentSelector" v-model="paymentSelector" value="wechatpay" id="selector5">
                    <label for="selector5"></label>
                  </div>
                  <div class="col-10 mt-1">
                    <label class="myradio-label mx-2" for="selector5">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/payment-gateway/wechat-logo.png" width="100" id="wechatpaylabel1"  />
                    </label>
                    <label class="myradio-label mx-2" for="selector5" id="wechatpaylabel2">
                      Wechat Pay QR Code
                    </label>
                  </div>

                  <!-- sixth gateway -->
                  <div class="col-2" hidden="true">
                    <input class="form-check-input myradio" type="radio" name="paymentSelector" v-model="paymentSelector" value="creditcard" id="selector6">
                    <label for="selector6"></label>
                  </div>
                  <div class="col-10 mt-1" hidden="true">
                    <label class="myradio-label mx-2" for="selector6">
                      <img src="https://booking-system24.com/busbooking/assets/images/icons/payment-gateway/master-visa-logo.png" width="100" id="creditcardlabel1"  />
                    </label>
                    <label class="myradio-label mx-2" for="selector6" id="creditcardlabel2">
                      Credit Card QR Code
                    </label>
                  </div>
                  <div class="col-12 text-center">
                    <button v-show="paymentSelector" type="button" @click="changeto_qr_pad()" class="btn btn-lg btn-primary">ตกลง</button>
                  </div>

                </div>
              </section> <!-- end of choice pad -->

              <section id="qr-pad" style="float:left;width:100%;">
                <h2 class="text-center text-primary font-weight-bold">กรุณาสแกน QR CODE เพื่อทำรายการต่อ</h2>
                <div class="p-4 mb-3 mt-4 text-center" style="border-radius: 7px;background: #ffeeb8;">
                  <div class="py-3 mb-3 mt-2 text-center" style="border-radius: 7px;background: white;">
                    <h4 class="text-center">เหลือเวลาอีก</h4>
                    <h2 class="text-center" style="font-size: 3rem">{{ timeReformat }}</h3>
                    <h4 class="text-center"><span v-show="minutes > 0">นาที</span><span v-show="timeReformat < 60">วินาที</span></h4>
                  </div>
                  <img id="qr-generator" width="200" />
                  <div class="mt-3 text-center">
                    <label>
                      <img id="qrlabel1" width="100" />
                    </label>
                    <label class="text-primary" id="qrlabel2"></label>
                  </div>
                  <button type="button" class="btn btn-lg btn-success mt-3" @click="startInquiry()">ยืนยันการชำระเงิน</button>
                  <div>
                    <label id="textScanDanger" class="text-danger font-weight-bold">กรุณากดปุ่มยืนยัน(สีเขียว) เพื่อยืนยันการชำระเงิน</label>
                  </div>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-lg btn-primary" @click="changeto_choice_pad()" id="btnPreviouspad">ย้อนกลับ</button>
                </div>
              </section> <!-- end of qr pad -->
            </div>

          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->


    <script src="https://booking-system24.com/busbooking/assets/js/jquery-3.3.1.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/popper.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/bootstrap.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/jquery-ui.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/sweetalert2.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/bootstrap-datepicker.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/locales/bootstrap-datepicker.th.js"></script>
<script src="https://booking-system24.com/busbooking/assets/libraries/keyboard/js/jquery.keyboard.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/libraries/keyboard/js/jquery.keyboard.extension-all.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/libraries/keyboard/js/jquery.mousewheel.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/libraries/keyboard/layouts/thai.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/vue.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/vue-i18n.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/axios.min.js"></script>
<script src="https://booking-system24.com/busbooking/assets/js/moment-with-locales.min.js"></script>
<!-- Lastly add this package -->
<script src="https://booking-system24.com/busbooking/assets/js/vue-loading-overlay@3.js?v=0.1"></script>
<script src="https://booking-system24.com/busbooking/assets/js/app.js?v=1"></script>    <script>

      var lang = get('lang') || 'th';
      var lang_date = lang == 'th' ? lang : 'en';

      var vueLoadingConfig = {
        canCancel: false,
        color: '#ff9900',
        loader: 'dots',
        width: 400,
        height: 400,
      };

      Vue.use(VueLoading, vueLoadingConfig);
      Vue.component('loading', VueLoading);

      var app = new Vue({
        el: '#app',
        data: {
          bookingId: '',
          steps: [
            {
              step: 1,
              isCurrent: true,
              isVisited: false,
              isShowStep: true,
              title: "ค้นหาเส้นทาง",
              defaultImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step1.png",
              currentImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step1-current.png",
              visitedImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step1-visited.png",
            },
            {
              step: 2,
              isCurrent: false,
              isVisited: false,
              isShowStep: true,
              title: "เลือกเที่ยวรถ",
              defaultImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step2.png",
              currentImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step2-current.png",
              visitedImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step2-visited.png",
            },
            {
              step: 3,
              section: 1,
              isCurrent: false,
              isVisited: false,
              isShowStep: true,
              title: "เลือกที่นั่ง",
              defaultImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step3.png",
              currentImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step3-current.png",
              visitedImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step3-visited.png",
            },
            {
              step: 4,
              section: 1,
              isCurrent: false,
              isVisited: false,
              isShowStep: true,
              title: "ชำระเงิน",
              defaultImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step4.png",
              currentImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step4-current.png",
              visitedImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step4-visited.png",
            },
            {
              step: 5,
              isCurrent: false,
              isVisited: false,
              isShowStep: false,
              title: "เดินทาง",
              defaultImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step5.png",
              currentImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step5-current.png",
              visitedImg: "https://booking-system24.com/busbooking/assets/images/icons/ticket-step/step5-visited.png",
            },
          ],
          seatImgUrl: {
            male: "https://booking-system24.com/busbooking/assets/images/icons/male.png",
            female: "https://booking-system24.com/busbooking/assets/images/icons/female.png",
            monk: "https://booking-system24.com/busbooking/assets/images/icons/mk.png",
            female2: "https://booking-system24.com/busbooking/assets/images/icons/female2.png",
          },
          passengersDeparture: [],
          passengersReturn: [],
          paymentMethod: '',
          paymentSelector: '',
          passengerQty: 1,
          tripType: 1,
          carType: 1,
          depRound: {},
          depRoundId: '',
          depRoundIdTemp: '',
          desRound: {},
          desRoundId: '',
          desRoundIdTemp: '',
          depProvinceName: '',
          desProvinceName: '',
          depProvinceSearch: '',
          desProvinceSearch: '',
          depProvinceId: '',
          desProvinceId: '',
          depProvinceList: [],
          desProvinceList: [],
          depStationList: [],
          depStationId: '',
          depStationName: '',
          desStationList: [],
          desStationId: '',
          desStationName: '',
          depDate: '',
          depDateName: '',
          desDate: '',
          desDateName: '',
          depRoundList: [],
          desRoundList: [],
          vendorList: [],
          insuranceAmount: 100,
          insuranceDepartureQty: 0,
          insuranceReturnQty: 0,

          // seat step
          depSeatFirstList: [],
          depSeatSecondList: [],
          depSeatSelectList: [],
          depPassengerRemainList: [],
          depSeatSelectObj: {},

          desSeatFirstList: [],
          desSeatSecondList: [],
          desSeatSelectList: [],
          desPassengerRemainList: [],
          desSeatSelectObj: {},

          // application state
          documentMounted: false,
          currentStep: 0,
          isTravelTrip: true,
          isTravelTripSeatTab: true,
          isTravelTripPassengerTab: true,
          depTimeFilter: '',
          depPriceFilter: '',
          depVendorFilter: '',
          desTimeFilter: '',
          desPriceFilter: '',
          desVendorFilter: '',
          depPassengerSelectObj: '',
          desPassengerSelectObj: '',
          lang: lang,
          nextStepButtonShow: true,
          prevStepButtonShow: false,
          depRoundListSortBy: '',
          depRoundListSortDir: '',
          desRoundListSortBy: '',
          desRoundListSortDir: '',
          minutes: '00',
          seconds: '00',
          couterInterval: null,
          payTransactionId: '',
          inquiryCounter: null,
          inquiryStatus: false,

          saveButtonShow: false,
          printTicketButtonShow: false,

          // for check timetable function
          isTimetable: false,
          timetableCurrentStep: 1,
          roundButtonShow: false,
          bookingButtonShow: false,

          // for payment
          totalBaht: 0,
          receivedBaht: 0,
          remainBaht: 0,
          changeBaht: 0,

          // for Time Round
          depTimeFirst: 0,
          depTimeSecond: 0,
          depTimeThird: 0,
          depTimeFourth: 0,

          desTimeFirst: 0,
          desTimeSecond: 0,
          desTimeThird: 0,
          desTimeFourth: 0,

          // for booking from local branch (Smart Bus)
          companyId: get('cid'),
          branchId: get('bid'),
          userId: get('uid'),
          vendorId: get('vid'),

          isDepSkipSeat: false,
          isRetSkipSeat: false,

          // Reject Bill
          RejectTicket: false,
          isTicketReject: 1,
          disReject: 1
        },
        methods: {
          loadProvinceDepartureItem() {
            this.depProvinceList = [];
            this.depStationList = [];
            // if (!this.depProvinceList) return;
            var loader = this.$loading.show();
            axios.get("https://booking-system24.com/busbooking/index.php/province/loads", {
              params: {
                txt: this.depProvinceSearch,
                lang: this.lang
              }
            })
            .then(response => {
              if (response) {
                this.depProvinceList = response.data.province;
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },
          loadProvinceDestinationItem() {
            this.desProvinceList = [];
            this.desStationList = [];
            // if (!this.desProvinceList) return;
            var loader = this.$loading.show();
            axios.get("https://booking-system24.com/busbooking/index.php/province/loads", {
              params: {
                txt: this.desProvinceSearch,
                lang: this.lang
              }
            })
            .then(response => {
              if (response) {
                this.desProvinceList = response.data.province;
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },
          loadStationDepartureItem(obj) {
            this.depProvinceId = obj.provid;
            this.depProvinceName = obj.name;

            var province = this.depProvinceList.find(v => v.provid == obj.provid);
            this.depStationList = province.station_items || [];
            // if (!this.depStationList) return;
            // var loader = this.$loading.show();
           /*  axios.get("https://booking-system24.com/busbooking/index.php/province/loads_station", {
              params: {
                provid: this.depProvinceId,
                lang: this.lang
              }
            })
            .then(response => {
              if (response) {
                this.depStationList = response.data.terminal;
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide()); */
          },
          loadStationDestinationItem(obj) {
            this.desProvinceId = obj.provid;
            this.desProvinceName = obj.name;

            var province = this.desProvinceList.find(v => v.provid == obj.provid);
            this.desStationList = province.station_items || [];

            // if (!this.desStationList) return;
            // var loader = this.$loading.show();

            /* axios.get("https://booking-system24.com/busbooking/index.php/province/loads_station", {
              params: {
                provid: this.desProvinceId,
                lang: this.lang
              }
            })
            .then(response => {
              if (response) {
                this.desStationList = response.data.terminal;
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide()); */
          },
          setStationDeparture(obj) {
            if (this.desStationId == obj.terid) {
              // mySwal.fire({
              //   title: 'คุณเลือกจุดขึ้นตรงกับจุดลง กรุณาเลือกใหม่'
              // });
              // return;
              this.desStationId = '';
              this.desStationName = '';
            }
            this.depStationId = obj.terid;
            this.depStationName = obj.name;

            $('#provinceDepartureModal').modal('hide');
            $('#provinceDestinationModal').modal();
            // if (!this.desProvinceId || !this.depStationId) $('#provinceDestinationModal').modal();
          },
          setStationDestination(obj) {
            if (this.depStationId == obj.terid) {
              mySwal.fire({
                title: 'คุณเลือกจุดขึ้นตรงกับจุดลง กรุณาเลือกใหม่'
              });
              return;
            }
            this.desStationId = obj.terid;
            this.desStationName = obj.name;

            $('#provinceDestinationModal').modal('hide');
            if (this.tripType == 1) {
              $('#dateModal').modal();
            } else {
              $('#date2Modal').modal();
            }
            /*if (this.tripType == 1 && !this.depDate) {
              $('#dateModal').modal();
            } else if (this.tripType == 2 && (!this.depDate || !this.desDate)) {
              $('#date2Modal').modal();
            }*/
          },
          checkRouteTravelTrip() {
            if (!this.depProvinceId) {
              mySwal.fire({
                title: "กรุณาเลือกสถานีต้นทาง",
                confirmButtonText: "ตกลง"
              }).then(() => {
                $('#provinceDepartureModal').modal();
              });
              return false;
            } else if (!this.depStationId) {
              mySwal.fire({
                title: "กรุณาเลือกจุดขึ้นรถ",
                confirmButtonText: "ตกลง"
              }).then(() => {
                $('#provinceDepartureModal').modal();
              });
              return false;
            } else if (!this.desProvinceId) {
              mySwal.fire({
                title: "กรุณาเลือกสถานีปลายทาง",
                confirmButtonText: "ตกลง"
              }).then(() => {
                $('#provinceDestinationModal').modal();
              });
              return false;
            } else if (!this.desStationId) {
              mySwal.fire({
                title: "กรุณาเลือกจุดลงรถ",
                confirmButtonText: "ตกลง"
              }).then(() => {
                $('#provinceDestinationModal').modal();
              });
              return false;
            } else if (!this.depDate) {
              mySwal.fire({
                title: "กรุณาเลือกวันที่เดินทางไป",
                confirmButtonText: "ตกลง"
              });
              return false;
            }
            return true;
          },
          checkDateReturnTrip() {
            if (this.tripType == 2) {
              if (!this.desDate) {
                mySwal.fire({
                  title: "กรุณาเลือกวันที่เดินทางกลับ",
                  confirmButtonText: "ตกลง"
                });
                return false;
              }
            }
            return true;
          },
          async checkPassengerDataRequired() {
            if (this.depRoundId && this.depRound.is_passenger_active == 1) {
              this.passengersDeparture = await this.passengersDeparture.map(v => {
                v.valid_gender = [];
                v.valid_passport = [];
                v.valid_name = [];
                v.valid_email = [];
                v.valid_mobile = [];
                v.valid_insurance = [];

                if (v.is_required_gender && !v.gender) {
                  v.valid_gender.push("จำเป็นต้องกรอกข้อมูล");
                } else {
                  v.valid_gender = true;
                }

                if (v.passport) {
                  if (v.passportType == 2 || (v.passportType == 1 && checkCardID(v.passport))) {
                    v.valid_passport = true;
                  } else {
                    v.valid_passport.push("รหัสบัตรประชาชนไม่ถูกต้อง");
                  }
                } else if (v.is_required_passport) {
                  v.valid_passport.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.name) {
                  if (checkName(v.name)) {
                    v.valid_name = true;
                  } else {
                    v.valid_name.push("กรุณากรอกเฉพาะตัวอักษร");
                  }
                } else if (v.is_required_name) {
                  v.valid_name.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.mobile) {
                  if (checkMobile(v.mobile)) {
                    v.valid_mobile = true;
                  } else {
                    v.valid_mobile.push("กรุณากรอกเฉพาะตัวเลข");
                  }
                } else if (v.is_required_mobile) {
                  v.valid_mobile.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.email) {
                  if (checkEmail(v.email)) {
                    v.valid_email = true;
                  } else {
                    v.valid_email.push("กรุณากรอกรูปแบบอีเมลที่ถูกต้อง");
                  }
                } else if (v.is_required_email) {
                  v.valid_email.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.is_active_insurance && v.is_required_insurance && v.insurance == 0) {
                  v.valid_insurance.push("จำเป็นต้องเลือกการประกันภัยการเดินทาง");
                }

                return v;
              });
            }

            if (this.desRoundId && this.desRound.is_passenger_active == 1) {
              this.passengersReturn = await this.passengersReturn.map(v => {
                v.valid_gender = [];
                v.valid_passport = [];
                v.valid_name = [];
                v.valid_email = [];
                v.valid_mobile = [];
                v.valid_insurance = [];

                if (v.is_required_gender && !v.gender) {
                  v.valid_gender.push("จำเป็นต้องกรอกข้อมูล");
                } else {
                  v.valid_gender = true;
                }

                if (v.passport) {
                  if (v.passportType == 2 || (v.passportType == 1 && checkCardID(v.passport))) {
                    v.valid_passport = true;
                  } else {
                    v.valid_passport.push("รหัสบัตรประชาชนไม่ถูกต้อง");
                  }
                } else if (v.is_required_passport) {
                  v.valid_passport.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.name) {
                  if (checkName(v.name)) {
                    v.valid_name = true;
                  } else {
                    v.valid_name.push("กรุณากรอกเฉพาะตัวอักษร");
                  }
                } else if (v.is_required_name) {
                  v.valid_name.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.mobile) {
                  if (checkMobile(v.mobile)) {
                    v.valid_mobile = true;
                  } else {
                    v.valid_mobile.push("กรุณากรอกเฉพาะตัวเลข");
                  }
                } else if (v.is_required_mobile) {
                  v.valid_mobile.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.email) {
                  if (checkEmail(v.email)) {
                    v.valid_email = true;
                  } else {
                    v.valid_email.push("กรุณากรอกรูปแบบอีเมลที่ถูกต้อง");
                  }
                } else if (v.is_required_email) {
                  v.valid_email.push("จำเป็นต้องกรอกข้อมูล");
                }

                if (v.is_active_insurance && v.is_required_insurance && v.insurance == 0) {
                  v.valid_insurance.push("จำเป็นต้องเลือกการประกันภัยการเดินทาง");
                }

                return v;
              });
            }
          },
          async nextStep() {
            var currStep = this.getCurrentStep();
            if (currStep == 0) { // for route step
              this.slideToDepart();
              if (!this.checkRouteTravelTrip() || !this.checkDateReturnTrip()) {
                return;
              }
              this.loadRoundTravelTrip();
              if (this.tripType == 2) {
                this.loadRoundReturnTrip();
              }
            } else if (currStep == 1) { // for round step
              if (!this.depRoundId) {
                mySwal.fire({
                  title: 'กรุณาเลือกรอบการเดินทางไป',
                  confirmButtonText: 'ตกลง'
                })
                .then(() => {
                  this.isTravelTrip = true;
                  this.slideToDepart();
                });
                return;
              }
              if (this.tripType == 2 && !this.desRoundId) {
                mySwal.fire({
                  title: 'กรุณาเลือกรอบการเดินทางกลับ',
                  confirmButtonText: 'ตกลง'
                }).then(() => {
                  this.isTravelTrip = false;
                  this.slideToReturn();
                });
                return;
              }

              this.isTimetable = false;
              this.renderSeatTemplate();
            } else if (currStep == 2 && this.steps[2].section == 1) { // for passenger step

              if ((this.depRoundId && this.depRound.is_passenger_active == 1)
                || (this.desRoundId && this.desRound.is_passenger_active == 1)) {
                await this.checkPassengerDataRequired();
              }

              var idxDepart = this.passengersDeparture.findIndex(v => {
                return (
                  (v.valid_passport.constructor == Array && v.valid_passport.length > 0)
                  || (v.valid_name.constructor == Array && v.valid_name.length > 0)
                  || (v.valid_mobile.constructor == Array && v.valid_mobile.length > 0)
                  || (v.valid_email.constructor == Array && v.valid_email.length > 0)
                  || (v.valid_gender.constructor == Array && v.valid_gender.length > 0)
                  || (v.valid_insurance.constructor == Array && v.valid_insurance.length > 0)
                )
              });

              var idxReturn = this.passengersReturn.findIndex(v => {
                return (
                  (v.valid_passport.constructor == Array && v.valid_passport.length > 0)
                  || (v.valid_name.constructor == Array && v.valid_name.length > 0)
                  || (v.valid_mobile.constructor == Array && v.valid_mobile.length > 0)
                  || (v.valid_email.constructor == Array && v.valid_email.length > 0)
                  || (v.valid_gender.constructor == Array && v.valid_gender.length > 0)
                  || (v.valid_insurance.constructor == Array && v.valid_insurance.length > 0)
                )
              });

              if (idxDepart > -1 || idxReturn > -1) {
                mySwal.fire({
                  title: "กรุณากรอกข้อมูลให้ครบถ้วน",
                  confirmButtonText: "ตกลง"
                }).then(result => {
                  if (result.value) {
                    if (idxDepart > -1) {
                      this.slideToDepartPassenger();
                    } else if (idxReturn > -1) {
                      this.slideToReturnPassenger();
                    }
                  }
                });
                return;
              }
              //compare Van zone
              if (this.tripType == 1) {   // ไปอย่างเดียว
                if (this.isDepSkipSeat) {
                  // random matching seat
                  this.reRenderSeatSelect(true);
                  this.randomSeatDepart();
                } else {
                  this.steps[2].section = 2;
                  this.reRenderSeatSelect();
                  this.slideSeatToDepart();
                  return;
                }
              } else {   // ไป -  กลับ
                this.reRenderSeatSelect(true);
                if(this.isDepSkipSeat) {
                  // random matching seat
                  this.randomSeatDepart();
                }
                if(this.isRetSkipSeat) {
                  // random matching seat
                  this.randomSeatReturn();
                }
                if (!this.isDepSkipSeat || !this.isRetSkipSeat) {
                  this.steps[2].section = 2;
                  this.reRenderSeatSelect();

                  if (!this.isDepSkipSeat) {
                    this.slideSeatToDepart();
                  } else if (!this.isRetSkipSeat) {
                    this.slideSeatToReturn();
                  }

                  return;
                }
              }

            } else if (currStep == 2 && this.steps[2].section == 2) { // for seat step
              if (this.passengersDeparture.length != this.depSeatSelectList.length && !this.isDepSkipSeat) {
                mySwal.fire({
                  title: "กรุณาเลือกที่นั่งเที่ยวไปให้ครบถ้วน",
                  confirmButtonText: "ตกลง"
                });
                return;
              }
              if (this.tripType == 2) {
                if (this.passengersDeparture.length != this.desSeatSelectList.length && !this.isRetSkipSeat) {
                  this.isTravelTripSeatTab = false;
                  mySwal.fire({
                    title: "กรุณาเลือกที่นั่งเที่ยวกลับให้ครบถ้วน",
                    confirmButtonText: "ตกลง"
                  });
                  return;
                }
              }
              this.steps[2].section = 1;
              // return;
            } else if (currStep == 3 && this.steps[3].section == 1) { // for payment step
              if (!this.paymentMethod) {
                mySwal.fire({
                  title: "เลือกวิธีการชำระเงิน",
                  confirmButtonText: "ตกลง"
                });
                return;
              }
              if (this.paymentMethod == 1) {
                this.steps[3].section = 2; // Cash payment

                this.openCash(); // Open Coin, Note, SmartHoper Any
                this.setRemainBaht(this.totalBaht);

                clearInterval(this.couterInterval);
                this.minutes = "10";
                this.seconds = "00";
                this.fadeBlinker('textblinker' ,4 ,1);
              } else {
                if(!this.inquiryStatus){
                  mySwal.fire({
                          title: "ท่านยังชำระเงินไม่สำเร็จ!", // account has create Msg
                          type: 'error',
                          text: "กรุณาเลือกวิธีชำระเงิน",
                          showConfirmButton: true,
                        });
                  return;
                }
                // this.steps[3].section = 3;
                this.setCurrentStep(currStep + 1, true);
                this.nextStepButtonShow = false;
                if(typeof cef == 'undefined'){
                  this.printTicketButtonShow = true;
                }
                return;
              }
              this.nextStepButtonShow = false;
              this.printTicketButtonShow = false;
              this.saveButtonShow = true;
              this.RejectTicket = true;
              return;
            } else if (currStep == 4) { // for thank step
              // return;
            }
            this.setCurrentStep(currStep + 1, true);
          },
          previousStep() {
            var currStep = this.getCurrentStep();
            if (currStep == 3 && this.steps[3].section == 1) {
              //compare Van zone
              if(this.tripType == "1"){   // ไปอย่างเดียว
                if(this.isDepSkipSeat){
                  this.steps[2].section = 1;
                }else{
                  this.steps[2].section = 2;
                  this.slideSeatToDepart();
                }
              }else{   // ไป -  กลับ
                if(this.isDepSkipSeat && this.isRetSkipSeat){
                  this.steps[2].section = 1;
                }else{ //เมื่อ DepVan และ RetVan เป็น False ทั้งคู่ = data เป็นบัสทั้งคู่
                  this.steps[2].section = 2;

                  if(this.isDepSkipSeat && !this.isRetSkipSeat){ // ขาไป เป็นรถตู้ ขากลับเป็นรถทัวร์
                    this.slideSeatToReturn();
                  }else if(!this.isDepSkipSeat && this.isRetSkipSeat){ // ขาไป เป็นรถทัวร์ ขากลับเป็นรถตู้
                    this.slideSeatToDepart();
                  }else{
                    this.slideSeatToReturn();
                  }
                }
              }
            } else if (currStep == 3 && (this.steps[3].section == 2 || this.steps[3].section == 3)) {
              this.steps[3].section = 1;
              this.nextStepButtonShow = true;
              this.saveButtonShow = false;
              this.RejectTicket = false;
              return;
            } else if (currStep == 2 && this.steps[2].section == 2) {
              this.steps[2].section = 1;
              currStep++;
            }
            this.setCurrentStep(currStep - 1, false);
          },
          getCurrentStep() {
            return this.steps.findIndex(item => {
              return item.isCurrent == true;
            });
          },
          setCurrentStep(step, isNext) {
            if (step < 0 || step > 4) return;
            if (step == 0) {
              this.prevStepButtonShow = false;
            } else {
              this.prevStepButtonShow = true;
            }

            this.saveButtonShow = false;
            this.RejectTicket = false;
            this.printTicketButtonShow = false;
            if (step == 4) {
              if(typeof cef == 'undefined'){
                this.printTicketButtonShow = true;
                this.prevStepButtonShow = false;
              }
            }

            var current = this.getCurrentStep();
            if (isNext) {
              this.steps[step - 1].isCurrent = false;
              this.steps[step - 1].isVisited = true;
              if (step == 3) {
                this.steps[step].section = 1;
              }
            } else {
              if (step == 2 && this.steps[2].section == 1) {
                this.steps[step].isCurrent = false;
                this.steps[step].isVisited = true;

                this.steps[step + 1].isCurrent = false;
              } else {
                this.steps[step + 1].isCurrent = false;
                this.steps[step + 1].isVisited = true;
              }
            }
            this.steps[step].isCurrent = true;
            if (this.isTimetable) {
              if (step == 0) {
                this.roundButtonShow = true;
                this.bookingButtonShow = false;
                this.nextStepButtonShow = false;
              } else if (step == 1) {
                this.roundButtonShow = false;
                this.bookingButtonShow = true;
                this.nextStepButtonShow = false;
              } else {
                this.roundButtonShow = false;
                this.bookingButtonShow = false;
                this.nextStepButtonShow = true;
                this.steps.forEach(v => {
                  if (v.step != 5) {
                    v.isShowStep = true
                  }
                });
              }
            } else {
              this.roundButtonShow = false;
              this.bookingButtonShow = false;
              this.nextStepButtonShow = true;
              this.steps.forEach(v => {
                if (v.step != 5) {
                  v.isShowStep = true
                }
              });
            }
            this.currentStep = step;
          },
          homeStep() {
            if (this.depProvinceId || this.depStationId || this.desProvinceId || this.desStationId) {
              mySwal.fire({
                title: "ยืนยันการกลับสู่เมนู",
                text: "ข้อมูลจะถูกรีเซ็ตหากทำการกลับสู่เมนู",
                showCancelButton: true,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
              }).then(ans => {
                if (ans.value) {
                  window.location.href = "https://booking-system24.com/busbooking/index.php";
                }
              });
            } else {
              window.location.href = "https://booking-system24.com/busbooking/index.php";
            }
          },
          async loadRoundTravelTrip() {
            this.depRoundList = [];
            var loader = this.$loading.show();
            await axios.get("https://booking-system24.com/busbooking/index.php/round/loads", {
              params: {
                tripType: 1,
                carType: this.carType,
                from_provinceId: this.depProvinceId,
                from_stationId: this.depStationId,
                to_provinceId: this.desProvinceId,
                to_stationId: this.desStationId,
                date: this.depDate,
                time: this.depTimeFilter,
                price: this.depPriceFilter,
                vendor: this.depVendorFilter,
                lang: this.lang,
                sort: this.depRoundListSortBy,
                dir: this.depRoundListSortDir,
                cid: this.companyId,
                bid: this.branchId,
                uid: this.userId,
                vid: this.vendorId,
              }
            })
            .then(response => {
              if (response) {
                this.depRoundList = response.data.row;
                this.countDepRound();
                this.countDesRound();
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },
          async loadRoundReturnTrip() {
            this.desRoundList = [];
            var loader = this.$loading.show();
            await axios.get("https://booking-system24.com/busbooking/index.php/round/loads", {
              params: {
                tripType: 2,
                carType: this.carType,
                from_provinceId: this.desProvinceId,
                from_stationId: this.desStationId,
                to_provinceId: this.depProvinceId,
                to_stationId: this.depStationId,
                date: this.desDate,
                time: this.desTimeFilter,
                price: this.desPriceFilter,
                vendor: this.desVendorFilter,
                lang: this.lang,
                sort: this.desRoundListSortBy,
                dir: this.desRoundListSortDir,
                cid: this.companyId,
                bid: this.branchId,
                uid: this.userId,
                vid: this.vendorId,
              }
            })
            .then(response => {
              if (response) {
                this.desRoundList = response.data.row;
                this.countDepRound();
                this.countDesRound();
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },
          loadVendor() {
            var loader = this.$loading.show();
            axios.get("https://booking-system24.com/busbooking/index.php/round/loads_vendor", {
              params: {
                lang: this.lang
              }
            })
            .then(response => {
              if (response) {
                this.vendorList = response.data.row;
              }
            })
            .catch(error => { console.log(error); })
            .then(() => { loader.hide(); });
          },
          tripFilter(type = 1) {
            if (type == 1) {
              this.loadRoundTravelTrip();
            } else {
              this.loadRoundReturnTrip();
            }
          },
          clearFilter(type, filter) {
            if (type == 1) {
              if (filter == 'time') {
                this.depTimeFilter = '';
              } else if (filter == 'price') {
                this.depPriceFilter = '';
              } else if (filter == 'vendor') {
                this.depVendorFilter = '';
              } else if (filter == 'all') {
                this.depTimeFilter = '';
                this.depPriceFilter = '';
                this.depVendorFilter = '';
              }
            } else {
              if (filter == 'time') {
                this.desTimeFilter = '';
              } else if (filter == 'price') {
                this.desPriceFilter = '';
              } else if (filter == 'vendor') {
                this.desVendorFilter = '';
              } else if (filter == 'all') {
                this.desTimeFilter = '';
                this.desPriceFilter = '';
                this.desVendorFilter = '';
              }
            }
            this.tripFilter(type);
          },
          selectRound(type, row) {
            if (type == 1) {
              this.depRound = row;
              this.depRoundId = row.timid;

              // for slide to return trip
              if (this.tripType == 2 && !this.desRoundId) {
                this.slideToReturn();
              }
              if (row.is_required_seat == '1') {
                this.isDepSkipSeat = false;
              } else {
                this.isDepSkipSeat = true;
              }
            } else {
              this.desRound = row;
              this.desRoundId = row.timid;
              if (!this.depRoundId) {
                this.slideToDepart();
              }
              if (row.is_required_seat == '1') {
                this.isRetSkipSeat = false;
              } else {
                this.isRetSkipSeat = true;
              }
            }
          },
          slideToDepart(){
            if(this.tripType == 1){return;}
            this.isTravelTrip = true;
            $('#right-tab').hide("slide", { direction: "right" }, 500);
            $('#left-tab').show("slide", { direction: "left" }, 500);
          },
          slideToReturn(){
            if(this.tripType == 1){return;}
            this.isTravelTrip = false;
            $('#left-tab').hide("slide", { direction: "left" }, 500);
            $('#right-tab').show("slide", { direction: "right" }, 500);
          },
          slideSeatToDepart(){
            if(this.tripType == 1){return;}
            if(this.isDepSkipSeat){return;}
            this.isTravelTripSeatTab = true;
            $('#right-seat').hide("slide", { direction: "right" }, 500);
            $('#left-seat').show("slide", { direction: "left" }, 500);
          },
          slideSeatToReturn(){
            if(this.tripType == 1){return;}
            if(this.isRetSkipSeat){return;}
            this.isTravelTripSeatTab = false;
            $('#left-seat').hide("slide", { direction: "left" }, 500);
            $('#right-seat').show("slide", { direction: "right" }, 500);
          },
          slideToDepartPassenger(){
            if(this.tripType == 1){return;}
            this.isTravelTripPassengerTab = true;
            $('#right-tab-passenger').hide("slide", { direction: "right" }, 500);
            $('#left-tab-passenger').show("slide", { direction: "left" }, 500);
          },
          slideToReturnPassenger(){
            if(this.tripType == 1){return;}
            this.isTravelTripPassengerTab = false;
            $('#left-tab-passenger').hide("slide", { direction: "left" }, 500);
            $('#right-tab-passenger').show("slide", { direction: "right" }, 500);
          },

          initialPassengerInfoDep() {
            var ps = {
              psuuid: generateUUID(),
              gender: 1,
              passportType: 1,
              passport: '',
              name: '',
              email: '',
              mobile: '',
              insurance: 0,

              valid_gender:[],
              valid_passport:[],
              valid_name: [],
              valid_email:[],
              valid_mobile:[],
              valid_insurance:[],

              is_active_gender: false,
              is_active_passport: false,
              is_active_name: false,
              is_active_email: false,
              is_active_mobile: false,
              is_active_insurance: false,

              is_required_gender: false,
              is_required_passport: false,
              is_required_name: false,
              is_required_email: false,
              is_required_mobile: false,
              is_required_insurance: false,
            };

            if (Object.entries(this.depRound).length !== 0 && this.depRound.constructor === Object) {
              this.depRound.passenger_fields.forEach(v => {
                if (v.fieldid == 1) { // gender
                  ps.is_active_gender = true;
                  ps.is_required_gender = v.is_required == 1;
                } else if (v.fieldid == 2) { // id card / passport
                  ps.is_active_passport = true;
                  ps.is_required_passport = v.is_required == 1;
                } else if (v.fieldid == 3) { // name
                  ps.is_active_name = true;
                  ps.is_required_name = v.is_required == 1;
                } else if (v.fieldid == 4) { // tel/mobile
                  ps.is_active_mobile = true;
                  ps.is_required_mobile = v.is_required == 1;
                } else if (v.fieldid == 5) { // email
                  ps.is_active_email = true;
                  ps.is_required_email = v.is_required == 1;
                } else if (v.fieldid == 6) { // insurance
                  ps.is_active_insurance = true;
                  ps.is_required_insurance = v.is_required == 1;
                  ps.insurance = v.is_default_selected == 1 ? 1 : 0;
                }
              });
              this.passengersDeparture = [];
              for (let i = 0; i < this.passengerQty; i++) {
                this.passengersDeparture.push(ps);
              }
            }
          },

          initialPassengerInfoRet() {
            var ps = {
              psuuid: generateUUID(),
              gender: 1,
              passportType: 1,
              passport: '',
              name: '',
              email: '',
              mobile: '',
              insurance: 0,

              valid_gender: [],
              valid_passport: [],
              valid_name: [],
              valid_email: [],
              valid_mobile: [],
              valid_insurance: [],

              is_active_gender: false,
              is_active_passport: false,
              is_active_name: false,
              is_active_email: false,
              is_active_mobile: false,
              is_active_insurance: false,

              is_required_gender: false,
              is_required_passport: false,
              is_required_name: false,
              is_required_email: false,
              is_required_mobile: false,
              is_required_insurance: false,
            };

            if (Object.entries(this.desRound).length !== 0 && this.desRound.constructor === Object) {
              this.desRound.passenger_fields.forEach(v => {
                if (v.fieldid == 1) { // gender
                  ps.is_active_gender = true;
                  ps.is_required_gender = v.is_required == 1;
                } else if (v.fieldid == 2) { // id card / passport
                  ps.is_active_passport = true;
                  ps.is_required_passport = v.is_required == 1;
                } else if (v.fieldid == 3) { // name
                  ps.is_active_name = true;
                  ps.is_required_name = v.is_required == 1;
                } else if (v.fieldid == 4) { // tel/mobile
                  ps.is_active_mobile = true;
                  ps.is_required_mobile = v.is_required == 1;
                } else if (v.fieldid == 5) { // email
                  ps.is_active_email = true;
                  ps.is_required_email = v.is_required == 1;
                } else if (v.fieldid == 6) { // insurance
                  ps.is_active_insurance = true;
                  ps.is_required_insurance = v.is_required == 1;
                  ps.insurance = v.is_default_selected == 1 ? 1 : 0;
                }
              });
              this.passengersReturn = [];
              for (let i = 0; i < this.passengerQty; i++) {
                this.passengersReturn.push(ps);
              }
            }
          },

          // passenger step
          addPassenger() {
            if (parseInt(this.passengerQty) == 4) {
              return;
            }

            this.passengerQty++;

            var ps = {
              psuuid: generateUUID(),
              gender: 1,
              passportType: 1,
              passport: '',
              name: '',
              email: '',
              mobile: '',
              insurance: 0,

              valid_gender: [],
              valid_passport: [],
              valid_name: [],
              valid_email: [],
              valid_mobile: [],
              valid_insurance: [],

              is_active_gender: false,
              is_active_passport: false,
              is_active_name: false,
              is_active_email: false,
              is_active_mobile: false,
              is_active_insurance: false,

              is_required_gender: false,
              is_required_passport: false,
              is_required_name: false,
              is_required_email: false,
              is_required_mobile: false,
              is_required_insurance: false,
            };

            var ps2 = { ...ps };

            if (Object.entries(this.depRound).length !== 0 && this.depRound.constructor === Object) {
              this.depRound.passenger_fields.forEach(v => {
                if (v.fieldid == 1) { // gender
                  ps.is_active_gender = true;
                  ps.is_required_gender = v.is_required == 1;
                } else if (v.fieldid == 2) { // id card / passport
                  ps.is_active_passport = true;
                  ps.is_required_passport = v.is_required == 1;
                } else if (v.fieldid == 3) { // name
                  ps.is_active_name = true;
                  ps.is_required_name = v.is_required == 1;
                } else if (v.fieldid == 4) { // tel/mobile
                  ps.is_active_mobile = true;
                  ps.is_required_mobile = v.is_required == 1;
                } else if (v.fieldid == 5) { // email
                  ps.is_active_email = true;
                  ps.is_required_email = v.is_required == 1;
                } else if (v.fieldid == 6) { // insurance
                  ps.is_active_insurance = true;
                  ps.is_required_insurance = v.is_required == 1;
                  ps.insurance = v.is_default_selected == 1 ? 1 : 0;
                }
              });
              this.passengersDeparture.push(ps);
            }

            if (Object.entries(this.desRound).length !== 0 && this.desRound.constructor === Object) {
              this.desRound.passenger_fields.forEach(v => {
                if (v.fieldid == 1) { // gender
                  ps2.is_active_gender = true;
                  ps2.is_required_gender = v.is_required == 1;
                } else if (v.fieldid == 2) { // id card / passport
                  ps2.is_active_passport = true;
                  ps2.is_required_passport = v.is_required == 1;
                } else if (v.fieldid == 3) { // name
                  ps2.is_active_name = true;
                  ps2.is_required_name = v.is_required == 1;
                } else if (v.fieldid == 4) { // tel/mobile
                  ps2.is_active_mobile = true;
                  ps2.is_required_mobile = v.is_required == 1;
                } else if (v.fieldid == 5) { // email
                  ps2.is_active_email = true;
                  ps2.is_required_email = v.is_required == 1;
                } else if (v.fieldid == 6) { // insurance
                  ps2.is_active_insurance = true;
                  ps2.is_required_insurance = v.is_required == 1;
                  ps2.insurance = v.is_default_selected == 1 ? 1 : 0;
                }
              });
              this.passengersReturn.push(ps2);
            }
          },
          async delPassenger(delps, type, index) {
            var psQty = parseInt(this.passengerQty) || 1;
            if (psQty <= 1) { return; }
            let result = await mySwal.fire({
              title: "ยืนยันการลบข้อมูล",
              showCancelButton: true,
              confirmButtonText: "ตกลง",
              cancelButtonText: "ยกเลิก"
            });
            if (result.value) {
              if (type == 'departure') {
                if (delps) {
                  var delps = this.passengersDeparture.splice(index, 1);
                  this.removeSeatSelect(delps.psuuid);
                  var delps = this.passengersReturn.splice(index, 1);
                  this.removeSeatSelect(delps.psuuid);
                } else {
                  var delps = this.passengersDeparture.splice(this.passengersDeparture.length - 1, 1);
                  this.removeSeatSelect(delps.psuuid);
                  var delps = this.passengersReturn.splice(this.passengersReturn.length - 1, 1);
                  this.removeSeatSelect(delps.psuuid);
                }
              } else if (type == 'return') {
                if (delps) {
                  var delps = this.passengersReturn.splice(index, 1);
                  this.removeSeatSelect(delps.psuuid);
                  var delps = this.passengersDeparture.splice(index, 1);
                  this.removeSeatSelect(delps.psuuid);
                } else {
                  var delps = this.passengersReturn.splice(this.passengersReturn.length - 1, 1);
                  this.removeSeatSelect(delps.psuuid);
                  var delps = this.passengersDeparture.splice(this.passengersDeparture.length - 1, 1);
                  this.removeSeatSelect(delps.psuuid);
                }
              }
              this.passengerQty--;
            }
          },
          increase() {
            this.addPassenger();
          },
          decrease() {
            this.delPassenger();
          },

          copyFromTravelTrip() {
            this.passengersDeparture.forEach((item, index) => {
              let ps = this.passengersReturn.find((_, i) => i == index);
              if (ps) {
                ps.gender = item.gender;
                ps.passportType = item.passportType;
                ps.passport = item.passport;
                ps.name = item.name;
                ps.mobile = item.mobile;
                ps.email = item.email;
                if (ps.is_active_insurance) {
                  if (ps.is_required_insurance) {
                    ps.insurance = 1;
                  } else if (item.is_active_insurance) {
                    ps.insurance = item.insurance;
                  }
                }
              }
            });
            this.checkPassengerDataRequired();
          },

          // seat step

          loadSeatTemplate(section, floor, timetableId, travelDate) {
            if (!timetableId) {
              return false;
            }
            var loader = this.$loading.show();
            axios.get("https://booking-system24.com/busbooking/index.php/seat/loads", {
              params: {
                floor: floor,
                timetableid: timetableId,
                traveldate: travelDate,
                lang: this.lang
              }
            })
            .then(response => {
              var list = [];
              if (response.data.seats) {
                response.data.seats.forEach(item => {
                  var cols = [];
                  item.forEach(col => {
                    var picPath = col.pic_path;
                    var selected = 0;
                    var disSelectSeat = [6, 7, 8, 9, 10];
                    var seatTypeId = parseInt(col.styid);
                    if (seatTypeId == 0 || seatTypeId == 4) {
                      col.seat_box_type = 1;
                    } else if (seatTypeId == 66) {
                      col.seat_box_type = 2;
                    } else if (seatTypeId == 77) {
                      col.seat_box_type = 3;
                    } else {
                      if (col.colspan > 1 || disSelectSeat.indexOf(seatTypeId) > -1) {
                        col.seat_box_type = 4;
                      } else {
                        col.seat_box_type = 5;
                        if (col.sold == 1 || col.sold == 2) { // 1 = reserved, 2 = sold
                          if (seatTypeId == 2) {
                            picPath = this.seatImgUrl.monk;
                          } else if (seatTypeId == 3) {
                            picPath = this.seatImgUrl.female2;
                          } else if (col.gender == 1) {
                            picPath = this.seatImgUrl.male;
                          } else {
                            picPath = this.seatImgUrl.female;
                          }
                          selected = 2;
                        }
                      }
                    }
                    col.pic_path_new = picPath;
                    col.selected = selected;
                    cols.push(col);
                  });
                  list.push(cols);
                });
              }
              if (section == 1) {
                this.depSeatFirstList = list;
              } else if (section == 2) {
                this.depSeatSecondList = list;
              } else if (section == 3) {
                this.desSeatFirstList = list;
              } else {
                this.desSeatSecondList = list;
              }
              this.reRenderSeatSelect();
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },

          renderSeatTemplate() {
            this.loadSeatTemplate(1, 1, this.depRoundId, this.depDate);
            this.loadSeatTemplate(2, 2, this.depRoundId, this.depDate);
            if (this.tripType == 2) this.loadSeatTemplate(3, 1, this.desRoundId, this.desDate);
            if (this.tripType == 2) this.loadSeatTemplate(4, 2, this.desRoundId, this.desDate);
          },

          selectSeatTravelTrip(seatObj, event) {
            if (seatObj.selected == 2) { return; }
            var idx = this.depSeatSelectList.findIndex(v => v.seatid == seatObj.gridid);
            if (idx > -1) {
              mySwal.fire({
                title: "คุณต้องการยกเลิกที่นั่งหรือไม่?",
                showCancelButton: true,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
              }).then(result => {
                if (result.value) {
                  var idx = this.depSeatSelectList.findIndex(v => v.seatid == seatObj.gridid);
                  this.depSeatSelectList.splice(idx, 1);
                  this.depSeatFirstList = this.depSeatFirstList.map(item => {
                    return item.map(col => {
                      if (col.gridid == seatObj.gridid) {
                        col.pic_path_new = col.pic_path;
                        col.selected = 0;
                      }
                      return col;
                    });
                  });
                  this.depSeatSecondList = this.depSeatSecondList.map(item => {
                    return item.map(col => {
                      if (col.gridid == seatObj.gridid) {
                        col.pic_path_new = col.pic_path;
                        col.selected = 0;
                      }
                      return col;
                    });
                  });
                  mySwal.fire({
                    title: "ยกเลิกแล้ว",
                    type: 'success',
                    showCancelButton: false,
                  });
                }
              });
              return;
            }

            if (this.depSeatSelectList.length == this.passengersDeparture.length) {
              return;
            }

            this.depSeatSelectObj = seatObj;

            var noSelect = true;
            this.depSeatSelectList.forEach(item => {
              if(item.seatid == seatObj.gridid) {
                noSelect = false;
                return false;
              }
            });
            if (noSelect) {
              var psRemain = [];
              this.passengersDeparture.forEach(ps => {
                var idx = this.depSeatSelectList.findIndex(item => item.psuuid == ps.psuuid);
                if (idx == -1) {
                  psRemain.push(ps);
                }
              });
              this.depPassengerRemainList = psRemain;
              $('#passengerTravelTripModal').modal();
            }
          },

          selectSeatReturnTrip(seatObj, event) {
            if (seatObj.selected == 2) { return; }
            var idx = this.desSeatSelectList.findIndex(v => v.seatid == seatObj.gridid);
            if (idx > -1) {
              mySwal.fire({
                title: "คุณต้องการยกเลิกที่นั่งหรือไม่?",
                showCancelButton: true,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
              }).then(result => {
                if (result.value) {
                  var idx = this.desSeatSelectList.findIndex(v => v.seatid == seatObj.gridid);
                  this.desSeatSelectList.splice(idx, 1);
                  this.desSeatFirstList = this.desSeatFirstList.map(item => {
                    return item.map(col => {
                      if (col.gridid == seatObj.gridid) {
                        col.pic_path_new = col.pic_path;
                        col.selected = 0;
                      }
                      return col;
                    });
                  });
                  this.desSeatSecondList = this.desSeatSecondList.map(item => {
                    return item.map(col => {
                      if (col.gridid == seatObj.gridid) {
                        col.pic_path_new = col.pic_path;
                        col.selected = 0;
                      }
                      return col;
                    });
                  });
                  mySwal.fire({
                    title: "ยกเลิกแล้ว",
                    type: 'success',
                    showCancelButton: false,
                  });
                }
              });
              return;
            }

            if (this.desSeatSelectList.length == this.passengersDeparture.length) {
              return;
            }

            this.desSeatSelectObj = seatObj;

            var noSelect = true;
            this.desSeatSelectList.forEach(item => {
              if(item.seatid == seatObj.gridid) {
                noSelect = false;
                return false;
              }
            });
            if (noSelect) {
              var psRemain = [];
              this.passengersDeparture.forEach(ps => {
                var idx = this.desSeatSelectList.findIndex(item => item.psuuid == ps.psuuid);
                if (idx == -1) {
                  psRemain.push(ps);
                }
              });
              this.desPassengerRemainList = psRemain;
              $('#passengerReturnTripModal').modal();
            }
          },

          useSeatTravelTrip() {
            var psuuid = this.depPassengerSelectObj.psuuid;
            if (!psuuid) return;
            var gender = this.depPassengerSelectObj.gender;
            var seat = this.depSeatSelectObj;
            if (seat.styid == 3) {
              if (gender == 1) {
                mySwal.fire({
                  title: "ที่นั่งสำหรับสตรีมีครรภ์ กรุณาเลือกที่นั่งอื่น",
                });
                return;
              } else {
                mySwal.fire({
                  title: "กรุณาพกสมุดฝากครรภ์ของท่านติดตัวระหว่างการเดินทาง<br/>เพื่อผลประโยชน์ของตัวท่านเอง",
                });
              }
            }

            if (seat.styid == 2) {
              if (gender == 2) {
                mySwal.fire({
                  title: "ที่นั่งสำหรับพระภิกษุ กรุณาเลือกที่นั่งอื่น",
                });
                return;
              } else {
                mySwal.fire({
                  title: "กรุณาพกสุทธิบัตรพระติดตัวระหว่างการเดินทาง<br/>เพื่อสิทธิประโยชน์ของตัวท่านเอง",
                });
              }
            }

            this.renderSeatSelect(1, psuuid, this.depSeatSelectObj.gridid);

            this.depSeatSelectList.push({
              seatid: this.depSeatSelectObj.gridid,
              psuuid: psuuid
            });
            this.depSeatSelectObj = {};
            this.depPassengerSelectObj = '';
            if (this.tripType == 2 && (this.passengersDeparture.length == this.depSeatSelectList.length)) {
              // this.isTravelTripSeatTab = false;
              this.slideSeatToReturn();
            }
          },

          useSeatReturnTrip() {
            var psuuid = this.desPassengerSelectObj.psuuid;
            if (!psuuid) return;
            var gender = this.desPassengerSelectObj.gender;
            var seat = this.desSeatSelectObj;
            if (seat.styid == 3 && gender == 1) {
              mySwal.fire({
                title: "ที่นั่งสำหรับสตรีมีครรภ์ กรุณาเลือกที่นั่งอื่น",
              });
              return;
            }

            if (seat.styid == 2 && gender == 2) {
              mySwal.fire({
                title: "ที่นั่งสำหรับพระภิกษุ กรุณาเลือกที่นั่งอื่น",
              });
              return;
            }

            this.renderSeatSelect(2, psuuid, this.desSeatSelectObj.gridid);

            this.desSeatSelectList.push({
              seatid: this.desSeatSelectObj.gridid,
              psuuid: psuuid,
            });
            this.desSeatSelectObj = {};
            this.desPassengerSelectObj = '';
          },

          renderSeatSelect(type, psuuid, seatId, isRemove = false) {

            var getSeatUrl = (seatTypeId, gender) => {
              if (seatTypeId == 2) {
                return this.seatImgUrl.monk;
              } else if (seatTypeId == 3) {
                return this.seatImgUrl.female2;
              } else if (gender == 1) {
                return this.seatImgUrl.male;
              } else {
                return this.seatImgUrl.female;
              }
            }

            if (type == 1) { // travel trip
              // travel trip
              var ps = this.passengersDeparture.find(v => v.psuuid == psuuid);
              this.depSeatFirstList = this.depSeatFirstList.map(item => {
                return item.map(col => {
                  if (col.gridid == seatId) {
                    if ((ps.gender == 1 && col.styid == 3) || (ps.gender == 2 && col.styid == 2)) {
                      col.pic_path_new = col.pic_path;
                      col.selected = 0;
                      this.removeSeatSelect(ps.psuuid, 1);
                    } else {
                      col.pic_path_new = getSeatUrl(col.styid, ps.gender);
                      col.selected = 1;
                    }
                  } else if (isRemove) {
                    col.pic_path_new = col.pic_path;
                    col.selected = 0;
                  }
                  return col;
                });
              });
              this.depSeatSecondList = this.depSeatSecondList.map(item => {
                return item.map(col => {
                  if (col.gridid == seatId) {
                    if ((ps.gender == 1 && col.styid == 3) || (ps.gender == 2 && col.styid == 2)) {
                      col.pic_path_new = col.pic_path;
                      col.selected = 0;
                      this.removeSeatSelect(ps.psuuid, 1);
                    } else {
                      col.pic_path_new = getSeatUrl(col.styid, ps.gender);
                      col.selected = 1;
                    }
                  } else if (isRemove) {
                    col.pic_path_new = col.pic_path;
                    col.selected = 0;
                  }
                  return col;
                });
              });
            } else { // return trip
              var ps = this.passengersReturn.find(v => v.psuuid == psuuid);
              this.desSeatFirstList = this.desSeatFirstList.map(item => {
                return item.map(col => {
                  if (col.gridid == seatId) {
                    if ((ps.gender == 1 && col.styid == 3) || (ps.gender == 2 && col.styid == 2)) {
                      col.pic_path_new = col.pic_path;
                      col.selected = 0;
                      this.removeSeatSelect(ps.psuuid, 2);
                    } else {
                      col.pic_path_new = getSeatUrl(col.styid, ps.gender);
                      col.selected = 1;
                    }
                  } else if (isRemove) {
                    col.pic_path_new = col.pic_path;
                    col.selected = 0;
                  }
                  return col;
                });
              });
              this.desSeatSecondList = this.desSeatSecondList.map(item => {
                return item.map(col => {
                  if (col.gridid == seatId) {
                    if ((ps.gender == 1 && col.styid == 3) || (ps.gender == 2 && col.styid == 2)) {
                      col.pic_path_new = col.pic_path;
                      col.selected = 0;
                      this.removeSeatSelect(ps.psuuid, 2);
                    } else {
                      col.pic_path_new = getSeatUrl(col.styid, ps.gender);
                      col.selected = 1;
                    }
                  } else if (isRemove) {
                    col.pic_path_new = col.pic_path;
                    col.selected = 0;
                  }
                  return col;
                });
              });
            }
          },

          reRenderSeatSelect(isRemove = false) {
            if (this.depSeatSelectList.length == 0) {
              this.renderSeatSelect(1, -1, -1, isRemove);
            } else {
              this.depSeatSelectList.forEach(v => {
                this.renderSeatSelect(1, v.psuuid, v.seatid, isRemove);
              });
            }

            if (this.desSeatSelectList.length == 0) {
              this.renderSeatSelect(2, -1, -1, isRemove);
            } else {
              this.desSeatSelectList.forEach(v => {
                this.renderSeatSelect(2, v.psuuid, v.seatid, isRemove);
              });
            }
          },

          removeSeatSelect(psuuid, type = '') {
            var idxDep = this.depSeatSelectList.findIndex(v => v.psuuid == psuuid);
            var idxDes = this.desSeatSelectList.findIndex(v => v.psuuid == psuuid);
            if (type == 1) {
              this.depSeatSelectList.splice(idxDep, 1);
            } else if (type == 2) {
              this.desSeatSelectList.splice(idxDes, 1);
            } else {
              this.depSeatSelectList.splice(idxDep, 1);
              this.desSeatSelectList.splice(idxDes, 1);
            }

            this.reRenderSeatSelect(true);
          },

          findSeatId(seatFirstList = [], seatSecondList = []) {
            var item = seatFirstList.find(main => {
              return main.find(seat => seat.selected == 0);
            });
            if (item) {
              return item.find(seat => seat.selected == 0);
            } else if (seatSecondList == false) {
              return -1;
            }
            return this.findSeatId(seatSecondList, false);
          },

          randomSeatDepart() {
            this.depSeatSelectList = [];
            this.passengersDeparture.forEach(v => {
              var seat = this.findSeatId(this.depSeatFirstList, this.depSeatSecondList);
              if (seat != -1) {
                v.gender = (seat.styid == 3) ? 2 : 1;
                this.renderSeatSelect(1, v.psuuid, seat.gridid);
                this.depSeatSelectList.push({
                  seatid: seat.gridid,
                  psuuid: v.psuuid
                });
              }
            });
          },

          randomSeatReturn() {
            this.desSeatSelectList = [];
            this.passengersReturn.forEach(v => {
              var seat = this.findSeatId(this.desSeatFirstList, this.desSeatSecondList);
              if (seat != -1) {
                v.gender = (seat.styid == 3) ? 2 : 1;
                this.renderSeatSelect(2, v.psuuid, seat.gridid);
                this.desSeatSelectList.push({
                  seatid: seat.gridid,
                  psuuid: v.psuuid
                });
              }
            });
          },

          bookingInfo() {
            const params = new URLSearchParams();

            params.append('bookingId', this.bookingId);

            params.append('depProvinceId', this.depProvinceId);
            params.append('depStationId', this.depStationId);
            params.append('depDate', this.depDate);
            params.append('depSeatSelectList', JSON.stringify(this.depSeatSelectList));
            params.append('depRound', JSON.stringify(this.depRound));

            params.append('desProvinceId', this.desProvinceId);
            params.append('desStationId', this.desStationId);
            params.append('desDate', this.desDate);
            params.append('desSeatSelectList', JSON.stringify(this.desSeatSelectList));
            params.append('desRound', JSON.stringify(this.desRound));

            params.append('tripType', this.tripType);
            params.append('carType', this.carType);
            params.append('passengerQty', this.passengerQty);
            params.append('passengersDeparture', JSON.stringify(this.passengersDeparture));
            params.append('passengersReturn', JSON.stringify(this.passengersReturn));
            params.append('paymentMethod', this.paymentMethod);

            params.append('cid', this.companyId);
            params.append('bid', this.branchId);
            params.append('uid', this.userId);
            params.append('vid', this.vendorId);
            params.append('isTicketReject', this.isTicketReject);
            params.append('disReject', this.disReject);

            params.append('kunnr',get('ssuser_id'));
            params.append('kr_id',get('kr_id')); // kr = kiosk register

            params.append('receivedBaht', this.receivedBaht);
            return params;
          },

          saveBookingFromButtonClick() {
            let loader = this.$loading.show();
            let params = this.bookingInfo();
            params.append('fromButtonClick', 1);
            axios.post("https://booking-system24.com/busbooking/index.php/booking/save_new", params)
            .then(response => {
              if (response) {
                console.log('booking has saved.');
                if (response.data.id) {
                  this.bookingId = response.data.id;
                }
                mySwal.fire({
                  title: 'Your booking ticket have been saved.',
                  type: 'success'
                }).then(() => this.nextStep())

                this.printBooking();
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },

          saveBookingCash() {
            let loader = this.$loading.show();
            let params = this.bookingInfo();
            params.append('fromButtonClick', 1);
            axios.post("https://booking-system24.com/busbooking/index.php/booking/save_new", params)
            .then(response => {
              if (response) {
                console.log('booking has saved.');
                if (response.data.id) {
                  this.bookingId = response.data.id;
                  this.printBooking();
                  this.nextStep();
                }
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());
          },

          saveBooking() {
            let params = this.bookingInfo();
            axios.post("https://booking-system24.com/busbooking/index.php/booking/save_new", params)
            .then(response => {
              if (response) {
                console.log('booking has saved.');
                if (response.data.id) {
                  this.bookingId = response.data.id;
                }
              }
            })
            .catch(error => console.log(error));
          },
          printBooking() {
            let cef = 'B';
            if(typeof cef != 'undefined'){ // cef is the object of cefsharp library from WinApp
              this.printDirectlyToPrinter(this.bookingId, 'B'); // Bill type bus is "B"
            }else{
              let url = "https://booking-system24.com/smartbus/index.php/busbooking?id=" + this.bookingId + '&cid=' + this.companyId;
              // let url = "http://localhost/smartbus/index.php/busbooking?id=" + this.bookingId + '&cid=' + this.companyId;
              if (location.protocol == 'http:') {
                window.open(url, '_blank');
              } else {
                let loader = this.$loading.show();
                this.printPdf(url);
                loader.hide();
              }
            }
          },
          printPdf: function (url) {
            var iframe = this._printIframe;
            if (!this._printIframe) {
              iframe = this._printIframe = document.createElement('iframe');
              document.body.appendChild(iframe);

              iframe.style.display = 'none';
              iframe.onload = function() {
                setTimeout(function() {
                  iframe.focus();
                  iframe.contentWindow.print();
                }, 1);
              };
            }
            iframe.src = url;
          },
          bindDataPassengers(event, keyboard, el) {
            let value = keyboard.$preview.val();
            // let idx = $(el).data('index');
            // let from = $(el).data('name');
            let idx = keyboard.$el.data('index');
            let from = keyboard.$el.data('name');
            let type = keyboard.$el.data('type');
            let item = '';

            if (type == 'departure') {
              item = this.passengersDeparture.find((_, index) => index == idx);
            } else if (type == 'return') {
              item = this.passengersReturn.find((_, index) => index == idx);
            }

            if (item && from == 'passport') {
              item.passport = value;
            } else if (item && from == 'name') {
              item.name = value;
            } else if (item && from == 'mobile') {
              item.mobile = value;
            } else if (item && from == 'email') {
              item.email = value;
            }

            this.checkPassengerDataRequired();
          },
          initialKeyboard() {
            var keyboardCofig = {
              // usePreview: false,
              // userClosed: true,
              autoAccept: true,
              tabNavigation: true,
              enterNavigation: true,
              display: {
                'bksp': '&#8678',
                'alt': 'TH/EN',
                'cancel': 'Close'
              }
            }

            var hideButton = () => {
              $("button.ui-keyboard-tab, button.ui-keyboard-accept").hide();
            }

            /*var addNav = function(base) {
              base.$el.addClass('current');
              var inputs = $('input');
              var indx = inputs.index(base.$el);
              var inputPosition = inputs.eq(indx).offset().top;
              var inputHeight = base.$el.height();
              var keyboardHeight = 450;
              var windowHeight = $(window).height();
              var spaceFromBottom = windowHeight - inputPosition;
              var offset = inputPosition - spaceFromBottom;
              console.log('windowHeight', windowHeight);
              console.log('inputPosition', inputPosition);
              console.log('keyboardHeight', keyboardHeight);
              console.log('spaceFromBottom', spaceFromBottom);
              console.log('= ', offset);

              $('#app').stop().animate({ scrollTop: 0 });
            };*/


            console.log('initial Keyboard');
            $('input[class*="passenger-passport"]')
            .keyboard({
              layout: 'qwerty',
              ...keyboardCofig,
              visible: function(e, keyboard, el) {
                // addNav(keyboard);
                hideButton();
              },
              beforeClose: function(e, keyboard, el, accepted) {
              },
              change: (event, keyboard, el) => {
                if (event.action == 'enter') {
                  keyboard.accept();

                }
              },
              accepted: async (event, keyboard, el) => {
                this.bindDataPassengers(event, keyboard, el);
                let type = keyboard.$el.data('type');
                let index = keyboard.$el.data('index');
                let r = await this.suggestCustomerByID(index, type);
                if(r){
                  let item = '';
                  if (type == 'departure') {
                    item = this.passengersDeparture.find((_, i) => i == index);
                  } else if (type == 'return') {
                    item = this.passengersReturn.find((_, i) => i == index);
                  }
                  console.log(r.data);
                  item.gender = r.gender;
                  item.name = r.name;
                  item.mobile = r.telno;
                  item.email = r.email;
                }
              },
            })
            .addTyping({
              showTyping: true,
              delay: 250,
            });

            $('input[class*="passenger-email"]')
            .keyboard({
              layout: 'qwerty',
              ...keyboardCofig,
              visible: (event, keyboard, el) => {
                hideButton();
              },
              beforeClose: (e, keyboard, el, accepted) => {
              },
              change: (event, keyboard, el) => {
                if (event.action == 'enter') {
                  keyboard.accept();
                }
              },
              accepted: (event, keyboard, el) => {
                this.bindDataPassengers(event, keyboard, el);
              },
            })
            .addTyping({
              showTyping: true,
              delay: 250,
            });

            $('input[class*="passenger-name"]')
            .keyboard({
              layout: 'thai-qwerty',
              ...keyboardCofig,
              visible: (event, keyboard, el) => {
                hideButton();
              },
              beforeClose: (e, keyboard, el, accepted) => {
              },
              change: (event, keyboard, el) => {
                if (event.action == 'enter') {
                  keyboard.accept();
                }
              },
              accepted: (event, keyboard, el) => {
                this.bindDataPassengers(event, keyboard, el);
              },
            })
            .addTyping({
              showTyping: true,
              delay: 250,
            });

            $('input[class*="passenger-mobile"]')
            .keyboard({
              layout: 'custom',
              customLayout: {
                'normal' : [
                  '1 2 3',
                  '4 5 6',
                  '7 8 9',
                  '0 {bksp}',
                  '{cancel} {enter}'
                ]
              },
              ...keyboardCofig,
              visible: function(e, keyboard, el) {
                // addNav(keyboard);
              },
              beforeClose: function(e, keyboard, el, accepted) {
              },
              change: (event, keyboard, el) => {
                if (event.action == 'enter') {
                  keyboard.accept();
                }
              },
              accepted: (event, keyboard, el) => {
                this.bindDataPassengers(event, keyboard, el);
              }
            })
            .addTyping({
              showTyping: true,
              delay: 250,
            });

            $('input[class*="province-search"]')
            .keyboard({
              layout: 'thai-qwerty',
              usePreview: false,
              ...keyboardCofig,
              visible: function(e, keyboard, el) {
                // addNav(keyboard);
                hideButton();
              },
              beforeClose: (e, keyboard, el, accepted) => {
              },
              change: (event, keyboard, el) => {
                if (event.action == 'enter') {
                  keyboard.accept();
                }
              },
              accepted: (event, keyboard, el) => {
                let value = keyboard.$preview.val();
                if (el.id == 'searchProvinceDeparture') {
                  this.depProvinceSearch = value;
                } else {
                  this.desProvinceSearch = value;
                }
              }
            })
            .addTyping({
              showTyping: true,
              delay: 250,
            });

          },

          initialDatePicker() {
            var dateConfig = {
              todayBtn: 'linked',
              language: lang,
              todayHighlight: true,
              format: 'yyyy-mm-dd',
            };

            $('#fromDate').datepicker(dateConfig).on('changeDate', ev => {
              if (!ev.date) {
                $('#fromDate').datepicker('setDate', this.depDate);
                return;
              }
              this.depDate = getDateStandard(ev.date);
            });
            $('#fromDate2').datepicker(dateConfig).on('changeDate', ev => {
              if (!ev.date) {
                $('#fromDate2').datepicker('setDate', this.depDate);
                return;
              }
              this.depDate = getDateStandard(ev.date);
            });
            $('#fromDate3').datepicker(dateConfig).on('changeDate', ev => {
              if (!ev.date) {
                $('#fromDate3').datepicker('setDate', this.depDate);
                return;
              }
              this.depDate = getDateStandard(ev.date);
            });
            $('#toDate').datepicker(dateConfig).on('changeDate', ev => {
              if (!ev.date) {
                $('#toDate').datepicker('setDate', this.desDate);
                return;
              }
              this.desDate = getDateStandard(ev.date);
            });
            $('#toDate2').datepicker(dateConfig).on('changeDate', ev => {
              if (!ev.date) {
                $('#toDate2').datepicker('setDate', this.desDate);
                return;
              }
              this.desDate = getDateStandard(ev.date);
            });

            // let startDate = moment(new Date(), 'YYYY-MM-DD').add(1, 'days').format().substr(0, 10);

            $('#fromDate').datepicker('setStartDate', this.depDate || getDateStandard(new Date()));
            $('#fromDate2').datepicker('setStartDate', this.depDate || getDateStandard(new Date()));
            $('#fromDate3').datepicker('setStartDate', this.depDate || getDateStandard(new Date()));
            $('#toDate').datepicker('setStartDate', this.desDate || getDateStandard(new Date()));
            $('#toDate2').datepicker('setStartDate', this.desDate || getDateStandard(new Date()));

            $('#fromDate').datepicker('setDate', this.depDate || getDateStandard(new Date()));
            $('#fromDate2').datepicker('setDate', this.depDate || getDateStandard(new Date()));
            $('#fromDate3').datepicker('setDate', this.depDate || getDateStandard(new Date()));
            $('#toDate').datepicker('setDate', this.desDate || getDateStandard(new Date()));
            $('#toDate2').datepicker('setDate', this.desDate || getDateStandard(new Date()));

            $('#fromDate .datepicker .datepicker-days')
            .on('click', 'td:not([class*="disabled"]).day', () => {
              setTimeout(() => $('#dateModal').modal('hide'), 200);
            });

            $('#toDate .datepicker .datepicker-days')
            .on('click', 'td:not([class*="disabled"]).day', () => {
              setTimeout(() => $('#date2Modal').modal('hide'), 200);
            });
          },
          setReceivedBaht(value) {
            if (!value) value = 0;
            this.receivedBaht = value;
          },
          setRemainBaht(value) {
            if (!value) value = 0;
            this.remainBaht = value;
          },
          setChangeBaht(value) {
            if (!value) value = 0;
            this.changeBaht = value;
          },
          getTotalAmount() {
            if (!this.total) return this.total = 0;
            return this.total
          },
          async filterByTime(fromSection = 'Route', fromTripType = 1, timeRange = 0) {
            if (fromSection == 'Route') {
              if (fromTripType == 1) {
                if (!this.checkRouteTravelTrip()) {
                  return;
                }
                if (this.depTimeFilter == timeRange) {
                  this.depTimeFilter = '';
                } else {
                  this.depTimeFilter = timeRange;
                }
                /*await this.loadRoundTravelTrip();
                if (this.depRoundList.length == 0) {
                  mySwal.fire({
                    title: 'ไม่มีรอบรถจากรายการที่คุณเลือก กรุณาเลือกวันที่/เวลาใหม่'
                  });
                }*/
              } else {
                if (!this.checkRouteTravelTrip() || !this.checkDateReturnTrip()) {
                  return;
                }
                if (this.desTimeFilter == timeRange) {
                  this.desTimeFilter = '';
                } else {
                  this.desTimeFilter = timeRange;
                }
                /*await this.loadRoundReturnTrip();
                if (this.desRoundList.length == 0) {
                  mySwal.fire({
                    title: 'ไม่มีรอบรถจากรายการที่คุณเลือก กรุณาเลือกวันที่/เวลาใหม่'
                  });
                }*/
              }
            } else {
              this.tripFilter(fromTripType);
            }
          },
          sortBy(type, sortby) {
            if (type == 1) {
              if (this.depRoundListSortBy == sortby && this.depRoundListSortDir == 'ASC') {
                this.depRoundListSortDir = 'DESC';
              } else {
                this.depRoundListSortBy = sortby;
                this.depRoundListSortDir = 'ASC';
              }
            } else {
              if (this.desRoundListSortBy == sortby && this.desRoundListSortDir == 'ASC') {
                this.desRoundListSortDir = 'DESC';
              } else {
                this.desRoundListSortBy = sortby;
                this.desRoundListSortDir = 'ASC';
              }
            }
            this.tripFilter(type);
          },
          showPaymentGatewayModal(){
            $('#paymentGatewayModal').modal();
            $('#choice-pad').show();
            $('#qr-pad').hide();
            this.fadeBlinker('textQRDanger' ,3 ,2);
          },
          hidePaymentGatewayModal(){
            $('#paymentGatewayModal').modal('hide');
            clearInterval(this.inquiryCounter);
            clearInterval(this.couterInterval);
          },
          changeto_qr_pad(){
            let loader = this.$loading.show();

            let params = new URLSearchParams();
            params.append('selector', this.paymentSelector);
            params.append('bookingId', this.bookingId);

            axios.post("https://booking-system24.com/busbooking/index.php/booking/api_post_generator" , params)
            .then(response => {
              console.log(response);
              let r = response.data;
              if(r != null && r.res_code == "00" && r.res_desc == 'success'){
                $('#qr-generator').attr("src","https://booking-system24.com/busbooking/qr-generator.php"+"?txt="+response.data.qrCode);
                if(r.transactionId){
                  clearInterval(this.couterInterval);
                  this.countdown(10);
                  this.payTransactionId = r.transactionId;
                }
              }else{
                mySwal.fire({
                    title: "ระบบชำระเงินขัดข้อง!", // account has create Msg
                    type: 'error',
                    text: "กรุณาเปลี่ยนวิธีชำระเงิน",
                    showConfirmButton: true,
                  }).then(() => {
                    this.changeto_choice_pad();
                  });
                return;
              }
            })
            .catch(error => console.log(error))
            .then(() => loader.hide());

            $('#qrlabel1').attr("src",$('#'+this.paymentSelector+'label1').attr("src"));
            $('#qrlabel2').text($('#'+this.paymentSelector+'label2').text());

            $('#choice-pad').hide("slide", { direction: "left" }, 500);
            $('#qr-pad').show("slide", { direction: "right" }, 500);

            this.fadeBlinker('textScanDanger' ,60 ,2);
            $('#btnGatewayModalClose').prop( "disabled", false );
            $('#btnPreviouspad').prop( "disabled", false );
          },
          changeto_choice_pad(){
            clearInterval(this.inquiryCounter);
            clearInterval(this.couterInterval);
            this.fadeBlinker('textQRDanger' ,3 ,2);
            $('#qr-pad').hide("slide", { direction: "right" }, 500);
            $('#choice-pad').show("slide", { direction: "left" }, 500);
          },

          countdown(min) {
            var date = moment(new Date()).add(min, 'minutes');
            var today = Date.parse(new Date());
            this.minutes = min;
            this.seconds = '00';

            var countDownDate = new Date(date).getTime();
            console.log(countDownDate);

            // Update the count down every 1 second
            this.couterInterval = setInterval(() => {

              // Get todays date and time
              var now = new Date().getTime();

              // Find the distance between now and the count down date
              var distance = countDownDate - now;

              // Time calculations for days, hours, minutes and seconds
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);

              this.minutes = minutes;
              this.seconds = seconds;

              // If the count down is finished, write some text
              if (distance <= 0) {
                console.log('pass if distance zero');
                if(this.paymentMethod == '2'){
                  this.changeto_choice_pad();
                  mySwal.fire({
                        title: "ท่านไม่ได้ชำระเงินภายในเวลาที่กำหนด!", // account has create Msg
                        type: 'warning',
                        text: "กรุณาเปลี่ยนวิธีชำระเงิน",
                        showConfirmButton: true,
                      }).then(() => {
                        this.changeto_choice_pad();
                      });
                }
                clearInterval(this.couterInterval);
              }

            }, 1000);

          },

          inquiry(){
            console.log('welcome to inquiry fnc');
            Swal.fire({
                title: "กำลังตรวจสอบระบบการชำระเงิน กรุณารอสักครู่",
                allowOutsideClick: false,
            });
            Swal.showLoading();
            // Update the count down every 1 second
            let params = new URLSearchParams();
            params.append('tid', this.payTransactionId);
            params.append('bookingId', this.bookingId);
            this.inquiryCounter = setInterval(() => {
              axios.post("https://booking-system24.com/busbooking/index.php/booking/api_post_inquiry" , params)
              .then(response => {
                console.log(response);
                let r = response.data;
                if(r){
                  if(r.res_code == "00" && r.res_desc == 'success'){
                      clearInterval(this.inquiryCounter);
                      clearInterval(this.couterInterval);
                      Swal.close();
                      this.inquiryStatus = true;
                      this.saveBookingGateway();
                  }
                }
              });
            }, 5000);
          },
          startInquiry(){
            $('#btnGatewayModalClose').prop( "disabled", true );
            $('#btnPreviouspad').prop( "disabled", true );
            clearInterval(this.inquiryCounter);
            this.inquiry();
          },
          saveBookingGateway(){
            mySwal.fire({
                title: "ชำระเงินเสร็จสิ้น!", // account has create Msg
                type: 'success',
                text: "ระบบกำลังดำเนินการต่อ กรุณารอสักครู่...",
                showConfirmButton: false,
                allowOutsideClick: false,
              });

            let params = this.bookingInfo();
            params.append('fromGateway', 1);
            axios.post("https://booking-system24.com/busbooking/index.php/booking/save_new", params)
            .then(response => {
              if (response) {
                console.log('booking has saved.');
                if (response.data.id) {
                  this.bookingId = response.data.id;
                  this.printBooking();
                }
                this.hidePaymentGatewayModal();
                mySwal.close();
                mySwal.fire({
                  title: 'ดำเนินการเสร็จสิ้น',
                  type: 'success',
                  showConfirmButton: false,
                  timer: 3000,
                }).then(() => this.nextStep());
              }
            }); // end of axios
          },
          fadeBlinker(el ,cnt ,paym){ // el : element id , cnt : จำนวนครั้งที่ต้องการกระพริบ , paym : 1 คือ ต้องการ Reset การนับเวลาการชำระเงินใหม่
            if(paym == 1){ clearInterval(this.couterInterval) }

            let i = 0;
            let xi = setInterval(() => {
              i++;
              $('#' + el).fadeOut(500);
              $('#' + el).fadeIn(500);
              if(i >= cnt){

                clearInterval(xi);
                if(paym == 1){
                  clearInterval(this.couterInterval);
                  this.countdown(10);
                }
              }
            }, 1000);
          },
          countDepRound() {
            this.depTimeFirst = 0;
            this.depTimeSecond = 0;
            this.depTimeThird = 0;
            this.depTimeFourth = 0;

            this.depRoundList.forEach(v => {
              if(v.frtime >= "00:00" && v.frtime <= "05:59"){
                this.depTimeFirst++;
              }else if(v.frtime >= "06:00" && v.frtime <= "11:59"){
                this.depTimeSecond++;
              }else if(v.frtime >= "12:00" && v.frtime <= "17:59"){
                this.depTimeThird++;
              }else if(v.frtime >= "18:00" && v.frtime <= "23:59"){
                this.depTimeFourth++;
              }
            });
          },
          countDesRound(){
            this.desTimeFirst = 0;
            this.desTimeSecond = 0;
            this.desTimeThird = 0;
            this.desTimeFourth = 0;

            this.desRoundList.forEach(v => {
              if (v.frtime >= "00:00" && v.frtime <= "05:59") {
                this.desTimeFirst++;
              } else if (v.frtime >= "06:00" && v.frtime <= "11:59") {
                this.desTimeSecond++;
              } else if (v.frtime >= "12:00" && v.frtime <= "17:59") {
                this.desTimeThird++;
              } else if (v.frtime >= "18:00" && v.frtime <= "23:59") {
                this.desTimeFourth++;
              }
            });
          },
          printDirectlyToPrinter(inv, typ){ // typ is ticket type e.g T=tour, B=Bus, P=parcel
            // cef.printDirectPdf(inv, typ);
            fetch("https://booking-system24.com/busbooking/index.php/printticket/print"+"?docno="+inv+"&dtype=B")
            .then(response => {
              return response.json()
            })
            .then(async res => {
              console.log(res);
              fetch('http://127.0.0.1:7777/v1/prints', {
                method: 'post',
                mode: 'no-cors',
                body:  JSON.stringify(res)
              })
              .then(async response => {
                console.log(response);
              });
            });

            // let url_bill = { 'url_bill': [
            //   "http://localhost/busbooking/pdftemp/11556530223711_0.BMP",
            //   "http://localhost/busbooking/pdftemp/11556530223711_1.BMP",
            //   "http://localhost/busbooking/pdftemp/11556530223711_2.BMP",
            //   "http://localhost/busbooking/pdftemp/11556530223711_3.BMP"
            // ]}


            // axios.post("http://127.0.0.1:7777/v1/prints" , {
            //     url_bill: JSON.stringify(url_bill)
            // }, {
            //   headers: {
            //     'Content-Type': 'application/json',
            //   }
            // })
            // .then(async response => {
            //   console.log(response);
            // });

            // fetch('http://127.0.0.1:7777/v1/prints', {
            //   method: 'post',
            //   body:  JSON.stringify(url_bill)
            // })
          },
          async suggestCustomerByID(idx, type){
            // console.log('val is passport = ' + $('#passport'+idx).val());
            let res_ex = false;
            let item = '';
            if (type == 'departure') {
              item = this.passengersDeparture[idx];
            } else if (type == 'return') {
              item = this.passengersReturn[idx];
            }
            if(!item || !item.passport){return;}
            let params = new URLSearchParams();
            params.append('passporttype', item.passportType);
            params.append('val', item.passport);
            await axios.post("https://booking-system24.com/busbooking/index.php/booking/chk_customer_exist" , params)
            .then(async response => {
              let r = response.data;
              if (!r) return;
              let msg = `<center>เลขบัตร : ${r.data.passport} <br/>ชื่อ - สกุล : ${r.data.name}<br/>เบอร์โทร : ${r.data.telno}<br/>อีเมล : ${r.data.email}</center>`
              if(r.cnt > 0){
                  await mySwal.fire({
                    title: "พบข้อมูลลูกค้าที่เคยทำรายการ! \nต้องการเพิ่มข้อมูลอัตโนมัติหรือไม่?",
                    html: msg,
                    type: "info",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก',
                  })
                  .then(fwd => {
                    if (fwd.value) {
                      mySwal.fire({
                        title : "เพิ่มข้อมูลเรียบร้อย!",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false,
                      });
                      res_ex = r.data;
                    }
                  })
                  .catch(error => console.log(error))
                  .then();
              }
            });
            return res_ex;
          },

          rejectBillTicket() {
            $('#rejectModal').modal();
            return;
          },

          nextFinalReject() {
            if(this.disReject == 1) {
              mySwal.fire({
                title: "โปรดเลือกสาเหตุการยกเลิก",
                confirmButtonText: "ตกลง"
              });
              return;
            }
            this.isTicketReject = 2;
            // this.setCurrentStep(3, true);
            this.saveBooking();
            this.nextStep();
            $('#rejectModal').modal('hide');
          },

          cancelReject() {
            this.disReject = 1;
            return;
          },

          async idCardScan(psIndex, type) {
            // alert('Passenger index ' + psIndex)
            let sw = Swal.fire({
                title: "ระบบกำลังตรวจสอบเพื่ออ่านข้อมูล",
                allowOutsideClick: false,
            });
            Swal.showLoading();
            let res = await fetch('http://127.0.0.1:7777/v1/citizens')
              .then(function(res) {
                return res.json();
              } );
            Swal.close();
            let {
              status,
              sex,
              citizenID,
              nameTH_FirstName,
              nameTH_SurName
            } = res;
            if (status == '00') { // have data
              let ps = '';
              if (type == 'departure') {
                ps = this.passengersDeparture.find((v, i) => i == psIndex);
              } else if (type == 'return') {
                ps = this.passengersReturn.find((v, i) => i == psIndex);
              }
              if (ps) {
                ps.gender = sex;
                ps.name = nameTH_FirstName + ' ' + nameTH_SurName;
                ps.passport = citizenID;
              }
            } else {
              mySwal.fire({
                html: "กรุณาเสียบบัตร ปชช. ของคุณที่เครื่องอ่านบัตร<br/>แล้วกดปุ่มสแกนอีกครั้ง",
                confirmButtonText: "ตกลง"
              });
              return;
            }
          },

          openCash() {
            /*
              Machine status
              00 = Success
            */
            let url = 'http://127.0.0.1:7777/v1/moneys?a=o&amt='+ this.totalBaht
            fetch (url)
            .then((response) => {
              console.log(response)

              return response.json()
            })
            .then((res) => {
              if(res.status == '00'){
                this.getCashAmountInterval = setInterval(this.getCashAmount, 1000)
              }else{
                this.alert('เครื่องไม่รับเงินสดไม่พร้อมใช้งาน')
              }
            })
          },

          getCashAmount(){

            let url = 'http://127.0.0.1:7777/v1/moneys?a=q'
            // let cash = [1,2,5,10,20,50,100,500]
            let remainAmt = this.totalBaht;

            fetch(url)
            .then((response) => {
              console.log('this->get->amount------------->');
              return response.json()
            })
            .then((res) => {
              // cc = cash[Math.floor(Math.random()*cash.length)]
              this.setReceivedBaht(res.value);

              if((this.totalBaht - this.receivedBaht) < -50){
                // Todo
              }else{
                remainAmt = this.totalBaht - this.receivedBaht;
                this.setRemainBaht(remainAmt);

                if(remainAmt <= 0){
                  clearInterval(this.getCashAmountInterval);
                  this.setRemainBaht(0);
                  this.setChangeBaht(remainAmt*(-1));

                  setTimeout(this.saveBookingCash, 5000);
                }
              }
            })
          },

          closeCash(){
            let url = 'http://127.0.0.1:7777/v1/moneys?a=c';
            fetch (url)
            .then((response) => {
              console.log();
            })
          }
        },
        mounted() {
          var _this = this;
          this.loadProvinceDepartureItem();
          this.loadProvinceDestinationItem();
          this.loadVendor();

          this.initialDatePicker();
          this.initialKeyboard();

          var urlParams = new URLSearchParams(location.search);
          if (urlParams.get('page') && urlParams.get('page').includes('timetable')) {
            this.nextStepButtonShow = false;
            this.isTimetable = true;
            this.roundButtonShow = true;
            this.steps.forEach(v => {
              if ([1, 2].indexOf(v.step) == -1) {
                v.isShowStep = false;
              }
            });
          }

          this.documentMounted = true;
        },
        computed: {
          total() {
            let qty = this.passengersDeparture.length;
            let depPrice = parseFloat(this.depRound.price) || 0;
            let desPrice = parseFloat(this.desRound.price) || 0;
            this.insuranceDepartureQty = 0;
            this.insuranceReturnQty = 0;
            this.passengersDeparture.forEach(ps => {
              if (ps.insurance == 1) {
                this.insuranceDepartureQty += 1;
              }
            });
            if (this.tripType == 2) {
              this.passengersReturn.forEach(ps => {
                if (ps.insurance == 1) {
                  this.insuranceReturnQty += 1;
                }
              });
            }
            this.totalBaht = (qty * depPrice) + (qty * desPrice) + (this.insuranceDepartureQty * this.insuranceAmount) + (this.insuranceReturnQty * this.insuranceAmount);
            return this.totalBaht;
          },

          remain() {
            let remain = (parseFloat(this.totalBaht) || 0) - (parseFloat(this.receivedBaht) || 0);
            if (remain < 0) {
              remain = 0;
            }
            return remain;
          },

          timeReformat(){
            if(this.minutes > 0){
              return this.minutes + " : " + ('0' + this.seconds).slice(-2);
            }else if(this.minutes <= 0 && this.seconds > 0){
              if(this.seconds <= 30 && this.paymentMethod == 2){
                this.fadeBlinker('textScanDanger' ,30 ,2);
              }
              return this.seconds;
            }else if(this.seconds <= 0){
              return 0;
            }
          },
        },
        filters: {
          numberFormat: function(value, decimal) {
            if (!value) return 0;
            return (parseFloat(value) || 0).toFixed(decimal || 0)
          },
          currencyFormat: function (value) {
            if (!value) return '0'
            value = parseFloat(value) || 0;
            // return new Intl.NumberFormat('thai', { style: 'currency', currency: 'THB', minimumFractionDigits: 2 }).format(value)
            return new Intl.NumberFormat().format(value)
          },
          dateFormat: function(value, format) {
            if (!value) return '1972-01-01';
            return moment(value).locale('th').format(format || 'YYYY-MM-DD');
          },
          timeFormat: function(value, format) {
            if (!value) return '08:00';
            return moment(value, "HH:mm:ss").format(format || "kk:mm");
          }
        },
        watch: {
          depRoundId(newId, oldId) {
            if (newId != this.depRoundIdTemp && this.depSeatSelectList.length > 0) {
              mySwal.fire({
                title: "ยืนยันการเปลี่ยนแปลงการเลือกรอบรถ",
                showCancelButton: true,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
              }).then(result => {
                if (result.value) {
                  this.depRoundIdTemp = newId;
                  this.depSeatSelectList = [];
                  this.reRenderSeatSelect(true);
                  this.initialPassengerInfoDep();
                } else {
                  this.depRoundId = oldId;
                  this.reRenderSeatSelect();
                }
              });
            } else {
              this.depRoundIdTemp = newId;
              this.initialPassengerInfoDep();
            }
          },
          desRoundId(newId, oldId) {
            if (newId != this.desRoundIdTemp && this.desSeatSelectList.length > 0) {
              mySwal.fire({
                title: "ยืนยันการเปลี่ยนแปลงการเลือกรอบรถ",
                showCancelButton: true,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
              }).then(result => {
                if (result.value) {
                  this.desRoundIdTemp = newId;
                  this.desSeatSelectList = [];
                  this.reRenderSeatSelect(true);
                  this.initialPassengerInfoRet();
                } else {
                  this.desRoundId = oldId;
                  this.reRenderSeatSelect();
                }
              });
            } else {
              this.desRoundIdTemp = newId;
              this.initialPassengerInfoRet();
            }
          },
          depDate(newDate, oldDate) {
            if (!this.depDate) {
              this.depDate = '';
              this.depDateName = '';
              return;
            }
            // var date = getDateString(this.depDate, lang_date);
            var date = getDateString(newDate, lang_date);
            this.depDate = date[1];
            this.depDateName = date[0];
            $('#fromDate').datepicker('update', this.depDate);
            $('#fromDate2').datepicker('update', this.depDate);
            $('#fromDate3').datepicker('update', this.depDate);
            if (this.depDate > this.desDate) {
              $('#toDate').datepicker('setStartDate', this.depDate);
              $('#toDate2').datepicker('setStartDate', this.depDate);
              $('#toDate').datepicker('setDate', this.depDate);
              $('#toDate2').datepicker('setDate', this.depDate);
            } else {
              $('#toDate').datepicker('setStartDate', this.depDate);
              $('#toDate2').datepicker('setStartDate', this.depDate);
            }

            this.tripFilter(1);

            // if (this.steps[1].isCurrent) {
            //   this.tripFilter(1);
            // }
          },
          desDate(newDate, oldDate) {
            if (newDate == 'Invalid da' && newDate <= this.depDate) {
              $('#toDate').datepicker('update', oldDate || newDate);
              $('#toDate2').datepicker('update', oldDate || newDate);
              return;
            }
            if (!this.desDate) {
              this.desDate = '';
              this.desDateName = '';
              return;
            }
            // var date = getDateString(this.desDate, lang_date);
            var date = getDateString(newDate, lang_date);
            this.desDate = date[1];
            this.desDateName = date[0];
            $('#toDate').datepicker('update', this.desDate);
            $('#toDate2').datepicker('update', this.desDate);

            // this.tripFilter(2);
            if (this.tripType == 2) this.tripFilter(2);
            // if (this.steps[1].isCurrent) {
            //   this.tripFilter(2);
            // }
          },
          /*depTimeFilter() {
            this.tripFilter(1);
          },*/
          depPriceFilter() {
            this.tripFilter(1);
          },
          depVendorFilter() {
            this.tripFilter(1);
          },
          /*desTimeFilter() {
            this.tripFilter(2);
          },*/
          desPriceFilter() {
            this.tripFilter(2);
          },
          desVendorFilter() {
            this.tripFilter(2);
          },
          passengersDeparture() {
            setTimeout(() => {
              this.initialKeyboard();
            }, 100);
          },
          passengersReturn() {
            setTimeout(() => {
              this.initialKeyboard();
            }, 100);
          },
          tripType(newValue, oldValue) {
            if (oldValue == 2 && this.desRoundId) {
              mySwal.fire({
                title: "ยืนยันการเปลี่ยนแปลงประเภทการเดินทาง",
                text: "ข้อมูลจะถูกรีเซ็ตหากทำการกดปุ่ม ตกลง",
                showCancelButton: true,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก"
              }).then(result => {
                if (result.value) {
                  this.desRoundId = '';
                  this.desRoundIdTemp = '';
                  this.desSeatSelectList = [];
                } else {
                  this.tripType = oldValue;
                }
              });
            }

            if (newValue == 2 && this.desStationId) {
              this.tripFilter(1);
              this.tripFilter(2);
            }
          },
          carType(newValue) {
            if (newValue) {
              this.tripFilter(1);
              if (this.tripType == 2) this.tripFilter(2);
            }
          },
          currentStep(newValue, oldValue) {
            if (newValue == 0) {
              this.clearFilter(1, 'all');
              if (this.tripType == 2) this.clearFilter(2, 'all');
            }
            if(!(this.paymentMethod == 2 && newValue == 4)){
              this.saveBooking();
            }
          },
          paymentMethod(newValue, oldValue) {
            if (newValue == 1) {
              /*let msg = `เงินคงเหลืือในระบบไม่เพียงพอสำหรับการทอนเงิน
              กรุณาเตรียมเงินให้พอดีกับราคาตั๋ว หรือ เลือกวิธีการชำระเงินด้วยช่องทางอื่น
              ขออภัยในความไม่สะดวก`;
              mySwal.fire({
                title: msg,
                width: '60%'
              });*/
            } else {
              // let msg = `ยอดเงินคงเหลืือในบัตรไม่เพียงพอ
              // กรุณาเลือกช่องทางอื่นในการชำระเงิน
              // ขออภัยในความไม่สะดวก`;
              // mySwal.fire({
              //   title: msg,
              // });
              // this.showPaymentGatewayModal();
            }
          },
          depProvinceId(newValue, oldValue) {
            this.depStationId = '';
            this.depStationName = '';
          },
          desProvinceId() {
            this.desStationId = '';
            this.desStationName = '';
          },
          desStationId(newValue, oldValue) {
            if (newValue) {
              this.tripFilter(1);
              if (this.tripType == 2) this.tripFilter(2);
            }
          },
          depProvinceSearch() {
            this.loadProvinceDepartureItem();
          },
          desProvinceSearch() {
            this.loadProvinceDestinationItem();
          }
        }
      });
    </script>
  </body>
</html>
