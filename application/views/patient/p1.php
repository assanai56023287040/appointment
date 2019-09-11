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
			<button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="onlyshowmodal('patient-profile')" title="ข้อมูลคนไข้" data-content="ดูรายละเอียดข้อมูลคนไข้" data-toggle="popover" data-trigger="hover" data-placement="bottom">
				<i class="far fa-user-circle m-2" style="font-size: 2rem;"></i>
			</button>
			<button type="button" class="btn x-btn-red" style="border-radius: 10px;" @click="logout()" title="ออกจากระบบ" data-content="กลับสู่หน้าลงทะเบียน" data-toggle="popover" data-trigger="hover" data-placement="bottom">
				<i class="fa fa-angle-double-right m-2" style="font-size: 2rem;"></i>
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
				<button class="btn btn-block x-btn-orenge my-3" style="border-radius: 10px;" @click="apmload(selapm.apmid)">
					<i class="fa fa-info align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">ดูข้อมูลการขอทำนัด</span> <!-- ขอทำนัด -->
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
			<div class="col-9 container text-center" style="display: flex;">
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
									<span class="text-muted" v-if="msg.side == 'p'" style="font-size: 14px;">{{ msg.msgtime | hourminute }}</span>
									<div class="d-inline-block bg-light py-2 px-4 text-wrap chat-msg-area text-left">
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
	<div id="new-appointment" class="modal fade" data-backdrop="true" role="dialog">
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
							<i class="far fa-times-circle" data-dismiss="modal" style="font-size: 2rem;"></i>
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
								<div class="input-group my-2">
									<div class="input-group-prepend">
										<div class="input-group-text">
									    	<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" value="" v-model="newapm.isseldct" id="defaultCheck1">
												<label class="form-check-label" for="defaultCheck1">ระบุแพทย์</label>
											</div>
										</div>
									</div>
									<select class="form-control" type="text" id="apmdct" v-model="newapm.apmdct" :disabled="!newapm.isseldct">
										<option value="" disabled selected>เลือกแพทย์</option>										
										<option value="11001">11001 | นพ.ทดสอบระบบแพทย์</option>
										<!-- <option v-for="(t , idx) in timehr" :value="t.k">{{ t.v }}</option> -->
									</select>
									<div class="input-group-append" >
										<button class="btn btn-outline-secondary" type="button" :disabled="!newapm.isseldct" title="ตารางออกตรวจแพทย์">
											<i class="far fa-calendar-alt align-middle" style="font-size: 1.5rem"></i>
										</button>
									</div>
								</div>

								<div class="form-row align-item-center justify-content-center">
									<div class="col form-group">
										<label class="small font-weight-bold" for="apmdate">วันที่ขอทำนัด : </label>
										<input class="form-control datepicker" type="text" id="apmdate" v-model="newapm.apmdate" placeholder="เลือกวันที่">
									</div>
									<div class="col form-group">
										<label class="small font-weight-bold" for="apmtime">เวลาที่ขอทำนัด : </label>
										<select class="form-control" type="text" id="apmtime">
											<option v-for="(t , idx) in timehr" :value="t.k">{{ t.v }}</option>
										</select>
									</div>
								</div> <!-- end div of sub form-row -->

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="clinic" id="clinicChoice2" value="itlct" v-model="newapm.lcttype">
									<label class="form-check-label" for="clinicChoice2">คลีนิคในเวลา</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="clinic" id="clinicChoice1" value="splct" v-model="newapm.lcttype">
									<label class="form-check-label" for="clinicChoice1">คลีนิคเฉพาะทาง</label>
								</div>

								<div v-show="newapm.lcttype == 'itlct'">
									<select id="apmlct"  placeholder="เลือกคลีนิก"> <!-- v-model="newapm.apmlct" -->
										<option v-for="(l , idx) in lctlist" :value="l.lctcode">[ {{ l.lctcode }} ] {{ l.lctname }}</option>
									</select>
								</div>
								
							</div>
						</div>
					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer text-right">
					<!-- new apm -->
					<button class="btn x-btn-green px-3" v-if="isnewapm" style="border-radius: 10px;" @click="savenewapm()">
						<i class="far fa-save align-middle" style="font-size: 2rem"></i>
						<span class="align-middle ml-2" style="font-size: 2rem;">บันทึก</span> <!-- ขอทำนัด -->
					</button>
					<!-- edit apm -->
					<button class="btn x-btn-orenge px-3" v-if="!isnewapm" style="border-radius: 10px;" @click="saveeditapm()">
						<i class="fa fa-pencil-alt fa-flip-horizontal align-middle" style="font-size: 2rem"></i>
						<span class="align-middle ml-2" style="font-size: 2rem;">บันทึก</span> <!-- ขอทำนัด -->
					</button>
				</div>
			</div>
		</div> <!-- end of div modal dialog -->
	</div> <!-- end of div modal new-appointment -->
	
</div> <!-- end of div container #app -->

<?php $this->load->view('js/myjs'); ?>
<script type="text/javascript">

	
	var app = new Vue({
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
			listInterval: null, // interval for show bagde message in chat list
			chatInterval: null, // for update message in chat page
			currmsg: "",
			messages: [],
			offsetchat: 0,
			onlistload: false,
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
				$('.datepicker').datepicker({
						language:'th-th',
						format:'dd/mm/yyyy',	
						autoclose: true,
						todayHighlight: true,
				});

				$('#apmdate').datepicker()
					.on('hide', v =>{
						this.newapm.apmdate = $('#apmdate').val();
					});

				$('#sfdate').datepicker()
					.on('hide', v =>{
						this.sfdate= $('#sfdate').val();
					});

				$('#stdate').datepicker()
					.on('hide', v =>{
						this.stdate = $('#stdate').val();
					});
			},
			activeselect2(elid){
				switch (elid) {
					case 'apmlct':
						$('#apmlct').select2({
							theme: "bootstrap",
							placeholder: "เลือกคลีนิค",
							// sorter: data => data.sort((a, b) => a.lctcode.localeCompare(b.lctcode)),
						});

						$('#apmlct').on("select2:closing", v => {
							this.newapm.apmlct = $('#apmlct').val();
						});
						break;

					case 'apmtime':
						$('#apmtime').select2({
							theme: "bootstrap",
							placeholder: "เลือกเวลา",
							// sorter: data => data.sort((a, b) => a.lctcode.localeCompare(b.lctcode)),
						});

						$('#apmtime').on("select2:closing", v => {
							this.newapm.apmtime = $('#apmtime').val();
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
						$('#apmlct').val(null).trigger('change');
						break;
					default : break;
				}
			},
			logout(){
				Swal.fire({
					title: 'ยืนยันการออกจากระบบ?'
					// text: "You won't be able to revert this!",
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
				let sellct = this.lctlist.find( v => v.lctcode == this.newapm.apmlct);
				let params = new URLSearchParams({
					'header' : this.newapm.header,
					'apmdate' : this.dateformysql(this.newapm.apmdate),
					'apmtime' : this.newapm.apmtime,
					'sicktxt' : this.newapm.sicktxt,
					'tel' : this.newapm.tel,
					'ptid' : this.ptid,
					'hn' : this.ptdata.HN,
					'stid' : this.newapm.stid,
					'isseldct' : this.newapm.isseldct,
					'apmdct' : this.newapm.apmdct,
					'lcttype' : this.newapm.lcttype,
					'apmlct' : sellct.lctcode,
					'lctname' : sellct.lctname,

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
				// $('#create-msg-box').focus();
			},
			apmload(apmid){
				Swal.fire({
	                title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",
	                allowOutsideClick: false,
	            });
	            Swal.showLoading();
				axios.get("<?php echo site_url('appointment/apmload'); ?>",{
					params : {
	            		apmid: apmid
	            	}
				}).then(res => {
					Swal.close();
					console.log(res);
					this.newapm = res.data.row[0];
					this.newapm.apmdate = this.dateforth(res.data.row[0].apmdate);
					$('#apmlct').val(this.newapm.apmlct).trigger('change');
					$('#apmtime').val(this.newapm.apmtime).trigger('change');
					this.actionshowmodal('edit-appointment');
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
					});
				$('#apmlct').val(null).trigger('change');
			},

		},
		mounted() {
			var _this = this;
			let ssidcard = ssget('idcard');
			if(ssidcard != null && ssidcard != ''){
				this.showlistpage();
				this.ptid = lcget('ptid');
				$('#patient-page').removeClass("d-none");
				$('[data-toggle="popover"]').popover();
				this.listload();
				this.lctload();
				this.activedatepicker();
				this.activeselect2('apmtime');
			}else{
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
			}
			
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