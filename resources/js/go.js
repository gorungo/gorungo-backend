let getTimeZoneOffset = function() {
    let d = new Date();
    return -d.getTimezoneOffset() / 60;
};

let mySqlDateTimeToJsUTC = function (mySqlDate) {

    // Split timestamp into [ Y, M, D, h, m, s ]
    var t = mySqlDate.split(/[- :]/);

    // Apply each element to the Date function
    var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

    return d;
};

let mySqlDateTimeToJs = function (mySqlDate) {

    // Split timestamp into [ Y, M, D, h, m, s ]
    var t = mySqlDate.split(/[- :]/);

    // Apply each element to the Date function
    var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);

    return d;
};

let currentDateTimeMySql = function () {
    return new Date().toISOString().slice(0, 19).replace('T', ' ');
};

let dateFromMySqlDateTime = function (datetime){
    return datetime.slice(0, 10);
};

let timeFromMySqlDateTime = function (datetime){
    return datetime.slice(11, 18);
};

let dateTimeMySql = function (date) {
    if(!date) return '';
    return date.toISOString().slice(0, 19).replace('T', ' ');
};

let localizeMySqlDateTime = function (mySqlDate) {
    let locale = 'ru-RU';
    let date = mySqlDateTimeToJsUTC(mySqlDate);
    return date.toLocaleDateString(locale) + ' ' + date.toLocaleTimeString(locale);
};

let localizeMySqlTime = function (mySqlDate) {
    let locale = 'ru-RU';
    let date = mySqlDateTimeToJsUTC(mySqlDate);
    return date.toLocaleTimeString(locale).slice(0, 5);
};

let localizeMySqlDate = function (mySqlDate) {
    let locale = 'ru-RU';
    let date = mySqlDateTimeToJsUTC(mySqlDate);
    return date.toLocaleDateString(locale);
};

let getLocation = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
};

let setLocation = function(location) {
    window.app.$store.dispatch('setUserLocation', location);
};

module.exports.getTimeZoneOffset = getTimeZoneOffset;
module.exports.mySqlDateTimeToJsUTC = mySqlDateTimeToJsUTC;
module.exports.mySqlDateTimeToJs = mySqlDateTimeToJs;
module.exports.currentDateTimeMySql = currentDateTimeMySql;
module.exports.dateTimeMySql = dateTimeMySql;
module.exports.localizeMySqlDateTime = localizeMySqlDateTime;
module.exports.localizeMySqlTime = localizeMySqlTime;
module.exports.localizeMySqlDate = localizeMySqlDate;
module.exports.dateFromMySqlDateTime = dateFromMySqlDateTime;
module.exports.timeFromMySqlDateTime = timeFromMySqlDateTime;
module.exports.getLocation = getLocation;
module.exports.setLocation = setLocation;
