$(document).ready(function() {
      
    $("#add-room").click(function() {
      var roomsCount = parseInt($("#hotels-rooms").val());
      console.log(roomsCount);
      if(roomsCount < 6)
      {
        var roomsCount = roomsCount + 1;
        var divtag = 
        `<div>
          Room `+roomsCount+`
          <div class="row align-items-center">
           
            <div class="col-sm-7">
              <p class="mb-sm-0">Adults <small class="text-muted">(12+ yrs)</small></p>
            </div>
            <div class="col-sm-5">
              <div class="qty input-group">
                <div class="input-group-prepend">
                  <button type="button" class="btn bg-light-4" id = "adult-travellers-minus-`+roomsCount+`">-</button>
                </div>
                <input type="text" data-ride="spinner" class="qty-spinner form-control" id="adult-travellers-`+roomsCount+`" value="1" name = "room`+roomsCount+`[adult]" readonly>
                <div class="input-group-append">
                  <button type="button" class="btn bg-light-4" id = "adult-travellers-plus-`+roomsCount+`">+</button>
                </div>
              </div>
            </div>
            
          </div>
        
          <div class="row align-items-center mt-2">
            <div class="col-sm-7">
              <p class="mb-sm-0">Children <small class="text-muted">(1-12 yrs)</small></p>
            </div>
            <div class="col-sm-5">
              <div class="qty input-group">
                <div class="input-group-prepend">
                  <button type="button" class="btn bg-light-4" id = "children-travellers-minus-`+roomsCount+`">-</button>
                </div>
                <input type="text" data-ride="spinner"  id="children-travellers-`+roomsCount+`" class="qty-spinner form-control" value="0" name = "room`+roomsCount+`[children]" readonly>
                <div class="input-group-append">
                  <button type="button" class="btn bg-light-4" id = "children-travellers-plus-`+roomsCount+`">+</button>
                </div>
              </div>
            </div>
            <hr class="my-2">
          </div>
          <div class="row mt-3" id="children-age-room-`+roomsCount+`"></div>
        </div>`;
        $("#rooms-container").append(divtag);
        $("#hotels-rooms").val(roomsCount);
      }
      updateHotelGuestsInfo();
      
    });

    $("#remove-room").click(function() {
      var roomsCount = parseInt($("#hotels-rooms").val());
      if(roomsCount != 1){
        $("#rooms-container").children().last().remove();
        $("#hotels-rooms").val(roomsCount - 1);
      }
      updateHotelGuestsInfo();
     
    });

   
    $(document).on('click', '#adult-travellers-minus-1,#adult-travellers-minus-2,#adult-travellers-minus-3,#adult-travellers-minus-4,#adult-travellers-minus-5,#adult-travellers-minus-6', function() {  
      var number = $(this).attr("id").split("adult-travellers-minus-")[1];
      var nAdultId = 'adult-travellers-'+number;
      var nAdult = parseInt($("#adult-travellers-"+number).val());
      if(nAdult != 1)
      {
        nAdult = nAdult - 1;
        $("#"+nAdultId).val(nAdult);
      }
      updateHotelGuestsInfo();
    });


    $(document).on('click', '#adult-travellers-plus-1,#adult-travellers-plus-2,#adult-travellers-plus-3,#adult-travellers-plus-4,#adult-travellers-plus-5,#adult-travellers-plus-6', function() {
      var number = $(this).attr("id").split("adult-travellers-plus-")[1];
      var nAdultId = 'adult-travellers-'+number;
      var nAdult = parseInt($("#adult-travellers-"+number).val());
      if(nAdult < 6)
      {
        nAdult = nAdult + 1;
        $("#"+nAdultId).val(nAdult);
      }
      updateHotelGuestsInfo();
    });

    //children

    $(document).on('click', '#children-travellers-minus-1,#children-travellers-minus-2,#children-travellers-minus-3,#children-travellers-minus-4,#children-travellers-minus-5,#children-travellers-minus-6', function() {
      var number = $(this).attr("id").split("children-travellers-minus-")[1];
      var nChildId = 'children-travellers-'+number;
      var nChild = parseInt($("#children-travellers-"+number).val());
      if(nChild > 0)
      {
        nChild = nChild - 1;
        $("#"+nChildId).val(nChild);
        $("#children-age-room-"+number).children().last().remove();
      }
      updateHotelGuestsInfo();
    });


    $(document).on('click', '#children-travellers-plus-1,#children-travellers-plus-2,#children-travellers-plus-3,#children-travellers-plus-4,#children-travellers-plus-5,#children-travellers-plus-6', function() {
      var number = $(this).attr("id").split("children-travellers-plus-")[1];
      var nChildId = 'children-travellers-'+number;
      var nChild = parseInt($("#children-travellers-"+number).val());
      if(nChild < 4)
      {
        nChild = nChild + 1;
        $("#"+nChildId).val(nChild);

        var childenAgeDivtag = 
        `<div class="form-group col-6 ">Child `+nChild+` <small class="text-muted">Age</small>
            <select id="train-class" name="room`+number+`[childrenAge][]" class="form-select mt-1 mb-2" style="min-height: 50%" required>
              <option value="">Select </option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
            </select>
        </div>`;
        $("#children-age-room-"+number).append(childenAgeDivtag);

      }
      updateHotelGuestsInfo();
    });
    

  });
 

  $(document).ready(function(){
    $("#bookingHotels").on("submit", function(){
      $("#hotelsearchbutton").prop('disabled',true);
      $("#hotelsearchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
    });//submit
  });//document ready