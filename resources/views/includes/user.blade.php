<form method="POST" action="/seatbooking" v-on:submit.prevent="seatBookingByUser()">
	{{-- <div v-show="guestUser" class="form-group">
	<label for="name" class="control-label">Name</label>
	<div class="input-group">
	    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
	    <input id="name" type="text" class="form-control" name="name" v-model="form.name">
	</div>
	<span class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
	</div>

	<div v-show="guestUser" class="form-group">
	<label for="email" class="control-label">E-Mail</label>
	<div class="input-group">
	    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
	    <input id="email" type="email" class="form-control" name="email" v-model="form.email">
	</div>
	<span class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
	</div>

	<div v-show="guestUser" class="form-group">
	<label for="phone" class="control-label">Mobile No.</label>
	<div class="input-group">
	    <span class="input-group-addon"><i class="fa fa-mobile fa-fw"></i></span>
	    <input id="phone" type="text" class="form-control" name="phone" v-model="form.phone">
	</div>
	<span class="help is-danger" v-if="form.errors.has('phone')" v-text="form.errors.get('phone')"></span>
	</div> --}}
	<button v-show="isSeatSelected" class="btn btn-primary">Continue</button>                                      
</form>
