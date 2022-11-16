$(function () {
	// Checks for Sims 2 related checkboxes
	checkEPs();
	$(".s2eps").change(function () {
		checkEPs();
	});

	// Sims 2 specific functions
	$("button#sims2gen").click(function () { // Sims 2 aspirations
		let sims2asp = 0;
		let aspimg = '';
		let aspalt = '';

		if ($("#cheese").prop("checked")) {
			sims2asp = random(1, 7, 1, true);
		} else if ($('#nl').prop('checked')) {
			sims2asp = random(1, 6, 1, true);
		} else {
			sims2asp = random(1, 5, 1, true);
		}

		switch (sims2asp) {
			case 1:
				aspimg = "Aspiration1.png";
				aspalt = "Family";
				break;
			case 2:
				aspimg = "Aspiration2.png";
				aspalt = "Wealth";
				break;
			case 3:
				aspimg = "Aspiration3.png";
				aspalt = "Knowledge";
				break;
			case 4:
				aspimg = "Aspiration4.png";
				aspalt = "Romance";
				break;
			case 5:
				aspimg = "Aspiration5.png";
				aspalt = "Popularity";
				break;
			case 6:
				aspimg = "Aspiration6.png";
				aspalt = "Pleasure";
				break;
			default:
				aspimg = "Null.png";
				aspalt = "";
				break;
		}
		$("#aspiration").attr("src", s2path + aspimg);
		$("#aspiration").attr("alt", aspalt);

		if (!$("#tocheck").prop("disabled") && $("#tocheck").prop("checked")) {
			tofrandom();
		} else {
			$("#ton1").attr("src", s2path + 'Null.png');
			$("#ton1").attr("alt", '');
			$("#ton2").attr("src", s2path + 'Null.png');
			$("#ton2").attr("alt", '');
			$("#toff").attr("src", s2path + 'Null.png');
			$("#toff").attr("alt", '');
		}
	});

	// Turn on / off randomiser
	function tofrandom() {
		let result = [];
		let rnd1 = 0; // Used for setting 1st turn-on
		let rnd2 = 0; // Used for setting 2nd turn-on
		let rnd3 = 0; // Used for setting turn-off
		let to1img = 'Null.png'; // Relative path for 1st turn-on
		let to1alt = ''; // Alt text for 1st turn-on
		let to2img = 'Null.png'; // Relative path for 2nd turn-on
		let to2alt = ''; // Alt text for 2nd turn-on
		let toffimg = 'Null.png'; // Relative path for turn-off
		let toffalt = ''; // Alt text for turn-off

		// If AL is false, don't include witches
		if ($('#al').prop('checked') === false) {
			// If BV and FT are false, don't include new turn-ons
			if ($('#bv').prop('checked') === false && $('#ft').prop('checked') === false) {
				result = random(1, 19, 3, false);
				rnd1 = result[0];
				rnd2 = result[1];
				rnd3 = result[2];
			} else {
				result = random(1, 33, 3, false);
				rnd1 = result[0];
				rnd2 = result[1];
				rnd3 = result[2];
			}
		} else {
			result = random(1, 34, 3, false);
			rnd1 = result[0];
			rnd2 = result[1];
			rnd3 = result[2];
		}

		// Check against randomly generated numbers and set image etc. to corresponding variables
		if (rnd1 === 1) {
			to1img = 'turnon1.png';
			to1alt = 'Cologne';
		} else if (rnd2 === 1) {
			to2img = "turnon1.png";
			to2alt = "Cologne";
		} else if (rnd3 === 1) {
			toffimg = "turnoff1.png";
			toffalt = "Cologne";
		}

		if (rnd1 === 2) {
			to1img = 'turnon2.png';
			to1alt = 'Stink';
		} else if (rnd2 === 2) {
			to2img = "turnon2.png";
			to2alt = "Stink";
		} else if (rnd3 === 2) {
			toffimg = "turnoff2.png";
			toffalt = "Stink";
		}

		if (rnd1 === 3) {
			to1img = 'turnon3.png';
			to1alt = 'Fat';
		} else if (rnd2 === 3) {
			to2img = "turnon3.png";
			to2alt = "Fat";
		} else if (rnd3 === 3) {
			toffimg = "turnoff3.png";
			toffalt = "Fat";
		}

		if (rnd1 === 4) {
			to1img = 'turnon4.png';
			to1alt = 'Fit';
		} else if (rnd2 === 4) {
			to2img = "turnon4.png";
			to2alt = "Fit";
		} else if (rnd3 === 4) {
			toffimg = "turnoff4.png";
			toffalt = "Fit";
		}

		if (rnd1 === 5) {
			to1img = 'turnon5.png';
			to1alt = 'Grey hair';
		} else if (rnd2 === 5) {
			to2img = "turnon5.png";
			to2alt = "Grey hair";
		} else if (rnd3 === 5) {
			toffimg = "turnoff5.png";
			toffalt = "Grey hair";
		}

		if (rnd1 === 6) {
			to1img = 'turnon6.png';
			to1alt = 'Formal wear';
		} else if (rnd2 === 6) {
			to2img = "turnon6.png";
			to2alt = "Formal wear";
		} else if (rnd3 === 6) {
			toffimg = "turnoff6.png";
			toffalt = "Formal wear";
		}


		if (rnd1 === 7) {
			to1img = 'turnon7.png';
			to1alt = 'Swimwear';
		} else if (rnd2 === 7) {
			to2img = "turnon7.png";
			to2alt = "Swimwear";
		} else if (rnd3 === 7) {
			toffimg = "turnoff7.png";
			toffalt = "Swimwear";
		}

		if (rnd1 === 8) {
			to1img = 'turnon8.png';
			to1alt = 'Underwear';
		} else if (rnd2 === 8) {
			to2img = "turnon8.png";
			to2alt = "Underwear";
		} else if (rnd3 === 8) {
			toffimg = "turnoff8.png";
			toffalt = "Underwear";
		}

		if (rnd1 === 9) {
			to1img = 'turnon9.png';
			to1alt = 'Vampirism';
		} else if (rnd2 === 9) {
			to2img = "turnon9.png";
			to2alt = "Vampirism";
		} else if (rnd3 === 9) {
			toffimg = "turnoff9.png";
			toffalt = "Vampirism";
		}

		if (rnd1 === 10) {
			to1img = 'turnon10.png';
			to1alt = 'Facial hair';
		} else if (rnd2 === 10) {
			to2img = "turnon10.png";
			to2alt = "Facial hair";
		} else if (rnd3 === 10) {
			toffimg = "turnoff10.png";
			toffalt = "Facial hair";
		}

		if (rnd1 === 11) {
			to1img = 'turnon11.png';
			to1alt = 'Glasses';
		} else if (rnd2 === 11) {
			to2img = "turnon11.png";
			to2alt = "Glasses";
		} else if (rnd3 === 11) {
			toffimg = "turnoff11.png";
			toffalt = "Glasses";
		}

		if (rnd1 === 12) {
			to1img = 'turnon12.png';
			to1alt = 'Makeup';
		} else if (rnd2 === 12) {
			to2img = "turnon12.png";
			to2alt = "Makeup";
		} else if (rnd3 === 12) {
			toffimg = "turnoff12.png";
			toffalt = "Makeup";
		}

		if (rnd1 === 13) {
			to1img = 'turnon13.png';
			to1alt = 'Face paint';
		} else if (rnd2 === 13) {
			to2img = "turnon13.png";
			to2alt = "Face paint";
		} else if (rnd3 === 13) {
			toffimg = "turnoff13.png";
			toffalt = "Face paint";
		}

		if (rnd1 === 14) {
			to1img = 'turnon14.png';
			to1alt = 'Hats';
		} else if (rnd2 === 14) {
			to2img = "turnon14.png";
			to2alt = "Hats";
		} else if (rnd3 === 14) {
			toffimg = "turnoff14.png";
			toffalt = "Hats";
		}

		if (rnd1 === 15) {
			to1img = 'turnon15.png';
			to1alt = 'Blond hair';
		} else if (rnd2 === 15) {
			to2img = "turnon15.png";
			to2alt = "Blond hair";
		} else if (rnd3 === 15) {
			toffimg = "turnoff15.png";
			toffalt = "Blond hair";
		}

		if (rnd1 === 16) {
			to1img = 'turnon16.png';
			to1alt = 'Red hair';
		} else if (rnd2 === 16) {
			to2img = "turnon16.png";
			to2alt = "Red hair";
		} else if (rnd3 === 16) {
			toffimg = "turnoff16.png";
			toffalt = "Red hair";
		}

		if (rnd1 === 17) {
			to1img = 'turnon17.png';
			to1alt = 'Brown hair';
		} else if (rnd2 === 17) {
			to2img = "turnon17.png";
			to2alt = "Brown hair";
		} else if (rnd3 === 17) {
			toffimg = "turnoff17.png";
			toffalt = "Brown hair";
		}

		if (rnd1 === 18) {
			to1img = 'turnon18.png';
			to1alt = 'Black hair';
		} else if (rnd2 === 18) {
			to2img = "turnon18.png";
			to2alt = "Black hair";
		} else if (rnd3 === 18) {
			toffimg = "turnoff18.png";
			toffalt = "Black hair";
		}

		if (rnd1 === 19) {
			to1img = 'turnon19.png';
			to1alt = 'Custom hair';
		} else if (rnd2 === 19) {
			to2img = "turnon19.png";
			to2alt = "Custom hair";
		} else if (rnd3 === 19) {
			toffimg = "turnoff19.png";
			toffalt = "Custom hair";
		}

		if (rnd1 === 20) {
			to1img = 'turnon20.png';
			to1alt = 'Works Hard';
		} else if (rnd2 === 20) {
			to2img = "turnon20.png";
			to2alt = "Works Hard";
		} else if (rnd3 === 20) {
			toffimg = "turnoff20.png";
			toffalt = "Works Hard";
		}

		if (rnd1 === 21) {
			to1img = 'turnon21.png';
			to1alt = 'Unemployed';
		} else if (rnd2 === 21) {
			to2img = "turnon21.png";
			to2alt = "Unemployed";
		} else if (rnd3 === 21) {
			toffimg = "turnoff21.png";
			toffalt = "Unemployed";
		}

		if (rnd1 === 22) {
			to1img = 'turnon22.png';
			to1alt = 'Logical';
		} else if (rnd2 === 22) {
			to2img = "turnon22.png";
			to2alt = "Logical";
		} else if (rnd3 === 22) {
			toffimg = "turnoff22.png";
			toffalt = "Logical";
		}

		if (rnd1 === 23) {
			to1img = 'turnon23.png';
			to1alt = 'Charismatic';
		} else if (rnd2 === 23) {
			to2img = "turnon22.png";
			to2alt = "Charismatic";
		} else if (rnd3 === 23) {
			toffimg = "turnoff23.png";
			toffalt = "Charismatic";
		}

		if (rnd1 === 24) {
			to1img = 'turnon24.png';
			to1alt = 'Good Cook';
		} else if (rnd2 === 24) {
			to2img = "turnon24.png";
			to2alt = "Good Cook";
		} else if (rnd3 === 24) {
			toffimg = "turnoff24.png";
			toffalt = "Good Cook";
		}

		if (rnd1 === 25) {
			to1img = 'turnon25.png';
			to1alt = 'Mechanic';
		} else if (rnd2 === 25) {
			to2img = "turnon25.png";
			to2alt = "Mechanic";
		} else if (rnd3 === 25) {
			toffimg = "turnoff25.png";
			toffalt = "Mechanic";
		}

		if (rnd1 === 26) {
			to1img = 'turnon26.png';
			to1alt = 'Creative';
		} else if (rnd2 === 26) {
			to2img = "turnon26.png";
			to2alt = "Creative";
		} else if (rnd3 === 26) {
			toffimg = "turnoff26.png";
			toffalt = "Creative";
		}

		if (rnd1 === 27) {
			to1img = 'turnon27.png';
			to1alt = 'Athletic';
		} else if (rnd2 === 27) {
			to2img = "turnon27.png";
			to2alt = "Athletic";
		} else if (rnd3 === 27) {
			toffimg = "turnoff27.png";
			toffalt = "Athletic";
		}

		if (rnd1 === 28) {
			to1img = 'turnon28.png';
			to1alt = 'Good Cleaner';
		} else if (rnd2 === 28) {
			to2img = "turnon28.png";
			to2alt = "Good Cleaner";
		} else if (rnd3 === 28) {
			toffimg = "turnoff28.png";
			toffalt = "Good Cleaner";
		}

		if (rnd1 === 29) {
			to1img = 'turnon29.png';
			to1alt = 'Zombie';
		} else if (rnd2 === 29) {
			to2img = "turnon29.png";
			to2alt = "Zombie";
		} else if (rnd3 === 29) {
			toffimg = "turnoff29.png";
			toffalt = "Zombie";
		}

		if (rnd1 === 30) {
			to1img = 'turnon30.png';
			to1alt = 'Jewelry';
		} else if (rnd2 === 30) {
			to2img = "turnon30.png";
			to2alt = "Jewelry";
		} else if (rnd3 === 30) {
			toffimg = "turnoff30.png";
			toffalt = "Jewelry";
		}

		if (rnd1 === 31) {
			to1img = 'turnon31.png';
			to1alt = 'Servo';
		} else if (rnd2 === 31) {
			to2img = "turnon31.png";
			to2alt = "Servo";
		} else if (rnd3 === 31) {
			toffimg = "turnoff31.png";
			toffalt = "Servo";
		}

		if (rnd1 === 32) {
			to1img = 'turnon32.png';
			to1alt = 'Plant Sim';
		} else if (rnd2 === 32) {
			to2img = "turnon32.png";
			to2alt = "Plant Sim";
		} else if (rnd3 === 32) {
			toffimg = "turnoff32.png";
			toffalt = "Plant Sim";
		}

		if (rnd1 === 33) {
			to1img = 'turnon33.png';
			to1alt = 'Werewolf';
		} else if (rnd2 === 33) {
			to2img = "turnon33.png";
			to2alt = "Werewolf";
		} else if (rnd3 === 33) {
			toffimg = "turnoff33.png";
			toffalt = "Werewolf";
		}

		if (rnd1 === 34) {
			to1img = 'turnon34.png';
			to1alt = 'Witch';
		} else if (rnd2 === 34) {
			to2img = "turnon34.png";
			to2alt = "Witch";
		} else if (rnd3 === 34) {
			toffimg = "turnoff34.png";
			toffalt = "Witch";
		}

		// Once all checks are done, set the appropriate image and alt text
		$("#ton1").attr("src", s2path + to1img);
		$("#ton1").attr("alt", to1alt);
		$("#ton2").attr("src", s2path + to2img);
		$("#ton2").attr("alt", to2alt);
		$("#toff").attr("src", s2path + toffimg);
		$("#toff").attr("alt", toffalt);
	}

	function checkEPs() {
		// If only Uni (or no EPs) checked, don't randomise turn-ons
		if (!$('#nl').prop('checked') && !$('#ofb').prop('checked') && !$('#pets').prop('checked') && !$('#sns').prop('checked') && !$('#bv').prop('checked') && !$('#ft').prop('checked') && !$('#al').prop('checked')) {
			$("#ton1").attr("src", s2path + 'Null.png');
			$("#ton1").attr("alt", '');
			$("#ton2").attr("src", s2path + 'Null.png');
			$("#ton2").attr("alt", '');
			$("#toff").attr("src", s2path + 'Null.png');
			$("#toff").attr("alt", '');
			// If turn-ons not applicable, disable TO and cheese options
			$("#tocheck").prop("checked", false);
			$("#tocheck").prop("disabled", true);
			$("#cheese").prop("checked", false);
			$("#cheese").prop("disabled", true);
		} else {
			// If relevant EPs checked, enable TO / cheese options and see if it's checked
			$("#tocheck").prop("disabled", false);
			$("#cheese").prop("disabled", false);
		}
	}
});