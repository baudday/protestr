function getTimezone () {
  var ts = new Date().toTimeString();
  var patt = /\((\w+)\)/g;
  return patt.exec(ts)[1];
}
