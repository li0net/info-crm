@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('main.service_categories')['list_page_header'] }}
@endsection

@section('main-content')
	
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Jopa</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<form class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" placeholder="Email" class="form-control">
					</div>
					<div class="form-group">
						<input type="password" placeholder="Password" class="form-control">
					</div>
					<button type="submit" class="btn btn-success">Sign in</button>
				</form>
			</div>
		</div>
	</nav>

	<div id="jopa">
	  <div class="container">
		<div class="row">
		  <div class="col-md-6 col-md-offset-3">
			<div class="lead-form">
			  <h1 class="text-center">Fill Out This Form</h1>
			  <hr />
			  <div class="row">
				<div class="col-md-6">
				  <input type="text" class="form-control" placeholder="Starting Zip" v-model="startingZip">
				  <span class="city-span">@{{startingCity}}</span>
				</div>
				<div class="col-md-6">
				  <input type="text" class="form-control" placeholder="Ending Zip" v-model="endingZip">
				  <span class="city-span">@{{endingCity}}</span>
				</div>
			  </div>
			  <div class="row">
				<div class="col-md-12">
				  <button class="btn btn-primary btn-block" id="submit-form" style="margin-top: 15px">Submit</button>
				</div>
			  </div>
			</div><!-- end of .lead-form -->
		  </div> <!-- end of .col-md-6.col-md-offset-3 -->
		</div> <!-- end of .row -->
	  </div> <!-- end of .container -->
	</div> <!-- end of #jopa -->

@endsection

<script src="https://unpkg.com/vue@2.0.3/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/vue.table/1.5.3/vue-table.min.js"></script>
<script src="https://unpkg.com/axios@0.12.0/dist/axios.min.js"></script>
<script src="https://unpkg.com/lodash@4.13.1/lodash.min.js"></script>

<script>
	var jopa = new Vue({
	  el: '#jopa',
	  data: {
		startingZip: '',
		startingCity: '',
		endingZip: '',
		endingCity: ''
	  },
	  watch: {
		startingZip: function() {
		  this.startingCity = ''
		  if (this.startingZip.length == 5) {
			this.lookupStartingZip()
		  }
		},
		endingZip: function() {
		  this.endingCity = ''
		  if (this.endingZip.length == 5) {
			this.lookupEndingZip()
		  }
		}
	  },
	  methods: {
		lookupStartingZip: _.debounce(function() {
		  alert('jopa');

		  var app = this
		  app.startingCity = "Searching..."
		  axios.get('http://ziptasticapi.com/' + app.startingZip)
				.then(function (response) {
				  app.startingCity = response.data.city + ', ' + response.data.state
				})
				.catch(function (error) {
				  app.startingCity = "Invalid Zipcode"
				})
		}, 500),
		lookupEndingZip: _.debounce(function() {
		  var app = this
		  app.endingCity = "Searching..."
		  axios.get('http://ziptasticapi.com/' + app.endingZip)
				.then(function (response) {
				  app.endingCity = response.data.city + ', ' + response.data.state
				})
				.catch(function (error) {
				  app.endingCity = "Invalid Zipcode"
				})
		}, 500)
	  }
	})
</script>