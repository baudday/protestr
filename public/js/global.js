// Format datetimes
$('.time').html(function(index, value) {
  var format = getFormat(value);
  return moment(value).format(format);
});
