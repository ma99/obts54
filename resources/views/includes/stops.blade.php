{{-- <div class="col-md-3"> --}}
  <div class="form-group">
    <label for="pickupPoint"> Pickup </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select v-model="selectedCityFrom" class="form-control" id="pickupPoint">
      <option disabled value="">Please select one</option>
      <option v-for="stop in stopList">
        @{{ stop.name }}
      </option>                           
    </select>
  </div>
{{-- </div>   --}}