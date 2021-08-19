
var moment = require("moment");

exports.getCurrentDateTime = () => {
    
    const format = "YYYY-MM-DD HH:mm:ss"
    let date = new Date();

    return moment(date).format(format);
};

exports.getTimeDifference = (startDateTime, endDateTime) => {

    var momentStartDateTime = moment(startDateTime, 'YYYY-MM-DD HH:mm:ss');
    var momentendDateTime = moment(endDateTime, 'YYYY-MM-DD HH:mm:ss');

    var duration = moment.duration(momentendDateTime.diff(momentStartDateTime));

    var d = duration.asDays();
    var h = duration.asHours();
    var m = duration.asMinutes();
    var s = duration.asSeconds();

    var hours = parseInt((s / 3600)) ;
    var minutes = parseInt( ( s % 3600 ) / 60 ) ;
    var seconds = ( s % 60 );

    return {"hours" : hours, "minutes": minutes, "seconds": seconds};

}; 

// End Function







 

