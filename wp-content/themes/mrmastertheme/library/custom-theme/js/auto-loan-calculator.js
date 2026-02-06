//--------------------------------------------------------------------------------
//
//  Copyright (c) 2016 Seven Design Inc. All rights reserved.
//
//  2019-03-15 v1.0.0
//  2019-03-29 v1.0.1
//  2019-04-02 v1.0.2
//  2019-04-24 v1.0.4
//  2019-04-25 v1.0.5
//--------------------------------------------------------------------------------
// create global object ot encapsulate all calculator methods
var Calcs = {};

Calcs.text = {};
Calcs.images = {};

// variables 
Calcs.SCRIPT_URL;
Calcs.SCRIPT_CALCULATOR         = null;             // eg: "auto_afford"
Calcs.SCRIPT_LOCALE             = "us_en";          // eg: "us_en", "ca_fr"
Calcs.SCRIPT_CURRENCY_ID        =  null;
Calcs.SCRIPT_SELECT_CURRENCY    = true;

Calcs.BASE_URL                  = null;
Calcs.BASE_LOCALE_URL           = null;

Calcs.CONTAINER_ELEM_ID = "calculator-container";
Calcs.CURRENCY_ID               = null;
Calcs.CURRENCY_SYMBOL = "$";

Calcs.dialogElem = null;
Calcs.errorElem = null;
Calcs.errorFn = null;
Calcs.otherFieldId = 0;

// constants
Calcs.COOKIE_CURRENCYID = "currencyID";

// script parameter names
Calcs.SCRIPT_PARAM_CALC = "data-calc";
Calcs.SCRIPT_PARAM_LOCALE = "data-locale";
Calcs.SCRIPT_PARAM_CURRENCY = "data-currency";
Calcs.SCRIPT_PARAM_SELECT_CURRENCY = "data-select-currency";


Calcs.currencies = {
	"ALL": { "name": "Albanian lek", "symbol": "L" },
	"AOA": { "name": "Angolan kwanza", "symbol": "Kz" },
	"ARS": { "name": "Argentine peso", "symbol": "$" },
	"AMD": { "name": "Armenian dram", "symbol": "֏" },
	"AWG": { "name": "Aruban florin", "symbol": "ƒ" },
	"AUD": { "name": "Australian dollar", "symbol": "$" },
	"AZN": { "name": "Azerbaijani manat", "symbol": "₼" },
	"BSD": { "name": "Bahamian dollar", "symbol": "$" },
	"BDT": { "name": "Bangladeshi taka", "symbol": "৳" },
	"BBD": { "name": "Barbadian dollar", "symbol": "$" },
	"BYN": { "name": "Belarusian ruble", "symbol": "Br" },
	"BZD": { "name": "Belize dollar", "symbol": "$" },
	"BMD": { "name": "Bermudian dollar", "symbol": "$" },
	"BTN": { "name": "Bhutanese ngultrum", "symbol": "Nu." },
	"BOB": { "name": "Bolivian boliviano", "symbol": "Bs." },
	"BAM": { "name": "Bosnia and Herzegovina convertible mark", "symbol": "KM" },
	"BWP": { "name": "Botswana pula", "symbol": "P" },
	"BRL": { "name": "Brazilian real", "symbol": "R$" },
	"GBP": { "name": "British pound", "symbol": "£" },
	"BND": { "name": "Brunei dollar", "symbol": "$" },
	"BGN": { "name": "Bulgarian lev", "symbol": "лв." },
	"MMK": { "name": "Burmese kyat", "symbol": "Ks" },
	"BIF": { "name": "Burundian franc", "symbol": "Fr" },
	"KHR": { "name": "Cambodian riel", "symbol": "៛" },
	"CAD": { "name": "Canadian dollar", "symbol": "$" },
	"CVE": { "name": "Cape Verdean escudo", "symbol": "$" },
	"KYD": { "name": "Cayman Islands dollar", "symbol": "$" },
	"XAF": { "name": "Central African CFA franc", "symbol": "Fr" },
	"XPF": { "name": "CFP franc", "symbol": "₣" },
	"CLP": { "name": "Chilean peso", "symbol": "$" },
	"CNY": { "name": "Chinese yuan", "symbol": "¥" },
	"COP": { "name": "Colombian peso", "symbol": "$" },
	"KMF": { "name": "Comorian franc", "symbol": "Fr" },
	"CDF": { "name": "Congolese franc", "symbol": "Fr" },
	"CRC": { "name": "Costa Rican colón", "symbol": "₡" },
	"HRK": { "name": "Croatian kuna", "symbol": "kn" },
	"CUP": { "name": "Cuban peso", "symbol": "$" },
	"CZK": { "name": "Czech koruna", "symbol": "Kč" },
	"DKK": { "name": "Danish krone", "symbol": "kr" },
	"DJF": { "name": "Djiboutian franc", "symbol": "Fr" },
	"DOP": { "name": "Dominican peso", "symbol": "RD$" },
	"XCD": { "name": "Eastern Caribbean dollar", "symbol": "$" },
	"EGP": { "name": "Egyptian pound", "symbol": "£" },
	"ERN": { "name": "Eritrean nakfa", "symbol": "Nfk" },
	"ETB": { "name": "Ethiopian birr", "symbol": "Br" },
	"EUR": { "name": "Euro", "symbol": "€" },
	"FKP": { "name": "Falkland Islands pound", "symbol": "£" },
	"FJD": { "name": "Fijian dollar", "symbol": "$" },
	"GMD": { "name": "Gambian dalasi", "symbol": "D" },
	"GEL": { "name": "Georgian lari", "symbol": "₾" },
	"GHS": { "name": "Ghanaian cedi", "symbol": "₵" },
	"GIP": { "name": "Gibraltar pound", "symbol": "£" },
	"GTQ": { "name": "Guatemalan quetzal", "symbol": "Q" },
	"GNF": { "name": "Guinean franc", "symbol": "Fr" },
	"GYD": { "name": "Guyanese dollar", "symbol": "$" },
	"HTG": { "name": "Haitian gourde", "symbol": "G" },
	"HNL": { "name": "Honduran lempira", "symbol": "L" },
	"HKD": { "name": "Hong Kong dollar", "symbol": "$" },
	"HUF": { "name": "Hungarian forint", "symbol": "Ft" },
	"ISK": { "name": "Icelandic króna", "symbol": "kr" },
	"INR": { "name": "Indian rupee", "symbol": "₹" },
	"IDR": { "name": "Indonesian rupiah", "symbol": "Rp" },
	"ILS": { "name": "Israeli new shekel", "symbol": "₪" },
	"JMD": { "name": "Jamaican dollar", "symbol": "$" },
	"JPY": { "name": "Japanese yen", "symbol": "¥" },
	"KZT": { "name": "Kazakhstani tenge", "symbol": "₸" },
	"KES": { "name": "Kenyan shilling", "symbol": "Sh" },
	"KGS": { "name": "Kyrgyzstani som", "symbol": "с" },
	"LAK": { "name": "Lao kip", "symbol": "₭" },
	"LSL": { "name": "Lesotho loti", "symbol": "L" },
	"LRD": { "name": "Liberian dollar", "symbol": "$" },
	"MOP": { "name": "Macanese pataca", "symbol": "MOP$" },
	"MKD": { "name": "Macedonian denar", "symbol": "ден" },
	"MGA": { "name": "Malagasy ariary", "symbol": "Ar" },
	"MWK": { "name": "Malawian kwacha", "symbol": "MK" },
	"MYR": { "name": "Malaysian ringgit", "symbol": "RM" },
	"MRU": { "name": "Mauritanian ouguiya", "symbol": "UM" },
	"MUR": { "name": "Mauritian rupee", "symbol": "₨" },
	"MXN": { "name": "Mexican peso", "symbol": "$" },
	"MDL": { "name": "Moldovan leu", "symbol": "L" },
	"MNT": { "name": "Mongolian tögrög", "symbol": "₮" },
	"MZN": { "name": "Mozambican metical", "symbol": "MT" },
	"NAD": { "name": "Namibian dollar", "symbol": "$" },
	"NPR": { "name": "Nepalese rupee", "symbol": "रू" },
	"ANG": { "name": "Netherlands Antillean guilder", "symbol": "ƒ" },
	"TWD": { "name": "New Taiwan dollar", "symbol": "$" },
	"NZD": { "name": "New Zealand dollar", "symbol": "$" },
	"NIO": { "name": "Nicaraguan córdoba", "symbol": "C$" },
	"NGN": { "name": "Nigerian naira", "symbol": "₦" },
	"KPW": { "name": "North Korean won", "symbol": "₩" },
	"NOK": { "name": "Norwegian krone", "symbol": "kr" },
	"PKR": { "name": "Pakistani rupee", "symbol": "₨" },
	"PGK": { "name": "Papua New Guinean kina", "symbol": "K" },
	"PYG": { "name": "Paraguayan guaraní", "symbol": "₲" },
	"PEN": { "name": "Peruvian sol", "symbol": "S/." },
	"PHP": { "name": "Philippine peso", "symbol": "₱" },
	"PLN": { "name": "Polish złoty", "symbol": "zł" },
	"RON": { "name": "Romanian leu", "symbol": "lei" },
	"RUB": { "name": "Russian ruble", "symbol": "₽" },
	"RWF": { "name": "Rwandan franc", "symbol": "Fr" },
	"SHP": { "name": "Saint Helena pound", "symbol": "£" },
	"WST": { "name": "Samoan tālā", "symbol": "T" },
	"STN": { "name": "São Tomé and Príncipe dobra", "symbol": "Db" },
	"RSD": { "name": "Serbian dinar", "symbol": "din." },
	"SCR": { "name": "Seychellois rupee", "symbol": "₨" },
	"SLL": { "name": "Sierra Leonean leone", "symbol": "Le" },
	"SGD": { "name": "Singapore dollar", "symbol": "$" },
	"SBD": { "name": "Solomon Islands dollar", "symbol": "$" },
	"SOS": { "name": "Somali shilling", "symbol": "Sh" },
	"ZAR": { "name": "South African rand", "symbol": "R" },
	"KRW": { "name": "South Korean won", "symbol": "₩" },
	"SSP": { "name": "South Sudanese pound", "symbol": "£" },
	"LKR": { "name": "Sri Lankan rupee", "symbol": "Rs" },
	"SRD": { "name": "Surinamese dollar", "symbol": "$" },
	"SEK": { "name": "Swedish krona", "symbol": "kr" },
	"CHF": { "name": "Swiss franc", "symbol": "Fr." },
	"SYP": { "name": "Syrian pound", "symbol": "£" },
	"TJS": { "name": "Tajikistani somoni", "symbol": "с." },
	"TZS": { "name": "Tanzanian shilling", "symbol": "Sh" },
	"THB": { "name": "Thai baht", "symbol": "฿" },
	"TOP": { "name": "Tongan paʻanga", "symbol": "T$" },
	"TTD": { "name": "Trinidad and Tobago dollar", "symbol": "$" },
	"TRY": { "name": "Turkish lira", "symbol": "₺" },
	"TMT": { "name": "Turkmenistan manat", "symbol": "m." },
	"UGX": { "name": "Ugandan shilling", "symbol": "Sh" },
	"UAH": { "name": "Ukrainian hryvnia", "symbol": "₴" },
	"USD": { "name": "United States dollar", "symbol": "$" },
	"UYU": { "name": "Uruguayan peso", "symbol": "$" },
	"UZS": { "name": "Uzbekistani soʻm", "symbol": "$" },
	"VUV": { "name": "Vanuatu vatu", "symbol": "Vt" },
	"VES": { "name": "Venezuelan bolívar soberano", "symbol": "Bs." },
	"VND": { "name": "Vietnamese đồng", "symbol": "₫" },
	"XOF": { "name": "West African CFA franc", "symbol": "Fr" },
	"ZMW": { "name": "Zambian kwacha", "symbol": "ZK" }
};

//----------------
// Utility methods
//----------------
Calcs.replaceTextParameters = function(text, parametersObj)
{
//  var parametersObj = {"%NAME%":"Mike","%AGE%":"26","%EVENT%":"20"},
//  var text = 'My Name is %NAME% and my age is %AGE%.';
    text = text.replace(/%\w+%/g, function(all) {
        return parametersObj[all] || all;
    });    
    return text;
}

Calcs.parseFloat = function(value)
{
    var str = value.toString();
    str = str.replace(/[^\d\.-]/g, '');     // remove all except numbers and '.'
//    if (str == '')
//        return NaN;
    return parseFloat(str);     
}

Calcs.parseInt = function(value)
{
    var str = value.toString();
    return parseInt(str.replace(/[^\d\.-]/g, ''));     // remove all except numbers and '.'
}

Calcs.validateText = function(options)
{
    // get and validate text input value
    // returns valid text value, or null
    // options:
    //      elementId
    //      allowEmpty       <optional> default=false
    //      error            <optional> if missing, no error will be displayed
    var elementId = options.elementId;
    var allowEmpty = options.hasOwnProperty("allowEmpty") ? options.allowEmpty : null;
    var errorText = options.hasOwnProperty("error") ? options.error : null;

    var value = document.getElementById(elementId).value;
    value = value.replace(/\s/g, '');
    var formattedValue = "";
    
    var isError = false;
    if (!isError && allowEmpty != null) {
        if (!allowEmpty && value == "") isError = true;
    } // if
    if (isError) {
        if (errorText != null) {
            Calcs.error(errorText, function() { document.getElementById(elementId).focus(); });
        } // if
        value = null;
    } else {
        formattedValue = value;
    } // if
    document.getElementById(elementId).value = formattedValue;
    return value;
}

Calcs.validateIntegerInput = function(options)
{
    // get and validate integer input value
    // returns valid integer value, or null
    // options:
    //      elementId
    //      allowZero       <optional> default=false
    //      default         <optional> default value used if empty
    //      minValue        <optional>
    //      maxValue        <optional>
    //      error           <optional> if missing, no error will be displayed
    var elementId = options.elementId;
    var minValue = options.hasOwnProperty("minValue") ? options.minValue : null;
    var maxValue = options.hasOwnProperty("maxValue") ? options.maxValue : null;
    var allowZero = options.hasOwnProperty("allowZero") ? options.allowZero : null;
    var defaultText = options.hasOwnProperty("default") ? options.default : null;
    var errorText = options.hasOwnProperty("error") ? options.error : null;
    
    var valueText = document.getElementById(elementId).value.replace(/\s/g, '');
    var isEmpty = valueText == "";
    if (isEmpty && defaultText != null) {
        valueText = defaultText
    } // if
    var value = Calcs.parseInt(valueText);
    var formattedValue = "";
    
    var isError = false;
    if (isNaN(value)) isError = true;
    if (!isError && minValue != null && value < minValue) isError = true;
    if (!isError && maxValue != null && value > maxValue) isError = true;
    if (!isError && allowZero != null) {
        if (allowZero && value < 0)  isError = true;
        if (!allowZero && value <= 0) isError = true;
    } // if
    
    if (isError) {
        if (errorText != null) {
            Calcs.error(errorText, function() { document.getElementById(elementId).focus(); });
        } // if
        value = null;
    } else {
        formattedValue = Calcs.formatFloat(value, 0);
    } // if
    document.getElementById(elementId).value = formattedValue;
    return value;
}

Calcs.validateFloatInput = function(options)
{
    // get and validate integer input value
    // returns valid integer value, or null
    // options:
    //      elementId
    //      deciPlaces      default 2
    //      allowZero       default=false
    //      default         <optional> default value used if empty
    //      error
    var elementId = options.elementId;
    var deciPlaces = options.hasOwnProperty("deciPlaces") ? options.deciPlaces : 2;
    var allowZero = options.hasOwnProperty("allowZero") ? options.allowZero : false;
    var defaultText = options.hasOwnProperty("default") ? options.default : null;
    var errorText = options.hasOwnProperty("error") ? options.error : null;
    
    var valueText = document.getElementById(elementId).value.replace(/\s/g, '');
    var isEmpty = valueText == "";
    if (isEmpty && defaultText != null) {
        valueText = defaultText
    } // if
    var value = Calcs.parseFloat(valueText);
    var formattedValue = "";
    
    if (allowZero) {
        if (isNaN(value) || value < 0) {
            if (errorText != null) {
                Calcs.error(errorText, function() { document.getElementById(elementId).focus(); });
            } // if
            value = null;
        } // if
    } else {
        if (isNaN(value) || value <= 0) {
            if (errorText != null) {
                Calcs.error(errorText, function() { document.getElementById(elementId).focus(); });
            } // if
            value = null;
        } // if
    } // if
    if (value != null) {
        formattedValue = Calcs.formatFloat(value, deciPlaces);
    } // if
    document.getElementById(elementId).value = formattedValue;
    return value;
}

Calcs.appendOptionsToSelect = function(selectElem, optionArray)
{
    // eg optionArray is array of:
    //      { value:1, text: "1 night", selected:true },

    var numOptions = optionArray.length;
    for (var i = 0; i < numOptions; i++) {
        var optionInfo = optionArray[i];
        var option = document.createElement("option");
        option.text = optionInfo.text;
        option.value = optionInfo.value;
        option.selected = optionInfo.selected;
        selectElem.add(option);
    } // for
}

Calcs.onChangeShowAssociatedElement = function(selectElem)
{
    // hide/show associated elements
    // elem ids are of the form: <parentID> + <option value>
    var parentId = selectElem.id;
    var selectedIndex = selectElem.selectedIndex;
    var optionsArray = selectElem.options;
    var numOptions = optionsArray.length;
    for (var index = 0; index < numOptions; index++) {
        var optionInfo = optionsArray[index];
        var elemId = parentId + optionInfo.value;
        var elem = document.getElementById(elemId);
        if (!elem)
            continue;
        elem.style.display = index == selectedIndex ? "block" : "none";
    } // for
}

Calcs.formatFloat = function(value, decimalPlaces)
{
    var decimalDelim = ".";
    var thousandsDelim = ",";
    if (Calcs.SCRIPT_LOCALE == "ca_fr") {
        decimalDelim = ",";
        thousandsDelim = ".";
    } // if
    value = value.toFixed(decimalPlaces);
    var result = value.toString();
    
    var splitArray = result.split('.');
    var wholePart = splitArray[0];
    var fracPart = splitArray.length > 1 ? decimalDelim + splitArray[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(wholePart)) {
        wholePart = wholePart.replace(rgx, '$1' + thousandsDelim + '$2');
    } // while
    result = wholePart + fracPart;    
    return result;
}

Calcs.formatPercent = function(value)
{
    value = 100.0*value;
    value = value.toFixed(0);
    var result = value.toString();
    result = result + "%";
    return result;
    
}

Calcs.formatCurrency = function(value)
{
    var decimalDelim = ".";
    var thousandsDelim = ",";
    if (Calcs.SCRIPT_LOCALE == "ca_fr") {
        decimalDelim = ",";
        thousandsDelim = ".";
    } // if
    value = value.toFixed(2);
    var result = value.toString();
    
    var splitArray = result.split('.');
    var wholePart = splitArray[0];
    var fracPart = splitArray.length > 1 ? decimalDelim + splitArray[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(wholePart)) {
        wholePart = wholePart.replace(rgx, '$1' + thousandsDelim + '$2');
    } // while
    result = wholePart + fracPart;    

    if (Calcs.SCRIPT_LOCALE == "ca_fr") {
        //result = result + " $";
        result = result + " " + Calcs.CURRENCY_SYMBOL;
    } else {
        //result = "$" + result;
        result = Calcs.CURRENCY_SYMBOL + result;
    } // if
    return result;
}
Calcs.getScriptParameter = function(paramName) {
    var scripts = document.getElementsByTagName('script');
    console.log(" Total <script> tags found:", scripts.length);
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i].src && scripts[i].src.indexOf("embed.js") !== -1) {
            var ret = scripts[i].getAttribute(paramName);
            return ret === "" ? null : ret;
        }
    }
    return null;
}


Calcs.insertCss = function(text)
{
    // add stylesheet to <head>
    var head = document.getElementsByTagName('head')[0];
    var style = document.createElement('style');
    style.type = 'text/css';
    head.appendChild(style);
    
    if (style.styleSheet) {
        style.styleSheet.cssText = text;        // IE
    } else {
        style.innerHTML = text;     // Other browsers
    }
}
Calcs.loadCss = function(url)
{
    //console.log("loadCss() " + url);
    
    var head = document.getElementsByTagName('head')[0];
    var link = document.createElement('link');
    link.type = 'text/css';
    link.rel = 'stylesheet';
    link.href = url;
    head.appendChild(link);
}


// render the calculator in its container: id="calculator-container"
Calcs.renderCalculator = function()
{
    // init currency
    //console.log("Calcs.renderCalculator()");
    
    Calcs.initCurrency();
    
    // user defined render
    renderCalculator();
    
}

Calcs.fixImagePaths = function() {
    if (!Calcs.BASE_LOCALE_URL) {
        if (Calcs.SCRIPT_URL) {
            Calcs.BASE_URL = Calcs.SCRIPT_URL.substring(0, Calcs.SCRIPT_URL.lastIndexOf("/"));
            Calcs.BASE_LOCALE_URL = Calcs.BASE_URL + "/res/" + Calcs.SCRIPT_LOCALE + "-locale";
        } else {
            Calcs.BASE_LOCALE_URL = "https://fnbo.practicalmoneyskills.com/assets/js/calcs/res/us_en-locale";
        }
    }
    for (var imageName in Calcs.images) {
        if (!/^https?:\/\//i.test(Calcs.images[imageName])) {
            Calcs.images[imageName] = Calcs.BASE_LOCALE_URL + "/" + Calcs.images[imageName];
        }
    }
};

Calcs.collapse = function(elem)
{
    // collapse/expand section with animation
    elem.classList.toggle("calc-active");
    var content = elem.nextElementSibling;
    if (content.style.maxHeight){
        content.style.maxHeight = null;
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
    } 
}    

Calcs.disclaimer = function(elem)
{
    // show disclaimer pop-up
    var htmlText = '<p class="calc-disclaimer">' + Calcs.text.TEXT_DISCLAIMER + "</p>";
    Calcs.showDialog(elem, htmlText);
}    

Calcs.embed = function(elem)
{
    // show embed pop-up
    var scriptAttribs =
        'type="text/javascript" ' +
        'src="' + Calcs.SCRIPT_URL + '" ' +
        Calcs.SCRIPT_PARAM_CALC + '="' + Calcs.SCRIPT_CALCULATOR + '" ' +
        Calcs.SCRIPT_PARAM_LOCALE + '="' + Calcs.SCRIPT_LOCALE + '"';
        
        if (Calcs.SCRIPT_CURRENCY_ID != null) {
            scriptAttribs += ' ' + Calcs.SCRIPT_PARAM_CURRENCY + '="' + Calcs.SCRIPT_CURRENCY_ID + '"';
        } // if
        if (Calcs.SCRIPT_SELECT_CURRENCY != null) {
            scriptAttribs += ' ' + Calcs.SCRIPT_PARAM_SELECT_CURRENCY + '="' + Calcs.SCRIPT_SELECT_CURRENCY + '"';
        } // if
    
    var htmlText =
        '<p class="calc-embed">' + Calcs.text.TITLE_EMBED + '</p>' +
        '<p class="calc-embed-code">&lt;script ' + scriptAttribs + '&gt;&lt;/script&gt;</p>';
        
    Calcs.showDialog(elem, htmlText);
}

Calcs.error = function(text, onCloseFn)
{
    if (Calcs.dialogElem)
        Calcs.hideDialog();
    if (Calcs.errorElem)
        Calcs.hideError();
    
    var overlayElem = document.createElement('div');
    overlayElem.className = "calc-dimmed-overlay";
    htmlText = '<div class="calc-error-close"><a href="javascript:Calcs.hideError()"><img src="' + Calcs.BASE_URL + '/res/icon-close.png' + '" width="20" height="20" /></a></div><p>' + text + '</p>';
    errorElem = document.createElement('div');
    errorElem.className = "calc-error";
    errorElem.innerHTML = htmlText;
    overlayElem.appendChild(errorElem);
    document.body.appendChild(overlayElem);
    
    Calcs.errorFn = onCloseFn;
    Calcs.errorElem = overlayElem;
}

Calcs.hideError = function(text)
{
    // close the current error
    if (Calcs.errorElem) {
        Calcs.errorElem.remove();
        Calcs.errorElem = null;
        if (Calcs.errorFn)
            Calcs.errorFn();
    } // if
}

Calcs.showDialog = function(elem, htmlText)
{
    if (Calcs.dialogElem)
        Calcs.hideDialog();
    if (Calcs.errorElem)
        Calcs.hideError();
    
    var parentElem = elem.parentElement;
    
    htmlText = '<div class="calc-dialog-close"><a href="javascript:Calcs.hideDialog()"><img src="' + Calcs.BASE_URL + '/res/icon-close.png' + '" width="20" height="20" /></a></div>\n' + htmlText;
    var width = elem.getBoundingClientRect().right - elem.getBoundingClientRect().left;
    var left = parseFloat(elem.offsetLeft) + parseFloat(width)/2 - 20; 
    var bottom = parseFloat(elem.offsetTop)  + 50;
    
    
    Calcs.dialogElem = document.createElement('div');
    Calcs.dialogElem.className = "calc-dialog";
    Calcs.dialogElem.style.left = left + "px";
    Calcs.dialogElem.style.bottom = bottom + "px";
    Calcs.dialogElem.innerHTML = htmlText;
    parentElem.appendChild(Calcs.dialogElem);
}

Calcs.hideDialog = function()
{
    // close the current dialog
    if (Calcs.dialogElem) {
        Calcs.dialogElem.remove();
        Calcs.dialogElem = null;
    } // if
}

Calcs.otherFieldAdd = function(duplicateRowId)
{
    // add an other form field
    // duplicateRowId is id of hidden row to duplicate 
    // new id's in the new row are appended with the next number sequence
    var rowToDup = document.getElementById(duplicateRowId);
    if (!rowToDup)
        return;

    Calcs.otherFieldId++;
    var newRowId = 'other-row' + Calcs.otherFieldId;

    var newRow = rowToDup.cloneNode(true);
    newRow.id = newRowId;
    newRow.setAttribute("data-other-row", Calcs.otherFieldId);

    // modify child id's
    // modify id's
    var children = newRow.getElementsByTagName("*");
    var numChildren = children.length;
    for (var i = 0; i < numChildren; i++) {
        var childElem = children[i];
        if (childElem.id == 'otherlabel')
            childElem.id = 'otherlabel' + Calcs.otherFieldId;
        else if (childElem.id == 'othervalue')
            childElem.id = 'othervalue' + Calcs.otherFieldId;
        else if (childElem.className == 'calc-other-remove') {
            var rowId 
            childElem.onclick = function () { Calcs.otherFieldRemove(newRowId); };
        } // if
    } // for

    // display    
    newRow.style.display = "block";
    rowToDup.parentElement.insertBefore(newRow, rowToDup);    
}

Calcs.otherFieldRemove = function(rowId)
{
    // remove other form field
    // rowId is id or row to remove
    var rowElem = document.getElementById(rowId);
    if (!rowElem)
        return;
    rowElem.parentElement.removeChild(rowElem);
}
//--------------------------------------------------------------------------------
// Charts
//--------------------------------------------------------------------------------
Calcs.drawPieChart = function(chartElem, chartTitle, chartData)
{
    if (!chartElem || !chartTitle || !chartData)
        return;
    
    var dataItem = ['Amount', Calcs.CURRENCY_SYMBOL];     // not displayed but needed to define data
    chartData.splice(0, 0, dataItem);
    
    var dataTable = google.visualization.arrayToDataTable(chartData);
    var options = {
          title : chartTitle,
          titleTextStyle : { color: '#666', fontSize: 22, bold: true },
          backgroundColor : {fill: '#f8f8f8', stroke: '#cccccc', strokeWidth : 1 },
          colors : ['#241e69', '#3561ef', '#7199ff'],
          fontSize : 16,
          chartArea : { left:'15%', top:'15%', width:'70%', height:'70%' },
          legend : {position : 'bottom', textStyle: {fontSize: 14 } },
          animation: {
              startup: true,
              duration: 1000,
              easing: 'out'
          }
      };
      var chart = new google.visualization.PieChart(chartElem);
      chart.draw(dataTable, options);
}

Calcs.drawTableChart = function(chartElem, chartCols, chartRows)
{
    if (!chartElem || !chartCols || !chartRows)
        return;
    
    var data = new google.visualization.DataTable();
    for (var i = 0; i < chartCols.length; i++) {
        data.addColumn('number', chartCols[i]);
    } // for
    data.addRows(chartRows);
    var options = {
        showRowNumber: false,
        sort: 'disable',
        cssClassNames: {headerRow: 'calc-table-header-row', headerCell: 'calc-table-header-cell', tableCell: 'calc-table-cell' },
    };
    var chart = new google.visualization.Table(chartElem);
    chart.draw(data, options);
    // Select the parent div with the class "google-visualization-table"
      var parentDiv = document.querySelector('.google-visualization-table');
    
      // Select the immediate child div within the parent div
      var childDiv = parentDiv.querySelector('div');
    
      // Add tabindex="0" to the child div
      childDiv.setAttribute('tabindex', '0');
}
//--------------------------------------------------------------------------------
// Currencies
//--------------------------------------------------------------------------------
Calcs.initCurrency = function()
{
    // init currency ID
    // use cookie
    Calcs.CURRENCY_ID = Calcs.getCookie(Calcs.COOKIE_CURRENCYID);
    if (Calcs.CURRENCY_ID != null) {
        console.log("Calcs.initCurrency() use cookie CURRENCY_ID = " + Calcs.CURRENCY_ID);
    } // if
    
    if (Calcs.CURRENCY_ID == null) {
        // use script param
        Calcs.CURRENCY_ID = Calcs.SCRIPT_CURRENCY_ID
        if (Calcs.CURRENCY_ID != null) {
            console.log("Calcs.initCurrency() use script param CURRENCY_ID = " + Calcs.CURRENCY_ID);
        } // if
    } // if
    
    if (Calcs.CURRENCY_ID == null) {
        // use a default
        if (Calcs.SCRIPT_LOCALE == "ca_en" || Calcs.SCRIPT_LOCALE == "ca_fr") {
            Calcs.CURRENCY_ID = "CAD";
        } else {
            Calcs.CURRENCY_ID = "USD";
        } // if
        console.log("Calcs.initCurrency() use defaul CURRENCY_ID = " + Calcs.CURRENCY_ID);
    } // if
    
    Calcs.CURRENCY_SYMBOL = "$";
    if (Calcs.currencies.hasOwnProperty(Calcs.CURRENCY_ID)) {
    	Calcs.CURRENCY_SYMBOL = Calcs.currencies[Calcs.CURRENCY_ID].symbol;
    } // if
}

Calcs.initCurrencySelect = function(selectElemID, selectLabelElemID)
{
    console.log("Calcs.initinitCurrencySelect()");
    
    // load the select element with currencies
    var optionArray = new Array()
    for (const currencyID in Calcs.currencies) {
        if (Calcs.currencies.hasOwnProperty(currencyID)) {
            var currencyInfo = Calcs.currencies[currencyID];
            var option = document.createElement("option");
            option.text = currencyInfo.name;
            option.value = currencyID;
            if (currencyID == Calcs.CURRENCY_ID) {
                option.selected = "selected"
            } // if
            optionArray.push(option);
        } // if
    } // for
    // sort by name
    optionArray.sort(function (a, b) {
            return a.text > b.text ? 1 : -1;
    });
    var selectElem = document.getElementById(selectElemID);
    var selectLabelElem = document.getElementById(selectLabelElemID);
    selectElem.innerHTML = '';
    
    if (Calcs.SCRIPT_SELECT_CURRENCY) {
        for (option of optionArray) {
            selectElem.appendChild(option);
        } // for
        selectElem.addEventListener("change", Calcs.doCurrencyChanged);
        selectElem.style.display = "inline-block";
        selectLabelElem.style.display = "block";
    } else {
        selectElem.removeEventListener("change", Calcs.doCurrencyChanged);
        selectElem.style.display = "none";
        selectLabelElem.style.display = "none";
    } // if
}

Calcs.doCurrencyChanged = function() 
{
    var currencyID = this.options[this.selectedIndex].value;
    //console.log("doCurrencyChanged() " + currencyID);
    
    Calcs.setCookie(Calcs.COOKIE_CURRENCYID, currencyID);
    
    Calcs.initCurrency();
    
    Calcs.renderCalculator();
}
//--------------------------------------------------------------------------------
// Cookies
//--------------------------------------------------------------------------------
Calcs.setCookie = function(name, value, days)
{
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

Calcs.getCookie = function(name)
{
    //console.log("getCookie() " + document.cookie);
    
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length,c.length);
        } // if
    }
    return null;
}

Calcs.eraseCookie = function(name)
{
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
//--------------------------------------------------------------------------------
// Main script
//--------------------------------------------------------------------------------
// write the outermost calculator element that will be filled in after all localized files are loaded
Calcs.init = function()
{
    //console.log("Calcs.init()");
    
    Calcs.SCRIPT_URL = Calcs.getScriptParameter("src");
    
    var param = Calcs.getScriptParameter(Calcs.SCRIPT_PARAM_CALC);
    if (param != null) {
        Calcs.SCRIPT_CALCULATOR = param.toLowerCase();
    } // if
    
    param = Calcs.getScriptParameter(Calcs.SCRIPT_PARAM_LOCALE);
    if (param != null) {
        Calcs.SCRIPT_LOCALE = param.toLowerCase();   // "us_en", "ca_fr"
    } // if

    param = Calcs.getScriptParameter(Calcs.SCRIPT_PARAM_CURRENCY);
    if (param != null) {
        Calcs.SCRIPT_CURRENCY_ID = param.toUpperCase();   // "USD"
    } // if
    
    param = Calcs.getScriptParameter(Calcs.SCRIPT_PARAM_SELECT_CURRENCY);
    if (param != null) {
        param = param.toLowerCase();   // "true" of "false"
        Calcs.SCRIPT_SELECT_CURRENCY = (param == "true");
    } // if

    Calcs.initCurrency();
    
    // write the outermost calculator element that will be filled in after all localized files are loaded
    var containerHtml = '<div id="' + Calcs.CONTAINER_ELEM_ID + '" class="calc-container"> </div>';
    document.write(containerHtml);

    // ensure absolute URL for script - NB may be on a different server
    // if starts with ??://
    var isAbsoluteUrlRegEx = new RegExp('^(?:[a-z]+:)?//', 'i');
    var isScriptUrlAbsolute = isAbsoluteUrlRegEx.test(Calcs.SCRIPT_URL);
    if (!isScriptUrlAbsolute) {
        var sep = "";
        if (Calcs.SCRIPT_URL.indexOf("/") != 0)
            sep = "/";
        Calcs.SCRIPT_URL = window.location.href.substring(0, window.location.href.lastIndexOf("/")) + sep + Calcs.SCRIPT_URL;
    } // if

    Calcs.BASE_URL = Calcs.SCRIPT_URL.substring(0, Calcs.SCRIPT_URL.lastIndexOf("/"));
    Calcs.BASE_LOCALE_URL = Calcs.BASE_URL + "/res/" + Calcs.SCRIPT_LOCALE + "-locale";

    
    console.log("SCRIPT_URL=" + Calcs.SCRIPT_URL);
    console.log("BASE_URL=" + Calcs.BASE_URL);
    console.log("SCRIPT_LOCALE=" + Calcs.SCRIPT_LOCALE);
    console.log("SCRIPT_CALCULATOR=" + Calcs.SCRIPT_CALCULATOR);
    console.log("SCRIPT_CURRENCY_ID=" + Calcs.SCRIPT_CURRENCY_ID);
    console.log("SCRIPT_SELECT_CURRENCY=" + Calcs.SCRIPT_SELECT_CURRENCY);
    console.log("CONTAINER_ELEM_ID=" + Calcs.CONTAINER_ELEM_ID);
    console.log("CURRENCY_ID=" + Calcs.CURRENCY_ID);
    console.log("CURRENCY_SYMBOL=" + Calcs.CURRENCY_SYMBOL);

    // load CSS
    Calcs.loadCss(Calcs.BASE_URL + "/res/calc.css");
	    // --------------------------------------------------------------------------------
    // Sequential script loading to avoid race conditions
    // --------------------------------------------------------------------------------
(function loadScriptsSequentially() {
    const scripts = [
        {
            url: "https://www.gstatic.com/charts/loader.js",
            cb: function () {
                console.log("Google Charts script loaded");
                try {
                    google.charts.load('current', {packages:['corechart', 'table']});
                    google.charts.setOnLoadCallback(() => {
                        console.log("Google Charts ready");
                    });
                } catch (e) {
                    console.error("Google Charts load error", e);
                }
                next(); // Always advance to next script
            }
        },
        {
            url: Calcs.BASE_URL + "/res/" + Calcs.SCRIPT_LOCALE + "-locale/" + Calcs.SCRIPT_CALCULATOR + ".js",
            cb: function () {
                console.log("Localization script loaded");
                next();
            }
        },
        {
            url: Calcs.BASE_URL + "/" + Calcs.SCRIPT_CALCULATOR + ".js",
            cb: function () {
                console.log("Calculator main script loaded");
				Calcs.fixImagePaths();
                Calcs.renderCalculator(); // Direct render
                console.log("✅ All scripts loaded — calculator rendered");
            }
        }
    ];

    let i = 0;
    function next() {
        if (i >= scripts.length) {
            return;
        }
        const s = scripts[i++];
        Calcs.loadScriptWithErrorHandling(s.url, s.cb);
    }

    next();
})();


};

// START GENAI
Calcs.loadScriptWithErrorHandling = function(url, callback) {
    console.log("Loading script: " + url);
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    let done = false;
    function success() {
        if (done) return;
        done = true;
        console.log("✅ Loaded:", url);
        callback();
    }
    function fail(reason) {
        if (done) return;
        done = true;
        console.error("❌ Failed:", url, "Reason:", reason);
        callback(); // Continue chain even on fail
    }
    script.onload = success;
    script.onreadystatechange = function() {
        if (this.readyState === 'complete' || this.readyState === 'loaded') success();
    };
    script.onerror = () => fail("network error");
    setTimeout(() => fail("timeout"), 15000);
    head.appendChild(script);
};
//--------------------------------------------------------------------------------
// Main script
//--------------------------------------------------------------------------------
Calcs.init();
//--------------------------------------------------------------------------------

