{{-- <div class="col-md-3"> --}}
  <div class="form-group">
    <label for="pickupPoint"> Pickup </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select class="form-control" id="pickupPoint">
      <option disabled value="">Please select one</option>
      <option v-for="pickup in pickupList">
        @{{ pickup.name }}
      </option>                           
    </select>
  </div>

  <div class="form-group">
    <label for="droppingPoint"> Dropping </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select class="form-control" id="droppingPoint">
      <option disabled value="">Please select one</option>
      <option v-for="dropping in droppingList">
        @{{ dropping.name }}
      </option>                           
    </select>
  </div>
{{-- </div>   --}}