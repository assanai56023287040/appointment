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

<!-- หน้าแรกของการ Login -->
<section v-show="rgsign" id="rgsign">
	<div class="full-height" style="position: relative;">
		<div class="true-center-page container badge-login bg-white text-center">
			<img class="mt-3" src="<?php echo base_url('assets/img/tuh_header_logo.png'); ?>" width="75%" alt="Responsive image">

				<p class="mt-2 font-weight-bold">เลขบัตรประชาชน</p>
				<div class="px-5 mb-4">
					<input class="form-control text-center" type="text" name="idcard" v-model="idcard" id="idcard" placeholder="กรอกเลขบัตรประชาชน 13 หลัก" style="font-size: 1.5rem;" @keyup.enter="showRegisterForm()" />
					<button class="btn btn-block x-btn-purple mt-3 p-3" id="btnRegister" @click="showRegisterForm()">
						<i class="fa fa-pen-alt fa-flip-horizontal m-3 align-middle" style="font-size: 2rem;"></i>
						<br/>
						ลงทะเบียน
					</button>
					<hr/>
					<button class="btn btn-block x-btn-blue p-3" type="button" @click="onlyShowModal('em-sign')">
						<i class="fa fa-user-nurse m-3 align-middle" style="font-size: 2rem;"></i>
						<br/>
						สำหรับพนักงาน
					</button>
				</div>
		</div>
	</div>
</section>

<!-- หนา้ลูกค้าใช้ ดูข้อมูล -->
<section v-show="rgform" id="rgform" class="p-4 container-fluid" style="display: flex; flex-flow: column; height: 100%;">
	<div class="row pt-3">
		<div class="col-4 text-left">
			<button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="showLoginForm()">
				<i class="far fa-arrow-alt-circle-left m-2 align-middle" style="font-size: 2rem;"></i>
				<span class="align-middle">ย้อนกลับ</span> 
			</button>
		</div>
		<div class="col-4"></div>
		<div class="col-4 text-right">
			<button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="onlyShowModal('patient-profile')" title="ข้อมูลผู้ใช้">
				<i class="far fa-user-circle m-2" style="font-size: 2rem;"></i>
			</button>
		</div>
	</div>

	<!-- area for show less profile -->
	<div class="container-fluid bg-white mt-2" style="border-radius: 10px;">
		<div class="row p-3">
			<div class="col-6">
				<h5 class="my-auto">
					<span class="font-weight-bold">HN : </span>
					{{ phn }}
				</h5>
			</div>
			<div class="col-6">
				<h5 class="my-auto">
					<span class="font-weight-bold">ชื่อ - นามสกุล : </span>
					{{ pname }}
				</h5>
			</div>
		</div>

		<!-- <div class="form-group rounded-lg">
			<input type="text" class="form-control text-center date-picker">
		</div> -->
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
				<input class="form-control text-center mt-1 mb-0 date-picker" v-model="stdate" />

				<p class="font-weight-bold mt-3 mb-0" style="font-size: 1rem">ถึงวันที่ : </p>
				<input class="form-control text-center mt-1 mb-0 date-picker" v-model="sfdate" />

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

	<!-- em-sign modal id -->
	<div id="em-sign" class="modal fade" data-backdrop="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<div class="row" style="min-width: 100%">
						<div class="col-6 text-left font-weight-bold">
							เข้าสู่ระบบสำหรับพนักงาน
						</div>
						<div class="col-6 text-right px-0">
							<i class="far fa-times-circle" data-dismiss="modal" style="font-size: 2rem;"></i>
						</div>
					</div>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<div class="text-center px-5">
						<i class="far fa-user-circle" style="font-size: 6rem;color: #0668E6;"></i>
						<input class="form-control text-center mt-4 font-weight-bold" type="text" name="adminusername" v-model="adminusername" id="adminusername" placeholder="ชื่อผู้ใช้" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<input class="form-control text-center mt-4 font-weight-bold" type="password" name="adminpassword" v-model="adminpassword" id="adminpassword" placeholder="รหัสผ่าน" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<button type="button" class="btn x-btn-blue btn-block mt-4 p-3" @click="emSignin()">
							<i class="fa fa-sign-in-alt" style="font-size: 2rem;"></i>
							<br/>
							ลงชื่อเข้าใช้
						</button>

					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer">
				</div>
			</div>
		</div> <!-- end of div modal dialog -->
	</div> <!-- end of div modal em-sign -->

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
								<input type="text" class="form-control" v-model="pp_th_fname" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">ชื่อ(อังกฤษ) : </p>
								<input type="text" class="form-control" v-model="pp_en_fname" :readonly="!isProfileEdit">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">สกุล(ไทย) : </p>
								<input type="text" class="form-control" v-model="pp_th_lname" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">สกุล(อังกฤษ) : </p>
								<input type="text" class="form-control" v-model="pp_en_lname" :readonly="!isProfileEdit">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">เพศ : </p>
								<input type="text" class="form-control" v-model="pp_gender" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">สถานภาพ : </p>
								<input type="text" class="form-control" v-model="pp_status" :readonly="!isProfileEdit">
							</div>
							<div class="col-3">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">เชื้อชาติ : </p>
								<input type="text" class="form-control" v-model="pp_origin" :readonly="!isProfileEdit">
								<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">สัญชาติ : </p>
								<input type="text" class="form-control" v-model="pp_nationality" :readonly="!isProfileEdit">
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
							เพิ่มข้อมูลการทำขอนัด
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
							
						</div>
					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer text-right">
					<button class="btn x-btn-green my-3" style="border-radius: 10px;">
						<i class="far fa-save align-middle" style="font-size: 2rem"></i>
						<span class="align-middle mx-2" style="font-size: 2rem;">บันทึก</span> <!-- ขอทำนัด -->
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
			rgsign: false,
			rgform: false,
			idcard: '1100600311926',
			adminusername: '',
			adminpassword: '',
			phn: '123456',
			pname: 'assanai dangmin',
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
			pp_th_fname: 'อัศนัย',
			pp_th_lname: 'แดงมิน',
			pp_en_fname: 'Assanai',
			pp_en_lname: 'Dangmin',
			pp_gender: 'ชาย',
			pp_status: 'โสด',
			pp_nationality: 'ไทย',
			pp_origin: 'ไทย',

		},
		methods: {
			onlyShowModal(modal_id){
				$('#'+modal_id).modal();
			},
			showLoginForm(){
				this.rgsign = true;
				this.rgform = false;
			},
			idcardChecker(id) {
				if(id.length != 13){
					return false;
				}
				for(i=0, sum=0; i < 12; i++){
					sum += parseFloat(id.charAt(i))*(13-i); 
				}
				if((11-sum%11)%10!=parseFloat(id.charAt(12))){
					return false;
				}
				return true;
			},
			showRegisterForm(){
				if(this.idcardChecker(this.idcard)){
					
					Swal.fire({
	                		title: 'เลขบัตรประชาชนถูกต้อง',
	                		text: 'กรุณารอสักครู่...',
		                  	type: 'success',
		                  	showConfirmButton: false,
		                  	allowOutsideClick: false,
		                  	timer: 1000,
		                }).then(() => {
								this.rgsign = false;
								this.rgform = true;
		                	});
					
				}else{
					Swal.fire({
					  type: 'error',
					  title: 'เลขบัตรประชาชนไม่ถูกต้อง!',
					  text: 'คุณกรอกเลขบัตรประชาชนไม่ถูกต้อง กรุณาตรวจสอบความถูกต้อง',
					  confirmButtonText: 'ปิด'
					});
				}
				
			},
			activeDatePicker(){
				$(".date-picker").datepicker_thai({
					dateFormat: 'dd/mm/yy',
					buttonImage: "", // ใส่ path รุป
					buttonImageOnly: false,
					currentText: "วันนี้",
					closeText: "ปิด",
					showButtonPanel: true,
					langTh:true,
					yearTh:true,
					numberOfMonths: 1,
					// showOn: 'button',
					// buttonText: "เลือกวันที่",
					// showOn: "both",
					// altField:"#h_dateinput",
					// altFormat: "yy-mm-dd",
					// onSelect:function(selectedDate, datePicker) {            
		  			// 		_this.date = selectedDate;
			  		// }
				});
			},
			clearForm(type){
				switch(type){

				}
			},
			emSignin(){
				$('#em-sign').modal('hide');
				Swal.fire({
	                title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่",
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
	            });
			},

		},
		mounted() {
			var _this = this;
			this.showLoginForm();
			this.activeDatePicker();
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