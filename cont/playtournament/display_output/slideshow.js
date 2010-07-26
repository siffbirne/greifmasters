var images = [
	"adfc",
	"angler",
	"AW",
	"basislager",
	"kajak",
	"kmkh",
	"LDI",
	"Logo_m.Unterzeile",
	"logo_Stadt_KA_4C_sText",
	"nf_logo_08_4c",
	"nwu",
	"Rothaus_Querformat",
	//"RR Logo_mit Bogen_4c_Vektor_Final",
	"Schild_front_HGweiss_o.G",
	"velokonzept_Logo_4c",
	"wandermagazin_logo_konvertiert"
	],
	tick = 0,
	$img;

function imgUrl(file)
{
	return "/greifmasters/gfx/sponsors/" + file + ".jpg";
};

jQuery(function()
{
	$img = jQuery('<img id="sponsor-img" src="'+ imgUrl(images[0]) +'" />');
	$img.appendTo("#slideshow");
	setInterval(rotateImage,10000);

});

function rotateImage()
{
	if(tick > images.length)
		tick = 0;
	console.log($img);
	$img.attr('src', imgUrl(images[++tick]));
};
