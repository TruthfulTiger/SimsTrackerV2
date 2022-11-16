/* Initialise values */
// Personality
let neat = document.getElementById('neatPoints');
let neatValueElement = document.getElementById('nP');
let outgoing = document.getElementById('outgoingPoints');
let outgoingValueElement = document.getElementById('oP');
let active = document.getElementById('activePoints');
let activeValueElement = document.getElementById('aP');
let playful = document.getElementById('playfulPoints');
let playfulValueElement = document.getElementById('pP');
let nice = document.getElementById('nicePoints');
let niceValueElement = document.getElementById('ncP');

// Interests
let politics = document.getElementById('politics');
let polsValueElement = document.getElementById('pols');
let crime = document.getElementById('crime');
let crimeValueElement = document.getElementById('crim');
let food = document.getElementById('food');
let foodValueElement = document.getElementById('fudz');
let sports = document.getElementById('sports');
let sportsValueElement = document.getElementById('spts');
let work = document.getElementById('work');
let workValueElement = document.getElementById('wk');
let school = document.getElementById('school');
let schoolValueElement = document.getElementById('sch');
let money = document.getElementById('money');
let moneyValueElement = document.getElementById('mny');
let entertainment = document.getElementById('entertainment');
let entsValueElement = document.getElementById('ents');
let health = document.getElementById('health');
let healthValueElement = document.getElementById('hth');
let paranormal = document.getElementById('paranormal');
let paraValueElement = document.getElementById('para');
let weather = document.getElementById('weather');
let weatherValueElement = document.getElementById('wth');
let toys = document.getElementById('toys');
let toysValueElement = document.getElementById('ty');
let environment = document.getElementById('environment');
let envValueElement = document.getElementById('env');
let culture = document.getElementById('culture');
let cultureValueElement = document.getElementById('clt');
let fashion = document.getElementById('fashion');
let fashionValueElement = document.getElementById('fash');
let travel = document.getElementById('travel');
let travelValueElement = document.getElementById('tvl');
let animals = document.getElementById('animals');
let animalsValueElement = document.getElementById('amls');
let scifi = document.getElementById('scifi');
let scifiValueElement = document.getElementById('sci');

// Skills
let cooking = document.getElementById('cooking');
let cookingValueElement = document.getElementById('ckP');
let mechanical = document.getElementById('mechanical');
let mechValueElement = document.getElementById('mP');
let charisma = document.getElementById('charisma');
let charismaValueElement = document.getElementById('chP');
let body = document.getElementById('body');
let bodyValueElement = document.getElementById('bP');
let logic = document.getElementById('logic');
let logicValueElement = document.getElementById('lP');
let creativity = document.getElementById('creativity');
let creativityValueElement = document.getElementById('cvP');
let cleaning = document.getElementById('cleaning');
let cleaningValueElement = document.getElementById('clP');

// Hobbies
let cuisine = document.getElementById('cuisine');
let cuisineValueElement = document.getElementById('cus');
let film = document.getElementById('film');
let filmValueElement = document.getElementById('lit');
let games = document.getElementById('games');
let gamesValueElement = document.getElementById('gms');
let tinkering = document.getElementById('tinkering');
let tinkeringValueElement = document.getElementById('tnk');
let science = document.getElementById('science');
let scienceValueElement = document.getElementById('ftsci');
let arts = document.getElementById('arts');
let artsValueElement = document.getElementById('crafts');
let sport = document.getElementById('sport');
let sportValueElement = document.getElementById('ftspt');
let nature = document.getElementById('nature');
let natureValueElement = document.getElementById('nat');
let fitness = document.getElementById('fitness');
let fitnessValueElement = document.getElementById('fit');
let music = document.getElementById('music');
let musicValueElement = document.getElementById('dance');

// AL
let reputation = document.getElementById('reputation');
let alignment = document.getElementById('alignment');
let magicLevel = document.getElementById('magicLevel');
let magicValueElement = document.getElementById('magic');

/* Personality */
$('#neatPoints').customSlider({
	start: [neatVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

neat.noUiSlider.on('update', function (values, handle) {
	neatValueElement.innerHTML = values[handle];
});

$('#outgoingPoints').customSlider({
	start: [outgoingVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

outgoing.noUiSlider.on('update', function (values, handle) {
	outgoingValueElement.innerHTML = values[handle];
});

$('#activePoints').customSlider({
	start: [activeVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

active.noUiSlider.on('update', function (values, handle) {
	activeValueElement.innerHTML = values[handle];
});

$('#playfulPoints').customSlider({
	start: [playfulVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

playful.noUiSlider.on('update', function (values, handle) {
	playfulValueElement.innerHTML = values[handle];
});

$('#nicePoints').customSlider({
	start: [niceVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

nice.noUiSlider.on('update', function (values, handle) {
	niceValueElement.innerHTML = values[handle];
});


/* Skills */
$('#cooking').customSlider({
	start: [cookVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

cooking.noUiSlider.on('update', function (values, handle) {
	cookingValueElement.innerHTML = values[handle];
});

$('#mechanical').customSlider({
	start: [mechVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

mechanical.noUiSlider.on('update', function (values, handle) {
	mechValueElement.innerHTML = values[handle];
});

$('#charisma').customSlider({
	start: [charVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

charisma.noUiSlider.on('update', function (values, handle) {
	charismaValueElement.innerHTML = values[handle];
});

$('#body').customSlider({
	start: [bodyVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

body.noUiSlider.on('update', function (values, handle) {
	bodyValueElement.innerHTML = values[handle];
});

$('#logic').customSlider({
	start: [logicVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

logic.noUiSlider.on('update', function (values, handle) {
	logicValueElement.innerHTML = values[handle];
});

$('#creativity').customSlider({
	start: [createVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

creativity.noUiSlider.on('update', function (values, handle) {
	creativityValueElement.innerHTML = values[handle];
});

$('#cleaning').customSlider({
	start: [cleanVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

cleaning.noUiSlider.on('update', function (values, handle) {
	cleaningValueElement.innerHTML = values[handle];
});

/* Interests */
$('#politics').customSlider({
	start: [politicsVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

politics.noUiSlider.on('update', function (values, handle) {
	polsValueElement.innerHTML = values[handle];
});

$('#crime').customSlider({
	start: [crimeVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

crime.noUiSlider.on('update', function (values, handle) {
	crimeValueElement.innerHTML = values[handle];
});

$('#food').customSlider({
	start: [foodVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

food.noUiSlider.on('update', function (values, handle) {
	foodValueElement.innerHTML = values[handle];
});

$('#sports').customSlider({
	start: [sportsVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

sports.noUiSlider.on('update', function (values, handle) {
	sportsValueElement.innerHTML = values[handle];
});

$('#work').customSlider({
	start: [workVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

work.noUiSlider.on('update', function (values, handle) {
	workValueElement.innerHTML = values[handle];
});

$('#school').customSlider({
	start: [schoolVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

school.noUiSlider.on('update', function (values, handle) {
	schoolValueElement.innerHTML = values[handle];
});

$('#money').customSlider({
	start: [moneyVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

money.noUiSlider.on('update', function (values, handle) {
	moneyValueElement.innerHTML = values[handle];
});

$('#entertainment').customSlider({
	start: [entVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

entertainment.noUiSlider.on('update', function (values, handle) {
	entsValueElement.innerHTML = values[handle];
});

$('#health').customSlider({
	start: [healthVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

health.noUiSlider.on('update', function (values, handle) {
	healthValueElement.innerHTML = values[handle];
});

$('#paranormal').customSlider({
	start: [paraVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

paranormal.noUiSlider.on('update', function (values, handle) {
	paraValueElement.innerHTML = values[handle];
});

$('#weather').customSlider({
	start: [weatherVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

weather.noUiSlider.on('update', function (values, handle) {
	weatherValueElement.innerHTML = values[handle];
});

$('#toys').customSlider({
	start: [toysVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

toys.noUiSlider.on('update', function (values, handle) {
	toysValueElement.innerHTML = values[handle];
});

$('#environment').customSlider({
	start: [envVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

environment.noUiSlider.on('update', function (values, handle) {
	envValueElement.innerHTML = values[handle];
});

$('#culture').customSlider({
	start: [cultureVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

culture.noUiSlider.on('update', function (values, handle) {
	cultureValueElement.innerHTML = values[handle];
});

$('#fashion').customSlider({
	start: [fashionVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

fashion.noUiSlider.on('update', function (values, handle) {
	fashionVal.innerHTML = values[handle];
});

$('#travel').customSlider({
	start: [travelVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

travel.noUiSlider.on('update', function (values, handle) {
	travelValueElement.innerHTML = values[handle];
});

$('#animals').customSlider({
	start: [animalsVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

animals.noUiSlider.on('update', function (values, handle) {
	animalsValueElement.innerHTML = values[handle];
});

$('#scifi').customSlider({
	start: [scifiVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

scifi.noUiSlider.on('update', function (values, handle) {
	scifiValueElement.innerHTML = values[handle];
});

/* Hobbies */
$('#cuisine').customSlider({
	start: [cuisineVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

cuisine.noUiSlider.on('update', function (values, handle) {
	cuisineValueElement.innerHTML = values[handle];
});

$('#film').customSlider({
	start: [filmVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

film.noUiSlider.on('update', function (values, handle) {
	filmValueElement.innerHTML = values[handle];
});

$('#games').customSlider({
	start: [gamesVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

games.noUiSlider.on('update', function (values, handle) {
	gamesValueElement.innerHTML = values[handle];
});

$('#tinkering').customSlider({
	start: [tinkeringVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

tinkering.noUiSlider.on('update', function (values, handle) {
	tinkeringValueElement.innerHTML = values[handle];
});

$('#science').customSlider({
	start: [scienceVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

science.noUiSlider.on('update', function (values, handle) {
	scienceValueElement.innerHTML = values[handle];
});

$('#arts').customSlider({
	start: [artsVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

arts.noUiSlider.on('update', function (values, handle) {
	artsValueElement.innerHTML = values[handle];
});

$('#sport').customSlider({
	start: [sportVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

sport.noUiSlider.on('update', function (values, handle) {
	sportValueElement.innerHTML = values[handle];
});

$('#nature').customSlider({
	start: [natureVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

nature.noUiSlider.on('update', function (values, handle) {
	natureValueElement.innerHTML = values[handle];
});

$('#fitness').customSlider({
	start: [fitnessVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

fitness.noUiSlider.on('update', function (values, handle) {
	fitnessValueElement.innerHTML = values[handle];
});

$('#music').customSlider({
	start: [musicVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

music.noUiSlider.on('update', function (values, handle) {
	musicValueElement.innerHTML = values[handle];
});

// Reputation
$('#reputation').customSlider({
	start: [repVal],
	step: 1,
	tooltips: [true],
	range: {
		'min': -100,
		'max': 100
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'positions',
		values: [0, 25, 50, 75, 100],
		density: 5
	}
});

reputation.noUiSlider.on('update', function (values, handle) {
	repUpdate(reputation.noUiSlider.get());
});

// Alignment
$('#alignment').customSlider({
	start: [alignVal],
	step: 1,
	tooltips: [true],
	range: {
		'min': -100,
		'max': 100
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'positions',
		values: [0, 25, 50, 75, 100],
		density: 5
	}
});

alignment.noUiSlider.on('update', function (values, handle) {
	alignUpdate(alignment.noUiSlider.get());
});

// Magic level
$('#magicLevel').customSlider({
	start: [magicVal],
	step: 1,
	range: {
		'min': 0,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	}),
	ariaFormat: wNumb({
		decimals: 0
	}),
	pips: {
		mode: 'steps',
		stepped: true,
		density: 10
	}
});

magicLevel.noUiSlider.on('update', function (values, handle) {
	magicValueElement.innerHTML = values[handle];
});

// Pet sliders
$('#shards-custom-slider').customSlider({
	start: [1],
	range: {
		'min': 1,
		'max': 3
	}
});