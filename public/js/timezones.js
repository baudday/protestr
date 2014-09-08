function getTimezone () {
  var ts = new Date().toTimeString();
  var patt = /\((\w+)\)/g;
  return patt.exec(ts)[1];
}

function getTimeObject (date, time) {
  var tz = getTimezone();
  var dateTimeString = date;
  var format = 'MMMM Do YYYY';
  if (time) {
    dateTimeString += ' ' + time + ' UTC';
    format += ' [at] h:mm A [' + tz + ']';
  }
  return {
    string: dateTimeString,
    format: format
  }
}
