function getAddress() {
	
			var latlonspan = document.getElementById("latlonvalues");
	
			var geocoder = new google.maps.Geocoder();
			var address = document.getElementById('mapsearch').value;
					
			geocoder.geocode( { 'address': address}, function(results, status) {
			
			  if (status == google.maps.GeocoderStatus.OK) {
				var glatitude = results[0].geometry.location.lat();
				var glongitude = results[0].geometry.location.lng();
				
				latlonspan.innerHTML =  address+": "+glatitude+" "+glongitude+" [<a href='javascript:void(0);' title='Copy this values to the Region Code field' onclick='usethis("+glatitude+","+glongitude+")'>use this</a>]";
							
			  } else {
				latlonspan.innerHTML = 'Impossible to locate that Address';
			  }
			}); 
			}


function usethis(lat,lon) {
	var inp = document.addimap.cd;
	inp.value = lat+" "+lon;
}

function addPlaceToTable() {
	
	var code = document.addimap.cd.value.replace(/;/g,"");
	var title = document.addimap.c.value.replace(/;/g,"&#59");
	var tooltip = document.addimap.t.value.replace(/;/g,"&#59");
	var action = document.addimap.u.value.replace(/;/g,"&#59");// special char &#59 = ;
	var color = document.addimap.cl.value.replace(/;/g,"");
	
	var code = code.replace(/,/g," ");
	var title = title.replace(/,/g,"&#44");
	var tooltip = tooltip.replace(/,/g,"&#44");
	var action = action.replace(/,/g,"&#44");	// special char &#44 = ,
	var color = color.replace(/,/g,"");	
	
	var newtext = code + ',' + title + ',' + tooltip + ',' + action + ',' + color + ';\n';
	document.addimap.places.value += newtext;
	document.addimap.cd.value = "";
	document.addimap.c.value = "";
	document.addimap.t.value = "";
	document.addimap.u.value = "";
	
	dataToTable();
}

function dataToTable(){

	
	var oldText = document.getElementById("places").value;	
	var oldTextArr = oldText.split(";");
	oldTextArr.pop();
	var newText = "";
		for(i = 0; i < oldTextArr.length; i++){
		oldTextArr[i] = oldTextArr[i].replace(/\r/,"");
		oldTextArr[i] = oldTextArr[i].replace(/^\'/,""); 
		oldTextArr[i] = oldTextArr[i].replace(/^\"/,"");
		oldTextArr[i] = oldTextArr[i].replace(/"$/,""); 
		oldTextArr[i] = oldTextArr[i].replace(/'$/,"");
		
		var entry = oldTextArr[i].split(",");			
		var colori = entry[4];
		oldTextArr[i] = oldTextArr[i] + "<div class='colorsample' style='background-color:"+colori+"'></div>";	
		
		oldTextArr[i] = "<tr><td>"+oldTextArr[i]+"</td><td><input type='button' value='Edit' onclick='editPlace("+i+");' /> <input type='button' value='Delete' onclick='deletePlace("+i+");' /></td></tr>";
		}		
	
	var linesep = ",";
	
	
	for(i = 0; i < oldTextArr.length; i++){
			oldTextArr[i] = oldTextArr[i].replace(new RegExp(linesep, "gi"), "</td><td>" );
			newText = newText + oldTextArr[i]+"\n";
	}
	
	var header = "<tr><th>Region Code</th><th>Title</th><th>Tooltip Text</th><th>Action Value</th><th>Color</th><th>&nbsp;</th></tr>";
	newText = "<table class='data-content-table'>\n"+header+"\n"+newText+"</table>\n";
	
	var span = document.getElementById("htmlplacetable");
	span.innerHTML = newText; // clear existing
	drawVisualization();
}

function updatePlace(placeid){

		//Get old text
		var oldText = document.getElementById("places").value;
		//Split into lines
		var oldTextArr = oldText.split(";");
		oldTextArr.pop();
		var newText ="";
		for(i = 0; i < oldTextArr.length; i++){
			
			if(i==placeid) {
			var updatecode = document.getElementById("input-"+placeid+"-0").value.replace(/,/g," ");
			var updatetitle = document.getElementById("input-"+placeid+"-1").value.replace(/,/g,"&#44");
			var updatetooltip = document.getElementById("input-"+placeid+"-2").value.replace(/,/g,"&#44");
			var updateaction = document.getElementById("input-"+placeid+"-3").value.replace(/,/g,"&#44");
			var updatecolor = document.getElementById("input-"+placeid+"-4").value.replace(/,/g,"");
			
			var updatecode = updatecode.replace(/;/g," ");
			var updatetitle = updatetitle.replace(/;/g,"&#59");
			var updatetooltip = updatetooltip.replace(/;/g,"&#59");
			var updateaction = updateaction.replace(/;/g,"&#59");
			var updatecolor = updatecolor.replace(/;/g,"");
			
			newText = newText + "\n" + updatecode + "," + updatetitle + "," + updatetooltip + "," + updateaction + ",#" + updatecolor + ";"; 
			}
			else {
			newText = newText+oldTextArr[i]+";";
			}
		}
		document.getElementById("places").value = newText;
		dataToTable();
}

function deletePlace(placeid){

		var conf = confirm('Are you sure you want to delete this Region entry?');
		if (conf==true)
  		{	
		var oldText = document.getElementById("places").value;		
		var oldTextArr = oldText.split(";");
		oldTextArr.pop();
		oldTextArr.splice(placeid,1);
		
		var newText ="";
		for(i = 0; i < oldTextArr.length; i++){
			newText = newText+oldTextArr[i]+";";
		}
		document.getElementById("places").value = newText;
		dataToTable();
		}
}




function editPlace(placeid){

	var oldText = document.getElementById("places").value;

	var oldTextArr = oldText.split(";");
	oldTextArr.pop();
	var newText = "";
	for(i = 0; i < oldTextArr.length; i++){
		oldTextArr[i] = oldTextArr[i].replace(/\r/,"");
		oldTextArr[i] = oldTextArr[i].replace(/^\'/,""); 
		oldTextArr[i] = oldTextArr[i].replace(/^\"/,"");
		oldTextArr[i] = oldTextArr[i].replace(/"$/,""); 
		oldTextArr[i] = oldTextArr[i].replace(/'$/,"");
		if(placeid == i) {
			
			
			var editArr = oldTextArr[i].split(",");
			oldTextArr[i] = "<tr class='editing-map-entry'>";
				for(ix = 0; ix < editArr.length; ix++){
					if(ix != 4 && ix != 3) {
						var ixvalue = editArr[ix].replace(/'/g,"&#39;");	
						oldTextArr[i] = oldTextArr[i] + "<td><input type='text' id='input-"+placeid+"-"+ix+"' value='"+ixvalue+"'></td>\n";
						} 
						if(ix == 3)  {
						var ixvalue = editArr[ix].replace(/'/g,"&#39;");	
						oldTextArr[i] = oldTextArr[i] + "<td><textarea id='input-"+placeid+"-"+ix+"'>"+ixvalue+"</textarea></td>\n";
						}
						
						if(ix == 4)  {
						var colorinput = document.createElement("INPUT");
						var inputname = 'input-'+placeid+'-'+ix;
						var inputvalue = '#'+editArr[ix];
						 colorinput.type = 'text';
						 colorinput.id = String(inputname);
						 colorinput.value = String(inputvalue);
						var col = new jscolor.color(colorinput);
						oldTextArr[i] = oldTextArr[i] + "<td><span id='colori'></span></td>\n"; 	
						
						}
				}	
			
					
			oldTextArr[i] = oldTextArr[i] + "</td><td><input type='button' value='Done' onclick='updatePlace("+placeid+");' /><input type='button' value='Cancel' onclick='dataToTable();' /></td></tr>";			
		
		} else {
			
		var entry = oldTextArr[i].split(",");			
		var colori = entry[4];
		oldTextArr[i] = oldTextArr[i] + "<div class='colorsample' style='background-color:"+colori+"'></div>";	
		oldTextArr[i] = "<tr><td>"+oldTextArr[i]+"</td><td><input type='button' value='Edit' onclick='editPlace("+i+");' /> <input type='button' value='Delete' onclick='deletePlace("+i+");' /></td></tr>";
		}
		
	}
	
	var linesep = ",";
	
		for(i = 0; i < oldTextArr.length; i++){
				
				oldTextArr[i] = oldTextArr[i].replace(new RegExp(linesep, "gi"), "</td><td>" );		
				newText = newText + oldTextArr[i]+"\n";
			
		}

	var header = "<tr><th>Region Code</th><th>Title</th><th>Tooltip Text</th><th>Action Value</th><th>Color</th><th>&nbsp;</th></tr>";
	newText = "<table class='data-content-table'>\n"+header+"\n"+newText+"</table>\n";
	
	var span = document.getElementById("htmlplacetable");
	span.innerHTML = newText; // clear existing
	
	document.getElementById("colori").appendChild(colorinput);
	
}

    
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawVisualization);

     function drawVisualization() {
		
		
		var bgcolor = document.getElementsByName('bg_color')[0].value;  
		var stroke = document.getElementsByName('border_stroke')[0].value; 
		var bordercolor = document.getElementsByName('border_color')[0].value; 
		var incolor = document.getElementsByName('ina_color')[0].value;
		var actcolor = document.getElementsByName('act_color')[0].value; 
		var width = document.getElementsByName('width')[0].value; 
		var height = document.getElementsByName('height')[0].value; 
		var aspratio = document.getElementById('aspratio'); 
		var interact = document.getElementById('interactive');
		var tooltipt = document.getElementById('tooltipt');  
		var areacombo = document.getElementsByName('region')[0].value; 
		var areashow = areacombo.split(",");
		var region = areashow[0]; 
		var resolution = areashow[1];
		var markersize = document.getElementsByName('marker_size')[0].value; 
		var displaym = document.getElementsByName('display_mode')[0].value;  
		var placestxt =  document.getElementsByName('places')[0].value.replace(/(\r\n|\n|\r)/gm,"");
		var places = placestxt.split(";");
		
		var displaymode = "regions";		
		  		
		if(displaym == "markers" || displaym == "markers02" ) {
			displaymode = "markers";
		}
		
		
		var ratio = false;
		if(aspratio.checked==true) {
			var ratio = true;	
		} 
		
		var interactive = 'true';
		if(interact.checked!=true) {
			var interactive = 'false';	
		}
		
		var toolt = 'focus';
		if(tooltipt.checked!=true) {
			var toolt = 'none';	
		}
		
       var data = new google.visualization.DataTable();
	   
	   	if(displaym == "markers02") {
	     data.addColumn('number', 'Lat');                                
	     data.addColumn('number', 'Long');
		 }
	   
	   
		data.addColumn('string', 'Country'); // Implicit domain label col.
		data.addColumn('number', 'Value'); // Implicit series 1 data col.
		data.addColumn({type:'string', role:'tooltip'}); // 
			var ivalue = new Array();
			var colorsmap = [];
			var colorsmapecho = "";		
			
			//places.length-1 to eliminate empty value at the end
			for (var i = 0; i < places.length-1; i++) {
			var entry = places[i].split(",");
			
			var ttitle = entry[1].replace(/&#59/g,";");
			ttitle = ttitle.replace(/&#44/g,",");
			var ttooltip = entry[2].replace(/&#59/g,";");
			ttooltip = ttooltip.replace(/&#44/g,",");
			
			
			//If data != markers02
			if(displaym != "markers02") {
			
			
				
			data.addRows([[{v:entry[0],f:ttitle},i,ttooltip]]);
			
			var index = entry[0];
			}
			else {
			var trim = entry[0].replace(/^\s+|\s+$/g,"");
			var latlon = trim.split(/ /);
			var lat = parseFloat(latlon[0]);
			var lon = parseFloat(latlon[1]);
			
						
					
			data.addRows([[lat,lon,ttitle,i,ttooltip]]);		
			
			var index = lat;
			
			}
			var colori = entry[4];
			
			ivalue[index] = entry[3].replace(/&#59/g,";");
			ivalue[index] = ivalue[index].replace(/&#44/g,",");	
			
			colorsmapecho = colorsmapecho + "'"+colori+"',";
			colorsmap.push(colori);
			ivalue.push(ivalue);
			}
			//colorsmap.pop();
			ivalue.pop();
			
		defmaxvalue = 0;
		if ((places.length-2) > 0) {
		defmaxvalue = places.length-2;	
		}
			 				
		var options = {
			backgroundColor: {fill:bgcolor,stroke:bordercolor ,strokeWidth:stroke },
			colorAxis:  {minValue: 0, maxValue: defmaxvalue,  colors: colorsmap},
			legend: 'none',	
			backgroundColor: {fill:bgcolor,stroke:bordercolor ,strokeWidth:stroke },		
			datalessRegionColor: incolor,
			displayMode: displaymode, 
			enableRegionInteractivity: interactive,
			resolution: resolution,
			sizeAxis: {minValue: 1, maxValue:1,minSize:markersize,  maxSize: markersize},
			region:region,
			keepAspectRatio: ratio,
			width:width,
			height:height,
			tooltip: {textStyle: {color: '#000'}, trigger:toolt}		
			};

        var chart = new google.visualization.GeoChart(document.getElementById('visualization'));
		
		google.visualization.events.addListener(chart, 'select', function() {
		var selection = chart.getSelection();
	
    	if (selection.length == 1) {
			var selectedRow = selection[0].row;
            var selectedRegion = data.getValue(selectedRow, 0);
			if(ivalue[selectedRegion] != "") { alert(ivalue[selectedRegion]); }
			}
			});
		
		chart.draw(data, options);
		
		
    }
	function showsimple() {		
		document.getElementById('simple-table').style.display='block';
		document.getElementById('advanced-table').style.display='none';
		document.getElementById("shsimple").setAttribute("class", "activeb");
		document.getElementById("shadvanced").setAttribute("class", "inactiveb");
	}
	
	function showadvanced() {		
		document.getElementById('simple-table').style.display='none';
		document.getElementById('advanced-table').style.display='block';
		document.getElementById("shsimple").setAttribute("class", "inactiveb");
		document.getElementById("shadvanced").setAttribute("class", "activeb");
	}
	

    function hidecustomsettings() {
		var e = document.getElementById('default-settings-table-add');
       e.style.display = 'none';
    }
    function showcustomsettings() {
		
		if(document.getElementsByName('use_defaults')[1].checked) { 
		
		var e = document.getElementById('default-settings-table-add');
       e.style.display = 'block';
		}

    }
	
	function  customoptionshow() {
		var e = document.getElementById('custom-action');
        e.style.display = 'block';
	}
	
	function  customoptionhide() {
		var e = document.getElementById('custom-action');
        e.style.display = 'none';
	}
	
	function  latlonshow() {
		var e = document.getElementById('latlondiv');
        e.style.display = 'block';
	}
	
	function  latlonhide() {
		var e = document.getElementById('latlondiv');
        e.style.display = 'none';
	}
	
	
	
	
	function isolink() {	 	
		
		var display = document.getElementsByName('display_mode')[0].value; 
	  	var areacombo = document.getElementsByName('region')[0].value; 
		var mapaction = document.getElementsByName('map_action')[0].value; 
		var areashow = areacombo.split(",");
		var region = areashow[0]; 
		var resolution = areashow[1];
		var span = document.getElementById("iso-code-msg");
	  
	  if(resolution == 'countries' && display == "regions")	{
		   
		span.innerHTML = '<b>' + document.getElementById('region')[document.getElementById('region').selectedIndex].innerHTML + '</b>- To create your interactive regions, when using the "Regions" display mode, use a country name as a string, or an uppercase <a href="http://en.wikipedia.org/wiki/ISO_3166-1">ISO-3166-1</a> code or its English text equivalent (for example, <i>GB</i> or <i>United Kingdom</i>). Check Google\'s <a href="https://developers.google.com/chart/interactive/docs/gallery/geochart#Continent_Hierarchy" target="_blank">Continents and Countries</a> list for aditional resources.'; 
		latlonhide();			
	  } 
	  
	   if(resolution == 'provinces' && display == "regions")	{
		var ct = areashow[0].length;
		var linkiso;
		if(ct>2) { 
		linkiso = "<a href='http://en.wikipedia.org/wiki/ISO_3166-2:US'>ISO-3166-2:US</a>";
		} else {
		linkiso = "<a target='_blank' href='http://en.wikipedia.org/wiki/ISO_3166-2:"+areashow[0]+"'>ISO-3166-2:"+areashow[0]+"</a>";	
		}
		span.innerHTML = '<b>' + document.getElementById('region')[document.getElementById('region').selectedIndex].innerHTML + '</b> - To create your interactive regions, use the '+linkiso+' codes.'; 
		latlonhide();			
	  	} 
	  
	  if(resolution == 'metros' && display == "regions") {
		 
		 span.innerHTML = '<b>' + document.getElementById('region')[document.getElementById('region').selectedIndex].innerHTML + '</b> - To create your interactive regions, use these three-digit <a href="http://developers.google.com/adwords/api/docs/appendix/metrocodes" target="_blank">metropolitan area codes</a> as the region codes.'; // 
			latlonhide();
		 }
		 
		 if(resolution == 'continents' && display == "regions") {
		 
		 span.innerHTML = '<b>' + document.getElementById('region')[document.getElementById('region').selectedIndex].innerHTML + '</b> - Region Codes for Continents (When using Regions Display Mode): <br /> Africa - 002 | Europe - 150 | Americas - 019 | Asia - 142 | Oceania - 009'; // 
		latlonhide();	
		 
		 }
		 
		  if(resolution == 'subcontinents' && display == "regions") {
		 
		 span.innerHTML = '<b>' + document.getElementById('region')[document.getElementById('region').selectedIndex].innerHTML + '</b> - Region codes for Subcontinents (When using Regions Display Mode): <br />Africa - Northern Africa: 015, Western Africa: 011, Middle Africa: 017, Eastern Africa: 014, Southern Africa: 018;<br />Europe - Northern Europe: 154, Western Europe: 155, Eastern Europe: 151, Southern Europe: 039;<br />Americas - Northern America: 021, Caribbean: 029, Central America: 013, South America: 005;<br />Asia - Central Asia: 143, Eastern Asia: 030, Southern Asia: 034, South-Eastern Asia: 035, Western Asia: 145;<br />Oceania - Australia and New Zealand: 053, Melanesia: 054, Micronesia: 057, Polynesia: 061;'; // 
		 
		 latlonhide();
			
		 }
		 
		 
		 
		  if(display == 'markers') {
		 
		 span.innerHTML = '<b>Markers (Text Location)</b> - When using the Markers display mode, a colored bubble will be added to the specified region. When this mode is selected you can also use a a specific string address (for example, "1600 Pennsylvania Ave") or Berlin Germany as a Region Code. DO NOT use commas (,) or quotes("").<br /><strong>If you experience slow loading of the Markers, consider using Markers (Coordinates) Display Mode.</strong>'; // 
		 
		 latlonhide();
			
		   }
		   
		   if(display == 'markers02') {
		 
		 span.innerHTML =  '<b>Markers (Coordinates)</b> - When using the Markers display mode, a colored bubble will be added to the specified region. When the Coordinates mode is chosen, you should insert the coordinates values in the Region Code, in this format: latitude longitude. <strong>Do not use commas, use a space to separate de values</strong>. Example:34.3071438 -53.7890625'; // 
		 latlonshow();
			
		   }
		   
		   

		    if(mapaction == 'i_map_action_open_url') {
		 
		 span.innerHTML =  span.innerHTML + '<br /><br /><b>Action - Open URL</b> - The URL you specify in the "Action Value" field will open in the same window, after the user clicked on that region.'; // 
		  customoptionhide();
			
		   }
		   if(mapaction == 'i_map_action_open_url_new') {
		 
		 span.innerHTML =  span.innerHTML + '<br /><br /><b>Action - Open URL (new window)</b> - The URL you specify in the "Action Value" field will open in a new window, after the user clicked on that region.'; // 
		  customoptionhide();
			
		   }
		   
		    if(mapaction == 'i_map_action_alert') {
		 
		 span.innerHTML =  span.innerHTML + '<br /><br /><b>Action - Alert</b> - An alert message will display with the text you specify in the "Action Value" field.'; // 
		  customoptionhide();
			
		   }
		   
		  if(mapaction == 'i_map_action_content_below') {
		 
		 span.innerHTML =  span.innerHTML + '<br /><br /><b>Display Content Below Map</b> - The content of the "Action Value" field will display inside a div under the map. The div will have the id="imapMAPIDmessage" (for example <i>imap1message</i>) and can be customized with CSS.';// 
		  customoptionhide();
			
		   }
		   
		  if(mapaction == 'i_map_action_content_above') {
		 
		 span.innerHTML =  span.innerHTML + '<br /><br /><b>Display Content Above Map</b> - The content of the "Action Value" field will display inside a div above the map. The div will have the id="imapMAPIDmessage" (for example <i>imap1message</i>) and can be customized with CSS.';// 
		  customoptionhide();
			
		   }
		   
		   
		   
		  if(mapaction == 'i_map_action_custom') {
		 
		 span.innerHTML =  span.innerHTML + '<br /><br /><b>Action - Custom</b> - Create your custom action.'; // 
		 customoptionshow();	
		   }
		   
		   if(mapaction == 'none') {
		 
		  customoptionhide();	
		   }
		   

	}
	
	function isolinkcheck() {
		drawVisualization();
		isolink();
		
	}
	
	function initmap() {
		isolink();
		dataToTable();
		showcustomsettings();
		

	}
	
	function addslashes( str ) {
    return (str+'').replace(/([\\"'])/g, "\\$1").replace(/\0/g, "\\0");
	}

	
	window.onload=initmap;