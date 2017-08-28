{{-- <div class="col-md-3"> --}}
  <div class="form-group">
    <label for="pickupPoint"> Pickup </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select v-model="selectedPickupPoint" class="form-control" id="pickupPoint">
      <!-- <option disabled value="">Please select one</option> -->
      <option v-if="!error.pickupPoint" disabled value="">Please select one</option>
      <option v-if="error.pickupPoint" disabled value="">@{{ error.pickupPoint }}</option>    
      <option v-for="pickup in pickupList">
        @{{ pickup.name }}
      </option>                           
    </select>
  </div>

  <div class="form-group">
    <label for="droppingPoint"> Dropping </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select v-model="selectedDroppingPoint" class="form-control" id="droppingPoint">
      <!-- <option disabled value="">Please select one</option> -->
      <option v-if="!error.droppingPoint" disabled value="">Please select one</option>
      <option v-if="error.droppingPoint" disabled value="">@{{ error.droppingPoint }}</option>
      <option v-for="dropping in droppingList">
        @{{ dropping.name }}
      </option>                           
    </select>
  </div>
{{-- </div>   --}}