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

		for (var i = 2 - 1; i >= 0; i--) {
			inputElement.classList.add('form-control')
			inputElement.setAttribute('placeholder', 'Enter stake')

			inputholder.appendChild(inputElement)
			tableData.appendChild(inputholder)
			tableRow.appendChild(tableData)

			__this.calculatorTable.appendChild(tableRow)
		}
	})
}

Init.prototype.filterOptions = function(){

	console.log(90);
	var url = new URL('/blexr-odd-filter/'),
    params = {lat:35.696233, long:139.570431};
	Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
	fetch(url)
		.then(response => response.text())
		.then(html => {
			document.querySelector('.table tbody').innerHTML = html
		})
}

document.addEventListener("DOMContentLoaded", function() {
    new Init();
});