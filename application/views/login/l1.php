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
  			/*background-image: linear-gradient(to left bottom, #f9beff, #f3acfc, #ed9af9, #e687f5, #df74f2, #d365e8, #c655de, #ba45d4, #a736c1, #9427ae, #82179b, #700089);*/
  		}

  	</style>
    
</head>
<body class="front-end">
<div class="container-fluid" id="app">

<!-- หน้าแรกของการ Login -->
<section id="signin" class="d-none">
	<div class="full-height" style="position: relative;">
		<div class="true-center-page container badge-login bg-white text-center">
			<img class="mt-3" src="<?php echo base_url('assets/img/tuh_header_logo.png'); ?>" width="75%" alt="Responsive image">

				<p class="mt-2 font-weight-bold">เลขบัตรประชาชน</p>
				<div class="px-5 mb-4">
					<input class="form-control text-center" type="text" name="idcard" v-model="idcard" id="idcard" placeholder="กรอกเลขบัตรประชาชน 13 หลัก" style="font-size: 1.5rem;" @keyup.enter="patientregister()" autocomplete="off"/>
					<button class="btn btn-block x-btn-purple mt-3 p-3" id="btnRegister" @click="patientregister()" style="border-radius: 10px;">
						<i class="fa fa-pen-alt fa-flip-horizontal m-3 align-middle" style="font-size: 2rem;"></i>
						<br/>
						ลงทะเบียน
					</button>
					<hr/>
					<button class="btn btn-block x-btn-blue p-3" type="button" @click="actionmodal('u-sign')" style="border-radius: 10px;">
						<i class="fa fa-user-nurse m-3 align-middle" style="font-size: 2rem;"></i>
						<br/>
						สำหรับพนักงาน
					</button>
				</div>
		</div>
	</div>
</section>

	<!-- ********************     modal zone     ******************** -->

	<!-- u-sign modal id -->
	<div id="u-sign" class="modal fade" data-backdrop="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<div class="row" style="min-width: 100%">
						<div class="col-10 text-left font-weight-bold text-nowrap text-truncate d-inline-block">
							เข้าสู่ระบบสำหรับพนักงาน
						</div>
						<div class="col-2 text-right px-0">
							<i class="far fa-times-circle" data-dismiss="modal" style="font-size: 2rem;"></i>
						</div>
					</div>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<div class="text-center px-5">
						<i :class="adminicon.icon" style="font-size: 6rem;" :style="adminicon.color"></i>
						<input class="form-control form-control-lg text-center mt-4 font-weight-bold" 
							   type="text" 
							   name="adminusername" 
							   v-model="adminusername" 
							   id="adminusername" 
							   placeholder="ชื่อผู้ใช้" 
							   style="font-size: 1.5rem;" 
							   @keyup.enter="$event.target.nextElementSibling.focus()" 
							   autocomplete="new-password"
							   :class="{'non-edit' : adminicon.k != 'sign' }"
							   :disabled="adminicon.k != 'sign' "
						/>
						<input class="form-control form-control-lg text-center mt-4 font-weight-bold" 
							   type="password" 
							   name="adminpassword" 
							   v-model="adminpassword" 
							   id="adminpassword" 
							   placeholder="รหัสผ่าน" 
							   style="font-size: 1.5rem;" 
							   @keyup.enter="usignin()" 
							   autocomplete="new-password" 
							   :class="{'non-edit' : adminicon.k != 'sign' }"
							   :disabled="adminicon.k != 'sign' "
						/>
						<button type="button" 
								class="btn x-btn-blue btn-block mt-4 p-3" 
								style="border-radius: 10px;" 
								@click="usignin()"
								:class="{'non-edit' : adminicon.k != 'sign' }"
							   	:disabled="adminicon.k != 'sign' "
						>
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
	</div> <!-- end of div modal u-sign -->
	

		<!-- u-sign modal id -->
	<div id="user-register" class="modal fade" data-backdrop="static" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<div class="row" style="min-width: 100%">
						<div class="col-10 text-left font-weight-bold text-nowrap text-truncate d-inline-block">
							ลงทะเบียนขอเข้าใช้งาน
						</div>
						<div class="col-2 text-right px-0">
							<i class="far fa-times-circle" data-dismiss="modal" style="font-size: 2rem;"></i>
						</div>
					</div>
				</div>

				<!-- modal body -->
				<div class="modal-body">
					<p class="font-weight-bold mt-1 mb-0" style="font-size: 1rem">รหัสพนักงาน : </p>
                  	<input type="text" class="form-control non-edit" v-model="staffcode">
                  	<p class="font-weight-bold mt-4 mb-0" style="font-size: 1rem">ชื่อพนักงาน : </p>
                  	<input type="text" class="form-control non-edit" v-model="staffname">
                  	<p class="font-weight-bold mt-4 mb-0" style="font-size: 1rem">เบอร์โทรศัพท์ติดต่อภายใน : </p>
                  	<input type="text" class="form-control" @keyup="telvalid = tel ? true : false" :class="telvalid ? '' : 'is-invalid'" v-model="tel">
                  	<div class="alert alert-warning mt-4 mb-0" style="font-size: 1rem">
                  		<strong>แจ้งเพื่อทราบ!</strong>
						<br/>1 - ข้อมูล รหัสพนักงาน / ชื่อพนักงาน ถูกส่งจากระบบ e-Phis ไม่สามารถแก้ไขได้
						<br/>2 - เบอร์ติดต่อภายใน คือเบอร์สำหรับพนักงานภายในโรงพยาบาลธรรมศาสตร์เท่านั้น
						<br/>3 - ผู้ดูแลระบบจะติดต่อกลับไปในภายหลัง หลังจากได้รับทราบการขอลงทะเบียนเข้าใช้เว็บไซต์
					</div>
				</div>

				<!-- modal footer -->
				<div class="modal-footer text-right">
					<!-- new apm -->
					<button class="btn x-btn-green p-3" style="border-radius: 10px;" @click="newuserregister()">
						<i class="far fa-address-book align-middle" style="font-size: 2rem"></i>
						<span class="align-middle ml-2" style="font-size: 1.4rem;">บันทึกการลงทะเบียน</span>
					</button>
				</div>
			</div>
		</div> <!-- end of div modal dialog -->
	</div> <!-- end of div modal u-sign -->

</div> <!-- end of div container #app -->

<?php $this->load->view('js/myjs'); ?>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
			idcard: '1100600311926',
			adminusername: 'assanai',
			adminpassword: '0853709109',
			adminicon: {},
			adminstyle : [
				{
					k: 'sign',
					icon:'far fa-user-circle',
					color: 'color: #0668E6;',
				},
				{
					k: 'load',
					icon:'fas fa-circle-notch fa-spin',
					color: 'color: #ff6600;',
				},
				{
					k: 'pass',
					icon:'far fa-check-circle',
					color: 'color: #00e600;',
				},
			],
			staffcode: '',
			staffname: '',
			tel: '',
			telvalid : true,
		},
		methods: {
			actionmodal(modal_id){
				switch(modal_id){
					case 'u-sign' :
						$('#'+modal_id).modal();
						this.adminicon = this.adminstyle[0];
						if(lcget('adminusername') && lcget('admindata')){
							this.adminicon = this.adminstyle[1];
							this.adminusername = '';
							this.adminpassword = '';
							setTimeout(() => {
								console.log("pass to get this admin username");
								this.adminicon = this.adminstyle[2];
								setTimeout(() => {
									ssset('adminusername',lcget('adminusername'));
									window.location = "<?php echo site_url('admin'); ?>";
								},1000);
							},1000);
						}
							
						break;
					default:
				}
			},
			idcardchecker(id) {
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
			clearform(type){
				switch(type){

				}
			},
			patientregister(){
				if(!this.idcardchecker(this.idcard)){
					Swal.fire({
					  type: 'error',
					  title: 'เลขบัตรประชาชนไม่ถูกต้อง!',
					  text: 'คุณกรอกเลขบัตรประชาชนไม่ถูกต้อง กรุณาตรวจสอบความถูกต้อง',
					  confirmButtonText: 'ปิด'
					});
				}else{
					Swal.fire({
		                title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",
		                allowOutsideClick: false,
		            });
		            Swal.showLoading();
		            axios.get("<?php echo site_url('patient/register'); ?>",{
		            	params : {
		            		idcard: this.idcard
		            	}
		            }).then(res => {
		            	console.log(res);
		            	Swal.close();
		            	res = res.data;

		            	if(res.success){
		            		var ptdata = JSON.stringify(res.row);
							ssset('idcard',this.idcard);
							lcset('idcard',this.idcard);
							lcset('ptid',res.ptid);
							lcset('patientdata',ptdata);
							Swal.fire({
			                		title: 'ลงทะเบียนเสร็จสิ้น',
			                		text: 'กรุณารอสักครู่...',
				                  	type: 'success',
				                  	timer: 2000,
				                  	showConfirmButton: false,
				                  	allowOutsideClick: false,
				                }).then(() => {
				                		window.location = "<?php echo site_url('patient/patientpage'); ?>";
			                	});
		            	}else{
		            		Swal.fire({
							  type: 'error',
							  title: 'ไม่พบข้อมูล!',
							  text: 'ระบบนัดหมายออนไลน์ของโรงพยาบาลธรรมศาสตร์เฉลิมพระเกียรติ สามารถลงทะเบียนเฉพาะผู้ป่วยเก่าเท่านั้น ',
							  confirmButtonText: 'ปิด'
							});
		            	}
		            });
				}
				
			},
			usignin(){
				$('#u-sign').modal('hide');
				Swal.fire({
	                title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",
	                allowOutsideClick: false,
	            });
	            Swal.showLoading();
	            axios.get("<?php echo site_url('login/usignin'); ?>",{
	            	params : {
	            		uid: this.adminusername
	            		,pwd: this.adminpassword
	            	}
	            }).then(res => {
	            	console.log(res);
	            	Swal.close();
	            	res = res.data;

	            	if(res.success){

	            		// res.useridentify will return as boolean type
	            		if(res.useridentify.identify){
	            			let admindetail = JSON.stringify(res.row);
		            		ssset('adminusername',this.adminusername);
		            		lcset('adminusername',this.adminusername);
		            		lcset('admindata',admindetail);
		            		Swal.fire({
							  type: 'success',
							  title: 'เข้าสู่ระบบเสร็จสิ้น',
							  text: 'กรุณารอสักครู่.....',
							  confirmButtonText: '',
							  timer: 2000,
							  showConfirmButton: false,
			                  allowOutsideClick: false,
							}).then(() => {
								window.location = "<?php echo site_url('admin'); ?>";
							});
	            		}else{
            				this.newusercontrol(res.row ,res.useridentify.failurecode);
            				return false;
	            		}
	            	}else{
	            		Swal.fire({
						  type: 'error',
						  title: 'ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง!',
						  confirmButtonText: 'ปิด'
						}).then(() => {
							$('#u-sign').modal();
						});
	            	}
	            });
			},
			async newusercontrol(data ,failurecode){
				let isregister = false;

				switch(failurecode){
					case 'new_user_register' : 

							await Swal.fire({
		          				title: 'ไม่พบข้อมูลการลงทะเบียนเข้าใช้งาน'
								,text: "ต้องการลงทะเบียนขอเข้าใช้งานหรือไม่"
								,type: 'question'
								,showCancelButton: true
								,confirmButtonColor: '#33cc33'
								,confirmButtonText: 'ขอเข้าใช้งาน'
								,cancelButtonColor: '#bfbfbf'
								,cancelButtonText: 'ไม่'
							}).then( res => {
								if (res.value) {
									 isregister = true;
		          				}
			        		});

			        		this.staffcode = data.STAFF_CODE;
			        		this.staffname = data.STAFF_NAME;

			        		if(isregister){
			        			$('#user-register').modal();
			        		}

						break;

					case 'new_user_exist' : 
							Swal.fire({
								type: 'warning'
								,title: 'อยู่ในระหว่างดำเนินการอนุมัติ'
								,text: "ตอนนี้ อยู่ในระหว่างตรวจสอบ และอนุมัติโดยผู้ดูแลระบบ เมื่อผู้ดูแลระบบอนุมัติแล้ว จะแจ้งกลับไปให้ทราบในภายหลัง"
								,confirmButtonText: 'ปิด'
							});
						break;

					case 'new_user_reject' : 
							Swal.fire({
								type: 'error'
								,title: 'ไม่อนุมัติให้เข้าใช้งาน'
								,html: "ผู้ดูแลระบบ ไม่อนุมัติให้เข้าใช้งาน สามารถติดต่อสอบถามได้ที่ <br/>- ศูนย์บริการสุขภาพบุคลากรและนัดหมายผู้รับบริการ <br/>หมายเลขติดต่อภายใน : 9860 , 8488 <br/>- งานสารสนเทศ หมวดดูแลและพัฒนาซอฟต์แวร์ <br/>หมายเลขติดต่อภายใน : 8495"
								,text: ""
								,confirmButtonText: 'ปิด'
							});
						break;


					default : 
						break;
				}

				
			},
			newuserregister(){
				if(!this.tel)
				{
					this.telvalid = false;
					return false;
				}

				Swal.fire({
	                title: "กำลังบันทึกข้อมูลลงทะเบียนขอเข้าใช้งาน...",
	                allowOutsideClick: false,
	            });
	            Swal.showLoading();
	            let params = new URLSearchParams({
					'username' : this.adminusername,
					'password' : this.adminpassword,
					'staffcode' : this.staffcode,
					'staffname' : this.staffname,
					'tel' : this.tel,
				});

	            axios.post("<?php echo site_url('admin/newuserregister'); ?>",params)
	            	.then(res => {
	            		Swal.close();
	            		res = res.data;

	            		if(res.success){
	            			$('#user-register').modal('hide');
	            			Swal.fire({
									type: 'success',
									title: 'บันทึกข้อมูลเรียบร้อยแล้ว!',
									confirmButtonText: 'ปิด'
								});
	            		}else{
	            			if(res.errcode == 'new_staff_exist'){
	            				Swal.fire({
									type: 'error',
									title: 'ข้อมูลขอลงทะเบียนนี้ อยู่ระหว่างการอนุมัติ!',
									text: 'ข้อมูลนี้ มีลงทะเบียนขอเข้าใช้งานแล้ว เมื่อผู้ดูแลระบบอนุมัติแล้ว จะแจ้งกลับไปให้ทราบ',
									confirmButtonText: 'ปิด'
								});
	            			}
	            		}

	            	});

			},

		},
		mounted() {
			var _this = this;
			this.idcard = (lcget('idcard') ? lcget('idcard') : '');
			$('#signin').removeClass('d-none');
		},
		computed: {

		},
		filters: {

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