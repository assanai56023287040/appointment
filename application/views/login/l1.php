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
<section id="rgsign">
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
						<input class="form-control form-control-lg text-center mt-4 font-weight-bold" type="text" name="adminusername" v-model="adminusername" id="adminusername" placeholder="ชื่อผู้ใช้" style="font-size: 1.5rem;" @keyup.enter="$event.target.nextElementSibling.focus()" />
						<input class="form-control form-control-lg text-center mt-4 font-weight-bold" type="password" name="adminpassword" v-model="adminpassword" id="adminpassword" placeholder="รหัสผ่าน" style="font-size: 1.5rem;" @keyup.enter="emSignin()" />
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
	
</div> <!-- end of div container #app -->

<?php $this->load->view('js/myjs'); ?>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
			idcard: '',
			adminusername: '',
			adminpassword: '',
		},
		methods: {
			onlyShowModal(modal_id){
				$('#'+modal_id).modal();
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
			showRegisterForm(){
				if(this.idcardChecker(this.idcard)){
					localStorage.setItem('idcard',this.idcard);
					Swal.fire({
	                		title: 'เลขบัตรประชาชนถูกต้อง',
	                		text: 'กรุณารอสักครู่...',
		                  	type: 'success',
		                  	showConfirmButton: false,
		                  	allowOutsideClick: false,
		                  	timer: 1000,
		                }).then(() => {
								window.location = "<?php echo site_url('patient'); ?>";
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

		},
		mounted() {
			var _this = this;
			this.idcard = localStorage.getItem('idcard');
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