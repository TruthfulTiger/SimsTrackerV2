let randNum = 0;
let numbers = [];

// General functions
function getRandomInt(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

// http://codetheory.in/weighted-biased-random-number-generation-with-javascript-based-on-probability/
function rand(min, max) {
	return Math.random() * (max - min) + min;
}

function getWeightedRandom(list, weight) {
	let total_weight = weight.reduce(function (prev, cur) {
		return prev + cur;
	});

	let random_num = rand(0, total_weight);
	let weight_sum = 0;
	//console.log(random_num)

	for (let i = 0; i < list.length; i++) {
		weight_sum += weight[i];
		weight_sum = +weight_sum.toFixed(2);

		if (random_num <= weight_sum) {
			return list[i];
		}
	}
}

// https://stackoverflow.com/questions/2380019/generate-unique-random-numbers-between-1-and-100
function shuffle(max, len) {
	let a = [];
	while (a.length < len) {
		let randomnumber = Math.floor(Math.random() * max) + 1;
		if (a.indexOf(randomnumber) > -1) continue;
		a[a.length] = randomnumber;
	}
	return a;
}

function random(min, max, n, rep) {
	$.ajax({
		url: 'https://api.random.org/json-rpc/2/invoke',
		type: "POST",
		data: JSON.stringify({
			"jsonrpc": "2.0",
			"method": "generateIntegers",
			"params": {
				"apiKey": "e7cca124-0c36-460c-972a-163ba70fd2dc",
				"n": n,
				"min": min,
				"max": max,
				"replacement": rep,
				"base": 10
			},
			"id": 28247
		}),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function (number) {
			if (n > 1) {
				numbers = number.result.random.data;
				$.each(numbers, function (index, value) {
					console.log(value);
				});
			} else {
				randNum = JSON.stringify(number.result.random.data[0]);
				console.log(JSON.stringify(number.result.random.data[0]));
			}

		},
		error: function (result) {
			console.log("File not found");
		}
	});
	if (n > 1) {
		return numbers;
	} else {
		return parseInt(randNum);
	}
}  

