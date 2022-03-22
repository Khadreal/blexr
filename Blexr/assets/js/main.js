var Init = function() {
	this.addMoreBtn = document.querySelector('.add__more');
	this.calculatorTable = document.querySelector('.calc__table')
	this.filterform = document.querySelector('.blexr__filter');


	if(this.addMoreBtn) this.addMore();
	if(this.filterform) this.filterOptions();
}


Init.prototype.addMore = function() {
	var __this = this,
		inputLength = 2;

	this.addMoreBtn.addEventListener('click', function(e){
		let tableRow = document.createElement('tr'),
			tableData = document.createElement('td'),
			inputholder = document.createElement('div'),
			inputElement = document.createElement('input');

		Array.from({ length:inputLength }).forEach( item => {
			inputElement.classList.add('form-control')
			inputElement.setAttribute('placeholder', 'Enter stake')

			inputholder.appendChild(inputElement)
			tableData.appendChild(inputholder)
			tableRow.appendChild(tableData)

			__this.calculatorTable.appendChild(tableRow)
		});
	})
}

Init.prototype.filterOptions = function(){
	let tableData = document.querySelector('.table tbody'),
		__this = this;

	this.filterform.addEventListener('submit', function(evt){
		evt.preventDefault();
		
		//Add loading class to table
		document.querySelector('.table').classList.add('loading')
		const params = {
		    markets: document.querySelector('#market').value,
		    sports: document.querySelector('#sport').value,
		    regions: document.querySelector('#region').value
		};

		const get = (url, params) => __this.processRequest(url, params);

		get("blexr-odd-filter", params).then((response) => {
			document.querySelector('.table').classList.remove('loading')
		  	tableData.innerHTML = ''
		   	tableData.innerHTML = response
		});
	});
}

Init.prototype.processRequest = function(url, params = {} ){
	url += "?" + new URLSearchParams(params).toString();

  	const result = fetch(url).then((response) => response.text());

  	return result;
};

document.addEventListener("DOMContentLoaded", function() {
    new Init();
});