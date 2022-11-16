$(function () {
	let gen = $('#currentGen').val();
	showGen(gen);

	for (i = 1; i <= gen; i++) {
		getGen(i);
	}

	$("#gen1").on("change", function () {
		getGen(1);
	});
	$("#gen2").on("change", function () {
		getGen(2);
	});
	$("#gen3").on("change", function () {
		getGen(3);
	});
	$("#gen4").on("change", function () {
		getGen(4);
	});
	$("#gen5").on("change", function () {
		getGen(5);
	});
	$("#gen6").on("change", function () {
		getGen(6);
	});
	$("#gen7").on("change", function () {
		getGen(7);
	});
	$("#gen8").on("change", function () {
		getGen(8);
	});
	$("#gen9").on("change", function () {
		getGen(9);
	});
	$("#gen10").on("change", function () {
		getGen(10);
	});
	$("#gen11").on("change", function () {
		getGen(11);
	});
	$("#gen12").on("change", function () {
		getGen(12);
	});
	$("#gen13").on("change", function () {
		getGen(13);
	});
	$("#gen14").on("change", function () {
		getGen(14);
	});
	$("#gen15").on("change", function () {
		getGen(15);
	});
	$("#gen16").on("change", function () {
		getGen(16);
	});
	$("#gen17").on("change", function () {
		getGen(17);
	});
	$("#gen18").on("change", function () {
		getGen(18);
	});
	$("#gen19").on("change", function () {
		getGen(19);
	});
	$("#gen20").on("change", function () {
		getGen(20);
	});
});

function getGen(v) {
	let url = $("a#url" + v);
	let data = url.attr("data-href");
	let log = url.attr("data-log");
	let s = $("#gen" + v).find(":selected").val();

	if (data == 0) {
		url.removeAttr("href");
		text = base + "/legacygen/create/" + user + "/" + v + "/" + challenge + "/" + s;
		url.attr("href", text);
	} else {
		url.removeAttr("href");
		text = base + "/legacygen/update/" + data + "/" + s;
		url.attr("href", text);
	}
	console.log(log);
}

function showGen(g) {
	if (g >= 1) {
		$("tr#founder").show();
	} else {
		$("tr#founder").hide();
	}

	if (g >= 2) {
		$("tr#gen2heir").show();
	} else {
		$("tr#gen2heir").hide();
	}

	if (g >= 3) {
		$("tr#gen3heir").show();
	} else {
		$("tr#gen3heir").hide();
	}

	if (g >= 4) {
		$("tr#gen4heir").show();
	} else {
		$("tr#gen4heir").hide();
	}

	if (g >= 5) {
		$("tr#gen5heir").show();
	} else {
		$("tr#gen5heir").hide();
	}

	if (g >= 6) {
		$("tr#gen6heir").show();
	} else {
		$("tr#gen6heir").hide();
	}

	if (g >= 7) {
		$("tr#gen7heir").show();
	} else {
		$("tr#gen7heir").hide();
	}

	if (g >= 8) {
		$("tr#gen8heir").show();
	} else {
		$("tr#gen8heir").hide();
	}

	if (g >= 9) {
		$("tr#gen9heir").show();
	} else {
		$("tr#gen9heir").hide();
	}

	if (g >= 10) {
		$("tr#gen10heir").show();
	} else {
		$("tr#gen10heir").hide();
	}
	if (g >= 11) {
		$("tr#gen11heir").show();
	} else {
		$("tr#gen11heir").hide();
	}

	if (g >= 12) {
		$("tr#gen12heir").show();
	} else {
		$("tr#gen12heir").hide();
	}

	if (g >= 13) {
		$("tr#gen13heir").show();
	} else {
		$("tr#gen13heir").hide();
	}

	if (g >= 14) {
		$("tr#gen14heir").show();
	} else {
		$("tr#gen14heir").hide();
	}

	if (g >= 15) {
		$("tr#gen15heir").show();
	} else {
		$("tr#gen15heir").hide();
	}

	if (g >= 16) {
		$("tr#gen16heir").show();
	} else {
		$("tr#gen16heir").hide();
	}

	if (g >= 17) {
		$("tr#gen17heir").show();
	} else {
		$("tr#gen17heir").hide();
	}

	if (g >= 18) {
		$("tr#gen18heir").show();
	} else {
		$("tr#gen18heir").hide();
	}

	if (g >= 19) {
		$("tr#gen19heir").show();
	} else {
		$("tr#gen19heir").hide();
	}

	if (g == 20) {
		$("tr#gen20heir").show();
	} else {
		$("tr#gen20heir").hide();
	}
}