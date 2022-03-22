


let stake = document.querySelector('.stake'),
	odds = document.querySelectorAll('.odds');

let oddsInputValue = 0,
	stakeValue = 0;

document.addEventListener("input", function() {
	let input = parseInt(stake.value),
		retval = input;

	Array.from(document.querySelectorAll('.odds')).forEach(input =>
		input.addEventListener('input', (event) => {
			document.querySelector('.payout').innerHTML = calculateOdds().toFixed(2);
		})
	);
});

let calculateOdds = () => {
	let retval = stakeValue,
		inputs = document.querySelectorAll('.odds');

	inputs.forEach(function(el, index, array){
		let currentValue = parseInt(inputs[index].value);
		if(currentValue > 100){
			retval = retval * 100
		} else{
			retval = retval * currentValue
		}
	})

	return retval;
}

stake.addEventListener("input", (e) => {
	let stakeInput = parseInt(e.target.value);
	if( isNaN(stakeInput)) {
		document.querySelector('.payout').innerHTML = '0.00';

		return;
	}
	stakeValue = stakeInput

	document.querySelector('.payout').innerHTML = calculateOdds().toFixed(2);
});

var Init = function() {
	this.addMoreBtn = document.querySelector('.add__more');
	this.calculatorTable = document.querySelector('.calc__table tbody')
	this.filterform = document.querySelector('.blexr__filter');


	if(this.addMoreBtn) this.addMore();
	if(this.filterform) this.filterOptions();

}

Init.prototype.addMore = function() {
	var __this = this,
		inputLength = 2;

	this.addMoreBtn.addEventListener('click', function(e){
		let tableRow = document.createElement('tr'),
			fragment = document.createDocumentFragment(),
			inputholder = document.createElement('div'),
			inputElement = document.createElement('input');

		inputholder.classList.add('flex');

		Array.from({ length:inputLength }).forEach( item => {
			let tableData = document.createElement('td')
			inputElement.classList.add('form-control')
			inputElement.classList.add('odds')
			inputElement.setAttribute('placeholder', 'Enter Odds')

			inputholder.appendChild(inputElement)
			tableData.appendChild(inputholder)
			
			fragment.appendChild(tableData)
		});

		tableRow.appendChild(fragment)
		__this.calculatorTable.appendChild(tableRow)
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