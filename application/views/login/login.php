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

  		.modal-center {
			display: flex;
			text-align: left;
			vertical-align: middle;
		}
  	</style>
    
</head>
<body>
<div class="container-fluid" id="app">

<section style="display: none;" id="register-doc">
	<div class="row full-height">
		<div class="col-4 text-left">
			<button class="btn btn-blue stay-left-bottom p-4" type="button" @click="showEmSign()" data-toggle="modal" data-target="#em-sign" style="border-radius: 40px;">
				<i class="fa fa-lock" style="font-size: 2rem;"></i>
			</button>
		</div>
		<div class="col-4">
			<div style="min-height: 30%;"></div>
			<div class="rounded-lg badge-login text-center">
				<img class="mt-3" src="<?php echo base_url('assets/img/tuh_header_logo.png'); ?>" width="75%" alt="Responsive image">

					<p class="mt-2 font-weight-bold">เลขบัตรประชาชน</p>
					<div class="px-5 mb-4">
						<input class="form-control px-5 text-center" type="text" name="idcard" v-model="idcard" id="idcard" placeholder="กรอกเลขบัตรประชาชน 13 หลัก" style="font-size: 1.5rem;" />
						<button class="btn mt-3 p-3 btn-purple" id="btnRegister">
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

	<!-- modal zone -->
	<div id="em-sign" class="modal fade">
		<div class="modal-dialog modal-center">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					aaaaa
				</div>

				<!-- modal body -->
				<div class="modal-body">
					bbbbb
				</div>

				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
			// registerDoc: false,
			idcard: '',
		},
		methods: {
			showEmSign() {
				$('#em-sign').modal();
				console.log('pass to fnc showEmSign');
				this.idcard = 'xxxxxxxxxx';
			}
		},
		mounted() {
			var _this = this;
			// this.idcard = 'abcd';
			// $('#idcard').val('aaaaa');
			// $('#register-doc').slideUp("slow");
			// $('#register-doc').show("slide", { direction: "left" }, 1000);
			// this.registerDoc: true;
		},
		computed: {

		},
		filter: {

		},
		watch: {

		}
	});
</script>
</body>
</html>