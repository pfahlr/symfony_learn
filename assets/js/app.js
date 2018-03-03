require('bootstrap-sass')
require('../css/app.scss');
require('../images/black-hole.jpg');
require('../images/neptune.png');

var $ = require('jquery');

$(document).ready(function() {
    $('body').prepend('<h1>hello</h1>');
});
