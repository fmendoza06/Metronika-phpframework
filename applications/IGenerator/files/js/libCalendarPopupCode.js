// JavaScript Document
// months as they appear in the calendar's title
var ARR_MONTHS = [];
// week day titles as they appear on the calendar
var ARR_WEEKDAYS = [];
// label butons
var ARR_ALT = [];
//title page
var TITLE_PAGE = "";
// day week starts from (normally 0-Su or 1-Mo)
var NUM_WEEKSTART;
// path to the directory where calendar images are stored. trailing slash req.
var STR_ICONPATH = "";


function GeneratorCalendarCode(date_current,obj_calendar){

  	//set current date
  	this.dt_current = date_current;

  	//set object calendar	
  	this.obj_caller = obj_calendar;

	if (this.obj_caller && this.obj_caller.year_scroll) {
		// get same date in the previous year
		this.dt_prev_year = new Date(this.dt_current);
		this.dt_prev_year.setFullYear(this.dt_prev_year.getFullYear() - 1);
		if (this.dt_prev_year.getDate() != this.dt_current.getDate())
			this.dt_prev_year.setDate(0);
		
		// get same date in the next year
	 	this.dt_next_year = new Date(this.dt_current);
		this.dt_next_year.setFullYear(this.dt_next_year.getFullYear() + 1);
		if (this.dt_next_year.getDate() != this.dt_current.getDate())
			this.dt_next_year.setDate(0);
	}
	
	// get same date in the previous month
	this.dt_prev_month = new Date(this.dt_current);
	this.dt_prev_month.setMonth(this.dt_prev_month.getMonth() - 1);
	if (this.dt_prev_month.getDate() != this.dt_current.getDate())
		this.dt_prev_month.setDate(0);
	
	// get same date in the next month
	this.dt_next_month = new Date(this.dt_current);
	this.dt_next_month.setMonth(this.dt_next_month.getMonth() + 1);
	if (this.dt_next_month.getDate() != this.dt_current.getDate())
		this.dt_next_month.setDate(0);

  	// assigning methods
	this.setLanguage       = language
	this.setFirstDay       = firstday
	this.setIconPath       = iconPath 
  	this.getHeaderPage     = headerPage;
  	this.getHeaderCalendar = headerCalendar;
  	this.getBrokePage      = brokePage;
  	this.getBodyCalendar   = bodyCalendar;
  	this.getFooterPage	   = footerPage;	

}

// day week starts from (normally 0-Su or 1-Mo)
function iconPath(str){
  STR_ICONPATH = str;
}

// day week starts from (normally 0-Su or 1-Mo)
function firstday(fday){
	if(fday != "Su"){
 		NUM_WEEKSTART = 1;
	}else{
		NUM_WEEKSTART = 0;
	}

	// get first day to display in the grid for current month
	this.dt_firstday = new Date(this.dt_current);
	this.dt_firstday.setDate(1);
	this.dt_firstday.setDate(1 - (7 + this.dt_firstday.getDay() - NUM_WEEKSTART) % 7);
}

//set language calendar
function language(lang){
	// months as they appear in the calendar's title
	// week day titles as they appear on the calendar
	if(lang != "es"){
	    TITLE_PAGE = "Calendar";
 		ARR_MONTHS = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
 		ARR_WEEKDAYS = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
		ARR_ALT = ["previous year", "previous month", "next month", "next year"];
	}else{
	    TITLE_PAGE = "Calendario";	
		ARR_MONTHS = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	 	ARR_WEEKDAYS = ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"];
		ARR_ALT = ["año anterior", "mes anterior", "mes siguiente", "año siguiente"];
	}
}

function headerPage(id){

	var str_code = "";
	str_code += "<html>";
	str_code += "<head>";
	str_code += "<title>" + TITLE_PAGE + "</title>";

	str_code += "<style type='text/css'>";
		str_code += "td {font-family: Tahoma, Verdana, sans-serif; font-size: 12px;}";
	str_code += "</style>"; 
	
	str_code += "<script language='JavaScript'>";
	str_code += "obj_caller = (window.opener ? window.opener.calendars[" + id + "] : null);";

	str_code += "function set_datetime(n_datetime, b_close) {";
		str_code += "if (!obj_caller) return;";
		str_code += "var dt_datetime = obj_caller.prs_time(";
		str_code += "(document.cal ? document.cal.time.value : ''),";
		str_code += "new Date(n_datetime)";
		str_code += ");";
		str_code += "if (!dt_datetime) return;";
		str_code += "if (b_close) {";
		str_code += "window.close();";
		str_code += "obj_caller.target.value = (document.cal";
		str_code += "? obj_caller.gen_tsmp(dt_datetime)";
		str_code += ": obj_caller.gen_date(dt_datetime)";
		str_code += ");";
		str_code += "}";
		str_code += "else obj_caller.popup(dt_datetime.valueOf(),1);";
	str_code += "}";

	str_code += "</script>";
	
	str_code += "</head>";
	str_code += "<body bgcolor='#FFFFFF' marginheight='5' marginwidth='5' topmargin='5' leftmargin='5' rightmargin='5'>";
	str_code += "<table cellspacing='0' border='0' width='100%'>";
	str_code += "<tr>";
	str_code += "<td bgcolor='#4682B4'>";
	str_code += "<table cellspacing='1' cellpadding='3' border='0' width='100%'>";
	str_code += "<tr>";
	str_code += "<td colspan='7'>";
	str_code += "<table cellspacing='0' cellpadding='0' border='0' width='100%'>";
	str_code += "<tr>";

	return str_code;
}

function headerCalendar(){
	return (
	'<td>'+(this.obj_caller && this.obj_caller.year_scroll?'<a href="javascript:set_datetime('+this.dt_prev_year.valueOf()+')"><img src="'+STR_ICONPATH+'prev_year.gif" width="16" height="16" border="0" alt="'+ARR_ALT[0]+'"></a>&nbsp;':'')+'<a href="javascript:set_datetime('+this.dt_prev_month.valueOf()+')"><img src="'+STR_ICONPATH+'prev.gif" width="16" height="16" border="0" alt="'+ARR_ALT[1]+'"></a></td>'+
	'<td align="center" width="100%"><font color="#ffffff">'+ARR_MONTHS[this.dt_current.getMonth()]+' '+this.dt_current.getFullYear() + '</font></td>'+
	'<td><a href="javascript:set_datetime('+this.dt_next_month.valueOf()+')"><img src="'+STR_ICONPATH+'next.gif" width="16" height="16" border="0" alt="'+ARR_ALT[2]+'"></a>'+(this.obj_caller && this.obj_caller.year_scroll?'&nbsp;<a href="javascript:set_datetime('+this.dt_next_year.valueOf()+')"><img src="'+STR_ICONPATH+'next_year.gif" width="16" height="16" border="0" alt="'+ARR_ALT[3]+'"></a>':'')+'</td>'
	);
}

function brokePage(){
	var str_code = "";
	str_code += "</tr>";
	str_code += "</table>";
	str_code += "</td>";
	str_code += "</tr>";
	str_code += "<tr>";
	return str_code;
}

function bodyCalendar(){
	var str_code = "";
	
	// print weekdays titles
	for (var n=0; n<7; n++)
		str_code += '<td bgcolor="#87cefa" align="center"><font color="#ffffff">'+ARR_WEEKDAYS[(NUM_WEEKSTART+n)%7]+'</font></td>';
	str_code += '</tr>';
	
	// print calendar table
	var dt_current_day = new Date(this.dt_firstday);
	while (dt_current_day.getMonth() == this.dt_current.getMonth() ||
		dt_current_day.getMonth() == this.dt_firstday.getMonth()) {
		// print row heder
		str_code += '<tr>';
		for (var n_current_wday=0; n_current_wday<7; n_current_wday++) {
			if (dt_current_day.getDate() == this.dt_current.getDate() &&
				dt_current_day.getMonth() == this.dt_current.getMonth())
				// print current date
				str_code += '<td bgcolor="#ffb6c1" align="center" width="14%">';
			else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
				// weekend days
				str_code += '<td bgcolor="#dbeaf5" align="center" width="14%">';
			else
				// print working days of current month
				str_code += '<td bgcolor="#ffffff" align="center" width="14%">';
	
			str_code += '<a href="javascript:set_datetime('+dt_current_day.valueOf() +', true);">';
	
			if (dt_current_day.getMonth() == this.dt_current.getMonth())
				// print days of current month
				str_code += '<font color="#000000">';
			else 
				// print days of other months
				str_code += '<font color="#606060">';
				
			str_code += dt_current_day.getDate()+'</font></a></td>';
			dt_current_day.setDate(dt_current_day.getDate()+1);
		}
		// print row footer
		str_code += '</tr>';
	}
	if (this.obj_caller && this.obj_caller.time_comp)
		str_code += '<form onsubmit="javascript:set_datetime('+this.dt_current.valueOf()+', true)" name="cal"><tr><td colspan="7" bgcolor="#87CEFA"><font color="White" face="tahoma, verdana" size="2">Time: <input type="text" name="time" value="'+this.obj_caller.gen_time(this.dt_current)+'" size="8" maxlength="8"></font></td></tr></form>';

	return str_code;
}

function footerPage(){
	var str_code = "";
    str_code += "</tr>";		
	str_code += "</table>";
	str_code += "</td>";		
	str_code += "</tr>";		
	str_code += "</table>";
	str_code += "</body>";
	str_code += "</html>";
	return str_code;	
}


