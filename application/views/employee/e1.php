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
  			background-image: linear-gradient(to bottom, #e9e9e9, #e6e6e6, #e2e2e2, #dfdfdf, #dcdcdc, #d6d6d6, #d0d0d0, #cacaca, #c0c0c0, #b5b5b5, #ababab, #a1a1a1);
  		}

  	</style>
    
</head>
<body class="admin-page p-2">
<div class="container-fluid m-0 p-0" id="app">

<!-- หนา้ลูกค้าใช้ ดูข้อมูล -->
<section v-show="homepage" id="homepage" class="p-0 container-fluid" style="display: flex; flex-flow: column; height: 100%;">
	<div style="display: flex;">
		<div class="container-fluid text-left d-inline-block" style="border-radius: 10px;flex: 1;">
			<div class="x-tab-light" v-for="(item,idx) in selmenu" :class="'active' : isactive">
				<i class="d-inline-block" v-if="item.iconclass" :class="item.iconclass"></i>
				<span class="d-inline-block" v-if="item.text" :class="">{{ item.text }}</span>
				<i class="d-inline-block fa fa-times" v-if="item.close"></i>
			</div>
		</div>
		<div class="d-inline-block text-right float-right align-middle ml-3">
			<button type="button" class="btn x-btn-white" style="border-radius: 10px;" @click="onlyshowmodal('patient-profile')" title="ข้อมูลผู้ใช้" data-content="ดูรายละเอียดข้อมูลคนไข้" data-toggle="popover" data-trigger="hover" data-placement="bottom">
				<!-- <i class="far fa-user-circle m-2" style="font-size: 2rem;"></i> -->
			<span style="font-size: 15px;"> ข้อมูลผู้ใช้ </span>
			</button>
			<button type="button" class="btn x-btn-red" style="border-radius: 10px;" @click="logout()" title="ออกจากระบบ" data-content="กลับสู่หน้าลงทะเบียน" data-toggle="popover" data-trigger="hover" data-placement="bottom">
				<!-- <i class="fa fa-angle-double-right m-2" style="font-size: 2rem;"></i> -->
			<span style="font-size: 15px;"> ออกจากระบบ </span>
			</button>
		</div>
	</div>
</section>

	<!-- ********************     modal zone     ******************** -->
	
</div> <!-- end of div container #app -->

<?php $this->load->view('js/myjs'); ?>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
			homepage: false,
			
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

		},
		methods: {
			onlyShowModal(modal_id){
				$('#'+modal_id).modal();
			},
			showHomePage(){
				this.homepage = true;
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

				// $('#apmdate').datepicker()
				// 	.on('hide', v =>{
				// 		this.newapm.apmdate = $('#apmdate').val();
				// 	});
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
							sessionStorage.setItem('adminusername',null);
							localStorage.setItem('admindata',null);
							window.location = "<?php echo site_url('login'); ?>";
						});
					}
				});
			},

		},
		mounted() {
			var _this = this;
			let ssusername = sessionStorage.getItem('adminusername');
			if(ssusername != null && ssusername != ''){
				this.showHomePage();
				this.activeDatePicker();
			}else{
				Swal.fire({
				  type: 'error',
				  title: 'ท่านไม่มีสิทธิ์เข้าใช้งานหน้านี้!',
				  text: 'กรุณาเข้าสู่ระบบใหม่อีกครั้ง!',
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