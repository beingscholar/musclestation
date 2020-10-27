jQuery(document).ready(function($){
	$('td#option_1 > input.D-B').on('click',function(){
		changevalue('6',"input#header_marquee_data_2");
	});
	$('td#option_2 > input.D-B').on('click',function(){
		changevalue('85',"input#header_marquee_data_6");
	});
	$('td#option_3 > input.D-B').on('click',function(){
		changevalue('50',"input#header_marquee_data_7");
	});
	$('td#option_4 > input.D-B').on('click',function(){
		changevalue('100',"input#header_marquee_data_8");
	});
	$('td#option_5 > input.D-B').on('click',function(){
		changevalue('0',"input#header_marquee_data_9");
	});
	$('td#option_6 > input.D-B').on('click',function(){
		changevalue('0',"input#header_marquee_data_10");
	});
	$('td#option_7 > input.D-B').on('click',function(){
		changevalue('100',"input#header_marquee_data_11");
	});
	$('td#option_8 > input.D-B').on('click',function(){
		changevalue('0',"input#header_marquee_data_12");
	});
	$('td#option_9 > input.D-B').on('click',function(){
		changevalue('0',"input#header_marquee_data_13");
	});
	$('td#option_1b > input.D-B').on('click',function(){
		changevalue('20',"input#header_marquee_data_14");
	});
	$('td#option_1b > input.D-B').on('click',function(){
		changevalue('50',"input#header_marquee_data_15");
	});
});

function changevalue(default_value,refen)
{
	jQuery(refen).val(default_value);
}