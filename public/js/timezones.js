function getTimezone () {
  var ts = new Date().toTimeString();
  var patt = /\((.*)\)/g;
  return patt.exec(ts)[1].match(/\b(\w)/g).join('');
}

function getFormat (string) {
  var regex = /((?:\d+)\:(?:\d+)\:(?:\d+))/
  var format = 'MMM. Do YYYY';
  if (regex.exec(string)) format +=  ' [at] h:mm A';
  return format;
}
