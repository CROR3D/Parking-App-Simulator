<div class="form-group">
    <label for="select1">Select City</label>
        <select class="form-control" name="select_city" id="select1">
            <option>---</option>
            @foreach($city_list as $city)
                  <option class="dropdown-item" value="{{ $city_values[$city->city] }}">{{ $city->city }}</option>
            @endforeach
        </select>
</div>

<div class="form-group">
    <label for="select2">Select Parking</label>
        <select class="form-control" name="select_parking" id="select2" disabled>
            <option>---</option>
            @foreach($parking_list as $parking)
                  <option name="{{ $parking->slug }}" class="dropdown-item" value="{{ $parking_values[$parking->slug] }}">{{ $parking->name }}</option>
            @endforeach
        </select>
</div>
