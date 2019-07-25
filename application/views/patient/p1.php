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
  			background-image: linear-gradient(to top, #8500aa, #9a31bf, #b050d4, #c56ce9, #db87ff);
  		}

  	</style>
    
</head>
<body>
<div class="container-fluid" id="app">

<!-- หนา้ลูกค้าใช้ ดูข้อมูล -->
<section v-show="listpage" id="listpage" class="p-4 container-fluid d-none" style="display: flex; flex-flow: column; height: 100%;">
	<div style="display: flex;">
		<div class="container-fluid bg-white text-left d-inline-block" style="border-radius: 10px;flex: 1;">
			<!-- <button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="showLoginForm()">
				<i class="far fa-arrow-alt-circle-left m-2 align-middle" style="font-size: 2rem;"></i>
				<span class="align-middle">ย้อนกลับ</span> 
			</button> -->
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
		<div class="text-right d-inline-block float-right align-middle ml-3">
			<button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="onlyShowModal('patient-profile')" title="ข้อมูลผู้ใช้">
				<i class="far fa-user-circle m-2" style="font-size: 2rem;"></i>
			</button>
			<button type="button" class="btn x-btn-red" style="border-radius: 10px;" @click="logout()" title="ออกจากระบบ">
				<i class="fa fa-angle-double-right m-2" style="font-size: 2rem;"></i>
			</button>
		</div>
	</div>

	<!-- list and search area -->
	<div class="container-fluid" style="display: flex; flex-flow: column; flex: 1 1 auto;">
		<div class="row mt-2 bg-white" style="border-radius: 10px;  flex: 1 1 auto;">
			<div class="col-3 px-3 text-center" style="position: relative;">
				<div class="vl-purple my-3" style="top: 0;right: 0;	position: absolute;"></div>
				<button class="btn btn-block x-btn-green my-3" style="border-radius: 10px;" @click="onlyShowModal('new-appointment')">
					<i class="fa fa-plus align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">เพิ่มข้อมูลใบนัด</span> <!-- ขอทำนัด -->
				</button>
				<hr/>
				<!-- search form is here -->
				<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">คำค้นหา : </p>
				<input class="form-control text-center mt-1 mb-0" placeholder="คำค้นหา" />

				<p class="font-weight-bold mt-3 mb-0" style="font-size: 1rem">จากวันที่ : </p>
				<input class="form-control text-center mt-1 mb-0 datepicker" v-model="stdate" />

				<p class="font-weight-bold mt-3 mb-0" style="font-size: 1rem">ถึงวันที่ : </p>
				<input class="form-control text-center mt-1 mb-0 datepicker" v-model="sfdate" />

				<button class="btn btn-block x-btn-blue my-3" style="border-radius: 10px;">
					<i class="fa fa-search align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">ค้นหา</span>
				</button>

				<button class="btn btn-block x-btn-red my-3" style="border-radius: 10px;">
					<i class="fa fa-times align-middle" style="font-size: 1.8rem"></i>
					<span class="align-middle mx-2" style="font-size: 1rem;">ล้าง</span>
				</button>

				<hr/>
			</div>
			<!-- row list of apm -->
			<div class="col-9 text-center">
				<h4 class="mt-3 font-weight-bold">รายการขอทำนัด</h4>
				<hr class="m-0">
				<div class="container-fluid m-0" style="overflow: auto;">
					<div class="bg-white" v-for="(list , idx) in apmlist">
						<div class="row py-2">
							<div class="col-2 text-left">{{ idx+1 }}</div>
							<div class="col-10">{{ list.header }}</div>
						</div>
						<hr class="m-0"/>
					</div>
				</div>
			</div>
		</div>
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
								<input type="text" class="form-control" v-model="ptdata.FNAME" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">HN : </p>
								<input type="text" class="form-control" v-model="ptdata.HN" :readonly="!isProfileEdit">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">สกุล(ไทย) : </p>
								<input type="text" class="form-control" v-model="ptdata.LNAME" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">AN : </p>
								<input type="text" class="form-control" v-model="ptdata.AN" :readonly="!isProfileEdit">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">เพศ : </p>
								<input type="text" class="form-control" v-model="ptdata.MALE" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">โรคประจำตัว : </p>
								<input type="text" class="form-control" v-model="ptdata.CONGENITAL" :readonly="!isProfileEdit">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">วันเดือนปี เกิด : </p>
								<input type="text" class="form-control" v-model="ptdata.BIRTHDATE" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">แพ้ยา : </p>
								<input type="text" class="form-control" :readonly="!isProfileEdit" :value="ptdata.ALLERGY? 'แพ้ยา' : 'ไม่แพ้ยา'">
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
							เพิ่มข้อมูลใบนัด
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
									<label for="header">หัวข้อเรื่อง : </label>
									<input class="form-control" type="text" id="header" v-model="newapm.header" placeholder="ระบุหัวข้อเรื่อง">
								</div>
								<div class="form-group">
									<label for="apmdate">วันที่ที่ขอทำนัด : </label>
									<input class="form-control datepicker" type="text" id="apmdate" v-model="newapm.apmdate" placeholder="เลือกวันที่">
								</div>
								<div class="form-group">
									<label for="apmtime">เวลาที่ขอทำนัด : </label>
									<select class="form-control" type="text" id="apmtime" v-model="newapm.apmtime" placeholder="เลือกเวลา">
										<option v-for="(t , idx) in timehr" :value="t.k">{{ t.v }}</option>
									</select> 
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="sicktxt">รายละเอียดอาการ : </label>
									<textarea class="form-control" id="sicktxt" v-model="newapm.sicktxt" placeholder="แจ้งรายละเอียดอาการป่วยสำหรับการขอทำนัด" rows="5"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer text-right">
					<button class="btn x-btn-green px-3" style="border-radius: 10px;">
						<i class="far fa-save align-middle" style="font-size: 2rem"></i>
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
			listpage: false,
			// for form search
			skeyword: '',
			sfdate: '',
			stdate: '',
			apmlist: [
				{
					header: 'ปวดเข่า',
				},{
					header: 'ปวดหัว',
				}
			],
			isProfileEdit: false,
			ptdata : [],
			newapm : {
				header: '',
				sicktxt: '',
				apmdate: '',
				apmtime: '',
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

		},
		methods: {
			onlyShowModal(modal_id){
				$('#'+modal_id).modal();
			},
			showListPage(){
				this.listpage = true;
				this.ptdata = JSON.parse(localStorage.getItem('patientdata'));
			},
			showLoginForm(){
				window.location = "<?php echo site_url('login'); ?>";
			},
			activeDatePicker(){
				$('.datepicker').datepicker({
						language:'th-th',
						format:'dd/mm/yyyy',
						autoclose: true,
						todayHighlight: true,
				});

				$('#apmdate').datepicker()
					.on('hide',()=>{
						this.newapm.apmdate = $('#apmdate').val();
					});
			},
			clearForm(type){
				switch(type){

				}
			},
			emSignin(){
				$('#em-sign').modal('hide');
				Swal.fire({
	                title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",
	                allowOutsideClick: false,
	            });
	            Swal.showLoading();
	            axios.get("<?php echo site_url('login/emSignin'); ?>",{
	            	params : {
	            		uid: this.adminusername
	            		,pwd: this.adminpassword
	            	}
	            }).then(res => {
	            	console.log(res);
	            	Swal.close();
	            	res = res.data;

	            	if(res.success){
	            		Swal.fire({
						  type: 'success',
						  title: 'เข้าสู่ระบบเสร็จสิ้น',
						  text: 'กรุณารอสักครู่.....',
						  confirmButtonText: '',
						  timer: 2000,
						  showConfirmButton: false,
		                  allowOutsideClick: false,
						}).then(() => {
							window.location = "<?php echo site_url('employee'); ?>";
						});
	            	}else{
	            		Swal.fire({
						  type: 'error',
						  title: 'ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง!',
						  confirmButtonText: 'ปิด'
						});
	            	}
	            });
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
							localStorage.setItem('idcard','');
							localStorage.setItem('patientdata','');
							window.location = "<?php echo site_url('login'); ?>";
						});
					}
				});
			},
		},
		mounted() {
			var _this = this;
			if(localStorage.getItem('idcard') != ''){
				this.showListPage();
				this.activeDatePicker();
				$('#listpage').removeClass("d-none");
			}else{
				Swal.fire({
				  type: 'error',
				  title: 'ท่านไม่มีสิทธิ์เข้าใช้งานหน้านี้!',
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
		filter: {

		},
		watch: {

		},
		// created () {
		// 	document.addEventListener("backbutton", this.showLoginForm(), false);
		// },
		// beforeDestroy () {
		// 	document.removeEventListener("backbutton", this.showLoginForm());
		// }
	});
</script>
</body>
</html>