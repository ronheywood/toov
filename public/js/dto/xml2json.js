(function() {
angular.module('Eve')
.factory('xml',[function(){
			Parser = {
				xml2json: function(xml) {
					// Create the return object
					var obj = {};

					if (xml.nodeType == 1) { // element
						// do attributes
						if (xml.attributes.length > 0) {
						obj["data"] = {};
							for (var j = 0; j < xml.attributes.length; j++) {
								var attribute = xml.attributes.item(j);
								obj["data"][attribute.nodeName] = attribute.nodeValue;
							}
						}
					} else if (xml.nodeType == 3) { // text
						obj = xml.nodeValue;
					}

					// do children
					if (xml.hasChildNodes()) {
						for(var i = 0; i < xml.childNodes.length; i++) {
							var item = xml.childNodes.item(i);
							var nodeName = item.nodeName;
							if (typeof(obj[nodeName]) == "undefined") {
								obj[nodeName] = Parser.xml2json(item);
							} else {
								if (typeof(obj[nodeName].push) == "undefined") {
									var old = obj[nodeName];
									obj[nodeName] = [];
									obj[nodeName].push(old);
								}
								obj[nodeName].push(Parser.xml2json(item));
							}
						}
					}
					return obj;
				},
				parse: function (data) {
					if(data == undefined){
						console.error('Empty data value passed to xml2json Parse method.');
					} 
					var dParse = new DOMParser();
					try {
		        		return Parser.xml2json(dParse.parseFromString(data,"text/xml")).eveapi.result;
		        	} catch(e){ console.error(e); }

		        	return {}
		    	}
			}

			return Parser;
		}])
})();