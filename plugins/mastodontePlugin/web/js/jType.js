jType = {
	registerNamespace : function(name){
		var rootObject = window;
		var namespaceParts = name.split('.');
		for (var i = 0; i < namespaceParts.length; i++) {
			if(typeof(rootObject[namespaceParts[i]]) == "undefined"){
				rootObject[namespaceParts[i]] = {};
			}
			rootObject = rootObject[namespaceParts[i]];
		}
	},
	registerClass : function(clas, extend, implement){
		if(typeof(extend) != "undefined"){
			clas.prototype.Super = extend;
			for(var constant in extend){
				if(constant != "prototype"){
					if(typeof(extend[constant]) == "object"){
						if(typeof(clas[constant]) == "undefined")
							clas[constant] = extend[constant];
						for(var subprop in extend[constant]){
							clas[constant][subprop] = extend[constant][subprop];
						}
					}else{
						clas[constant] = extend[constant];
					}
				}
			}
			for(var method in extend.prototype){
				clas.prototype[method] = extend.prototype[method];
			}
		}
	}
}