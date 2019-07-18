function localset(k ,v){
	localStorage.setItem(k ,v);
}

function localget(k){
	var g = localStorage.getItem(k);
	return g;
}

function localremove(k){
	localStorage.removeitem(k);
}