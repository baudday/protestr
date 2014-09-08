function getTimezone () {
  var ts = new Date().toTimeString();
  var patt = /\((\w+)\)/g;
  return patt.exec(ts)[1];
}

function getFormat (string) {
  var regex = /((?:\d+)\:(?:\d+)\:(?:\d+))/
  var format = 'MMMM Do YYYY';
  if (regex.exec(string)) format +=  ' [at] h:mm A';
  return format;
}
