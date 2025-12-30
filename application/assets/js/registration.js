
$(function () {
  $('#regForm').on('submit', function(){
    $('button[type="submit"]').prop('disabled', true);
    return true;
  });
});
