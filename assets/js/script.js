function lcset(k ,v){
	localStorage.setItem(k ,v);
}

function lcget(k){
	var g = localStorage.getItem(k);
	return g;
}

function lcremove(k){
	localStorage.removeItem(k);
}

function ssset(k ,v){
	sessionStorage.setItem(k ,v);
}

function ssget(k){
	var g = sessionStorage.getItem(k);
	return g;
}

function ssremove(k){
	sessionStorage.removeItem(k);
}