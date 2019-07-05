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

  		.badge-login {
  			/*min-height: 40%;*/
  			min-width: 100%;
  			background-color: white;
  			position: absolute;
  			vertical-align: middle;
  			border-radius: 20px;
  		}
  	</style>
    
</head>
<body>
<div class="container-fluid" id="app">

<!-- หน้าแรกของการ Login -->
<section v-show="rgsign" id="rgsign">
	<div class="row full-height">
		<div class="col-4 text-left">
			<button class="btn x-btn-blue stay-left-bottom p-4" type="button" @click="onlyShowModal('em-sign')" style="border-radius: 50px;">
				<i class="fa fa-lock" style="font-size: 2rem;"></i>
			</button>
		</div>
		<div class="col-4">
			<div style="min-height: 30%;"></div>
			<div class="rounded-lg badge-login text-center">
				<img class="mt-3" src="<?php echo base_url('assets/img/tuh_header_logo.png'); ?>" width="75%" alt="Responsive image">

					<p class="mt-2 font-weight-bold">เลขบัตรประชาชน</p>
					<div class="px-5 mb-4">
						<input class="form-control text-center" type="text" name="idcard" v-model="idcard" id="idcard" placeholder="กรอกเลขบัตรประชาชน 13 หลัก" style="font-size: 1.5rem;" @keyup.enter="showRegisterForm()" />
						<button class="btn mt-3 p-3 x-btn-purple" id="btnRegister" @click="showRegisterForm()">
							<i class="fa fa-pen-alt fa-flip-horizontal" style="font-size: 2rem;"></i>
							<br/>
							<span class="mt-3">ลงทะเบียน</span>
						</button>
						<!-- <div class="mt-4">
							<span class="py-3 fa fa-pen-alt fa-flip-horizontal rounded-top" width="100%" style="font-size: 1rem;background-color: #b19cd9;"></span>
							<span width="100%" style="font-size: 1rem;background-color: #ebe4ef;">ลงทะเบียน</span>
						</div> -->
					</div>
			</div>
			<div style="min-height: 30%;"></div>
		</div>
		<div class="col-4"></div>
	</div>	
</section>

<!-- หนา้ลูกค้าใช้ ดูข้อมูล -->
<section v-show="rgform" id="rgform" class="p-4 container-fluid">
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

	<div class="container-fluid">
		<div class="row mt-2 bg-white" style="border-radius: 10px;">
			<div class="col-3 px-3 text-center" style="position: relative;">
				<div class="vl-purple my-3" style="top: 0;right: 0;	position: absolute;"></div>
				<button class="btn btn-block x-btn-green my-3" style="border-radius: 10px;">
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
			<div class="col-9"></div>
		</div>
	</div>
</section>

	<!-- ********************     modal zone     ******************** -->
	<div id="em-sign" class="modal fade" data-backdrop="true" role="dialog">
		<div class="modal-dialog modal-xl modal-dialog-centered">
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
							<i class="far fa-user-circle" style="font-size: 6rem;color: #BA55D3;"></i>
						<input class="form-control text-center mt-4 font-weight-bold" type="text" name="adminusername" v-model="adminusername" id="adminusername" placeholder="ชื่อผู้ใช้" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<input class="form-control text-center mt-4 font-weight-bold" type="password" name="adminpassword" v-model="adminpassword" id="adminpassword" placeholder="รหัสผ่าน" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<button type="button" class="btn x-btn-purple btn-block mt-4 p-3">
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

	<div id="patient-profile" class="modal fade" data-backdrop="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered">
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
					<div class="text-center px-5">
							<i class="far fa-user-circle" style="font-size: 6rem;color: #BA55D3;"></i>
						<input class="form-control text-center mt-4 font-weight-bold" type="text" name="adminusername" v-model="adminusername" id="adminusername" placeholder="ชื่อผู้ใช้" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<input class="form-control text-center mt-4 font-weight-bold" type="passowrd" name="adminpassword" v-model="adminpassword" id="adminpassword" placeholder="รหัสผ่าน" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<button type="button" class="btn x-btn-purple btn-block mt-4 p-3">
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
	</div> <!-- end of div modal patient-profile -->
	
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
			}

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