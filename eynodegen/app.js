var createError = require('http-errors');
var express = require('express');
var app = express();

var helmet = require('helmet');
var cors = require('cors');

app.use(helmet({contentSecurityPolicy: false}));
app.use(cors());

var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');

var indexRouter = require('./routes/index');
var getStatusRouter = require('./routes/getStatus');
var analysisExecuterRouter = require('./routes/analysisExecuter');
var createNewAnalysisRouter = require('./routes/createNewAnalysis');
var importDB3Router = require('./routes/importDB3');
var getSapStatusRouter = require('./routes/getSapStatus');
var getServerRunningStatusRouter = require('./routes/getServerRunningStatus');

var updateSODLibraryRouter = require('./routes/updateSODLibrary');


// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', indexRouter);
app.use('/getStatus',getStatusRouter);
app.use('/runNodeAnalysis',analysisExecuterRouter);
app.use('/createNewAnalysis',createNewAnalysisRouter);
app.use('/createNewAnalysis/getStatus',createNewAnalysisRouter);

app.use('/importDB3',importDB3Router);
app.use('/getSapStatus',getSapStatusRouter);
app.use('/getServerRunningStatus',getServerRunningStatusRouter);
app.use('/updateSODLibrary',updateSODLibraryRouter);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;
