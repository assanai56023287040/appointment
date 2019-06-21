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
  			min-height: 40%;
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

	<div class="row full-height">
		<div class="col-3 text-left">
			<button class="btn btn-primary stay-left-bottom p-4" type="button" @click="showEmSign()" data-toggle="modal" data-target="#em-sign" style="border-radius: 40px;">
				<i class="fa fa-lock" style="color: white;font-size: 2rem;"></i>
			</button>
		</div>
		<div class="col-6">
			<div style="min-height: 30%;"></div>
			<div class="rounded-lg badge-login">
				<!-- <div class="form-group">
					 <label for="idc">ID Card</label>
					<input type="text" class="form-control" name="idcard" v-model="idcard" id="idcard" />
				</div> -->
			</div>
			<div style="min-height: 30%;"></div>
		</div>
		<div class="col-3"></div>
	</div>

	<!-- modal zone -->
	<div id="em-sign" class="modal fade">
		<div class="modal-dialog">
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
	
</div> <!-- end of div container -->

<?php $this->load->view('js/myjs'); ?>
<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
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
			this.idcard = 'abcd';
			// $('#idc').val('aaaaa');
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