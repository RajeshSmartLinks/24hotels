$(document).ready(function() {
    $(document).on('click', '#adult-flight-travellers-minus', function() {  
        var nAdultId = 'adult-flight-travellers';
        var nAdult = parseInt($("#adult-flight-travellers").val());
        if(nAdult != 1)
        {
            nAdult = nAdult - 1;
            $("#"+nAdultId).val(nAdult);
        }
        else{
            alert("you should be minimum one adult")
        }
        updateFlightPassengersInfo();
    });

    $(document).on('click', '#adult-flight-travellers-plus', function() {
      var nAdultId = 'adult-flight-travellers';
      var nAdult = parseInt($("#adult-flight-travellers").val());
      var totalCount = totalflightPassengersCount();

      if(totalCount < 9)
      {
        nAdult = nAdult + 1;
        $("#"+nAdultId).val(nAdult);
      }
      else
      {
        alert("you can add upto 9 passengers per Booking")
      }
      updateFlightPassengersInfo();
    });

    //children

    $(document).on('click', '#children-flight-travellers-minus', function() {  
        var nChildrenId = 'children-flight-travellers';
        var nChildren = parseInt($("#children-flight-travellers").val());
        if(nChildren != 0)
        {
            nChildren = nChildren - 1;
            $("#"+nChildrenId).val(nChildren);
        }
       
        updateFlightPassengersInfo();
    });


    $(document).on('click', '#children-flight-travellers-plus', function() {
      var nChildrenId = 'children-flight-travellers';
      var nChildren = parseInt($("#children-flight-travellers").val());
      var totalCount = totalflightPassengersCount();

      if(totalCount < 9)
      {
        nChildren = nChildren + 1;
        $("#"+nChildrenId).val(nChildren);
      }
      else
      {
        alert("you can add upto 9 passengers per Booking")
      }
      updateFlightPassengersInfo();
    });

    //infant

    $(document).on('click', '#infant-flight-travellers-minus', function() {  
        var nInfantId = 'infant-flight-travellers';
        var nInfant = parseInt($("#infant-flight-travellers").val());
        if(nInfant != 0)
        {
            nInfant = nInfant - 1;
            $("#"+nInfantId).val(nInfant);
        }
       
        updateFlightPassengersInfo();
    });


    $(document).on('click', '#infant-flight-travellers-plus', function() {
      var nInfantId = 'infant-flight-travellers';
      var nInfant = parseInt($("#infant-flight-travellers").val());
      var nAdult = parseInt($("#adult-flight-travellers").val());
      var totalCount = totalflightPassengersCount();

      if(totalCount < 9)
      {
        if(nAdult>nInfant)
        {
          nInfant = nInfant + 1;
          $("#"+nInfantId).val(nInfant);
        }
        else{
          alert("Please add adults for more Infants")
        }
      }
      else
      {
        alert("you can add upto 9 passengers per Booking")
      }
      updateFlightPassengersInfo();
    });


    function totalflightPassengersCount(){
      var ids = ['adult', 'children','infant'];
      var totalCount = ids.reduce(function (prev, id) {
        return parseInt($('#' + id + '-flight-travellers').val()) + prev}, 0);
      return totalCount;
    }
    

  });
 

//   $(document).ready(function(){
//     $("#bookingHotels").on("submit", function(){
//       $("#hotelsearchbutton").prop('disabled',true);
//       $("#hotelsearchbutton").find('span').append( '<i class="fa fa-spinner fa-spin"></i>' );
//     });//submit
//   });//document ready