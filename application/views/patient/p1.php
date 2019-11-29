<html lang="en">
<head>

  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<title>ระบบนัดหมายออนไลน์</title>
    <?php $this->load->view('css/mycss'); ?>
  	<style type="text/css">
        html{
            height: 100%;
        }
  		body {
  			/* min-height: 100%; */
  			background-image: linear-gradient(to bottom, #f9beff, #f3acfc, #ed9af9, #e687f5, #df74f2, #d365e8, #c655de, #ba45d4, #a736c1, #9427ae, #82179b, #700089);
  			background-repeat: no-repeat;
  			background-attachment: fixed;
  			overflow: hidden;
  			padding: 0 0 0 0 !important;
  		}

  	</style>
    
</head>
<body class="front-end">
<div class="container-fluid m-0 p-0" id="app" style="overflow: hidden;">

<!-- หนา้ลูกค้าใช้ ดูข้อมูล -->
<section id="patient-page" class="p-4 container-fluid d-none" style="display: flex; flex-flow: column; height: 100%;">
	<div style="display: flex;">
		<div class="container-fluid bg-white text-left d-inline-block" style="border-radius: 10px;flex: 1;">
			<div class="row p-3">
				<div class="col-6">
					<h5 class="my-auto">
						<span class="font-weight-bold">HN : </span>
						{{ ptdata.HN }}
					</h5>
				</div>
				<div class="col-6">
					<h5 class="my-auto">
						<span class="font-weight-bold">ชื่อ - นามสกุล : </span>
						{{ ptdata.FNAME }} {{ ptdata.LNAME }}
					</h5>
				</div>
			</div>
		</div>
		<div class="d-inline-block text-right float-right align-middle ml-3">
			<button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="onlyshowmodal('patient-profile')" title="ข้อมูลคนไข้">
				<i class="far fa-user-circle m-2" style="font-size: 2rem;"></i>
			</button>
			<button type="button" class="btn x-btn-red" style="border-radius: 10px;" @click="logout()" title="ออกจากระบบ">
				<i class="fas fa-power-off m-2" style="font-size: 2rem;"></i>
			</button>
		</div>
	</div>

	
	<div class="container-fluid my-2 bg-white"style="display: flex; flex-flow: column; flex: 1 1 auto;border-radius: 10px;height: 85vh">

		<!-- list and search area -->
		<section class="row" id="list-page" style="flex: 1 1 auto;display: none;">
			<div class="col-3 px-3 text-center" style="position: relative;">
				<div class="vl-purple my-3" style="top: 0;right: 0;	position: absolute;"></div>
				<button class="btn btn-block x-btn-green my-3" style="border-radius: 10px;" @click="actionshowmodal('new-appointment')">
					<i class="fa fa-plus align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">เพิ่มข้อมูลใบนัด</span> <!-- ขอทำนัด -->
				</button>
				<hr/>
				<!-- search form is here -->
				<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">คำค้นหา : </p>
				<input class="form-control text-center mt-1 mb-0" placeholder="คำค้นหา" v-model="skeyword" @keyup.enter="listload()"/>

				<p class="font-weight-bold mt-3 mb-0" style="font-size: 1rem">จากวันที่ : </p>
				<input class="form-control text-center mt-1 mb-0 datepicker" id="sfdate" v-model="sfdate" autocomplete="off" />

				<p class="font-weight-bold mt-3 mb-0" style="font-size: 1rem">ถึงวันที่ : </p>
				<input class="form-control text-center mt-1 mb-0 datepicker" id="stdate" v-model="stdate" autocomplete="off" />

				<button class="btn btn-block x-btn-blue my-3" style="border-radius: 10px;" 
						@click="listload()"
						:class="{'non-edit' : onlistload}"
                        :disabled="onlistload"
				>
					<i class="align-middle" style="font-size: 1.8rem" :class="onlistload ? 'fas fa-circle-notch fa-spin' : 'fas fa-search'"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">{{ onlistload ? 'กำลังค้นหา' : 'ค้นหา' }}</span>
				</button>

				<button class="btn btn-block x-btn-red my-3" style="border-radius: 10px;" @click="clearform('searchform')">
					<i class="fa fa-times align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">ล้าง</span>
				</button>

				<hr/>
			</div>
			<!-- row list of apm -->
			<div class="col-9 container text-center" style="display: flex;">
				<div class="m-0 p-0 w-100 h-100" style="display: flex;flex: 1;">
					<div class="container-fluid mt-3 pl-0" style="flex: 1;overflow-y: auto;height: 75vh">
						<div class="row m-0 p-0 bg-white sticky-top">
							<div class="col-12 m-0 p-0">
								<h4 class="d-block mt-3 font-weight-bold">รายการขอทำนัด</h4>
								<hr class="m-0">
							</div>
						</div>
						<div class="container-fluid m-0 bg-white" id="frame-list" v-for="(list , idx) in apmlist">
							<hr class="m-0" v-show="idx != 0">
							<div class="container-fluid py-1 my-2 x-card-light" style="display: flex;" @click="openchat(list.apmid)">
								<div class="d-inline float-left text-center p-0" style="position: relative;min-width: 40px;">
									<div class="vl-purple my-0" style="top: 0;right: 0;	position: absolute;"></div>
									<span class="align-middle" >{{ idx+1 }}</span>
								</div>
								<div class="d-inline pl-3 w-75" style="flex: 1;">
									<!-- <div class="d-block text-left my-1 w-100 text-truncate">
										<h5 class="font-weight-bold m-0">หัวข้อเรื่อง : {{ list.header }}</h5>
									</div> -->
									<div class="d-block text-left w-100 text-truncate small">
										รายละเอียดอาการ : {{ list.sicktxt }}
									</div>
									<div class="d-block text-left small">
										วันที่ขอทำนัด : {{ list.apmdate | thdate }}
									</div>
									<div class="d-block text-left my-1 w-50 small">
										<div class="alert" :class="stalertclass(list.stid)">{{ list.stname }}</div>
									</div>
								</div>
								<div class="d-inline float-right p-0" style="position: relative;min-width: 40px;"></div>
							</div> <!-- end of div row -->
						</div> <!-- end of div v-for -->
					</div> <!-- end of content flex -->
				</div> <!-- end of parent div for flex -->
			</div>
		</section>

		<!-- appointment chat -->
		<section class="row" id="chat-page" style="flex: 1 1 auto;display: none;">
			<div class="col-3 px-3 text-center" style="position: relative;">
				<div class="vl-yellow my-3" style="top: 0;right: 0;	position: absolute;"></div>
				<button class="btn btn-block x-btn-white-grayshadow my-3" style="border-radius: 10px;" @click="onlyshowmodal('patient-profile')">
					<i class="far fa-user-circle align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">ข้อมูลคนไข้</span> <!-- ขอทำนัด -->
				</button>
				<hr/>
				<button class="btn btn-block x-btn-orenge my-3" 
						style="border-radius: 10px;" 
						@click="actionshowmodal('edit-appointment')"
						:class="{'non-edit' : onptapmload}"
                      	:disabled="onptapmload"
				>
					<i class="align-middle" style="font-size: 1.8rem" :class="onptapmload ? 'fas fa-circle-notch fa-spin' : 'fas fa-info'"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">{{ onptapmload ? 'กำลังดาวน์โหลดข้อมูลขอทำนัด' : 'ดูข้อมูลการขอทำนัด' }}</span> <!-- ขอทำนัด -->
				</button>
				<div class="text-center w-100 my-2">
					<h3 class="font-weight-bold">ข้อมูลการขอทำนัด</h3>
					<div class="form-group px-3">
						<label class="small font-weight-bold" for="header">รายละเอียดอาการ : </label>
						<textarea class="form-control non-edit" type="text" :value="selapm.sicktxt" rows="4"></textarea> 
					</div>
					<div class="form-group px-3">
						<label class="small font-weight-bold" for="apmdate">วันที่ขอทำนัด : </label>
						<input class="form-control non-edit text-center" type="text" :value="selapm.apmdate">
					</div>
					<div class="form-group px-3">
						<label class="small font-weight-bold" for="apmdate">เวลาที่ขอทำนัด : </label>
						<input class="form-control non-edit text-center" type="text" :value="selapm.apmtime+'.00'">
					</div>
					<div class="form-group px-3">
						<label class="small font-weight-bold" for="apmdate">เบอร์โทรศัพท์ที่ติดต่อได้ : </label>
						<input class="form-control non-edit text-center" type="text" :value="selapm.tel">
					</div>
				</div>
			</div>
			<!-- chat and option zone -->
			<div class="col-9 container text-center" style="display: flex;" id="chatzone">
				<div class="m-0 p-0 w-100 h-100" style="display: flex;flex: 1;">
					<div class="container-fluid mt-3 px-0" style="flex: 1;height: 75vh;background-color: #ffffcc;position: relative;padding-bottom: 60px;">
						<div class="row m-0 p-0 sticky-top h-100" style="display: flex;flex-direction: column;">
							<div class="container-fluid px-0 col-12" id="messages-area" style="align-self: stretch;overflow-y: auto;">
								<div class="row m-0 p-0 sticky-top">
									<div class="col-12 m-0 p-0 text-right bg-white">
										<button class="btn x-btn-yellow my-1 mx-2" style="border-radius: 10px;" @click="showlistpage(true)">
											<i class="fa fa-chevron-circle-down align-middle" style="font-size: 1.8rem"></i>
											<span class="align-middle mx-2" style="font-size: 1rem;">ปิดหน้าแชท</span> <!-- ขอทำนัด -->
										</button>
										<hr class="my-2">
									</div>
								</div>
								<div class="text-center x-btn-white px-5 mx-5 my-2" v-show="false" style="border-radius: 10px;">
									<i class="fa fa-angle-up align-middle" style="font-size: 1.5rem"></i>
									<span class="align-middle mx-2" style="font-size: 1rem;">โหลดเพิ่มเติม</span>
								</div>
								<div class="d-block m-2" v-for="(msg ,idx) in messages" :class="msg.side == 'a'? 'text-left':'text-right'">
									<div class="d-block text-center text-muted mt-3 mb-1"
                                      v-if="idx == 0 ? true : messages[idx-1].msgdate == msg.msgdate ? false : true"
	                                    >
	                                  <span class="px-4 py-1" style="border: 1px solid #bfbfbf;border-radius: 10px;background-color: #ffff80;font-size: 1rem;">
	                                  	{{ msg.msgdate | thdate }}
	                                  </span>
	                                </div>
									<div class="d-block text-muted" 
										style="font-size: 1rem;" 
										v-if="msg.side != 'a' ? false : idx == 0 ? true : messages[idx-1].creby == msg.creby ? false : true"
											>{{ msg.crebyname }}</div>
									<span class="text-muted" v-if="msg.side == 'p'" style="font-size: 14px;">{{ msg.msgtime | hourminute }}</span>
									<div class="d-inline-block py-2 px-4 text-wrap text-left" :class="msg.msgcl ? 'text-muted font-italic '+msg.msgcl : 'chat-msg-area'">
										{{ msg.msgtxt }}
									</div>
									<span class="text-muted" v-if="msg.side == 'a'" style="font-size: 14px;">{{ msg.msgtime | hourminute }}</span>
								</div>
							</div>
						</div>

						<div class="input-group sticky-bottom" style="height: 55px;"><!-- min-height: 30px; -->
							<input type="text" id="create-msg-box" class="form-control form-control-lg font-weight-bold" placeholder="พิมพ์ เพื่อตอบแชท..." style="font-size: 24px;height: auto;" @keyup.enter="createmsg()" v-model="currmsg">
							<div class="input-group-append" @click="createmsg()">
						    	<span class="input-group-text x-btn-purple">
						    		<i class="fa fa-angle-double-up align-middle mx-3" style="font-size: 24px"></i>
						    	</span>
						  	</div>
						</div>
					</div> <!-- end of content flex -->
				</div> <!-- end of parent div for flex -->
			</div>
		</section>
	</div>

	
</section>

	<!-- ********************     modal zone     ******************** -->

	<!-- patient-profile modal id -->
	<div id="patient-profile" class="modal fade" data-backdrop="true" role="dialog">
		<div class="modal-dialog modal-xl modal-dialog-centered vw-fit">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<div class="row" style="min-width: 100%">
						<div class="col-6 text-left font-weight-bold">
							รายละเอียดข้อมูลผู้ใช้
						</div>
						<div class="col-6 text-right px-0">
							<i class="far fa-times-circle" data-dismiss="modal" style="font-size: 2rem;"></i>
						</div>
					</div>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row justify-content-md-center" style="min-height: 10px;">
							<div class="col-3 text-left">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">ชื่อ(ไทย) : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.FNAME">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">HN : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.HN">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">สกุล(ไทย) : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.LNAME">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">AN : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.AN">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">เพศ : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.MALE">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">โรคประจำตัว : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.CONGENITAL">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">วันเดือนปี เกิด : </p>
								<input type="text" class="form-control non-edit" v-model="ptdata.BIRTHDATE">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">แพ้ยา : </p>
								<input type="text" class="form-control non-edit" :value="ptdata.ALLERGY? ptdata.ALLERGY : ''">
							</div>
						</div>
					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer">
				</div>
			</div>
		</div> <!-- end of div modal dialog -->
	</div> <!-- end of div modal patient-profile -->

	<!-- new-appointment modal id -->
	<div id="new-appointment" class="modal fade" data-backdrop="static" role="dialog" tabindex="-1" data-keyboard="false">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<div class="row" style="min-width: 100%">
						<div class="col-6 text-left font-weight-bold">
							<h3 class="font-weight-bold" v-if="isnewapm"> เพิ่มข้อมูลใบนัด </h3>
							<h3 class="font-weight-bold" v-if="!isnewapm"> แก้ไขข้อมูลใบนัด </h3>
						</div>
						<div class="col-6 text-right px-0">
							<i class="far fa-times-circle icon-hover-trans-gray" data-dismiss="modal" style="font-size: 2rem;"></i>
						</div>
					</div>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row justify-content-center" style="min-height: 10px;overflow: auto;">
							<div class="col-sm-6">

								<div class="form-group">
									<label class="small font-weight-bold" for="sicktxt">รายละเอียดอาการ : </label>
									<textarea class="form-control" id="sicktxt" v-model="newapm.sicktxt" placeholder="แจ้งรายละเอียดอาการป่วยสำหรับการขอทำนัด" rows="5"></textarea>
								</div>
								<div class="form-group">
									<label class="small font-weight-bold" for="header">เบอร์โทรศัพท์ที่ติดต่อได้ : </label>
									<input class="form-control" type="text" id="header" v-model="newapm.tel" placeholder="ระบุเบอร์โทรสำหรับติดต่อกลับ">
								</div>


								<div class="form-group" v-show="false">
									<label class="small font-weight-bold" for="header">หัวข้อเรื่อง : </label>
									<input class="form-control" type="text" id="header" v-model="newapm.header" placeholder="ระบุหัวข้อเรื่อง">
								</div>
								
								<div class="alert alert-danger small" v-show="false">
									<strong>เวลาทำการ : วันและเวลาราชการ     </strong>
									<br/>จันทร์ - ศุกร์  |  8.00 - 16.00
									<br/>ติดต่อคลีนิกในเวลา : 02-926-9991
									<br/>ติดต่อคลีนิกนอกเวลา : 02-926-9860
								</div>
							</div>
							<div class="col-sm-6">

								<div class="d-inline-block form-check form-check-inline text-left">
									<input class="form-check-input" type="checkbox" value="" v-model="newapm.isseldct" id="defaultCheck1">
									<label class="small font-weight-bold form-check-label" for="defaultCheck1">ระบุแพทย์</label>
								</div>

								<div class="d-inline-block float-right text-right mt-1">
									<button class="btn btn-outline-secondary" type="button" title="ตารางออกตรวจแพทย์" :disabled="(!newapm.apmdct && !newapm.apmlct) || (!newapm.isseldct && newapm.lcttype != 'itlct')" @click="actionshowmodal('dct-schedule-in')">
											<i class="far fa-calendar-alt align-middle" style="font-size: 1.5rem"></i>
									</button>
								</div>

								<div class="mt-3 mb-2">
									<select id="apmdct" :disabled="!newapm.isseldct"></select>
								</div>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="clinic" id="clinicChoice2" value="itlct" v-model="newapm.lcttype">
									<label class="small font-weight-bold form-check-label" for="clinicChoice2">คลินิคในเวลา</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="clinic" id="clinicChoice1" value="splct" v-model="newapm.lcttype">
									<label class="small font-weight-bold form-check-label" for="clinicChoice1">คลินิคเฉพาะทาง</label>
								</div>

								<div class="my-2"> <!--  class="collapse" -->
									<select id="apmlct" :disabled="newapm.lcttype != 'itlct'"> <!-- v-model="newapm.apmlct" -->
										<!-- <option v-for="(l , idx) in lctlist" :value="l.lctcode">[ {{ l.lctcode }} ] {{ l.lctname }}</option> -->
									</select>
								</div>

								<div class="form-row align-item-center justify-content-center">
									<div class="col form-group">
										<label class="small font-weight-bold" for="apmdate">วันที่ขอทำนัด : </label>
										<input class="form-control datepicker-forapmdate" type="text" id="apmdate" v-model="newapm.apmdate" placeholder="เลือกวันที่">
									</div>
									<div class="col form-group">
										<label class="small font-weight-bold" for="apmtime">เวลาที่ขอทำนัด : </label>
										<select class="form-control" type="text" id="apmtime"></select>
									</div>
								</div> <!-- end div of sub form-row -->

							</div>
						</div>
					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer text-right">
					<!-- new apm -->
					<button class="btn x-btn-green px-3" v-if="isnewapm" style="border-radius: 10px;" @click="savenewapm()">
						<i class="far fa-save align-middle" style="font-size: 2rem"></i>
						<span class="align-middle ml-2" style="font-size: 2rem;">บันทึก</span><!-- ขอทำนัด -->
					</button>
					<!-- edit apm -->
					<button class="btn x-btn-orenge px-3" 
							v-if="!isnewapm" 
							style="border-radius: 10px;" 
							@click="saveeditapm()"
							:class="{'non-edit' : newapm.stid == '03'}"
                        	:disabled="newapm.stid == '03'"
					>
						<i class="fa fa-pencil-alt fa-flip-horizontal align-middle" style="font-size: 2rem"></i>
						<span class="align-middle ml-2" style="font-size: 2rem;">บันทึกการแก้ไข</span> <!-- ขอทำนัด -->
					</button>
				</div>
			</div>
		</div> <!-- end of div modal dialog -->
	</div> <!-- end of div modal new-appointment -->

	<!-- dct-schedule modal id -->
	<div id="dct-schedule" class="modal fade" data-backdrop="static" role="dialog" tabindex="-1" data-keyboard="false">
		<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
			<div class="modal-content" style="height: 95vh;">
				<!-- modal header -->
				<div class="modal-header">
					<div class="row" style="min-width: 100%">
						<div class="col-6 text-left font-weight-bold">
							<i style="font-size: 2rem;" class="far fa-calendar-alt d-inline mr-2"></i>
							<h3 class="d-inline font-weight-bold" >ตารางออกตรวจแพทย์</h3>
						</div>
						<div class="col-6 text-right px-0">
							<i class="far fa-times-circle icon-hover-trans-gray" @click="actionshowmodal('dct-schedule-out')" style="font-size: 2rem;"></i>
						</div>
					</div>
				</div>

				<!-- modal body -->
				<div class="modal-body" style="display: flex;flex-flow: column;height: 75vh;">
					<div class="row">
						<div class="col-auto">
							<label class="small font-weight-bold" for="dct-schedule-month">เดือนที่ออกตรวจ : </label>
							<input class="form-control" type="text" id="dct-schedule-month" v-model="scheduledctmonth" placeholder="เลือกเดือน">
						</div>
						<div class="col-auto">
							<div class="alert alert-success small alert-dismissible m-0" v-show="scheduledctboo">
								<a href="#" class="close" @click="scheduledctboo=false;loadscheduledct(schedulelctboo,scheduledctboo)">&times;</a>
								<strong>แพทย์ : </strong>
								<br/>{{ scheduledctname }}
							</div>
						</div>
						<div class="col-auto">
							<div class="alert alert-info small alert-dismissible m-0" v-show="schedulelctboo">
								<a href="#" class="close" @click="schedulelctboo=false;loadscheduledct(schedulelctboo,scheduledctboo)">&times;</a>
								<strong>คลินิค : </strong>
								<br/>{{ schedulelctname }}
							</div>
						</div>
					</div>

					<hr class="my-3 mx-0 text-dark">

					<div class="text-center alert alert-warning" v-show="onscheduledctload">
						<i class="fas fa-circle-notch fa-spin align-middle" style="font-size: 1.8rem"></i>
						<span class="align-middle mx-2" style="font-size: 1rem;">กำลังตรวจสอบตารางออกตรวจแพทย์</span>
					</div>
					<div class="text-center alert alert-danger" v-show="!onscheduledctload && scheduledctitem.length == 0">
						<i class="far fa-calendar-times align-middle" style="font-size: 1.8rem"></i>
						<span class="align-middle mx-2" style="font-size: 1rem;">ไม่พบข้อมูลการออกตรวจแพทย์ตามข้อมูลที่เลือก</span>
					</div>
					<div class="row" style="overflow-y: auto;">
						<div class="py-2 col-sm-6 col-md-4 col-lg-3" v-for="(i,idx) in scheduledctitem">
							<div class="card shadow-sm h-100" style="font-size: 1rem" :class="scheduledayclass(i.LCTDAY)" @click="sdisel = sdisel==idx?null:idx">
								<div class="card-body text-left" :class="{'sdisel' : idx==sdisel}">
									<i class="align-middle ml-0 mr-1" style="font-size: 1.6rem" :class="idx == sdisel ? 'fas fa-check-circle' : 'far fa-circle'"></i>
									<span class="font-weight-bold align-middle">{{ i.SUBCLINICNAME }}</span>
									<hr/>
									แพทย์ : {{ i.DCTNAME }}<br/>
									คลินิค : {{ i.LCTNAME }}<br/>
									เวลา : {{ i.TIMESPANNAME }}
								</div>
								<div class="card-footer text-center">
									{{ i.DAYNAME }} | {{ i.WORKDATE }}
								</div>
							</div>
						</div>
					</div>
					
				</div>

				<!-- modal footer -->
				<div class="modal-footer sticky-bottom">
					<button class="btn x-btn-green px-3" 
							style="border-radius: 10px;"
							@click="sdiselitem()"
							:class="{'non-edit' : sdisel == null}"
                        	:disabled="sdisel == null"
						>
						<i class="far fa-save align-middle" style="font-size: 2rem"></i>
						<span class="align-middle ml-2" style="font-size: 2rem;">เลือก</span><!-- ขอทำนัด -->
					</button>
				</div>
			</div>
		</div>
	</div> <!-- end of dct-schedule modal -->
	
</div> <!-- end of div container #app -->

<?php $this->load->view('js/myjs'); ?>
<script type="text/javascript">

	const fdbconfig = {
		databaseURL: "https://tuhappointmentv1.firebaseio.com"
	};

	firebase.initializeApp(fdbconfig);

	const db = firebase.database();
	const apmchat = db.ref('apmchat');
	apmchat.push('yyyyy');
	
	let app = new Vue({
		el: '#app',
		data: {
			patientpage: false,
			listpage: false,
			chatpage: false,
			// for form search
			skeyword: '',
			sfdate: '',
			stdate: '',
			// var for use
			isProfileEdit: false,
			isnewapm: true,
			ptid : '',
			ptdata : [],
			apmlist: [],
			apmid: 0,
			selapm : {},
			newapm : {
				header: '',
				sicktxt: '',
				apmdate: '',
				apmtime: '',
				tel: '',
				stid : '01',
				isseldct: 0,
				apmdct: '',
				apmlct: '',
				lcttype: '',
			},
			timehr: [
				{k: "00", v:"00.00"},
				{k: "01", v:"01.00"},
				{k: "02", v:"02.00"},
				{k: "03", v:"03.00"},
				{k: "04", v:"04.00"},
				{k: "05", v:"05.00"},
				{k: "06", v:"06.00"},
				{k: "07", v:"07.00"},
				{k: "08", v:"08.00"},
				{k: "09", v:"09.00"},
				{k: "10", v:"10.00"},
				{k: "11", v:"11.00"},
				{k: "12", v:"12.00"},
				{k: "13", v:"13.00"},
				{k: "14", v:"14.00"},
				{k: "15", v:"15.00"},
				{k: "16", v:"16.00"},
				{k: "17", v:"17.00"},
				{k: "18", v:"18.00"},
				{k: "19", v:"19.00"},
				{k: "20", v:"20.00"},
				{k: "21", v:"21.00"},
				{k: "22", v:"22.00"},
				{k: "23", v:"23.00"},
			],
			lctlist: [],
			lctlist_x: [],
			dctlist: [],
			dctlist_x: [],
			listInterval: null, // interval for show bagde message in chat list
			chatInterval: null, // for update message in chat page
			currmsg: "",
			messages: [],
			offsetchat: 0,
			onlistload: false,
			onptapmload: false,
			switchload: '',
			onscheduledctload: false,
			scheduledctmonth: '',
			scheduledctname : '',
			schedulelctname : '',
			scheduledctboo : true,
			schedulelctboo : true,
			scheduledctitem: [],
			sdisel : null,
		},
		methods: {
			onlyshowmodal(modal_id){
				$('#'+modal_id).modal();
			},
			actionshowmodal(modal_id){
				switch(modal_id){
					case 'new-appointment' : 
						this.isnewapm = true;
						this.clearform('newapm');
						this.onlyshowmodal('new-appointment');
						break;
					case 'edit-appointment' : 
						this.isnewapm = false;
						this.onlyshowmodal('new-appointment');
						break;
					case 'dct-schedule-in' :
						$('#new-appointment').modal('hide');
						this.onlyshowmodal('dct-schedule');

						let d = moment();

						if(!this.scheduledctmonth){
							this.scheduledctmonth = (d.month()+1)+'-'+(d.year()+543);
						}
						// ตรวจสอบแพทย์
						if(this.newapm.apmdct){
							this.scheduledctname = this.dctlist.find( v => v.dctcode == this.newapm.apmdct).dctname;
							this.scheduledctboo = true
						}else{
							this.scheduledctname = '';
							this.scheduledctboo = false;
						}
						// ตรวจสอบคลินิค
						if(this.newapm.apmlct){
							this.schedulelctname = this.lctlist.find( v => v.lctcode == this.newapm.apmlct).lctname;
							this.schedulelctboo = true
						}else{
							this.schedulelctname = '';
							this.schedulelctboo = false;
						}

						this.sdisel = null;
						this.loadscheduledct();
						break;
					case 'dct-schedule-out' :
						$('#dct-schedule').modal('hide');
						this.onlyshowmodal('new-appointment');
						// this.loadscheduledct();
						break;
				}
			},
			showlistpage(ani = false){	// ani : use animation slide 
				if(ani){
					clearInterval(this.chatInterval);
					$('#list-page').show("slide", { direction: "up" }, 500);
					$('#chat-page').hide("slide", { direction: "down" }, 500);
				}else{
					$('#list-page').css('display','');
				}
				this.ptdata = JSON.parse(lcget('patientdata'));
			},
			showchatpage(){ 
				$('#chat-page').show("slide", { direction: "down" }, 500);
				$('#list-page').hide("slide", { direction: "up" }, 500);
			},
			activedatepicker(){
				$('.datepicker-forapmdate').datepicker({
						language:'th-th',
						format:'dd/mm/yyyy',	
						autoclose: true,
						todayHighlight: true,
						startDate: '+3d',
				});

				$('#apmdate').datepicker()
					.on('hide', v => {
						let df = this.checkapmdatefromnow(this.dateformysql($('#apmdate').val()));
						if(!df){return false;}
						if(df >= 3){
							this.newapm.apmdate = $('#apmdate').val();
						}else if(df >= 0 && df < 3){
							$('#apmdate').val('');
							$('#apmdate').datepicker("show");
							Swal.fire({
							  type: 'error',
							  title: 'วันที่ที่เลือก ไม่สามารถทำนัดได้!',
							  html: '<center>เจ้าหน้าที่สามารถทำนัดให้ได้ 3 วัน นับจากวันที่ขอทำนัด <br> กรุณาเลือกวันที่จากปฏิทินที่เปิดให้เลือก</center>',
							  showConfirmButton: true,
					          allowOutsideClick: false,
							});
						}else{
							$('#apmdate').val('');
							$('#apmdate').datepicker("show");
							Swal.fire({
							  type: 'error',
							  title: 'เลือกวันที่ไม่ถูกต้อง',
							  html: '<center>ไม่สามารถทำนัดย้อนหลังให้ได้ <br> กรุณาเลือกวันที่จากปฏิทินที่เปิดให้เลือก</center>',
							  showConfirmButton: true,
					          allowOutsideClick: false,
							});
						}
					});

				$('.datepicker').datepicker({
						language:'th-th',
						format:'dd/mm/yyyy',	
						autoclose: true,
						todayHighlight: true,
				});

				$('#sfdate').datepicker()
					.on('hide', v =>{
						this.sfdate= $('#sfdate').val();
					});

				$('#stdate').datepicker()
					.on('hide', v =>{
						this.stdate = $('#stdate').val();
					});

				$('#dct-schedule-month').datepicker({
					    language:'th-th',
						format: "mm-yyyy",
						autoclose: true,
						todayHighlight: true,
						startDate: '+3d',
					    startView: "months",
					    minViewMode: "months"
				});

				$('#dct-schedule-month').datepicker()
					.on('hide', v =>{
						let val = $('#dct-schedule-month').val();
						if(val == this.scheduledctmonth || !val){return false;}
						this.scheduledctmonth = val;
						this.loadscheduledct(this.scheduledctboo,this.scheduledctboo);
					});
			},
			activeselect2(elid){
				switch (elid) {
					case 'apmlct':
						$('#apmlct').select2({
							theme: "bootstrap",
							placeholder: "เลือกคลินิค",
							// sorter: data => data.sort((a, b) => a.lctcode.localeCompare(b.lctcode)),
						});

						$('#apmlct').on("select2:select", v => {
							let val = v.params.data.id;
							if(!val || this.newapm.apmlct == val){return false;}
							this.newapm.apmlct = val
							if(this.switchload != 'dct'){ // หากมีการเลือก dct มาก่อน ระบบจะทำการ filter คลีนิคมาให้ เพราะงั้น จึงไม่ต้องไปโหลด dct แล้ว
								this.switchload = 'lct';
								this.loaddctbylct(this.newapm.apmlct);
							}
						});
						break;

					case 'apmtime':
						$('#apmtime').select2({
							theme: "bootstrap",
							placeholder: "เลือกเวลา",
							// sorter: data => data.sort((a, b) => a.lctcode.localeCompare(b.lctcode)),
						});

						$('#apmtime').on("select2:select", v => {
							this.newapm.apmtime = v.params.data.id;
						});
						break;

					case 'apmdct':
						$('#apmdct').select2({
							theme: "bootstrap",
							placeholder: "เลือกแพทย์",
						});

						$('#apmdct').on("select2:select", v => {
							let val = v.params.data.id;
							if(!val || this.newapm.apmdct == val){return false;}
							this.newapm.apmdct = val;
							if(this.switchload != 'lct'){ // หากมีการเลือก lct มาก่อน ระบบจะทำการ filter แพทย์มาให้ เพราะงั้น จึงไม่ต้องไปโหลด lct แล้ว
								this.switchload = 'dct';
								this.loadlctbydct(this.newapm.apmdct);
							}
							
						});
						break;
				
					default:
						break;
				}
				
			},
			dateformysql(strdate){
				if(strdate){
					strdate = strdate.split('/');
					return (strdate[2]-543)+'-'+strdate[1]+'-'+strdate[0];
				}else{
					return "";
				}
			},
			dateforth(sqldate){
				if(sqldate){
					let strdate = sqldate.split('-');
					if(strdate.length == 3){
						return strdate[2]+'/'+strdate[1]+'/'+(parseInt(strdate[0],10)+543);
					}else{return v;}
				}else{
					return "";
				}
			},
			convertdctmonthto(type,m){
				if(m){
					let mx = m.split('-');
					switch(type){
						case 'th' : mx[1] = mx[1]+543;
							break;
						case 'en' : mx[1] = mx[1]-543;
							break;	
					}

					return mx[0]+'-'+mx[1];
				}else{
					return "";
				}
			},
			clearform(type){
				switch(type){
					case 'searchform' : 
						this.skeyword = '';
						this.sfdate = '';
						this.stdate = '';
						this.listload();
						break;
					case 'newapm' :
						this.newapm = {
							header: '',
							sicktxt: '',
							apmdate: '',
							apmtime: '',
							tel: '',
							stid : '01',
							isseldct: 0,
							apmdct: '',
							apmlct: '',
							lcttype: '',
						};
						if(this.switchload == 'dct'){
							this.lctlist = this.lctlist_x;
							this.appendsel2('apmlct',this.lctlist);
						}
						if(this.switchload == 'lct'){
							this.dctlist = this.dctlist_x;
							this.appendsel2('apmdct',this.dctlist);
						}

						this.appendsel2('apmtime',this.timehr);
						this.switchload = '';
						$('#apmlct').val(null).trigger('change');
						$('#apmtime').val(null).trigger('change');
						$('#apmdct').val(null).trigger('change');
						break;
					default : break;
				}
			},
			logout(){
				Swal.fire({
					toast: true
					,position: 'top-end'
					,title: 'ยืนยันการออกจากระบบ?'
					,type: 'warning'
					,showCancelButton: true
					,confirmButtonColor: '#dd3333'
					,confirmButtonText: 'ออกจากระบบ'
					,cancelButtonColor: '#bfbfbf'
					,cancelButtonText: ' ไม่'
				}).then((result) => {
					if (result.value) {
						Swal.fire({
							type: 'success'
					  		,title: 'ออกจากระบบเรียบร้อย!'
					  		,text: 'กรุณารอสักครู่...'
					  		,timer: 2000
					  		,showConfirmButton: false
		                  	,allowOutsideClick: false
						}).then(() => {
							ssremove('idcard');
							lcremove('ptid');
							lcremove('idcard');
							lcremove('patientdata');
							window.location = "<?php echo site_url('login'); ?>";
						});
					}
				});
			},
			savenewapm(){
				if(this.validnewapm()){return false;}
				let sellct = this.lctlist.find( v => v.lctcode == this.newapm.apmlct);
				let seldct = this.dctlist.find( v => v.dctcode == this.newapm.apmdct);
				let params = new URLSearchParams({
					'header' : this.newapm.header,
					'apmdate' : this.dateformysql(this.newapm.apmdate),
					'apmtime' : this.newapm.apmtime,
					'sicktxt' : this.newapm.sicktxt,
					'tel' : this.newapm.tel,
					'ptid' : this.ptid,
					'hn' : this.ptdata.HN,
					'stid' : this.newapm.stid,
					'lcttype' : this.newapm.lcttype,
					'apmlct' : sellct.lctcode,
					'lctname' : sellct.lctname,
					'isseldct' : this.newapm.isseldct,
					'apmdct' : this.newapm.apmdct,
					'dctname' : seldct.dctname,
				});
				axios.post("<?php echo site_url('appointment/newapm'); ?>",params)
				.then(async res => {
					this.apmid = res.apmid;
					this.clearform('newapm');
					$('#new-appointment').modal('hide');
					await this.listload();
					this.selapm = this.apmlist.find(v => v.apmid == res.data.apmid);
					Swal.fire({
						  type: 'success',
						  title: 'บันทึกใบขอทำนัดเสร็จสิ้น',
						  text: 'กรุณารอสักครู่.....',
						  confirmButtonText: '',
						  timer: 2000,
						  showConfirmButton: false,
		                  allowOutsideClick: false,
					}).then(() => {
						this.openchat(this.selapm.apmid);
					});
				});
			},
			saveeditapm(){
				let sellct = this.lctlist.find( v => v.lctcode == this.newapm.apmlct);
				let seldct = this.dctlist.find( v => v.dctcode == this.newapm.apmdct);
				let params = new URLSearchParams({
					'apmid' : this.selapm.apmid,
					'header' : this.newapm.header,
					'apmdate' : this.dateformysql(this.newapm.apmdate),
					'apmtime' : this.newapm.apmtime,
					'sicktxt' : this.newapm.sicktxt,
					'tel' : this.newapm.tel,
					'ptid' : this.ptid,
					'hn' : this.ptdata.HN,
					'stid' : this.newapm.stid,
					'lcttype' : this.newapm.lcttype,
					'apmlct' : sellct.lctcode,
					'lctname' : sellct.lctname,
					'isseldct' : this.newapm.isseldct,
					'apmdct' : this.newapm.apmdct,
					'dctname' : seldct.dctname,
				});
				axios.post("<?php echo site_url('appointment/editapm'); ?>",params)
				.then(async res => {
					this.apmid = res.apmid;
					this.clearform('newapm');
					$('#new-appointment').modal('hide');
					await this.listload();
					this.selapm = this.apmlist.find(v => v.apmid == res.data.apmid);
					Swal.fire({
						  type: 'success',
						  title: 'บันทึกใบขอทำนัดเสร็จสิ้น',
						  text: 'กรุณารอสักครู่.....',
						  confirmButtonText: '',
						  timer: 2000,
						  showConfirmButton: false,
		                  allowOutsideClick: false,
					}).then(() => {
						this.openchat(this.selapm.apmid);
					});
				});
			},
			async listload(){
				this.onlistload = true;
	            await axios.get("<?php echo site_url('appointment/listload'); ?>",{
					params : {
	            		keyword : this.skeyword,
						fdate : this.dateformysql(this.sfdate),
						tdate : this.dateformysql(this.stdate),
						ptid : this.ptid,
	            	}
				})
	            .then(res => {
	            	this.apmlist = [];
	            	this.onlistload = false;
	            	this.apmlist = res.data.row;
	            	this.apmlist.forEach((item,idx) =>{
	            		// console.log(item);
	            		item.apmdate = this.dateforth(item.apmdate);
	            	});
	            });

			},
			stalertclass(v){
				switch(v){
					case '01': 
						return 'alert-secondary'
						break;
					case '02': 
						return 'alert-warning'
						break;
					case '03': 
						return 'alert-success'
						break;
					case '04': 
						return 'alert-primary'
						break;
					case '05': 
						return 'alert-danger'
						break;
					default: 
						return 'alert-light';
				}
			},
			scrolltobottom(){
				let messagesArea = document.getElementById("messages-area");
				$("#messages-area").animate({ scrollTop: messagesArea.scrollHeight }, "slow");
			},
			async openchat(apmid){
				this.showchatpage();
				this.selapm = this.apmlist.find( v => v.apmid == apmid );
				await this.loadchat();
				this.scrolltobottom();
				this.inquirychat();
				this.clearform('newapm');
				this.apmload(this.selapm.apmid,true);
				// $('#create-msg-box').focus();
			},
			apmload(apmid,aniload = false){
				if(aniload)  this.onptapmload = true;
				axios.get("<?php echo site_url('appointment/apmload'); ?>",{
					params : {
	            		apmid: apmid
	            	}
				}).then(res => {
					this.onptapmload = false;
					this.newapm = res.data.row;
					this.newapm.apmdate = this.dateforth(res.data.row.apmdate);
					$('#apmdate').datepicker('update', this.newapm.apmdate);
					$('#apmdct').val(this.newapm.apmdct).trigger('change');
					$('#apmlct').val(this.newapm.apmlct).trigger('change');
					$('#apmtime').val(this.newapm.apmtime).trigger('change');
					
					// this.actionshowmodal('edit-appointment');
				});
			},
			createmsg(){
				if(!this.currmsg){return false;}
				clearInterval(this.chatInterval);
				let dt = new Date();
				let d = dt.getFullYear()+'-'+(dt.getMonth()+1)+'-'+dt.getDate();
				let t = dt.getHours() + ':' + dt.getMinutes().toString().padStart(2,0); // + ":" + dt.getSeconds()
				this.messages.push({
					side:"p"
					,msgtxt: this.currmsg
					,msgdate: d
					,msgtime: t
				});
				
				let params = new URLSearchParams({
					'apmid' : this.selapm.apmid,
					'side' : 'p',
					'msgtxt' : this.currmsg,
					'msgdate' : d,
					'msgtime' : t,
					'msgcl' : '',
				});

				this.currmsg = "";
				this.scrolltobottom();
				$("#create-msg-box").focus();

				axios.post("<?php echo site_url('appointment/createmsg'); ?>",params)
					.then(res => {
						this.inquirychat();
					});
			},
			async loadchat(){
				this.messages = [];
				Swal.fire({
	                title: "กำลังโหลดข้อมูล Chat...",
	                allowOutsideClick: false,
	                // toast: true,
	            });
	            Swal.showLoading();
	            await axios.get("<?php echo site_url("appointment/loadchat"); ?>",{
						params : {
							apmid : this.selapm.apmid,
							offset : this.offsetchat,
							nowside : 'p',
						}
					})
					.then(res => {
						Swal.close();
						res = res.data;
						if(res.success && res.cnt > 0){
							res.msg.forEach((item,idx) => {
								this.messages.push(item);
							});
						}
					});

			},
			inquirychat(){
				this.chatInterval = setInterval(() => {
					axios.get("<?php echo site_url("appointment/inquirychat"); ?>",{
						params : {
							apmid : this.selapm.apmid,
							nowside: 'p',
						}
					})
					.then(res => {
						res = res.data;
						if(res.success && res.cnt > 0){
							res.msg.forEach((item,idx) => {
								this.messages.push(item);
							});
							this.scrolltobottom();
						}
					});
				},5000);
			},

			async lctload(){
				this.lctlist = [];
				this.lctlist_x = [];
				this.activeselect2('apmlct');
				await axios.get("<?php echo site_url('appointment/lctload'); ?>")
					.then(res => {
						res = res.data;
						res.row.forEach((item,idx) => {
							this.lctlist.push({
								lctcode : item.lctcode,
								lctname : item.lctname,
							});
						});
						this.appendsel2('apmlct',this.lctlist);
					});
				this.lctlist_x = this.lctlist;
				$('#apmlct').val(null).trigger('change');
			},
			async dctload(){
				this.dctlist = [];
				this.dctlist_x = [];
				this.activeselect2('apmdct');
				await axios.get("<?php echo site_url('appointment/dctload'); ?>")
					.then(res => {
						res = res.data;
						res.row.forEach((item,idx) => {
							this.dctlist.push({
								dctcode : item.DCT,
								dctname : item.NAME,
							});
						});
						this.appendsel2('apmdct',this.dctlist);
					});
				this.dctlist_x = this.dctlist;
				$('#apmdct').val(null).trigger('change');
			},
			changeformatselect2(elid,arr){
				let dt = [];
				switch(elid){
					case 'apmlct' : 
							arr.forEach((item,idx) => {
								dt.push({
									"id" : item.lctcode
									,"text" : item.lctcode + " | " + item.lctname
								});
							});
						break;
					default : 
						break;
				}

				return {"results" : dt};
			},
			checkapmdatefromnow(dt){
				let n = moment().startOf('day'); // moment will return value for now date
				let sd = moment(dt,"YYYY-MM-DD"); // select date 
				let df = sd.diff(n , 'days');
				return df;
			},
			validnewapm(){
				let npass = false;
				let xmsg = 'ท่านกรอกข้อมูล : <br>';

				if(!this.newapm.sicktxt){
					npass = true;
					xmsg += '-รายละเอียดอาการ<br>';
				}
				if(!this.newapm.tel){
					npass = true;
					xmsg += '-เบอร์โทรศัพท์<br>';
				}
				if(!this.newapm.apmdate){
					npass = true;
					xmsg += '-วันที่ขอทำนัด<br>';
				}
				if(!this.newapm.apmtime){
					npass = true;
					xmsg += '-เวลาที่ขอทำนัด<br>';
				}

				xmsg += 'ไม่ถูกต้อง <br> กรุณากรอกข้อมูลให้ถูกต้องครบถ้วน';
				if(npass){
					Swal.fire({
						type: 'error',
					  	html: '<center>' + xmsg + '</center>',
					  	showConfirmButton: true,
			          	allowOutsideClick: false,
					});

				}
				return npass;
			},
			loadlctbydct(dct){
				let lct = $('#apmlct');
				lct.prop('disabled',true);
				lct.empty();
				let loadoption = new Option('กำลังโหลดข้อมูลคลินิก.....' ,0 ,true ,true);
				lct.append(loadoption).trigger('change');
				axios.get("<?php echo site_url('appointment/loadlctbydct'); ?>",{params: {dct: dct}})
					.then(res => {
						res = res.data;
						if(res.success){
							// res = res.row;
							this.lctlist = [];
							res.row.forEach((item,idx) => {
								this.lctlist.push({
									lctcode : item.LCT,
									lctname : item.NAME,
								});
							});
							this.appendsel2('apmlct',this.lctlist);
							lct.prop('disabled',this.newapm.lcttype != 'itlct');
						}
					});
			},
			loaddctbylct(lct){
				let dct = $('#apmdct');
				dct.prop('disabled',true);
				dct.empty();
				let loadoption = new Option('กำลังโหลดข้อมูลแพทย์ที่ออกตรวจ.....' ,0 ,true ,true);
				dct.append(loadoption).trigger('change');
				axios.get("<?php echo site_url('appointment/loaddctbylct'); ?>",{params: {lct: lct}})
					.then(res => {
						res = res.data;
						if(res.success){
							// res = res.row;
							this.dctlist = [];
							res.row.forEach((item,idx) => {
								this.dctlist.push({
									dctcode : item.DCT,
									dctname : item.NAME,
								});
							});
							this.appendsel2('apmdct',this.dctlist);
							dct.prop('disabled',!this.newapm.isseldct);
						}
					});
			},
			appendsel2(elid,arr){
				let dt = {};
				let newoption = null;
				switch(elid){
					case 'apmlct' : 
							$('#apmlct').empty();

							newoption = new Option("ไม่เลือกคลีนิค" ,0 ,true ,true);
							$('#apmlct').append(newoption).trigger('change');

							arr.forEach((item,idx) => {
								dt = {
									id : item.lctcode
									,text : " [ " + item.lctcode + " ] " + item.lctname
								};
								newoption = new Option(dt.text ,dt.id ,false ,false);
								$('#apmlct').append(newoption).trigger('change');
							});
						break;
					case 'apmdct' : 
							$('#apmdct').empty();

							newoption = new Option("ไม่เลือกแพทย์" ,0 ,true ,true);
							$('#apmdct').append(newoption).trigger('change');

							arr.forEach((item,idx) => {
								dt = {
									id : item.dctcode
									,text : " [ " + item.dctcode + " ] " + item.dctname
								};
								newoption = new Option(dt.text ,dt.id ,false ,false);
								$('#apmdct').append(newoption).trigger('change');
							});
						break;
					case 'apmtime' : 
							$('#apmtime').empty();

							newoption = new Option("ไม่เลือกเวลา" ,"00" ,true ,true);
							$('#apmtime').append(newoption).trigger('change');

							arr.forEach((item,idx) => {
								dt = {
									id : item.k
									,text : item.v
								};
								newoption = new Option(dt.text ,dt.id ,false ,false);
								$('#apmtime').append(newoption).trigger('change');
							});

						break;
					default : 
				}
			},
			loadscheduledct(uselct = true , usedct = true){
				this.onscheduledctload = true;
				this.scheduledctitem = [];
				let std = null;
				let dx = moment(this.convertdctmonthto('en',this.scheduledctmonth),'MM-YYYY').startOf('day');
				let no = moment().startOf('day'); // no is now

				if(dx.month() == no.month() && dx.year() == no.year()){ // ถ้าเป็นเดือนเดียวกัน(หรือน้อยกว่า)ให้ผ่าน IF ลงมา
					std = no.add(3,'days');
					dx = moment(std.format('MM-YYYY'),'MM-YYYY').startOf('day');
					std = std.format('YYYY-MM-DD');

					this.scheduledctmonth = std.format('MM-YYYY');
					$('#dct-schedule-month').datepicker('update',this.scheduledctmonth);
				}else{
					std = dx.startOf('month').format('YYYY-MM-DD');
				}


				let end = dx.endOf('month').format('YYYY-MM-DD');
				axios.get("<?php echo site_url('appointment/loadscheduledct'); ?>",{
					params : {
						lct : uselct ? this.newapm.apmlct : ''
						,dct : usedct ? this.newapm.apmdct : ''
						,std : std
						,end : end
					}
				})
				.then(res => {
					res = res.data;
					this.onscheduledctload = false;
					if(res.success){
						this.scheduledctitem = res.row
						this.scheduledctitem.forEach((item,idx) => {
							item.WORKDATE = this.dateforth(item.WORKDATE.substr(0,10));
						});
					}else{
						this.scheduledctitem = [];
					}
					console.log(res);
				});
			},
			scheduledayclass(v){
				switch(v){
					case 1: 
						return 'card-weekday-color-monday'
						break;
					case 2: 
						return 'card-weekday-color-tuesday'
						break;
					case 3: 
						return 'card-weekday-color-wednesday'
						break;
					case 4: 
						return 'card-weekday-color-thursday'
						break;
					case 5: 
						return 'card-weekday-color-friday'
						break;
					case 6: 
						return 'card-weekday-color-saturday'
						break;
					default: 
						return 'card-weekday-color-sunday';
				}
			},
			async sdiselitem(){
				if(this.sdisel == null){return false;}
				let sel = this.scheduledctitem[this.sdisel];
				if(this.switchload == 'dct' && !this.scheduledctboo && this.newapm.apmdct != sel.DCT){
					// ถ้าปลดการ filter แพทย์ ออกที่หน้าตารางออกตรวจ แล้วเลือกแพทย์ใหม่ ที่ไม่ใช้แพทย์เดิมที่หน้า -> reload LCT
					await this.loadlctbydct(sel.DCT);
				}else if(this.switchload == 'lct' && !this.schedulelctboo && this.newapm.apmlct != sel.LCT){
					// ถ้าปลดการ filter คลีนิค ออกที่หน้าตารางออกตรวจ แล้วเลือกคลีนิคใหม่ ที่ไม่ใช้คลีนิคเดิมที่หน้า -> reload DCT
					await this.loaddctbylct(sel.LCT);
				}

				this.newapm.apmdate = sel.WORKDATE;
				this.newapm.apmdct = sel.DCT;
				this.newapm.apmlct = sel.LCT;

				$('#apmdate').datepicker('update', this.newapm.apmdate);
				$('#apmdct').val(this.newapm.apmdct).trigger('change');
				$('#apmlct').val(this.newapm.apmlct).trigger('change');

				let st = this.timetransform(sel.STTIME);
				this.newapm.apmtime = st.hr;
				$('#apmtime').val(st.hr).trigger('change');
				this.filterapmtime(sel.STTIME,sel.ENDTIME,'apmtime');

				this.actionshowmodal('dct-schedule-out');
			},
			timetransform(t){
				t = t.toString();
				let res = null;
				if(t == "0"){
					res = {
						hr: "00",
						mn: "00",
						sc: "00",
					};
				}else{
					if(t.length >= 5){
						t = t.padStart(6,0);
						let hr = t.slice(0,2);
						let mn = t.slice(2,4);
						let sc = t.slice(4,6);

						res = {
							hr: hr,
							mn: mn,
							sc: sc,
						};
					}
				}

				return res;
			},
			filterapmtime(sttime,endtime,elid){
				let st = this.timetransform(sttime);
				let en = this.timetransform(endtime);

				let i = parseInt(st.hr);
				let t = parseInt(en.hr);
				let arr = [];
				if(i == 0 && t == 0){return false;}
				for (; i <= t; i++){
					arr.push({
						k: i.toString().padStart(2,0), 
						v: i.toString().padStart(2,0)+".00"
					});	
				} //end of for loop
				this.appendsel2(elid,arr);
			},
		},
		mounted() {
			var _this = this;
			let ssidcard = ssget('idcard');
			if(ssidcard == null || ssidcard == ''){
				Swal.fire({
				  type: 'error',
				  title: 'ท่านไม่มีสิทธิ์เข้าใช้งานหน้านี้!',
				  text: 'กรุณาลงทะเบียนอีกครั้ง!',
				  timer: 2000,
				  showConfirmButton: false,
		          allowOutsideClick: false,
				}).then(() => {
					window.location = "<?php echo site_url('login'); ?>";
				});
				return false;
			}

			
			this.showlistpage();
			this.ptid = lcget('ptid');
			$('#patient-page').removeClass("d-none");
			this.listload();
			this.lctload();
			this.dctload();
			this.activedatepicker();
			this.activeselect2('apmtime');
			this.activeselect2('apmdct');

			// let firebaseConfig = {
			// 	apiKey: "AIzaSyA68XE68hnFfoD5zZimz4ET5Vye5JrvCiI",
		 //    	authDomain: "tuhappointmentv1.firebaseapp.com",
		 //    	databaseURL: "https://tuhappointmentv1.firebaseio.com",
		 //    	projectId: "tuhappointmentv1",
		 //    	storageBucket: "tuhappointmentv1.appspot.com",
		 //    	messagingSenderId: "139160427028",
		 //    	appId: "1:139160427028:web:c30fd7df3d2031943fa501",
		 //    	measurementId: "G-0TQP6T4JJY"
		 //  	};
		 //  	// Initialize Firebase
		 //  	firebase.initializeApp(firebaseConfig);
		 //  	firebase.analytics();

			// let firebaseref = firebase.database().ref("apmchat");
			// firebaseref.once('value').then(snapshot => {
			// 	console.log(snapshot.val());
			// });
			
		},
		computed: {

		},
		filters: {
			thdate(v){
				if(v){
					let strdate = v.split('-');
					if(strdate.length == 3){
						return strdate[2]+'/'+strdate[1]+'/'+(parseInt(strdate[0],10)+543);
					}else{return v;}
				}else{
					return "";
				}
			},
			hourminute(v){
				let strtime = v.split(':');
				if(strtime.length == 3 || strtime.length == 2){
					return strtime[0]+':'+strtime[1];
				}else{
					return "";
				}
			},
		},
		watch: {

		},
	});
</script>
</body>
</html>