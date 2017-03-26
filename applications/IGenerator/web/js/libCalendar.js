
// if two digit year input dates after this year considered 20 century.
var NUM_CENTYEAR = 30;
// is time input control required by default
var BUL_TIMECOMPONENT = false;
// are year scrolling buttons required by default
var BUL_YEARSCROLL = true;
//is format date required by default
var BUL_FORMATDATE = "DD-MM-YYYY";
// language of calendar
var BUL_LANGUAGE = "en";
//
var BUL_FIRSTDATE = "Mo";

//array months
var MONTHS = [];

var calendars = [];
var RE_NUM = /^\-?\d+$/;

function calendar(obj_target) {

	// assigning methods
	this.gen_date    = cal_gen_date1;
	this.gen_time    = cal_gen_time1;
	this.gen_tsmp    = cal_gen_tsmp1;
	this.prs_date    = cal_prs_date1;
	this.prs_time    = cal_prs_time1;
	this.prs_tsmp    = cal_prs_tsmp1;
	this.popup       = cal_popup1;
    this.change_date = cal_change_date;
	this.setlanguage = cal_language;

	// validate input parameters
	if (!obj_target)
		return cal_error("Error calling the calendar: no target control specified");
	if (obj_target.value == null)
		return cal_error("Error calling the calendar: parameter specified is not valid target control");
	this.target = obj_target;
	this.time_comp = BUL_TIMECOMPONENT;
	this.year_scroll = BUL_YEARSCROLL;
	this.format_date = BUL_FORMATDATE;
	this.language = BUL_LANGUAGE;
	this.first_day = BUL_FIRSTDATE;

	// register in global collections
	this.id = calendars.length;
	calendars[this.id] = this;
}

//set language calendar (array months full names)
function cal_language(lang){
	if(lang != "es"){
		MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	}else{
    	MONTHS = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	}
}

// call windows popup
function cal_popup1 (str_datetime,swtch_change_date) {

	this.setlanguage(this.language);

	if(!swtch_change_date)
		str_datetime = this.change_date(str_datetime ? str_datetime : this.target.value,this.format_date,BUL_FORMATDATE);

	this.dt_current = this.prs_tsmp(str_datetime ? str_datetime : this.target.value);
	
	if (!this.dt_current) return;

	var obj_calwindow = window.open(
		'',
		'Calendar', 
		'width=200,height='+(this.time_comp ? 215 : 190)+',status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes'
	);

	var calendar_popup = new GeneratorCalendarCode(this.dt_current,calendars[this.id]);
	calendar_popup.setLanguage(this.language);
	calendar_popup.setFirstDay(this.first_day);
	calendar_popup.setIconPath(this.icon_path);
	
	//building code page
  	var str_code_page = "";
  	str_code_page += calendar_popup.getHeaderPage(this.id);;
	str_code_page += calendar_popup.getHeaderCalendar();
	str_code_page += calendar_popup.getBrokePage();
	str_code_page += calendar_popup.getBodyCalendar();
	str_code_page += calendar_popup.getFooterPage();	

	//assig code to window popup
	obj_calwindow.document.open();
	obj_calwindow.document.writeln(str_code_page);
	obj_calwindow.document.close();
	obj_calwindow.opener = window;
	obj_calwindow.focus();

}

//change the format date
function cal_change_date(str_datetime,format_input,format_output){

	if (!str_datetime)
	    return str_datetime;

	if (format_input == format_output)
	    return str_datetime;

	if(this.time_comp){
	   arr_aux = str_datetime.split(' ');
	   str_datetime = arr_aux[0]
	}

	switch (format_input) {
		case "DD-MM-YYYY" :
				var arr_date = str_datetime.split('-');
				var day   = arr_date[0];
				var month = arr_date[1];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[2];
				break;
		case "DD-YYYY-MM" :
				var arr_date = str_datetime.split('-');
				var day   = arr_date[0];
				var month = arr_date[2];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[1];
				break;
		case "MM-DD-YYYY" :
				var arr_date = str_datetime.split('-');
				var day   = arr_date[1];
				var month = arr_date[0];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[2];
				break;
		case "MM-YYYY-DD" :
				var arr_date = str_datetime.split('-');
				var day   = arr_date[2];
				var month = arr_date[0];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[1];
				break;
		case "YYYY-MM-DD" :
				var arr_date = str_datetime.split('-');
				var day   = arr_date[2];
				var month = arr_date[1];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[0];
				break;
		case "YYYY-DD-MM" :
				var arr_date = str_datetime.split('-');
				var day   = arr_date[1];
				var month = arr_date[2];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[0];
				break;
		case "DD/MM/YYYY" :
				var arr_date = str_datetime.split('/');
				var day   = arr_date[0];
				var month = arr_date[1];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);				
				var year  = arr_date[2];
				break;
		case "DD/YYYY/MM" :
				var arr_date = str_datetime.split('/');
				var day   = arr_date[0];
				var month = arr_date[2];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[1];
				break;
		case "MM/DD/YYYY" :
				var arr_date = str_datetime.split('/');
				var day   = arr_date[1];
				var month = arr_date[0];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[2];
				break;
		case "MM/YYYY/DD" :
				var arr_date = str_datetime.split('/');
				var day   = arr_date[2];
				var month = arr_date[0];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[1];
				break;
		case "YYYY/MM/DD" :
				var arr_date = str_datetime.split('/');
				var day   = arr_date[2];
				var month = arr_date[1];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[0];
				break;
		case "YYYY/DD/MM" :
				var arr_date = str_datetime.split('/');
				var day   = arr_date[1];
				var month = arr_date[2];
				    month = (month.charAt(0) == 0 ? month.charAt(1) : month);
				var year  = arr_date[0];
				break;
		case "DD-MON-YYYY" :			
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[0];
				var month = get_number_month1(arr_date[1]);
				var year  = arr_date[2];
				break;
		case "DD-YYYY-MON" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[0];
				var month = get_number_month1(arr_date[2]);
				var year  = arr_date[1];
				break;
		case "MON-DD-YYYY" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[1];
				var month = get_number_month1(arr_date[0]);
				var year  = arr_date[2];
				break;
		case "MON-YYYY-DD" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[2];
				var month = get_number_month1(arr_date[0]);
				var year  = arr_date[1];
				break;
		case "YYYY-MON-DD" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[2];
				var month = get_number_month1(arr_date[1]);
				var year  = arr_date[0];
				break;
		case "YYYY-DD-MON" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[1];
				var month = get_number_month1(arr_date[2]);
				var year  = arr_date[0];
				break;
		case "DD/MON/YYYY" :			
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[0];
				var month = get_number_month1(arr_date[1]);
				var year  = arr_date[2];
				break;
		case "DD/YYYY/MON" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[0];
				var month = get_number_month1(arr_date[2]);
				var year  = arr_date[1];
				break;
		case "MON/DD/YYYY" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[1];
				var month = get_number_month1(arr_date[0]);
				var year  = arr_date[2];
				break;
		case "MON/YYYY/DD" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[2];
				var month = get_number_month1(arr_date[0]);
				var year  = arr_date[1];
				break;
		case "YYYY/MON/DD" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[2];
				var month = get_number_month1(arr_date[1]);
				var year  = arr_date[0];
				break;
		case "YYYY/DD/MON" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[1];
				var month = get_number_month1(arr_date[2]);
				var year  = arr_date[0];
				break;
    	case "DD-MONTH-YYYY" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[0];
				var month = get_number_month2(arr_date[1]);
				var year  = arr_date[2];
				break;
		case "DD-YYYY-MONTH" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[0];
				var month = get_number_month2(arr_date[2]);
				var year  = arr_date[1];
				break;
		case "MONTH-DD-YYYY" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[1];
				var month = get_number_month2(arr_date[0]);
				var year  = arr_date[2];
				break;
		case "MONTH-YYYY-DD" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[2];
				var month = get_number_month2(arr_date[0]);
				var year  = arr_date[1];
				break;
		case "YYYY-MONTH-DD" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[2];
				var month = get_number_month2(arr_date[1]);
				var year  = arr_date[0];
				break;
		case "YYYY-DD-MONTH" :
  				var arr_date = str_datetime.split('-');
				var day   = arr_date[1];
				var month = get_number_month2(arr_date[2]);
				var year  = arr_date[0];
				break;
    	case "DD/MONTH/YYYY" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[0];
				var month = get_number_month2(arr_date[1]);
				var year  = arr_date[2];
				break;
		case "DD/YYYY/MONTH" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[0];
				var month = get_number_month2(arr_date[2]);
				var year  = arr_date[1];
				break;
		case "MONTH/DD/YYYY" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[1];
				var month = get_number_month2(arr_date[0]);
				var year  = arr_date[2];
				break;
		case "MONTH/YYYY/DD" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[2];
				var month = get_number_month2(arr_date[0]);
				var year  = arr_date[1];
				break;
		case "YYYY/MONTH/DD" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[2];
				var month = get_number_month2(arr_date[1]);
				var year  = arr_date[0];
				break;
		case "YYYY/DD/MONTH" :
  				var arr_date = str_datetime.split('/');
				var day   = arr_date[1];
				var month = get_number_month2(arr_date[2]);
				var year  = arr_date[0];
				break;
		default :
				alert('format don\'t exist !');
	}


	switch (format_output) {
		case "DD-MM-YYYY" :
			str_datetime = day + "-" + (parseInt(month) < 10 ? "0" + month : month) + "-" + year;
			break;
		case "DD-YYYY-MM" :
			str_datetime = day + "-" + year + "-" + (parseInt(month) < 10 ? "0" + month : month);
			break;
		case "MM-DD-YYYY" :
			str_datetime = (parseInt(month) < 10 ? "0" + month : month) + "-" + day + "-" + year;
			break;
		case "MM-YYYY-DD" :
			str_datetime = (parseInt(month) < 10 ? "0" + month : month) + "-" + year + "-" + day;
			break;
		case "YYYY-MM-DD" :
			str_datetime = year + "-" + (parseInt(month) < 10 ? "0" + month : month) + "-" + day;
			break;
		case "YYYY-DD-MM" :
			str_datetime = year + "-" + day + "-" + (parseInt(month) < 10 ? "0" + month : month);
			break;
		case "DD/MM/YYYY" :
			str_datetime = day + "/" + (parseInt(month) < 10 ? "0" + month : month) + "/" + year;
			break;
		case "DD/YYYY/MM" :
			str_datetime = day + "/" + year + "/" + (parseInt(month) < 10 ? "0" + month : month);
			break;
		case "MM/DD/YYYY" :
			str_datetime = (parseInt(month) < 10 ? "0" + month : month) + "/" + day + "/" + year;
			break;
		case "MM/YYYY/DD" :
			str_datetime = (parseInt(month) < 10 ? "0" + month : month) + "/" + year + "/" + day;
			break;
		case "YYYY/MM/DD" :
			str_datetime = year + "/" + (parseInt(month) < 10 ? "0" + month : month) + "/" + day;
			break;
		case "YYYY/DD/MM" :
			str_datetime = year + "/" + day + "/" + (parseInt(month) < 10 ? "0" + month : month);
			break;
		case "DD-MON-YYYY" :			
			str_datetime = day + "-" + get_month(parseInt(month)-1).substr(0,3) + "-" + year;
			break;
		case "DD-YYYY-MON" :
			str_datetime = day + "-" + year + "-" + get_month(parseInt(month)-1).substr(0,3);
			break;
		case "MON-DD-YYYY" :
			str_datetime = get_month(parseInt(month)-1).substr(0,3) + "-" + day + "-" + year;
			break;
		case "MON-YYYY-DD" :
			str_datetime = get_month(parseInt(month)-1).substr(0,3) + "-" + year + "-" + day;
			break;
		case "YYYY-MON-DD" :
			str_datetime = year + "-" + get_month(parseInt(month)-1).substr(0,3) + "-" + day;
			break;
		case "YYYY-DD-MON" :
			str_datetime = year + "-" + day + "-" + get_month(parseInt(month)-1).substr(0,3);
			break;
		case "DD/MON/YYYY" :			
			str_datetime = day + "/" + get_month(parseInt(month)-1).substr(0,3) + "/" + year;
			break;
		case "DD/YYYY/MON" :
			str_datetime = day + "/" + year + "/" + get_month(parseInt(month)-1).substr(0,3);
			break;
		case "MON/DD/YYYY" :
			str_datetime = get_month(parseInt(month)-1).substr(0,3) + "/" + day + "/" + year;
			break;
		case "MON/YYYY/DD" :
			str_datetime = get_month(parseInt(month)-1).substr(0,3) + "/" + year + "/" + day;
			break;
		case "YYYY/MON/DD" :
			str_datetime = year + "/" + get_month(parseInt(month)-1).substr(0,3) + "/" + day;
			break;
		case "YYYY/DD/MON" :
			str_datetime = year + "/" + day + "/" + get_month(parseInt(month)-1).substr(0,3);
			break;
    	case "DD-MONTH-YYYY" :
			str_datetime = day + "-" + get_month(parseInt(month)-1) + "-" + year;
			break;
		case "DD-YYYY-MONTH" :
			str_datetime = day + "-" + year + "-" + get_month(parseInt(month)-1);
			break;
		case "MONTH-DD-YYYY" :
			str_datetime = get_month(parseInt(month)-1) + "-" + day + "-" + year;
			break;
		case "MONTH-YYYY-DD" :
			str_datetime = get_month(parseInt(month)-1) + "-" + year + "-" + day;
			break;
		case "YYYY-MONTH-DD" :
			str_datetime = year + "-" + get_month(parseInt(month)-1) + "-" + day;
			break;
		case "YYYY-DD-MONTH" :
			str_datetime = year + "-" + day + "-" + get_month(parseInt(month)-1);
			break;
    	case "DD/MONTH/YYYY" :
			str_datetime = day + "/" + get_month(parseInt(month)-1) + "/" + year;
			break;
		case "DD/YYYY/MONTH" :
			str_datetime = day + "/" + year + "/" + get_month(parseInt(month)-1);
			break;
		case "MONTH/DD/YYYY" :
			str_datetime = get_month(parseInt(month)-1) + "/" + day + "/" + year;
			break;
		case "MONTH/YYYY/DD" :
			str_datetime = get_month(parseInt(month)-1) + "/" + year + "/" + day;
			break;
		case "YYYY/MONTH/DD" :
			str_datetime = year + "/" + get_month(parseInt(month)-1) + "/" + day;
			break;
		case "YYYY/DD/MONTH" :
			str_datetime = year + "/" + day + "/" + get_month(parseInt(month)-1);
			break;
	   	case "DD-MONTH-YYYY" :
			str_datetime = day + "-" + get_month(parseInt(month)-1) + "-" + year;
			break;
		case "DD-YYYY-MONTH" :
			str_datetime = day + "-" + year + "-" + get_month(parseInt(month)-1);
			break;
		case "MONTH-DD-YYYY" :
			str_datetime = get_month(parseInt(month)-1) + "-" + day + "-" + year;
			break;
		case "MONTH-YYYY-DD" :
			str_datetime = get_month(parseInt(month)-1) + "-" + year + "-" + day;
			break;
		case "YYYY-MONTH-DD" :
			str_datetime = year + "-" + get_month(parseInt(month)-1) + "-" + day;
			break;
		case "YYYY-DD-MONTH" :
			str_datetime = year + "-" + day + "-" + get_month(parseInt(month)-1);
			break;
 	    default :
			alert('format don\'t exist !');
	}
	
	if(this.time_comp && arr_aux[1]){
	   str_datetime += " " + arr_aux[1];
	}
	return str_datetime;
}


function get_month(monthNo) {
	return MONTHS[monthNo];
}

// send number month with middle name
function get_number_month1(monthLe){
	for(i=0;i < MONTHS.length;i++){
	    if(monthLe == MONTHS[i].substr(0,3)){
		   return i+1;
		}   
	}
}

// send number month with full name
function get_number_month2(monthLe){
	for(i=0;i < MONTHS.length;i++){
	    if(monthLe == MONTHS[i]){
		   return i+1;
		}   
	}
}

// timestamp generating function
function cal_gen_tsmp1 (dt_datetime) {
	return(this.gen_date(dt_datetime) + ' ' + this.gen_time(dt_datetime));
}

// date generating function
function cal_gen_date1 (dt_datetime) {

	str_datetime = (dt_datetime.getDate() < 10 ? '0' : '') + dt_datetime.getDate() + "-"
					+ (dt_datetime.getMonth() < 9 ? '0' : '') + (dt_datetime.getMonth() + 1) + "-"
					+ dt_datetime.getFullYear();

	str_datetime = this.change_date(str_datetime,BUL_FORMATDATE,this.format_date);

	return (str_datetime);
}

// time generating function
function cal_gen_time1 (dt_datetime) {
	return (
		(dt_datetime.getHours() < 10 ? '0' : '') + dt_datetime.getHours() + ":"
		+ (dt_datetime.getMinutes() < 10 ? '0' : '') + (dt_datetime.getMinutes()) + ":"
		+ (dt_datetime.getSeconds() < 10 ? '0' : '') + (dt_datetime.getSeconds())
	);
}

// timestamp parsing function
function cal_prs_tsmp1 (str_datetime) {
	// if no parameter specified return current timestamp
	if (!str_datetime)
		return (new Date());

	// if positive integer treat as milliseconds from epoch
	if (RE_NUM.exec(str_datetime))
		return new Date(str_datetime);
		
	// else treat as date in string format
	var arr_datetime = str_datetime.split(' ');
	return this.prs_time(arr_datetime[1], this.prs_date(arr_datetime[0]));
}

// date parsing function
function cal_prs_date1 (str_date) {

	var arr_date = str_date.split('-');

	if (arr_date.length != 3) return cal_error ("Invalid date format: '" + str_date + "'.\nFormat accepted is dd-mm-yyyy.");
	if (!arr_date[0]) return cal_error ("Invalid date format: '" + str_date + "'.\nNo day of month value can be found.");
	if (!RE_NUM.exec(arr_date[0])) return cal_error ("Invalid day of month value: '" + arr_date[0] + "'.\nAllowed values are unsigned integers.");
	if (!arr_date[1]) return cal_error ("Invalid date format: '" + str_date + "'.\nNo month value can be found.");
	if (!RE_NUM.exec(arr_date[1])) return cal_error ("Invalid month value: '" + arr_date[1] + "'.\nAllowed values are unsigned integers.");
	if (!arr_date[2]) return cal_error ("Invalid date format: '" + str_date + "'.\nNo year value can be found.");
	if (!RE_NUM.exec(arr_date[2])) return cal_error ("Invalid year value: '" + arr_date[2] + "'.\nAllowed values are unsigned integers.");

	var dt_date = new Date();
	dt_date.setDate(1);

	if (arr_date[1] < 1 || arr_date[1] > 12) return cal_error ("Invalid month value: '" + arr_date[1] + "'.\nAllowed range is 01-12.");
	dt_date.setMonth(arr_date[1]-1);
	 
	if (arr_date[2] < 100) arr_date[2] = Number(arr_date[2]) + (arr_date[2] < NUM_CENTYEAR ? 2000 : 1900);
	dt_date.setFullYear(arr_date[2]);

	var dt_numdays = new Date(arr_date[2], arr_date[1], 0);
	dt_date.setDate(arr_date[0]);
	if (dt_date.getMonth() != (arr_date[1]-1)) return cal_error ("Invalid day of month value: '" + arr_date[0] + "'.\nAllowed range is 01-"+dt_numdays.getDate()+".");

	return (dt_date)
}

// time parsing function
function cal_prs_time1 (str_time, dt_date) {

	if (!dt_date) return null;
	var arr_time = String(str_time ? str_time : '').split(':');

	if (!arr_time[0]) dt_date.setHours(0);
	else if (RE_NUM.exec(arr_time[0]))
		if (arr_time[0] < 24) dt_date.setHours(arr_time[0]);
		else return cal_error ("Invalid hours value: '" + arr_time[0] + "'.\nAllowed range is 00-23.");
	else return cal_error ("Invalid hours value: '" + arr_time[0] + "'.\nAllowed values are unsigned integers.");
	
	if (!arr_time[1]) dt_date.setMinutes(0);
	else if (RE_NUM.exec(arr_time[1]))
		if (arr_time[1] < 60) dt_date.setMinutes(arr_time[1]);
		else return cal_error ("Invalid minutes value: '" + arr_time[1] + "'.\nAllowed range is 00-59.");
	else return cal_error ("Invalid minutes value: '" + arr_time[1] + "'.\nAllowed values are unsigned integers.");

	if (!arr_time[2]) dt_date.setSeconds(0);
	else if (RE_NUM.exec(arr_time[2]))
		if (arr_time[2] < 60) dt_date.setSeconds(arr_time[2]);
		else return cal_error ("Invalid seconds value: '" + arr_time[2] + "'.\nAllowed range is 00-59.");
	else return cal_error ("Invalid seconds value: '" + arr_time[2] + "'.\nAllowed values are unsigned integers.");

	dt_date.setMilliseconds(0);

	return dt_date;
}

function cal_error (str_message) {
	alert (str_message);
	return null;
}
