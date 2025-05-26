
$('input:radio[name="flight-trip"]').change(function() {
    if ($(this).val() == 'roundtrip') {
        $('#flightReturn').prop("disabled",false);
        $('#flightReturn').prop("required",true);

    } else {
        $('#flightReturn').prop("disabled",true);
        $('#flightReturn').prop("required",false);
    }
});
$('.gButton').click(function(){
    $(this).css('pointer-events','none');
    $(this).css('opacity','0.5');
    $(this).find('span.gButtonloader').append( '<i class="fa fa-spinner fa-spin"></i>' );
});

function updateHotelGuestsInfo()
{
  var ids = ['adult', 'children'];
  var totalCount = ids.reduce(function (prev, id) {
    var roomsCount = [1,2,3,4,5,6];
    return  roomsCount.reduce(function (prev , room) {
      var guestcount = parseInt($('#' + id + '-travellers-'+ room).val());
      if(isNaN(guestcount))
      {
        guestcount = 0;	
      }
      return guestcount + prev} , 0) + prev
  }, 0)+ ' ' +'People';
  var idsRoom = ['hotels-rooms'];
  var totalCountRoom = idsRoom.reduce(function (prev, id) {
        return parseInt($('#hotels-rooms').val()) + prev}, 0)+ ' ' +'Room';
    
    $('#hotelsTravellersClass').val(totalCountRoom + ' / ' + totalCount);
}
function updateFlightPassengersInfo()
{
    var ids = ['adult', 'children','infant'];
    var totalCount = ids.reduce(function (prev, id) {
        return parseInt($('#' + id + '-flight-travellers').val()) + prev}, 0);
    var fc = $('input[name="flight-class"]:checked  + label').text();
    $('#flightTravellersClass').val(totalCount + ' - ' + fc);

}